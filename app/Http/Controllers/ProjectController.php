<?php

namespace App\Http\Controllers;

use Auth;
use App\Projects;
use App\ProjectAttributes;
use App\Users;
use App\Library\Icon;
use App\Library\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        $projects = Projects::get_projects();
        
        $icons = (new Icon())->get_icons();

        return view('projects', compact('projects', 'icons'));
    }
    
    public function view_project(Request $request){
        $project = Projects::get_project($request->project_id);
        
        $icons = (new Icon())->get_icons();

        return view('project', compact('project', 'icons'));
    }
    
     public function create(Request $request){
        $validated_data = $request->validate([
            'name' => 'required|max:255'
        ]);
        
        if($request->category_id != null){
            $project = new Project($request->category_id);
            $project->update_project($request);
        } else{
            $project = (new Project())->create_project($request);
        }
        return array("error" => false, 'project' => $project);
    }
    
}
