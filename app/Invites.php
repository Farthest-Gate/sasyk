<?php

namespace App;

use Auth;
use App\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Invites extends Model
{
    //


    //
    use SoftDeletes;
    
    protected $table = 'invites';
    protected $primaryKey = 'id';

    protected $dates = ['created_at, updated_at, deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'company_id', 'token', 'expires', 'updated_at', 'updated_by', 'created_by', 'created_at'
    ];

}


