<?php

namespace App\Imports;

use App\MonthlyFile;
use Maatwebsite\Excel\Concerns\ToModel;

class MonthlyFilesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MonthlyFile([
            'member_number'     => $row[0],
            'amount'            => $row[1], 
        ]);
    }
}
