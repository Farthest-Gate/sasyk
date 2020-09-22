<?php

namespace App\Library;

use Auth;
use App\Posts;
use App\PostAttributes;
use App\PostCategories;
use App\PostProjects;
use Carbon\Carbon;

use App\Categories;


class Post {
    private $post;
    private $id;
    private $title;
    private $content;
    private $attributes;
    private $categories;
    private $projects;
    private $post_type;
    
    public function __construct($id = null){
        
        $post = Posts::find($id);
        if($post != null){
            $this->post = $post;
            $this->id = $id;
            $this->title = $post->title;
            $this->content = $post->content;
            $this->post_type = $post->post_type;
            $this->attributes = PostAttributes::where('post_id', $id)->get();
            $this->categories = PostCategories::where('post_id', $id)->get();
            $this->projects = PostProjects::where('post_id', $id)->get();
        }
    }
    
    public function get_title(){
        return $this->title;
    }
    
    public function set_title($title){
        $this->title = $title;
        $this->post->title = $title;
        $this->post->save();
    }
    
    public function get_content(){
        return $this->content;
    }
    
    public function set_content($content){
        $this->content = $content;
        $this->post->content = $content;
        $this->post->save();
    }
    
    public function get_post_type(){
        return $this->post_type;
    }
    
    public function set_post_type($post_type){
        $this->post_type = $post_type;
        $this->post->post_type = $post_type;
        $this->post->save();
    }
    
    public function get_attributes(){
        return $this->attributes;
    }
    
    public function remove_all_attributes(){
        PostAttributes::where('post_id', $this->id)->delete();
        $this->attributes = PostAttributes::where('post_id', $this->id)->get();
    }
    
    public function set_attribute($attr_name, $attr_value){
        $attribute = PostAttributes::where('post_id', $this->id)->where('attr_name', $attr_name)->first();
        
        $id = $this->id;
        if($attribute == null){
            PostAttributes::create([
                'post_id' => $id,
                'attr_value' => $attr_value,
                'attr_name' => $attr_name,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);
        } else {
            $attribute->attr_value = $attr_value;
            $attribute->updated_at = Carbon::now();
            $attribute->updated_by = Auth::user()->id;
            $attribute->save();
        }
    }
    
    public function get_categories(){
        return $this->categories;
    }
    
    public function remove_category($category_id){
        PostCategories::where('post_id', $this->id)->where('category_id', $category_id)->delete();
        $this->categories = PostCategories::where('category_id', $this->id)->get();
    }
    
    public function remove_all_categories(){
        PostCategories::where('post_id', $this->id)->delete();
        $this->categories = PostCategories::where('category_id', $this->id)->get();
    }
    
    public function set_category($category_id){
        $category = PostCategories::where('post_id', $this->id)->where('category_id', $category_id)->first();
        
        $id = $this->id;
        if($category == null){
            PostCategories::create([
                'post_id' => $id,
                'category_id' => $category_id,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);
        } 
        $this->categories = PostCategories::where('category_id', $this->id)->get();
    }
    
    public function get_projects(){
        return $this->projects;
    }
    
    public function remove_project($project_id){
        $project = PostProjects::where('post_id', $this->id)->where('project_id', $project_id)->delete();
        $this->projects = PostProjects::where('project_id', $this->id)->get();
    }
    
    public function remove_all_projects(){
        PostProjects::where('post_id', $this->id)->delete();
        $this->projects = PostProjects::where('project_id', $this->id)->get();
    }
    
    public function set_project($project_id){
        $project = PostProjects::where('post_id', $this->id)->where('project_id', $project_id)->first();
        
        $id = $this->id;
        if($project == null){
            PostProjects::create([
                'post_id' => $id,
                'project_id' => $project_id,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);
        }
        $this->projects = PostProjects::where('project_id', $this->id)->get();
    }
    
    public function update_post($request){
        if($this->post != null){
            
            
            $this->post->title = $request->title;
            $this->post->content = $request->content;
            $this->post->post_type = $request->type;
            $this->post->updated_at = Carbon::now();
            $this->post->updated_by = Auth::user()->id;
            $this->post->save();
            $this->remove_all_attributes();
            if(isset($request->attrs)){
                $attrs = json_decode($request->attrs);
                foreach($attrs as $name => $value){
                    $this->set_attribute($name, $value);
                }
            } 
            //set categories
            $this->remove_all_categories();
            if(isset($request->categories)){
                foreach($request->categories as $cat){
                    $this->set_category($cat);
                }
            }

            //set projects
            $this->remove_all_projects();
            if(isset($request->projects)){
                foreach($request->projects as $proj){
                    $this->set_project($proj);
                }
            }

        }
        return $this->id;
    }
    
    public static function create_post($request){
        $post = Posts::create([
            'title' => $request->title,
            'content' => $request->content,
            'post_type' => $request->type,
            'company_id' => Auth::user()->company_id,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);
        $post = new Post($post->post_id);

        // set attributes
        if(isset($request->attrs)){
            $attrs = $request->attrs;
            foreach($attrs as $name => $value){
                $post->set_attribute($name, $value);
            }
        }
        //set categories
        $post->remove_all_categories();
        if(isset($request->categories)){
            foreach($request->categories as $cat){
                $post->set_category($cat);
            }
        }
        
        //set projects
        $post->remove_all_projects();
        if(isset($request->projects)){
            foreach($request->projects as $proj){
                $post->set_project($proj);
            }
        }
        // set type
        
        
        return $post->id;
    }
    
}