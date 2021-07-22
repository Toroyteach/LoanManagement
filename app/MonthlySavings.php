<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class MonthlySavings extends Model
{
    //
    use SoftDeletes, Auditable;

    public $table = 'monthly_savings';

    protected $fillable = [
        'total_contributed', 'monthly_amount', 'user_id', 'next_payment_date', 'overpayment_amount', 'created_by', 'modified_at',
    ]; 

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}
