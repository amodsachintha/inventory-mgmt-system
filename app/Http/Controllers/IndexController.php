<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function show(){
        if(Auth::check()){
            return view('pages/index');
        }
        else
            return "Error 403: Forbidden";
    }
}
