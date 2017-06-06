<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Uuids;

class User extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_status', 
        'email', 
        'password',
        'division_id',
        'dealer_id',
        'status_dealer_id',
        'md_id',
        'is_active',
        'created_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $incrementing = false;

    public function division() {
        return $this->belongsTo('App\Model\Division', 'division_id', 'id_division');
    }

    public function dealer() {
        return $this->belongsTo('App\Model\Dealer', 'dealer_id', 'id_dealer');
    }
}
