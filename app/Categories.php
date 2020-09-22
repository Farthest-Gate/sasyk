<?php

namespace App;

use Auth;
use App\Users;
use App\Posts;
use App\PostCategories;
use App\Library\Post;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'categories';
    protected $primaryKey = 'category_id';

    protected $dates = ['created_at, updated_at, deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'icon', 'company_id', 'updated_at', 'updated_by', 'created_by', 'created_at'
    ];
    
    public static function get_categories(){
        $categories = Categories::where('company_id', Auth::user()->company_id)->get();
        foreach($categories as $category){
            $updated = Users::find($category->updated_by);
            $category->updated_by_name = $updated->name;
        }
        return $categories;
    }
    public static function get_category($category_id){
        $category = Categories::where('company_id', Auth::user()->company_id)->where('category_id', $category_id)->first();
        $updated = Users::find($category->updated_by);
        $category->updated_by_name = $updated->name;
        
        $posts = PostCategories::where('category_id', $category_id)->get();
        $posts_full = array();
        foreach($posts as $post){
            $post = Posts::find($post->post_id);
            $post_obj = array('post_id' => $post->post_id, 'title' => $post->title);
            array_push($posts_full, $post_obj);
            
        }
        $category->posts = $posts_full;
        return $category;
    }
}
