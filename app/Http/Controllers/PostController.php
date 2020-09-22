<?php

namespace App\Http\Controllers;

use Auth;
use App\Categories;
use App\Posts;
use App\PostAttributes;
use App\Projects;
use App\Users;
use App\Library\Icon;
use App\Library\Post;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Response;


class PostController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        $posts = Posts::get_posts();
        return view('posts', compact('posts'));
    }
    
    public function view_create_post(Request $request){
        $categories = Categories::get_categories();
        $projects = Projects::get_projects();
        $posts = Posts::get_posts();

        return view('create-post', compact('posts', 'categories', 'projects'));
    }
    
    public function view_post(Request $request){
        $post = Posts::get_post($request->post_id);
        if(!$post){
            return ["error" => "404"];
        }
        
        return view('view-post', compact('post'));
    }
    
    public function view_update_post(Request $request){
        $post = Posts::get_post($request->post_id);
        if(!$post){
            return ["error" => "404"];
        }
        $categories = Categories::get_categories();
        $projects = Projects::get_projects();
        $posts = Posts::get_posts();

        return view('create-post', compact('posts', 'categories', 'projects', 'post'));
    }
    
    public function create_post(Request $request){
        $post;
        $validated_data = $request->validate([
//            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'content' => 'required',
            'attrs' => 'nullable',
            'projects' => 'nullable',
            'categories' => 'nullable',
            'type' => 'nullable',
            'update_post_id' => 'nullable'
        ]);
        if($request->update_post_id != null){
            $post = new Post($request->update_post_id);
            $post = $post->update_post($request);

            //            $category = new Category($request->category_id);
//            $category->update_category($request);
        } else{
            $post = (new Post())->create_post($request);
        }

        return array("error" => false, "post" => $post);
    
    }
    
    public function upload_image(Request $request){
        if($request->hasFile('document')) {
            $file = $request->file('document');
            // CHECK EXTENSIION IS ALLOWED
            $accepted_extensions = array('jpeg','bmp','png','pdf','jpg');
            $file_size = $request->file('document')->getSize();
            if($file_size > 5000000){
                return array("success" => false, "error" => "This file is ". number_format((float)$file_size / 1000000, 2, '.', '') . "mb. Maximum file size is 5mb");
            }
            
            $path_to_folder = storage_path('app/public/uploads/'.Auth::user()->id.'/');
            
            
            if (!File::isDirectory($path_to_folder)){
                File::makeDirectory($path_to_folder, 0777, true, true);
            }
            
            $file_name = Carbon::now()->timestamp . "." .$file->getClientOriginalExtension();
            $file->move($path_to_folder, $file_name);
            $image_url = route('view-image', ['image' => $file_name]);
            return array("success" => true, "url" =>$image_url);
        } else {
            return array("success" => false, "error" => "No file found");
        }
    }
    
    
    public function view_image(Request $request){
        
        $image_name = $request->image;

        $path = $path_to_folder = storage_path('app/public/uploads/'.Auth::user()->id.'/') . $image_name;


        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }
            

        $file = File::get($path);
        $ext = $ext = pathinfo($path, PATHINFO_EXTENSION);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $ext);

        return $response;
        
    }
    
}
