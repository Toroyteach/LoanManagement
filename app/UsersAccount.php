<?php

namespace App;

use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersAccount extends Model
{
    //
    use SoftDeletes, Auditable;

    public $table = 'users_accounts';

    protected $dates = [
        'created_at',
        'updated_at',
        'delted_at',
    ];

    protected $fillable = [
        'total_amount',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}
