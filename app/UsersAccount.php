<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

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
        'modified_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }

    public function logs()
    {
        return $this->morphMany(AuditLog::class, 'subject');
    }
}
