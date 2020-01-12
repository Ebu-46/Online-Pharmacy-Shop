<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Auth;

class CheckoutsController extends Controller
{
    public function index(){
        // if(Auth::check()){
        //     $carts = Cart::Where('user_id',Auth::id())->get();
        // }
        // else{
        //     $carts = Cart::Where('ip_address',request()->ip())->get();
        // }
        $carts = Cart::totalCarts();
        return view('frontend.pages.checkout.index',compact('carts'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'phone_no' => 'required|numeric',
            'email' => 'nullable|email',
            'shipping_address' => 'required',
            'payment_short_name' => 'required',
        ],
        [
            'name.required' => 'please provide receiver name',
            'phone_no.required' => 'please provide receiver phone number',
            'email.email' => 'please provide a valid email example abc@xyz',
            'shipping_address.required' => 'please provide shipping address',
            'payment_short_name.required' => 'please select payment method',

        ]);

        $order = new Order;

        if($request->payment_short_name != 'cash_in'){
            if($request->transaction_id == NULL || $request->transaction_id == ''){
                session()->flash('Errors','Please provide transaction code for your payment');
                return back();
            }
            else{
                $order->transaction_id = $request->transaction_id;
            }
        }

        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone_no = $request->phone_no;
        $order->shipping_address = $request->shipping_address;
        $order->ip_address = request()->ip();

        if(Auth::check()){
            $order->user_id = Auth::id();
        }

        $order->payment_id = Payment::where('short_name',$request->payment_short_name)->first()->id;
        $order->save();

        $carts = Cart::totalCarts();
        foreach($carts as $cart){
            $cart->order_id = $order->id;
            $cart->save();
        }

        session()->flash('success','your order has been taken successfuly! Please wait Admin will soon confirm it.');
        return redirect()->route('index');
    }

}
