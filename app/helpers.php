<?php
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Setting;
use App\Models\Category;
use App\Models\ContentManagement;
use Illuminate\Support\Facades\Auth;

if (!function_exists('get_settings')) {
    function get_settings() {
        return Setting::findOrFail(1);
    }
}

if (!function_exists('getWishlistProductIds')) {
    function getWishlistProductIds()
    {
        // Check if a user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's ID
            $userId = Auth::id();
            
            // Fetch wishlist products associated with the user
            $wishlistProducts = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();

            return $wishlistProducts;
        }

        // Return an empty array if the user is not authenticated or no products are found
        return [];
    }
}

if (!function_exists('getWishlistProductListWithDetails')) {
    function getWishlistProductListWithDetails()
    {
        // Check if a user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's ID
            $userId = Auth::id();
            
            // Fetch wishlist products associated with the user
            $wishlistProducts = Wishlist::where('user_id', $userId)
                ->orderBy('created_at', 'desc') // Order by creation date
                ->take(4)
                ->pluck('product_id')
                ->toArray();

            // Fetch full product information for each product ID
            $products = Products::whereIn('id', $wishlistProducts)->get();

            return $products;
        }

        // Return an empty array if the user is not authenticated or no products are found
        return [];
    }
}

if (!function_exists('getCartProductIds')) {
    function getCartProductIds()
    {
        // Check if a user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's ID
            $userId = Auth::id();
            
            // Fetch wishlist products associated with the user
            $cartProducts = Cart::where('user_id', $userId)->pluck('product_id')->toArray();

            return $cartProducts;
        }

        // Return an empty array if the user is not authenticated or no products are found
        return [];
    }
}

// In helpers.php or any other appropriate file

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

if (!function_exists('getHeaderCategoriesMenu')) {
    function getHeaderCategoriesMenu()
    {
        $categoriesHeaderMenu = Category::with('children')->select('id', 'name')->whereIn('id', explode(",", get_settings()['header_menu_categories']))->orderBy('name', 'ASC')->get();

        return $categoriesHeaderMenu;
    }
}

if (!function_exists('getFooterCategoriesMenu')) {
    function getFooterCategoriesMenu()
    {
        $categoriesFooterMenu = Category::select('id', 'name')->whereIn('id', explode(",", get_settings()['footer_menu_categories']))->orderBy('name', 'ASC')->get();

        return $categoriesFooterMenu;
    }
}

if (!function_exists('get_content_management_settings')) {
    function get_content_management_settings($id) {
        return ContentManagement::findOrFail($id);
    }
}
