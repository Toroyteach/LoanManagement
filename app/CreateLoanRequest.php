<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreateLoanRequest extends Model
{
    //

    public $table = 'create_loan_requests';

    protected $fillable = [
        'loan_amount', 'description', 'loan_type', 'duration', 'file', 'user_id',
    ]; 

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}
