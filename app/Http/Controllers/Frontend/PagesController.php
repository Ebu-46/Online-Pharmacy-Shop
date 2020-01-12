<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
class PagesController extends Controller
{
    public function index(){
        $products = Product::orderBy('id','desc')->paginate(8);
        return view('frontend.pages.index',compact('products'));
    }

    public function contact(){
        return view('frontend.pages.contact');
    }

    public function search(Request $request){
        $search = $request->search;
        $products = Product::orwhere('title','like','%'.$search.'%')
        ->orwhere('description','like','%'.$search.'%')
        ->orwhere('price','like','%'.$search.'%')
        ->orwhere('quantity','like','%'.$search.'%')
        ->orderBy('id','desc')->paginate(9);

        return view('frontend.pages.search',compact('search','products'));
    }
}
