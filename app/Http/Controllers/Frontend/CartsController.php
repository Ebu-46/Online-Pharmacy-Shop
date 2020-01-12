<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Auth;

class CartsController extends Controller
{
    public function index(){
        $carts = Cart::totalCarts();
        return view('frontend.pages.cart.index',compact('carts'));
    }

    public function store(Request $request){

        if(Auth::check()){
            $cart = Cart::Where('user_id',Auth::id())
                      ->where('order_id',NULL)
                      ->where('product_id',$request->product_id)
                      ->first();
        }

        else{
            $cart = Cart::Where('ip_address',request()->ip())
                      ->where('order_id',NULL)  
                      ->where('product_id',$request->product_id)
                      ->first();
        }

        //dd($cart);
         
        if(!is_null($cart)){
            $cart->increment('product_quantity');
            $cart->save();
        }
        else{
            $cart = new Cart;

            if(Auth::check()){
                $cart->user_id = Auth::id(); 
            }
            $cart->product_id = $request->product_id;
            $cart->ip_address = request()->ip(); 

            $cart->save();
        }
        
        session()->flash('success','Product has been added to cart successfuly!');
        return back();
    }

    public function update(Request $request,$id){
        $cart = Cart::find($id);
        if(!is_null($cart)){
            $cart->product_quantity = $request->product_quantity;
            $cart->save();
        }
        session()->flash('success','cart has updated successfully !!');
        return back();
    }


    public function delete($id){
        $cart = Cart::find($id);
        if(!is_null($cart)){
            $cart->delete();
        }
        session()->flash('success','cart has deleted successfully !!');
        return back();
    }

}
