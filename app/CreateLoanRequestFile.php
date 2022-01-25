<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateLoanRequestFile extends Model
{
    use HasFactory;

    public $table = 'create_loan_request_files';

    protected $fillable = [
        'uuid', 'title', 'cover', 'loan_requestor_id'
    ]; 

    public function loanRequestor()
    {
        return $this->belongsTo(CreateLoanRequest::class, 'loan_requestor_id');
    }
}
