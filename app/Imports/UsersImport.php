<?php

namespace App\Imports;

use App\UserBulk;
use Maatwebsite\Excel\Concerns\ToModel;
use App\UsersAccount;
use App\SaccoAccount;
use App\MonthlySavings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $fname = (string)$row['firstname'];
        $lname = (string)$row['lastname'];
        $mname = (string)$row['middlename'];
        $national = (string)$row['nationalid'];
        $number = (string)$row['number'];
        $memberno = (string)$row['memberno'];

        return new UserBulk([
            'nationalid' => $national,
            'memberno' => $memberno,
            'number' => $number,
            'fristname' => $fname,
            'lastname' => $lname,
            'middlename'=> $mname
         ]);
        
    }
}
