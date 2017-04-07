<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailQuestionare extends Model
{
	use SoftDeletes;

    protected $primaryKey = 'id_detail_questionare';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'questionare_id',
    	'pertanyaan',
    	'jenis_pertanyaan',
    	'created_at',
    ];

    public $timestamps = false;
    public $incrementing = false;
}
