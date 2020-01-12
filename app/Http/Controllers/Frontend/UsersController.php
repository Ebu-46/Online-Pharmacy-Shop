<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Admin;
use Auth;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function dashboard(){

        $user = Auth::user();

        $admin = Admin::where('email',$user->email)->first();

        if(!is_null($admin)){
            return view('admin.pages.index',compact('admin'));
        }
        else{
            return view('frontend.pages.user.dashboard',compact('user'));
        }
    }

    public function edit(){
        $user = Auth::user();
        return view('frontend.pages.user.edit',compact('user'));
    }

    public function update(Request $request){
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            //'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != NULL || $request->password != "")
            $user->password = Hash::make($request->password); 
        $user->save();

        session()->flash('success','User profile has updated successfuly!');
        //return back();
        return view('frontend.pages.user.dashboard',compact('user'));
    }

}
