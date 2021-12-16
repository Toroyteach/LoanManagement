<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyFile extends Model
{
    use HasFactory;

    protected $fillable = ['member_number', 'amount'];

    protected $table = 'monthly_files';
}
