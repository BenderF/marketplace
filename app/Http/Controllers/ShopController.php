<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function createFreeShop(Request $request)
    {
        try{
            $user = User::find(\Auth::user()->id);

            if(count($user->shops()->get()) < 1) {
                Shop::create([
                    'shop' => $request->get('shop'),
                    'user' => \Auth::user()->id,
                    'max_prod' => 5,
                ]);
            } else {
                return "User already have a free shop!";
            }
            return 201;
        } catch (\Throwable $exception) {
            abort(500, $exception->getMessage());
        }
    }

    public function list()
    {
        $user = User::find(\Auth::user()->id);
        return $user->shops()->get();
    }

}
