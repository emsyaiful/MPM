<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'user_divisions';
    protected $primaryKey = 'id_division';

    protected $fillable = [
        'id_division',
        'kode_divisi', 
        'nama', 
        'divisi',
        'deleted_at',
    ];

    public $incrementing = false;
    public $timestamps = false;
}
