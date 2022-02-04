<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreateGuarantorRequestObserver;

class CreateGuarantorLoanRequest extends Model
{
    //

    public $table = 'create_guarantor_loan_requests';

    protected $fillable = [
        'user_id', 'request_id', 'request_status',
    ]; 

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected static function booted()
    {
        self::observe(CreateGuarantorRequestObserver::class);
    }

    public function request()
    {
        return $this->belongsTo(CreateLoanRequest::class, 'request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
