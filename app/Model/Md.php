<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Md extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'mds';
    protected $primaryKey = 'id_md';

    protected $fillable = [
        'id_md', 
        'nama_md',
        'deleted_at',
    ];

    public $incrementing = false;
    public $timestamps = false;
}
