<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBulk extends Model
{
    use HasFactory;

    public $table = 'user_bulks';

    protected $fillable = [
        'fristname',
        'lastname',
        'middlename',
        'nationalid',
        'number',
        'memberno',
    ];
}
