<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkUpload extends Model
{
    use HasFactory;

    public $table = 'bulk_uploads';

    protected $fillable = [
        'title'
    ];
}
