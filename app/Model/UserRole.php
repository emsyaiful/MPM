<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'nama',
    	'divisi',
    	'deleted_at',
    ];
    public $timestamps = false;
    public $incrementing = false;
    
    public function user() {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
