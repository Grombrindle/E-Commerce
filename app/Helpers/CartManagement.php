<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{

    public static function addItemToCart($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        $item_key = null;

        // Find the array KEY (index) of the existing item
        foreach ($cart_items as $key => $item) {
            if ($item["product_id"] == $product_id) {
                $item_key = $key;
                break;
            }
        }

        if ($item_key !== null) {
            // Increment quantity and update total for existing item
            $cart_items[$item_key]['quantity']++;
            $cart_items[$item_key]['total_amount'] = $cart_items[$item_key]['quantity'] * $cart_items[$item_key]['unit_amount'];
        } else {
            // Add new item to cart
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'unit_amount' => $product->price,
                    'image' => $product->images[0] ?? null, // Added null check for images
                    'quantity' => 1,
                    'total_amount' => $product->price,
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    public static function addItemToCartWithQty($product_id, $qty = 1)
    {
        $cart_items = self::getCartItemsFromCookie();
        $item_key = null;

        // Find the array KEY (index) of the existing item
        foreach ($cart_items as $key => $item) {
            if ($item["product_id"] == $product_id) {
                $item_key = $key;
                break;
            }
        }

        if ($item_key !== null) {
            // Increment quantity and update total for existing item
            $cart_items[$item_key]['quantity'] = $qty;
            $cart_items[$item_key]['total_amount'] = $cart_items[$item_key]['quantity'] * $cart_items[$item_key]['unit_amount'];
        } else {
            // Add new item to cart
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'unit_amount' => $product->price,
                    'image' => $product->images[0] ?? null, // Added null check for images
                    'quantity' => $qty,
                    'total_amount' => $product->price,
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    public static function removeCartItem($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart_items[$key]);
            }
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    static public function addCartItemsToCookie($cart_items)
    {
        Cookie::queue("cart_items", json_encode($cart_items), 60 * 24 * 30);
    }

    static public function clearCartItems()
    {
        Cookie::queue(Cookie::forget("cart_items"));
    }

    static public function getCartItemsFromCookie()
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if (!$cart_items) {
            $cart_items = [];
        }
        return $cart_items;
    }

    static public function IncrementQuantityToCartItems($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            }
        }

        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    static public function DecrementQuantityToCartItems($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                if ($cart_items[$key]['quantity']  > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                }
            }
        }

        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    static public function calculateGrandTotal($items)
    {
        return array_sum(array_column($items, 'total_amount'));
    }
}
