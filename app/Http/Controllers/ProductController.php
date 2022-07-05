<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function insertProductIntoShop(Request $request)
    {
        try {
            //Check if shop has space for product
            $shop = Shop::find($request->get('shop'));

            if ($shop->max_prod > count($shop->products()->get())) {
                //Insert product into shop
                Product::create([
                    'product' => $request->get('product'),
                    'category' => $request->get('category'),
                    'stock' => $request->get('stock'),
                    'shop' => $request->get('shop')
                ]);
            } else {
                return response("Shop is full!", 201);
            }
            return [201, "Product created!"];
        } catch (\Throwable $exception) {
            abort(500, $exception->getMessage());
        }
    }
}
