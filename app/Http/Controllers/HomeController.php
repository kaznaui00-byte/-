<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return response('<h1 style="text-align:center;margin-top:100px">مرحباً بك في سرد</h1>');
    }
}