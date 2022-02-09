<?php

namespace App\Exports;

use App\LoanApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LoansExport implements FromCollection, WithCustomStartCell, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $usersLoan = LoanApplication::join('users', 'loan_applications.created_by_id', '=', 'users.id')
        ->selectRaw('loan_applications.id AS ID, users.idno AS MemberNumber, users.name AS MmemberName, loan_applications.loan_entry_number AS LoanId, loan_applications.loan_type AS loanType, loan_applications.balance_amount AS Balance')
        ->where('loan_applications.status_id', 8)
        ->get(['loan_applications.id', 'users.name', 'users.idno', 'loan_applications.loan_entry_number', 'loan_applications.loan_type', 'loan_applications.balance_amount']);

        return $usersLoan;
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function headings(): array
    {
        return [
            'ID', 'memberno', 'MemberName', 'loanentryno', 'LoanTypes', 'LoanBalance', 'newamount'
        ];
    }
}
