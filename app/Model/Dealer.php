<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
    // use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'dealers';
    protected $primaryKey = 'id_dealer';

    protected $fillable = [
        'id_dealer', 
        'kode_dealer',
        'nama',
        'alamat',
        'status_dealer_id',
        'md_id',
        'kota_id',
        'deleted_at',
    ];

    public $incrementing = false;
    public $timestamps = false;

    public function status() {
        return $this->belongsTo('App\Model\StatusDealer', 'status_dealer_id', 'id_status_dealer');
    }

    public function md() {
        return $this->belongsTo('App\Model\Md', 'md_id', 'id_md');
    }

    public function kota() {
        return $this->belongsTo('App\Model\Kota', 'kota_id', 'id_kota');
    }
}
