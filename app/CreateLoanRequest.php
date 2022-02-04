<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreateLoanRequest extends Model
{
    //

    public $table = 'create_loan_requests';

    protected $fillable = [
        'loan_amount', 'description', 'loan_type', 'duration', 'file', 'user_id', 'emi', 'total_plus_interest',
    ]; 

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }

    public function files()
    {
        return $this->hasMany(CreateLoanRequestFile::class, 'loan_requestor_id');
    }

    public function gurantorStatus()
    {
        return $this->hasMany(CreateGuarantorLoanRequest::class, 'request_id');
    }
}
