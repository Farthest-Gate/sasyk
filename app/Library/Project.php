<?php

namespace App\Library;

use Auth;

use App\Projects;
use App\ProjectAttributes;
use Carbon\Carbon;

class Project {
    
    private $id;
    private $name;
    private $description;
    private $project;
    private $project_attributes;
    
    public function __construct($id = null){
        
        $project = Projects::find($id);
        if($project != null){
            $this->id = $id;
            $this->name = $project->name;
            $this->description = $project->description;
            $this->project_attributes = ProjectAttributes::where('project_id', $id)->get();
            $this->project = $project;
        }
    }
    
    public function get_id(){
        return $this->id;
    }
    
    public function get_name(){
        return $this->name;
    }
    
    public function set_name($name){
        $this->project->name = $name;
        $this->project->save();
    }
    
    public function get_description(){
        return $this->description;
    }
    
    public function set_desription($description){
        $this->project->description = $description;
        $this->project->save();
    }
    
    public function get_attributes(){
        return $this->project_attributes;
    }
    
    public function remove_all_attributes(){
        ProjectAttributes::where('project_id', $this->id)->delete();
    }
    
    public function set_attribute($attr_name, $attr_value){
        $attribute = ProjectAttributes::where('project_id', $this->id)->where('attr_name', $attr_name)->first();
        
        $id = $this->id;
        if($attribute == null){
            ProjectAttributes::create([
                'project_id' => $id,
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
    
    public function update_project($request){
        if($this->project != null){
            $this->project->name = $request->name;
            $this->project->description = $request->description;
            $this->project->icon = $request->icon;
            $this->project->updated_by = Auth::user()->id;
            $this->project->updated_at = Carbon::now();
            $this->project->save();
        
            $this->remove_all_attributes();
            $attrs = $request->attrs;
            if($attrs != null){
                foreach($attrs as $name => $value){
                    $this->set_attribute($name, $value);
                }
            }
        }
    }
    
    public static function create_project($request){
        $project = Projects::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'company_id' => Auth::user()->company_id,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);
        $proj = new Project($project->project_id);
       
        if(isset($request->attrs)){
            $attrs = $request->attrs;
            foreach($attrs as $name => $value){
                $proj->set_attribute($name, $value);
            }
        }
        return $project;
    }
}
















