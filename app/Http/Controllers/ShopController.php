<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function createShop(Request $request)
    {
        try{
            $user = User::find(\Auth::user()->id);

            $data = $request->validate([
                'shop' => 'required|max:255|unique:shop'
            ]);

            if(count($user->shops()->get()) < 1) {
                Shop::create([
                    'shop' => $data['shop'],
                    'user' => \Auth::user()->id,
                    'max_prod' => 50,
                ]);
            } else {
                return response("User already have a shop!", 201);
            }
            return response("Shop created!",201);
        } catch (\Throwable $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    public function listAllShops()
    {
        try {
            return Shop::all();
        } catch (\Throwable $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    public function listUserShop()
    {
        try{
            $user = User::find(\Auth::user()->id);
            return $user->shops()->get();
        } catch (\Throwable $exception) {
            return response($exception->getMessage(), 500);
        }
    }

}
