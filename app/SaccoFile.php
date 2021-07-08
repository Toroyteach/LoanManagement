<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaccoFile extends Model
{
    //
    protected $fillable = ['uuid', 'title', 'cover'];

    protected $table = 'sacco_files';
}
