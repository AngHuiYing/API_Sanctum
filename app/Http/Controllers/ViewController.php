<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index(){
        return view('login');
    }

    public function register(){
        return view('register');
    }

    public function dashboard(){
        return view('dashboard');
    }

    public function addProduct(){
        return view('addProduct');
    }
    
    public function viewProduct(){
        return view('viewProduct');
    }

}
