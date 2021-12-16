<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanFileUpload extends Model
{
    use HasFactory;

    protected $fillable = ['entry_number', 'member_number', 'amount'];

    protected $table = 'loan_file_uploads';
}
