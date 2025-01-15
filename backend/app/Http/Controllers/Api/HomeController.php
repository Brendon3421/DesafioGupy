<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class HomeController extends Controller
{
    public function __construct() {}


    public function Dashboard()
    {
        return view('dashboard');
    }

    public function Post()
    {
        $category = Category::all();
        return view('forms.cadastrarTask', compact('category'));
    }
}
