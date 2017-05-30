<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mailer extends Model
{
    //use SoftDeletes;

	protected $table = 'mailsender';
    protected $primaryKey = 'id';
    protected $fillable = [
    	'id',
    	'email',
    	'name',
    	'subject',
    	'body',
    	'timestamp',
    	'is_sent'
    ];
    //protected $dates = ['deleted_at'];

    public $timestamps = false;
    //public $incrementing = false;
}
