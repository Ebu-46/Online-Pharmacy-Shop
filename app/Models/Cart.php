<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Cart extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function totalCarts(){

        if(Auth::check()){
            $carts = Cart::Where('user_id',Auth::id())
            ->where('order_id',NULL)
            ->get();
        }
        else{
            $carts = Cart::Where('ip_address',request()->ip())
            ->where('order_id',NULL)
            ->get();
        }
        
        return $carts;
    }

    public static function totalItems(){

        // if(Auth::check()){
        //     $carts = Cart::Where('user_id',Auth::id())->get();
        // }
        // else{
        //     $carts = Cart::Where('ip_address',request()->ip())->get();
        // }

        $carts = Cart::totalCarts();
        $total_item = 0;
        foreach($carts as $cart){
            $total_item += $cart->product_quantity;
        }
        
        return $total_item;
    }
}
