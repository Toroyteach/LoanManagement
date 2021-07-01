<?php

namespace App;

use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersAccount extends Model
{
    //

    public $table = 'users_accounts';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'total_amount',
        'user_id',
    ];
}
