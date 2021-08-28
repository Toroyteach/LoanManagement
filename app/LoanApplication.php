<?php

namespace App;

use App\Observers\LoanApplicationObserver;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class LoanApplication extends Model
{
    use SoftDeletes, MultiTenantModelTrait, Auditable;

    public $table = 'loan_applications';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'loan_entry_number',
        'loan_amount',
        'description',
        'repaid_amount',
        'repaid_status',
        'duration',
        'loan_type',
        'analyst_id',
        'firebaseid',
        'cfo_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'status_id',
    ];

    protected static function booted()
    {
        self::observe(LoanApplicationObserver::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function accountant()
    {
        return $this->belongsTo(User::class, 'analyst_id');
    }

    public function creditCommittee()
    {
        return $this->belongsTo(User::class, 'cfo_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function logs()
    {
        return $this->morphMany(AuditLog::class, 'subject');
    }
}
