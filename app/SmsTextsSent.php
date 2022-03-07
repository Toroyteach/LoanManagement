<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsTextsSent extends Model
{
    //

    public $table = 'sms_texts_sents';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'type',
        'description',
        'user_id',
        'smsclientid',
        'messageid',
    ];
}
