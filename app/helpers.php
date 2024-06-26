<?php
use App\Models\Banner;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductsOptions;
use App\Models\ProductsOptionsValues;
use App\Models\Setting;
use App\Models\Category;
use App\Models\ContentManagement;
use App\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/* below function for settings */
if (!function_exists('get_settings')) {
    function get_settings() {
        return Setting::findOrFail(1);
    }
}

/* below function for wishlist products ids */
if (!function_exists('getWishlistProductIds')) {
    function getWishlistProductIds()
    {
        if (Auth::check()) {
            $wishlistProducts = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
            return $wishlistProducts;
        }
        return [];
    }
}

/* below function for siderbar wishlist products*/
if (!function_exists('getWishlistProductListWithDetails')) {
    function getWishlistProductListWithDetails()
    {        
        if (Auth::check()) {            
            $wishlistProducts = Wishlist::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->pluck('product_id')
                ->toArray();

            $products = Products::whereIn('id', $wishlistProducts)->get();
            return $products;
        }
        return [];
    }
}

/* below function for siderbar cart products*/
if (!function_exists('getTotalCartProducts')) {
    function getTotalCartProducts()
    {
        if (Auth::check()) {

            $defaultController = app(Controller::class);

            // if user selected categories product added in the cart. then that products will be deleted.
            // start
            $getParentAndSubCategoryIds = getParentAndSubCategoryIds();
            if(count($getParentAndSubCategoryIds)>0){
                /*$product_ids = Products::whereIn('category_id', $getParentAndSubCategoryIds)
                              ->pluck('id')
                              ->toArray();*/

                $product_ids = Products::where(function ($query) use ($getParentAndSubCategoryIds) {
                    foreach ($getParentAndSubCategoryIds as $category_id) {
                        $query->orWhereRaw("FIND_IN_SET('$category_id', category_id)");
                    }
                })->pluck('id')->toArray();

                Cart::where('user_id', Auth::user()->id)->whereNotIn('product_id', $product_ids)->delete();
            }
            // end

            $cartProducts = Cart::with('product', 'product.product_image')
                            ->where('user_id', Auth::user()->id)
                            ->orderBy('created_at', 'desc')
                            ->get();

            if (count($cartProducts)>0){
                foreach ($cartProducts as $key => $order) {
                    $oIds = [];
                    $optionArray = [];
                    $options = json_decode($order->options);
                    if (!empty($options)) {
                        foreach ($options as $keyO => $valueO) {
                            $product_option = ProductsOptions::where('id', $keyO)->first();
                            $product_option_value = ProductsOptionsValues::where('id', $valueO)->first();

                            if ($product_option && $product_option_value) {
                                $optionArray[$product_option->option_name] = $product_option_value->option_value;
                            }

                            $oIds[] = $valueO;
                        }
                    }

                    $stock = $defaultController->checkStock($order->product_id,$oIds,1);

                    $cartProducts[$key]['total_stock_quantity'] = 0;
                    $cartProducts[$key]['out_of_stock'] = 0;
                    if(!empty($stock)){
                        if($stock['remaining_qty'] >= $order->quantity){
                            $cartProducts[$key]['out_of_stock'] = 1;
                        }

                        $cartProducts[$key]['total_stock_quantity'] = $stock['remaining_qty'];
                    }
                    
                    $cartProducts[$key]['product_options'] = $optionArray;
                }
            }
            return $cartProducts;
        }
        return [];
    }
}

/* below function for product badge sale, new, hot */
if (!function_exists('customBadge')) {
    function customBadge($type) {
        $textColor = 'white';
        $bgColor = '';

        switch ($type) {
            case 'sale':
                $bgColor = 'success';
                break;
            case 'new':
                $bgColor = 'primary';
                break;
            case 'hot':
                $bgColor = 'danger';
                break;
            default:
                $bgColor = 'secondary';
                break;
        }

        return '<div class="badge bg-' . $bgColor . ' text-' . $textColor . ' position-absolute ft-regular ab-left text-upper">' . $type . '</div>';
    }
}

/* below function for category header menu */
if (!function_exists('getHeaderCategoriesMenu')) {
    function getHeaderCategoriesMenu()
    {
        $categoriesHeaderMenu = Category::with('children')->select('id', 'name', 'slug')->whereIn('id', explode(",", get_settings()['header_menu_categories']))->where('status', 'active')->orderBy('name', 'ASC')->get();

        return $categoriesHeaderMenu;
    }
}

/* below function for category footer menu */
if (!function_exists('getFooterCategoriesMenu')) {
    function getFooterCategoriesMenu()
    {
        $categoriesFooterMenu = Category::select('id', 'name', 'slug')->whereIn('id', explode(",", get_settings()['footer_menu_categories']))->where('status', 'active')->orderBy('name', 'ASC')->get();

        return $categoriesFooterMenu;
    }
}

/* below function for privacy policy & terms & condition page content */
if (!function_exists('get_content_management_settings')) {
    function get_content_management_settings($id) {
        return ContentManagement::findOrFail($id);
    }
}

/* below function for home page banner sliders */
if (!function_exists('getActiveBanners')) {
    function getActiveBanners()
    {
        return Banner::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->get();
    }
}

/* below function for home page trending products */
if (!function_exists('getTrendingProducts')) {
    function getTrendingProducts()
    {
        $desiredCategoryIds = getUserCategoryIds();

        $query = Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])
            ->where('status', 'active');

        if (!empty($desiredCategoryIds)) {
            $query->where(function ($query) use ($desiredCategoryIds) {
                $query->whereHas('category', function ($query) use ($desiredCategoryIds) {
                    $query->whereIn('id', $desiredCategoryIds);
                })->orWhereHas('category.parent', function ($query) use ($desiredCategoryIds) {
                    $query->whereIn('id', $desiredCategoryIds);
                });
            });
        }

        return $query->orderBy('id', 'DESC')->take(8)->get();
    }
}

/* below function for home page category tab */
if (!function_exists('getCategoryProducts')) {
    function getCategoryProducts()
    {   
        $desiredCategoryIds = getUserCategoryIds();

        $categoriesWithRandomProducts = Category::has('products')
            ->with(['products' => function ($query) {
                $query->inRandomOrder()->take(8); // Randomly order and limit to 8 products per category
            }])
            ->whereHas('products', function ($query) use ($desiredCategoryIds) {
                if (!empty($desiredCategoryIds)) {
                    $query->where(function ($query) use ($desiredCategoryIds) {
                        $query->whereIn('category_id', $desiredCategoryIds)
                              ->orWhereHas('category.parent', function ($query) use ($desiredCategoryIds) {
                                  $query->whereIn('id', $desiredCategoryIds);
                              });
                    });
                }
            })
            ->take(4)
            ->get();

        return $categoriesWithRandomProducts;
    }
}

/* below function for category filter listing */
if (!function_exists('getCategoriesWithProductsForFilter')) {
    function getCategoriesWithProductsForFilter()
    {
        return Category::with(['children' => function ($query) {
                                    $query->whereHas('products');
                                }, 'children.products'])
                                ->where('parent_category_id', 0)
                                ->whereHas('children.products')
                                ->orderBy('name', 'ASC')
                                ->get();
    }
}

/* below function for size filter listing */
if (!function_exists('getProductSizes')) {
    function getProductSizesForFilter()
    {
        return ProductsOptions::join('products_options_values', 'products_options.id', '=', 'products_options_values.option_id')
            ->select('products_options_values.option_value')
            ->where('products_options.option_name', 'SIZE')
            ->groupBy('products_options_values.option_value')
            ->orderBy('products_options_values.option_value')
            ->pluck('option_value')
            ->toArray();
    }
}

/* below function for product details page reviews */
if (!function_exists('get_latest_product_reviews')) {
    function get_latest_product_reviews($productId, $limit = 3) {
        $reviews = Review::with('user')->where('product_id', $productId)->latest()->take($limit)->get();
        return $reviews;
    }
}

if (!function_exists('getUserCategoryIds')) {
    function getUserCategoryIds()
    {
        return Auth::check() && !empty(Auth::user()->categories_id) ? explode(',', Auth::user()->categories_id) : [];
    }
}

if (!function_exists('get_categories_by_ids')) {
    function get_categories_by_ids($limit) {
        if (Auth::check()) {
            return Category::select('id', 'name', 'slug')->whereIn('id', explode(',', Auth::user()->categories_id))->orderBy('name', 'ASC')->take($limit)->get();
        }
        // Return an empty collection or handle the case where the user is not authenticated
        return collect(); // Empty collection
    }
}

if (!function_exists('getParentAndSubCategoryIds')) {
    function getParentAndSubCategoryIds($limit = null)
    {   
        $parentAndSubCategoryIds = [];
        if (Auth::check()) {
            // Get desired category IDs from authenticated user
            $desiredCategoryIds = getUserCategoryIds();

            if(count($desiredCategoryIds)>0){
                // Start building the query
                $query = Category::with('children')
                    ->whereIn('id', $desiredCategoryIds)
                    ->orderBy('name', 'ASC');

                // Apply limit if provided
                if ($limit !== null) {
                    $query->take($limit);
                }

                // Retrieve parent category IDs and corresponding subcategory IDs
                $parentAndSubCategoryIds = $query->get()->flatMap(function ($category) {
                    return [$category->id, ...$category->children->pluck('id')->toArray()];
                });
            }
        }

        return $parentAndSubCategoryIds;
    }
}

if (!function_exists('get_product_categories_by_ids')) {
    function get_product_categories_by_ids($categories_id) {
        if (Auth::check()) {
            //return Category::select('full_name')->whereIn('id', explode(',', $categories_id))->orderBy('full_name', 'ASC')->pluck('full_name')->implode(', ');

            return Category::select('id', 'full_name', 'slug')->whereIn('id', explode(',', $categories_id))->orderBy('full_name', 'ASC')->get();
        }
        // Return an empty collection or handle the case where the user is not authenticated
        return collect(); // Empty collection
    }
}