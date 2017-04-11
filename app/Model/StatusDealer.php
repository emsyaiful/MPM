<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusDealer extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'status_dealers';
    protected $primaryKey = 'id_status_dealer';

    protected $fillable = [
        'id_status_dealer', 
        'nama_status', 
        'deleted_at',
    ];

    public $incrementing = false;
    public $timestamps = false;
}
