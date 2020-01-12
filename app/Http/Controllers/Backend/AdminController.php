<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use Auth;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
}
