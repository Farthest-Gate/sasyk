<?php

namespace App;

use Auth;
use App\Categories;
use App\Projects;
use App\PostAttributes;
use App\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'posts';
    protected $primaryKey = 'post_id';

    protected $dates = ['created_at, updated_at, deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'title', 'post_type', 'content', 'updated_at', 'updated_by', 'created_by', 'created_at'
    ];
    
    public static function add_category_name($categories){
        foreach($categories as $cat){
            $category = Categories::find($cat->category_id);
            $cat['name'] = $category->name;
        }
        return $categories;
    }
    public static function add_project_name($projects){
        foreach($projects as $proj){
            $project = Projects::find($proj->project_id);
            $proj['name'] = $project->name;
        }
        $ye = "TESTING";
        $Just introducing a bug to test codoacy
            
        return $projects;
    }
    
    public static function get_post($post_id){
        $post = Posts::where('post_id', $post_id)->where('company_id', Auth::user()->company_id)->first();
        if($post == null){
            return false;
        }
        $updated = Users::find($post->updated_by);
        $post['updated_by_name'] = $updated->name;
        $created = Users::find($post->created_by);
        $post['created_by_name'] = $created->name;

        $attributes = PostAttributes::where('post_id', $post->post_id)->get();
        $post['attributes'] = $attributes;
        $categories = PostCategories::where('post_id', $post->post_id)->get();                        
        $post['categories'] = Posts::add_category_name($categories);
        $projects = PostProjects::where('post_id', $post->post_id)->get();
        $post['projects'] = Posts::add_project_name($projects);

        return $post;
    }
    
    public static function get_posts(){
        $posts = Posts::where('company_id', Auth::user()->company_id)->get();
        
        foreach($posts as $post){
            $updated = Users::find($post->updated_by);
            $post['updated_by_name'] = $updated->name;
            $attributes = PostAttributes::where('post_id', $post->post_id)->get();
            $post['attributes'] = $attributes;
            $categories = PostCategories::where('post_id', $post->post_id)->get();                        
            $post['categories'] = Posts::add_category_name($categories);
            $projects = PostProjects::where('post_id', $post->post_id)->get();
            $post['projects'] = Posts::add_project_name($projects);

        }
        
        return $posts;
    }
}
