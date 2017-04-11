<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kares extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'kares';
    protected $primaryKey = 'id_kares';

    protected $fillable = [
        'id_kares', 
        'nama_kares', 
        'deleted_at',
    ];

    public $incrementing = false;
    public $timestamps = false;

}
