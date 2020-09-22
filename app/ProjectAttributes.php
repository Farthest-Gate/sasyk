<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectAttributes extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'project_attributes';
    protected $primaryKey = 'id';

    protected $dates = ['created_at, updated_at, deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'attr_name', 'attr_value', 'updated_at', 'updated_by', 'created_by', 'created_at'
    ];
}
