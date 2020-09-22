<?php

namespace App\Http\Controllers;

use App\Projects;
use App\Posts;
use App\Categories;
use App\Library\Icon;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $projects = Projects::get_projects()->sortByDesc('updated_at');
        $posts = Posts::get_posts()->sortByDesc('updated_at');
        $categories = Categories::get_categories()->sortByDesc('updated_at');
        $icons = (new Icon())->get_icons();
        return view('home', compact('posts', 'categories', 'projects'));
    }
}
