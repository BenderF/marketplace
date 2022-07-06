<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertProductRequest;
use App\Models\Product;
use App\Models\Shop;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function insertProductIntoShop(InsertProductRequest $request)
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
                    'shop' => $request->get('shop'),
                    'price' => $request->get('price')
                ]);
            } else {
                return response("Shop is full!", 201);
            }
            return response("Product created!", 201);
        } catch (\Throwable $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    public function deleteProduct(Request $request)
    {
        try {
            $data = $request->validate([
                'product_id' => 'required|integer'
            ]);

            Product::destroy($data['product_id']);
            return response("Product deleted", 201);
        } catch (\Throwable $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    public function listShopProducts(Request $request)
    {
        try {
            $data = $request->validate([
                'shop_id' => 'required|integer'
            ]);

            return response(Product::where('shop', $data['shop_id'])->get(), 200);
        } catch (\Throwable $exception) {
            return response($exception->getMessage(), 500);
        }
    }
}
