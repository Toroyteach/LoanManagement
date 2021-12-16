<?php

namespace App\Imports;

use App\LoanFileUpload;
use Maatwebsite\Excel\Concerns\ToModel;

class LoanFilesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new LoanFileUpload([
            'entry_number'     => $row[0],
            'member_number'    => $row[1], 
            'amount'           => $row[2],
        ]);
    }
}
