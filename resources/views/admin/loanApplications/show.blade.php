@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.loanApplication.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-info" href="{{ route('admin.loan-applications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            Loan Id
                        </th>
                        <td>
                            {{ $loanApplication->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.id') }}
                        </th>
                        <td>
                            {{ $loanApplication->loan_entry_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.loan_amount') }}
                        </th>
                        <td>
                            {{ $loanApplication->loan_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                           Member Elligible Amount
                        </th>
                        <td>
                            {{ $elligibleAmount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.description') }}
                        </th>
                        <td>
                            {{ $loanApplication->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.loantype') }}
                        </th>
                        <td>
                            {{ $loanApplication->loan_type }}
                        </td>
                    </tr>
                    <tr>

                            @if(Auth::user()->getIsMemberAttribute())
                                @if($loanApplication->status_id === 8)
                                    <th>
                                        {{ trans('cruds.loanApplication.fields.amountremaining') }}
                                    </th>
                                    <td>
                                        {{ $remaining }}
                                    </td>
                                @else
                                    <th>
                                        {{ trans('cruds.loanApplication.fields.amountremaining') }}
                                    </th>
                                    <td>
                                        <span class="badge badge-warning">null</span>
                                    </td>
                                @endif
                            @else
                                @if($loanApplication->status_id === 8)
                                    <th>
                                        {{ trans('cruds.loanApplication.fields.amountremaining') }}
                                    </th>
                                    <td>
                                        {{ $remaining }}
                                    </td>
                                @else
                                    <th>
                                        {{ trans('cruds.loanApplication.fields.amountremaining') }}
                                    </th>
                                    <td>
                                        <span class="badge badge-warning">{{ $loanApplication->status->name }} loan</span>
                                    </td>
                                @endif
                            @endif

                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.duration') }}
                        </th>
                        <td>
                            {{ $loanApplication->duration }} Months
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.expectedpaydate') }}
                        </th>
                        <td>
                            @if($loanApplication->status_id === 8)
                                @if( \Carbon\Carbon::now()->diffInDays($loanApplication->repayment_date, false) < 5 )
                                    <span class="badge badge-danger">{{ \Carbon\Carbon::parse($loanApplication->repayment_date)->diffForHumans() }}</span>
                                @else
                                    <span class="badge badge-info">{{ \Carbon\Carbon::parse($loanApplication->repayment_date)->diffForHumans() }}</span>
                                @endif
                            @else
                                @if(!$user->is_member)
                                    @if(in_array($loanApplication->status_id, [7, 4, 9])) 
                                        <span class="badge badge-danger">Loan Rejected</span>
                                    @else
                                        <span class="badge badge-warning">Loan not yet Approved</span>
                                    @endif
                                @else
                                    null
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Loan Status
                        </th>
                        <td>                            
                            @if(in_array($loanApplication->status_id, [7, 4, 9]))
                                <span class="badge badge-danger">Rejected</span>
                            @else
                                @if(!$user->is_member)
                                 <span class="badge badge-info"> {{ $loanApplication->status->name }} </span>
                                @else
                                 <span class="badge badge-success">{{ $loanApplication->status_id < 8 ? 'Processing' : $loanApplication->status->name }}</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.paymentstatus') }}
                        </th>
                        <td>
                            @if($loanApplication->status_id === 8)
                                @if ($loanApplication->repaid_status)
                                <span class="badge badge-success">Paid</span>
                                @else
                                <span class="badge badge-danger">Not Paid</span>
                                @endif
                            @else
                                null
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.datecreated') }}
                        </th>
                        <td>
                            {{ \Carbon\Carbon::parse($loanApplication->created_at)->toDateString() }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Files Attached
                        </th>
                        <td>
                            @if(!empty($loanApplication->file))<a class="btn btn-md btn-primary" href="{{ route('admin.loans.pdf', $loanApplication->id ) }}">Download Attached File</a>@endif
                        </td>
                    </tr>
                    @if(!$user->is_member)
                        <tr>
                            <th>
                                {{ trans('cruds.loanApplication.fields.analyst') }}
                            </th>
                            <td>
                                {{ $loanApplication->analyst->name ?? 'Not Processed' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.loanApplication.fields.cfo') }}
                            </th>
                            <td>
                                {{ $loanApplication->cfo->name ?? 'Not Processed' }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if(!$user->is_member && count($logs))
                @can('audit_log_show')
                    <h3>Logs</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Changes</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>
                                        {{ $log['user'] }}
                                    </td>
                                    <td>
                                        <ul>
                                            @foreach($log['changes'] as $change)
                                                <li>
                                                    {!! $change !!}
                                                </li>
                                            @endforeach
                                            @if($log['comment'])
                                                <li>
                                                    <b>Comment</b>: {{ $log['comment'] }}
                                                </li>
                                            @endif
                                        </ul>
                                    </td>
                                    <td>
                                        {{ $log['time'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endcan
            @endif

            <div class="form-group">
                            @if(($user->is_accountant or $user->is_admin) && in_array($loanApplication->status_id, [1, 2, 3]))
                                        
                                                @if($loanApplication->status_id == 1)
                                                <a class="btn btn-md btn-success" href="{{ route('admin.loan-applications.showAnalyze', $loanApplication->id) }}">
                                                    Submit Analysis
                                                    <!-- here the accountant sets the loan to status 3(approved) or 4(rejected) then its moved to next stage 5(creditcommittee processing) -->
                                                </a>
                                                @elseif($loanApplication->status_id == 2)
                                                <a class="btn btn-md btn-success" href="{{ route('admin.loan-applications.showAnalyze', $loanApplication->id) }}">
                                                    Submit analysis
                                                    <!-- here the credit committee sets the loan to status 6(approved) or 7(rejected) from 5(processing)-->
                                                    <!-- then it is sent back to the accountant -->
                                                </a>
                                                @else
                                                <a class="btn btn-md btn-success" href="{{ route('admin.loan-applications.showSend', $loanApplication->id) }}">
                                                    Send to Credit Committee 
                                                    <!-- here the credit committee is sent the loan to be able to porcess it -->
                                                </a>
                                                @endif

                            @elseif(($user->is_creditcommittee && $loanApplication->status_id == 3) || ($user->is_creditcommittee && $loanApplication->status_id == 5))
                                        <!-- status 3 and 5 are more less the same  -->
                                <a class="btn btn-xs btn-success" href="{{ route('admin.loan-applications.showAnalyze', $loanApplication->id) }}">
                                    Submit analysis
                                    <!-- here the credit committee sets the loan to status 6(approved) or 7(rejected) from 5(processing)-->
                                    <!-- then it is sent back to the accountant -->
                                </a>
                            @endif  

                @if((Gate::allows('loan_application_edit') and ($user->is_admin or $user->accountant)) && $loanApplication->status_id == 6)
                    <form method="POST" action="{{ route('admin.loan-applications.update', [$loanApplication->id]) }}">
                        @method('PUT')
                        @csrf
                            <input type="hidden" name="loan_amount" id="loan_amount" value="{{ $loanApplication->loan_amount }}" required>
                            <input type="hidden" name="status_id" id="status_id" value="8" required>

                            <button class="btn btn-lg btn-success" type="submit"> Finalize Application</button>
                    </form>
                @endif

                @can('loan_application_delete')
                    <form action="{{ route('admin.loan-applications.destroy', $loanApplication->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-md btn-danger" value="{{ trans('global.delete') }}">
                    </form>
                @endcan
            </div>
            <div class="form-group">
                <a class="btn btn-md btn-info" href="{{ route('admin.loan-applications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            @if($loanApplication->status_id == 8)
                @can('loan_application_repay')
                <div class="form-group">
                    <a class="btn btn-md  btn-warning text-white" onclick="makeLoanRepaymenRequest()">
                        Make Payment Request
                    </a>
                </div>
                @endcan
            @endif
        </div>
    </div>
</div>



@endsection

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">


    function makeLoanRepaymenRequest() {


            swal.fire({
            title: "Loan Repayment Request",
            icon: 'warning',
            text: "Are you sure you want to make repayment for this loan application? Please confirm then move forward",
            input: 'range',
            inputAttributes: {
                min: 1000,
                max: 20000,
                step: 500,
            },
            inputValue: "{{ $loanApplication->loan_amount ?? '' }}",
            inputLabel: "Amount",
            showCancelButton: !0,
            confirmButtonText: "Yes, Submit",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
            }).then(function (e) {

                const value = document.getElementById("swal2-input").value; 

                if (e.isConfirmed) {

                    //console.log(value);

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.loan-applications.repay') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            loan_id: "{{ $loanApplication->id }}",
                            amount: value
                            },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.response === true) {

                                swal.fire("Done!", results.message, "success");
                                // refresh page after 2 seconds
                                setTimeout(function(){
                                    location.reload();
                                },3000);

                            } else if(results.response === false) {

                                swal.fire("Error!", results.failure, "error");

                            }
                        }
                    });

                } else {
                    
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })


    }

</script>
