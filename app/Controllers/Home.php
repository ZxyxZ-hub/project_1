<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home'); // this loads your landing page
    }
}