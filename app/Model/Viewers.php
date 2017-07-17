<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Viewers extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id_viewers';
    protected $dates = ['deleted_at'];
    protected $table = 'viewers';
    protected $fillable = [
    	'user_id',
    	'questionare_id',
    ];

    public $timestamps = false;
    public $incrementing = false;

    public function user() {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function questionare() {
    	return $this->belongsTo('App\Model\Questionare', 'questionare_id', 'id_questionare');
    }
}
