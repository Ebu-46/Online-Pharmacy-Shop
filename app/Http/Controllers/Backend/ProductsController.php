<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Image;
use File;

use App\Models\User;
use App\Models\Admin;
use Auth;

class ProductsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $user = Auth::user();

        $admin = Admin::where('email',$user->email)->first();

        if(!is_null($admin)){
            $products = Product::orderBy('id','desc')->get();
            return view('admin.pages.product.index')->with('products',$products);
        }
        else{
            return view('frontend.pages.error');
        }
        
    }

    public function create(){

        $user = Auth::user();

        $admin = Admin::where('email',$user->email)->first();

        if(!is_null($admin)){
            return view('admin.pages.product.create');
        }
        else{
            return view('frontend.pages.error');
        } 
    }

    public function store(Request $request){
        
        $request->validate([
            'title' => 'required|max:150',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);
        $product = new Product;

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        $product->slug = Str::slug($request->title);
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->admin_id = 1;
        $product->save();

        // insert img to productimage model

        if($request->hasFile('product_image')){
            //$image=$request->file('product_image');
            foreach($request->product_image as $image){
            $img=time().'.'.$image->getClientOriginalExtension();
            $location=public_path('images/products/'.$img);
            Image::make($image)->save($location);

            $product_image=new ProductImage;
            $product_image->product_id=$product->id;
            $product_image->image=$img;
            $product_image->save();
            }
        }

        session()->flash('success','Product has added successfully !!');
        return redirect()->route('admin.product.create');
    }

    

    public function edit($id){

        $user = Auth::user();

        $admin = Admin::where('email',$user->email)->first();

        if(!is_null($admin)){
            $product = Product::find($id);
            return view('admin.pages.product.edit')->with('product',$product);
        }
        else{
            return view('frontend.pages.error');
        } 

    }

    public function update(Request $request, $id){
        
        $request->validate([
            'title' => 'required|max:150',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);
        $product = Product::find($id);

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        // $product->slug = Str::slug($request->title);
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        // $product->admin_id = 1;
        $product->save();
        session()->flash('success','Product has updated successfully !!');
        // // insert img to productimage model

        if($request->hasFile('product_image')){

            foreach($product->images as $image){
                if(File::exists('images/products/'.$image->image)){
                    File::delete('images/products/'.$image->image);
                }
            }

            //$image=$request->file('product_image');
            foreach($request->product_image as $image){
                $img=time().'.'.$image->getClientOriginalExtension();
                $location=public_path('images/products/'.$img);
                Image::make($image)->save($location);

                $product_image=new ProductImage;
                $product_image->product_id=$product->id;
                $product_image->image=$img;
                $product_image->save();
            }
        }
        return redirect()->route('admin.products');
    }

    public function delete($id){
        $product = Product::find($id);
        if(!is_null($product)){
            $product->delete();
        }
        session()->flash('success','Product has deleted successfully !!');
        return back();
    }
}
