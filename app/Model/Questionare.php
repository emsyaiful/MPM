<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questionare extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'id_questionare';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'user_id',
    	'judul_questionare',
    	'deadline_questionare',
    	'created_at',
    ];
    public $timestamps = false;
    public $incrementing = false;

    public function user() {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
