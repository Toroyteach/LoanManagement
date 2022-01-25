<?php

namespace App\Imports;

use App\LoanFileUpload;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LoanFilesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new LoanFileUpload([
            'entry_number'     => $row['loanno'],
            'member_number'    => $row['memberno'], 
            'amount'           => $row['amount'],
        ]);
    }
}
