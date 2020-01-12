<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Image;

use App\Models\User;
use App\Models\Admin;
use Auth;

class PagesController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $user = Auth::user();

        $admin = Admin::where('email',$user->email)->first();

        if(!is_null($admin)){
            return view('admin.pages.index',compact('admin'));
        }
        else{
            return view('frontend.pages.error');
        }

        //return view('admin.pages.index');
    }
    
}
