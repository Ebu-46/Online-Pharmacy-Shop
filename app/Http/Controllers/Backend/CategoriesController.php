<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;
use Image;
use File;

use App\Models\User;
use App\Models\Admin;
use Auth;

class CategoriesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $user = Auth::user();

        $admin = Admin::where('email',$user->email)->first();

        if(!is_null($admin)){
            $categories = Category::orderBy('id','desc')->get();
            return view('admin.pages.category.index',compact('categories'));
        }
        else{
            return view('frontend.pages.error');
        }
    }

    public function create(){

        $user = Auth::user();

        $admin = Admin::where('email',$user->email)->first();

        if(!is_null($admin)){
            $main_categories = Category::orderBy('name','desc')->where('parent_id',NULL)->get();
            return view('admin.pages.category.create',compact('main_categories'));
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
            'name.required' => 'please provide a category name',
            //'description.required' => 'please provide a category description',
            'image.image' => 'please provide a valid image with .jpg, .png, .jpeg, .gif',
        ]);
        $category = new Category;

        $category->name = $request->name;
        $category->description = $request->description;

        if($request->hasFile('category_image')){
            $image=$request->file('category_image');
            
            $img=time().'.'.$image->getClientOriginalExtension();
            $location=public_path('images/categories/'.$img);
            Image::make($image)->save($location);

            $category->image=$img;
        }
        
        $category->parent_id = $request->parent_id;
        $category->save();
        session()->flash('success','Product has added successfully !!');
        return redirect()->route('admin.categories');
    }

    

    public function edit($id){

        $user = Auth::user();

        $admin = Admin::where('email',$user->email)->first();

        if(!is_null($admin)){
            $category = Category::find($id);
            $main_categories = Category::orderBy('name','desc')->where('parent_id',NULL)->get();
            return view('admin.pages.category.edit',compact('main_categories'))->with('category',$category);
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
            'name.required' => 'please provide a category name',
            //'description.required' => 'please provide a category description',
            'image.image' => 'please provide a valid image with .jpg, .png, .jpeg, .gif',
        ]);
        $category = category::find($id);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;

        if($request->hasFile('category_image')){

            if(File::exists('images/categories/'.$category->image)){
                File::delete('images/categories/'.$category->image);
            }

            $image=$request->file('category_image');
            
            $img=time().'.'.$image->getClientOriginalExtension();
            $location=public_path('images/categories/'.$img);
            Image::make($image)->save($location);

            $category->image=$img;
        }
       
        // $category->slug = Str::slug($request->title);
        // $category->category_id = 1;
        // $category->brand_id = 1;
        // $category->admin_id = 1;
        $category->save();
        session()->flash('success','category has updated successfully !!');
        // // insert img to categoryimage model

        // if($request->hasFile('category_image')){
        //     //$image=$request->file('category_image');
        //     foreach($request->category_image as $image){
        //     $img=time().'.'.$image->getClientOriginalExtension();
        //     $location=public_path('images/categories/'.$img);
        //     Image::make($image)->save($location);

        //     $category_image=new categoryImage;
        //     $category_image->category_id=$category->id;
        //     $category_image->image=$img;
        //     $category_image->save();
        //     }
        // }
        return redirect()->route('admin.categories');
    }

    public function delete($id){
        $category = category::find($id);
        if(!is_null($category)){

            if($category->parent_id==NULL){
                $sub_categories=Category::orderBy('name','desc')->where('parent_id',$category->id)->get();
                foreach($sub_categories as $sub_category){
                    if(File::exists('images/categories/'.$sub_category->image)){
                        File::delete('images/categories/'.$sub_category->image);
                    }
                    $sub_category->delete();
                }
            }

            if(File::exists('images/categories/'.$category->image)){
                File::delete('images/categories/'.$category->image);
            }

            $category->delete();
        }
        session()->flash('success','category has deleted successfully !!');
        return back();
    }
}
