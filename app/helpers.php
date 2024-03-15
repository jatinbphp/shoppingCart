<?php
use App\Models\Banner;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductsOptions;
use App\Models\Setting;
use App\Models\Category;
use App\Models\ContentManagement;
use App\Models\Review;
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
if (!function_exists('getCartProductIds')) {
    function getCartProductIds()
    {
        if (Auth::check()) {
            $cartProducts = Cart::where('user_id', Auth::id())->pluck('product_id')->toArray();
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
        $categoriesHeaderMenu = Category::with('children')->select('id', 'name')->whereIn('id', explode(",", get_settings()['header_menu_categories']))->orderBy('name', 'ASC')->get();

        return $categoriesHeaderMenu;
    }
}

/* below function for category footer menu */
if (!function_exists('getFooterCategoriesMenu')) {
    function getFooterCategoriesMenu()
    {
        $categoriesFooterMenu = Category::select('id', 'name')->whereIn('id', explode(",", get_settings()['footer_menu_categories']))->orderBy('name', 'ASC')->get();

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
        return Products::with(['product_image', 'category', 'product_images', 'options.product_option_values'])
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();
    }
}

/* below function for home page category tab */
if (!function_exists('getCategoryProducts')) {
    function getCategoryProducts()
    {
        return Category::has('products')
            ->with(['products' => function ($query) {
                $query->inRandomOrder()->take(8); // Randomly order and limit to 8 products per category
            }])
            ->take(4)
            ->get();
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

if (!function_exists('get_latest_product_reviews')) {
    function get_latest_product_reviews($productId, $limit = 3) {
        $reviews = Review::with('user')->where('product_id', $productId)->latest()->take($limit)->get();
        return $reviews;
    }
}
