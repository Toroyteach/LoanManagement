<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanFile extends Model
{
    //
    protected $fillable = ['uuid', 'title', 'cover', 'loan_application_id'];

    protected $table = 'loan_files';

    public function loan()
    {
        return $this->belongsTo(LoanApplications::class, 'loan_application_id');
    }
}
