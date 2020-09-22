<?php

namespace App;

use Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Contact extends Model
{
    //
        //
    use SoftDeletes;
    
    protected $table = 'contact';
    protected $primaryKey = 'id';

    protected $dates = ['created_at, updated_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'message', 'email', 'updated_at', 'created_at'
    ];
    
}
