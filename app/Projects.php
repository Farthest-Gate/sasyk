<?php

namespace App;

use Auth;
use App\PostProjects;
use App\ProjectAttributes;
use App\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Projects extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'projects';
    protected $primaryKey = 'project_id';

    protected $dates = ['created_at, updated_at, deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'icon', 'company_id', 'updated_at', 'updated_by', 'created_by', 'created_at'
    ];
    
    public static function get_projects(){
        $projects = Projects::where('company_id', Auth::user()->company_id)->get();
        
        foreach($projects as $project){
            $updated = Users::find($project->updated_by);
            $project->updated_by_name = $updated->name;
            $attributes = ProjectAttributes::where('project_id', $project->project_id)->get();
            $project->project_attributes = $attributes;
        }
        return $projects;
    }
    
    public static function get_project($project_id){
        $project = Projects::where('company_id', Auth::user()->company_id)->where('project_id', $project_id)->first();
        
        $updated = Users::find($project->updated_by);
        $project->updated_by_name = $updated->name;
        $attributes = ProjectAttributes::where('project_id', $project->project_id)->get();
        $project->project_attributes = $attributes;
        
        // get posts
        $posts = PostProjects::where('project_id', $project_id)->get();
        $posts_full = array();
        foreach($posts as $post){
            $post = Posts::find($post->post_id);
            $post_obj = array('post_id' => $post->post_id, 'title' => $post->title);
            array_push($posts_full, $post_obj);
        }
        $project->posts = $posts_full;
        return $project;
    }
}
