<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanGuarantor extends Model
{
    //

    public $table = 'loan_guarantors';

    protected $fillable = [
        'user_id', 'loan_application_id',
    ]; 

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }

    public function loan()
    {
        return $this->belongsTo(LoanApplication::class, 'loan_application_id');

    }
}
