<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class MonthlyDebit extends Model
{
    use SoftDeletes, Auditable;
    //
    public $table = 'monthhly_debits';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'amount',
        'comment',
        'cfo',
        'user_id',
        'useraccount_id',
    ];
}
