<?php

namespace App\Http\Controllers;

use Auth;
use App\Categories;
use App\Users;
use App\Library\Category;
use App\Library\Icon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index(Request $request){        
        $categories = Categories::get_categories();
        $icons = (new Icon())->get_icons();
        return view('categories', compact('categories', 'icons'));
    }
    
    public function view_category(Request $request){
        $category = Categories::get_category($request->category_id);
        $icons = (new Icon())->get_icons();
        return view('category', compact('category', 'icons'));

    }
    
    public function create(Request $request){
        $validated_data = $request->validate([
            'name' => 'required|max:255'
        ]);
        
        if($request->category_id != null){
            $category = new Category($request->category_id);
            $category->update_category($request);
        } else{
            $category = (new Category())->create_category($request);
        }
        return array("error" => false);
    }
    

}
