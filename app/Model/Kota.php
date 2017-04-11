<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kota extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'kotas';
    protected $primaryKey = 'id_kota';

    protected $fillable = [
        'id_kota', 
        'nama_kota',
        'kares_id',
        'deleted_at',
    ];

    public $incrementing = false;
    public $timestamps = false;

    public function kares() {
        return $this->belongsTo('App\Model\Kares', 'kares_id', 'id_kares');
    }
}
