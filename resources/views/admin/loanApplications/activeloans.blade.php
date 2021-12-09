@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Active Loans
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-LoanApplication">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.loanApplication.fields.id') }}
                        </th>
                        <th>
                            Loan Id
                        </th>
                        <th>
                            {{ trans('cruds.loanApplication.fields.loan_amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.loanApplication.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.loanApplication.fields.status') }}
                        </th>
                        <th>
                            Loan Type
                        </th>
                        <th>
                            Loan Applicant Name
                        </th>
                        <th>
                            Member No
                        </th>
                        @if(!$user->is_member)
                            <th>
                                Approved By
                            </th>
                        @endif
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loanApplications as $key => $loanApplication)
                        <tr data-entry-id="{{ $loanApplication->id }}">
                            <td>

                            </td>
                            <td>
                            {{ $key++ }}
                            </td>
                            <td>
                                {{ $loanApplication->loan_entry_number ?? '' }}
                            </td>
                            <td>
                                {{ $loanApplication->loan_amount ?? '' }}
                            </td>
                            <td>
                                {{ $user->is_member && $loanApplication->status_id < 8 ? $defaultStatus->name : $loanApplication->status->name }}
                            </td>
                            <td>
                                {{ $loanApplication->loan_type }}
                            </td>
                            <td>
                                {{ $loanApplication->created_by->name }}
                            </td>
                            <td>
                                {{ $loanApplication->created_by->idno }}
                            </td>
                            @if(!$user->is_member)
                                <td>
                                    {{ $loanApplication->creditCommittee->name ?? '' }}
                                </td>
                            @endif
                            <td>
                                @can('loan_application_show')<br>
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.loan-applications.show', $loanApplication->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-LoanApplication:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
