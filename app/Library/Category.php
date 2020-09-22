<?php

namespace App\Library;

use Auth;
use Carbon\Carbon;

use App\Categories;


class Category {
    
    private $id;
    private $name;
    private $description;
    private $category;
    
    public function __construct($id = null){
        $this->category = Categories::find($id);
        
        if($this->category != null){
            $this->id = $id;
            $this->name = $this->category->name;
            $this->description = $this->category->description;
        }
    }
    
    public function get_id(){
        return $this->id;
    }
    
    public function get_name(){
        return $this->name;
    }
    
    public function set_name($name){
        $this->category->name = $name;
        $this->category->save();
    }
    
    public function get_description(){
        return $this->description;
    }
    
    public function set_desription($description){
        $this->category->description = $description;
        $this->category->save();
    }
    
    public function update_category($request){
        if($this->category != null){
            $this->category->name = $request->name;
            $this->category->description = $request->description;
            $this->category->icon = $request->icon;
            $this->category->updated_by = Auth::user()->id;
            $this->category->updated_at = Carbon::now();
            $this->category->save();
        }
    }
    
    public static function create_category($request){
        $category = Categories::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'company_id' => Auth::user()->company_id,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);
        
        return $category;
    }
}