<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Brand;
use Image;
use File;

use App\Models\User;
use App\Models\Admin;
use Auth;

class BrandsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $user = Auth::user();

        $admin = Admin::where('email',$user->email)->first();

        if(!is_null($admin)){
            $brands = Brand::orderBy('id','desc')->get();
            return view('admin.pages.brand.index',compact('brands'));
        }
        else{
            return view('frontend.pages.error');
        }
    }

    public function create(){
        
        $user = Auth::user();

        $admin = Admin::where('email',$user->email)->first();

        if(!is_null($admin)){
            return view('admin.pages.brand.create');
        }
        else{
            return view('frontend.pages.error');
        } 
    }

    public function store(Request $request){
        
        $request->validate([
            'name' => 'required',
            //'description' => 'required',
            'image' => 'nullable|image',
            // 'price' => 'required|numeric',
            // 'quantity' => 'required|numeric',
        ],
        [
            'name.required' => 'please provide a brand name',
            //'description.required' => 'please provide a brand description',
            'image.image' => 'please provide a valid image with .jpg, .png, .jpeg, .gif',
        ]);
        $brand = new Brand;

        $brand->name = $request->name;
        $brand->description = $request->description;

        if($request->hasFile('brand_image')){
            $image=$request->file('brand_image');
            
            $img=time().'.'.$image->getClientOriginalExtension();
            $location=public_path('images/brands/'.$img);
            Image::make($image)->save($location);

            $brand->image=$img;
        }
        
        
        $brand->save();
        session()->flash('success','Product has added successfully !!');
        return redirect()->route('admin.brands');
    }

    

    public function edit($id){

        $user = Auth::user();

        $admin = Admin::where('email',$user->email)->first();

        if(!is_null($admin)){
            $brand = Brand::find($id);
            return view('admin.pages.brand.edit')->with('brand',$brand);
        }
        else{
            return view('frontend.pages.error');
        } 

    }

    public function update(Request $request, $id){
        
        $request->validate([
            'name' => 'required',
            //'description' => 'required',
            'image' => 'nullable|image',
            // 'price' => 'required|numeric',
            // 'quantity' => 'required|numeric',
        ],
        [
            'name.required' => 'please provide a brand name',
            //'description.required' => 'please provide a brand description',
            'image.image' => 'please provide a valid image with .jpg, .png, .jpeg, .gif',
        ]);
        $brand = Brand::find($id);

        $brand->name = $request->name;
        $brand->description = $request->description;
        

        if($request->hasFile('brand_image')){

            if(File::exists('images/brands/'.$brand->image)){
                File::delete('images/brands/'.$brand->image);
            }

            $image=$request->file('brand_image');
            
            $img=time().'.'.$image->getClientOriginalExtension();
            $location=public_path('images/brands/'.$img);
            Image::make($image)->save($location);

            $brand->image=$img;
        }
       
        // $brand->slug = Str::slug($request->title);
        // $brand->brand_id = 1;
        // $brand->brand_id = 1;
        // $brand->admin_id = 1;
        $brand->save();
        session()->flash('success','brand has updated successfully !!');
        // // insert img to brandimage model

        // if($request->hasFile('brand_image')){
        //     //$image=$request->file('brand_image');
        //     foreach($request->brand_image as $image){
        //     $img=time().'.'.$image->getClientOriginalExtension();
        //     $location=public_path('images/brands/'.$img);
        //     Image::make($image)->save($location);

        //     $brand_image=new brandImage;
        //     $brand_image->brand_id=$brand->id;
        //     $brand_image->image=$img;
        //     $brand_image->save();
        //     }
        // }
        return redirect()->route('admin.brands');
    }

    public function delete($id){
        $brand = Brand::find($id);
        if(!is_null($brand)){

            if(File::exists('images/brands/'.$brand->image)){
                File::delete('images/brands/'.$brand->image);
            }

            $brand->delete();
        }
        session()->flash('success','brand has deleted successfully !!');
        return back();
    }
}
