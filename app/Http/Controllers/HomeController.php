<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Category;
class HomeController extends Controller
{
    public function index()
{
    $slides = Slide::where('status', 1)->get()->take(3);
    $categories = Category::orderBy('name')->get();
    return view('index', compact('slides', 'categories'));
}
}
