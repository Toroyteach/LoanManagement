<?php

namespace App\Services;

use App\LoanApplication;
use App\MonthlySavings;
use App\Status;
use App\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuditLogService
{
    public static function generateLogs(LoanApplication $loanApplication)
    {
        $changes      = [];
        $statuses     = Status::pluck('name', 'id');
        $users        = User::pluck('name', 'id');

        foreach ($loanApplication->logs as $log) {
            $current = json_decode($log->properties, true);
            unset($current['status'], $current['id']);

            if (isset($previous)) {
                $differences   = array_diff_assoc($current, $previous);
                $value         = [
                    'user'    => $log->user->name ?? 'Monthly Calculation',
                    'time'    => $log->created_at,
                    'comment' => null,
                    'changes' => []
                ];

                foreach ($differences as $key => $difference) {
                    $previousValue = $previous[$key] ?? null;
                    $currentValue  = $current[$key] ?? null;

                    if (Str::endsWith($key, '_at') || $previousValue == $currentValue) {
                        continue;
                    }

                    if ($key == 'status_id') {
                        $previousValue = $previousValue ? $statuses[$previousValue] : null;
                        $currentValue  = $statuses[$currentValue];
                        $key           = Str::replaceFirst('_id', '', $key);
                        if (in_array($difference, [3, 4, 6, 7])) {
                            $column = in_array($difference, [3, 4]) ? 'analyst_id' : 'cfo_id';
                            //dd($current);
                            $value['comment'] = $loanApplication->comments->where('user_id', $current[$column])->first()->comment_text;
                        }
                    } elseif (in_array($key, ['analyst_id', 'cfo_id'])) {
                        $previousValue = $previousValue ? $users[$previousValue] : null;
                        $currentValue  = $users[$currentValue];
                        $key           = Str::replaceFirst('_id', '', $key);
                    }

                    $changesString = '<b>' . Str::of($key)->replace('_', ' ')->title() . '</b>: ';
                    //var_dump('<br>'.$changesString);
                    $changesString .= $previousValue ? 'from ' . $previousValue . ' to ' . $currentValue : 'set to ' . $currentValue;
                    $value['changes'][] = $changesString;
                }

                $changes[] = $value;
            }

            $previous = $current;
        }

        return $changes;

    }

    public static function generateUserLogs(LoanApplication $loanApplication)
    {
        $changes      = [];
        $statuses     = Status::pluck('name', 'id');
        $users        = User::pluck('name', 'id');

        $usersAccounts = MonthlySavings::with('logs')->where('user_id', $loanApplication->created_by_id)->first();

        foreach ($usersAccounts->logs as $log) {
            $current = json_decode($log->properties, true);
            unset($current['status'], $current['id'], $current['user']);

            if (isset($previous)) {
                $differences   = array_diff_assoc($current, $previous);
                $value         = [
                    'user'    => $log->user->name,
                    'time'    => $log->created_at,
                    'comment' => null,
                    'changes' => []
                ];

                foreach ($differences as $key => $difference) {
                    $previousValue = $previous[$key] ?? null;
                    $currentValue  = $current[$key] ?? null;

                    if (Str::endsWith($key, '_at') || $previousValue == $currentValue) {
                        continue;
                    }

                    if ($key == 'overpayment_amount') {
                        $previousValue = $previousValue ? $statuses[$previousValue] : null;
                        $currentValue  = $statuses[$currentValue];
                        $key           = Str::replaceFirst('_id', '', $key);
                    }

                    $changesString = '<b>' . Str::of($key)->replace('_', ' ')->title() . '</b>: ';
                    $changesString .= $previousValue ? 'from ' . $previousValue . ' to ' . $currentValue : 'set to ' . $currentValue;
                    $value['changes'][] = $changesString;
                }

                $changes[] = $value;
            }

            $previous = $current;
        }

        return $changes;
    }

    public static function generateLoanStatementLogs()
    {

        $changesTop   = [];
        $memberLoans  = LoanApplication::where('created_by_id', \Auth::user()->id)->with('logs')->get();
        $statuses     = Status::pluck('name', 'id');
        $users        = User::pluck('name', 'id');

        foreach ($memberLoans as $log) {

                $LoanValue = [
                    'changes' => [],
                    'loan_number'    => $log->loan_entry_number,
                    'loan_start_date' => Carbon::parse($log->created_at)->toFormattedDateString(),
                    'loan_duration'    => $log->duration,
                    'loan_end_date' => ($log->status_id ?? 10) ? $log->repayment_date : 'NUll',
                    'loan_amount'    => strval($log->loan_amount),
                    'loan_balance' => null,
                    'loan_debit_total' => 0,
                    'loan_credit_total' => 0,
                    'loan_type' => $log->loan_type
                ];

                $totalBalance = $log->loan_amount_plus_interest;
        
                foreach ($log->logs as $loanLog) {  
                    $current = json_decode($loanLog->properties, true);
                    unset($current['status'], $current['id'], $current['user']);
                    
                    if (isset($previous)) {
                        
                        $differences   = array_diff_assoc($current, $previous);

                        foreach ($differences as $key => $difference) {
                            //fill in the values in the above with new data to show
                            $previousValue = $previous[$key] ?? null;
                            $currentValue  = $current[$key] ?? null;

                            if (Str::endsWith($key, '_at') || $previousValue == $currentValue) {
                                continue;
                            }

                            if ($key == 'repaid_amount') {

                                $inputValue = ($currentValue - $previousValue);
                                $totalBalance -= $inputValue;

                                $time = now();
                                $value['postingDate'] = Carbon::parse($log->updated_at)->toFormattedDateString();
                                $value['debitAmount'] = $inputValue;
                                $value['description'] = substr(date("F", strtotime('m')), 0, 3).' - Interest';
                                $value['creditAmount'] = strval($inputValue);
                                $value['balance'] = strval($totalBalance);


                            }

                        }
        
                        $LoanValue['changes'][] = $value;

                        if($totalBalance <= 0){

                            $LoanValue['loan_balance'] = 0;
        
                        } else {
        
                            $LoanValue['loan_balance'] = $totalBalance;
                            
                        }
                        
                    }
        
                    $previous = $current;
                }

            $changesTop[] = $LoanValue;

        }

        unset($changesTop[0]['changes'][0]);
        unset($changesTop[0]['changes'][1]);
        unset($changesTop[0]['changes'][2]);
        unset($changesTop[0]['changes'][3]);
        unset($changesTop[0]['changes'][4]);
        unset($changesTop[0]['changes'][5]);

        foreach($changesTop as $key => $change){

            
            foreach($change['changes'] as $key2 => $newChange){

                if($key2 %2 == 0){

                    continue;

                }

                unset($changesTop[$key]['changes'][$key2]);
            }

        }

        //dd($changesTop);

        return $changesTop;
    }

    public static function generateMonthlyStatementLogs()
    {

        $changes      = [];
        $statuses     = Status::pluck('name', 'id');
        $users        = User::pluck('name', 'id');

        $usersAccounts = MonthlySavings::with('logs')->where('user_id', \Auth::user()->id)->first();


        $i = 0;
        $totalBalance = 0;
        
        foreach ($usersAccounts->logs as $log) {
            $current = json_decode($log->properties, true);
            unset($current['status'], $current['id']);

            if (isset($previous)) {

                unset($current['user']);

                $differences   = array_diff_assoc($current, $previous);


                foreach ($differences as $key => $difference) {
                    $previousValue = $previous[$key] ?? null;
                    $currentValue  = $current[$key] ?? null;


                    if (Str::endsWith($key, '_at') || $previousValue == $currentValue) {
                        continue;
                    }

                    if ($key == 'total_contributed') {

                        
                        $inputValue = ($currentValue - $previousValue);
                        $totalBalance +=  $inputValue;

                        //print_r($key.'<br>');

                        $time = now();
                        $value['postingDate'] = Carbon::parse($log->updated_at)->toFormattedDateString();
                        $value['debitAmount'] = strval($log->next_months_pay);
                        $value['description'] = substr($log->updated_at->format('M'), 0, 3).' - Contribution';
                        $value['creditAmount'] = strval( $inputValue );
                        $value['balance'] = strval( $totalBalance );


                    }

                    if ($key == 'overpayment_amount') {

                        $inputValue = ($currentValue - $previousValue);
                        $totalBalance += $inputValue;

                        $time = now();
                        $value['postingDate'] = Carbon::parse($log->updatedd_at)->toFormattedDateString();
                        $value['debitAmount'] = strval($log->next_months_pay);
                        $value['description'] = substr($log->updated_at->format('M'), 0, 3).' - C/F Loan Overpayment';
                        $value['creditAmount'] = strval( $inputValue );
                        $value['balance'] = strval( $totalBalance );

                        
                        
                    }
                    //print_r($inputValue.'<br>');

                    
                    $i++;
                }
                // print_r($totalBalance.'<br>');

                $changes[] = $value;
            }

            $previous = $current;
        }

        //die();

        $monthlyValues = [];

        for($i = 0; $i < count($changes); $i += 2) {  // take every second element

            array_push($monthlyValues, $changes[$i]);

        }

        return $monthlyValues;
    }
}
