<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}
