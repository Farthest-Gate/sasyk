<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostProjects extends Model
{
    //
     use SoftDeletes;
    
    protected $table = 'post_projects';
    protected $primaryKey = 'id';

    protected $dates = ['created_at, updated_at, deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'project_id', 'updated_at', 'updated_by', 'created_by', 'created_at'
    ];
}
