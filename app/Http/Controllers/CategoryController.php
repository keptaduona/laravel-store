<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        Category::create(['name' => request('name')]);

        return 'OK';
    }

    public function get()
    {
        $categories = Category::pluck('name');

        return $categories;

    }

}
