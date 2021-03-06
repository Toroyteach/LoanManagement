<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaccoAccount extends Model
{
    //
    use SoftDeletes;

    public $table = 'sacco_accounts';

    protected $fillable = [
        'opening_bal', 'deposit_bal', 'user_id', 'created_by'
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
