<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponsPenerima extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id_respons_penerima';
    protected $fillable = [
    	'user_id',
    	'questionare_id',
    	'detail_questionare_id',
    	'response',
    	'deleted_at',
    	'created_at',
    ];
    protected $dates = ['deleted_at'];

    public $timestamps = false;
    public $incrementing = false;

    public function detailQuestionare() {
        return $this->belongsTo('App\Model\DetailQuestionare', 'detail_questionare_id', 'id_detail_questionare');
    }
}
