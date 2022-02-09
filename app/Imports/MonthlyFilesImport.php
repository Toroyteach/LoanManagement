<?php

namespace App\Imports;

use App\MonthlyFile;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MonthlyFilesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MonthlyFile([
            'member_number'     => $row['memberno'],
            'amount'            => $row['newamount'], 
        ]);

        // return [
        //     'ID', 'MemberNo', 'MemberName', 'MonthlyAmount', 'NewAmount'
        // ];
    }
}
