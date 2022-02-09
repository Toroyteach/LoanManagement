<?php

namespace App\Exports;

use App\MonthlySavings;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MonthlyExport implements FromCollection, WithCustomStartCell, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $usersLoan = MonthlySavings::join('users', 'monthly_savings.user_id', '=', 'users.id')
        ->selectRaw('monthly_savings.id AS ID, users.idno AS MemberNumber, users.name AS MmemberName, monthly_savings.monthly_amount AS MonthlyAmount')
        ->get(['monthly_savings.id', 'users.name', 'users.idno', 'monthly_savings.monthly_amount']);

        return $usersLoan;
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function headings(): array
    {
        return [
            'ID', 'memberno', 'MemberName', 'MonthlyAmount', 'newamount'
        ];
    }
}
