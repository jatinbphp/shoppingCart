<?php

use App\Models\Wishlist;
use App\Models\Products;
use App\Models\ProductImages;
use Illuminate\Support\Facades\Auth;

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
                ->pluck('product_id')
                ->toArray();

            // Take the latest 4 products
            $latestProducts = array_slice($wishlistProducts, 0, 4);

            // Fetch full product information for each product ID
            $products = Products::with(['product_image'])->whereIn('id', $latestProducts)->get();

            return $products;
        }

        // Return an empty array if the user is not authenticated or no products are found
        return [];
    }
}
