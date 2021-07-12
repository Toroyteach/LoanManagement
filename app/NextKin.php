<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NextKin extends Model
{
    use SoftDeletes;
    //
    public $table = 'next_kin';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'phone',
        'relationship',
        'user_id',
    ];
}
