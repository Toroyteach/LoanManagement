@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        My Loans
    </div>

    <div class="card-body">
         <div class="container-fluid">
                <h2 class="section-title"></h2>
            </div>
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive tile-body table-responsive-md table-responsive-lg table-responsive-xl table-responsive-sm">
                        <table class="table table-bordered table-striped table-hover datatable datatable-LoanApplication">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.loanApplication.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.loanApplication.fields.loan_amount') }}
                                    </th>
                                    <th>
                                        Loan Interest
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
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loanApplications as $key => $loanApplication)
                                    <tr data-entry-id="{{ $loanApplication->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ 1+$key++ }}
                                        </td>
                                        <td>
                                            Ksh {{ $loanApplication->loan_amount ?? '0.00' }}
                                        </td>
                                        <td>
                                            Ksh {{ $loanApplication->loan_amount_plus_interest ?? '0.00' }}
                                        </td>
                                        <td>
                                            {{ $loanApplication->description ?? '' }}
                                        </td>
                                        <td>
                                            @if(in_array($loanApplication->status_id, [7, 4, 9]))
                                                <span class="badge badge-danger">Rejected</span>
                                            @else
                                                @if($loanApplication->status_id === 8)
                                                    <span class="badge badge-success">{{ $loanApplication->status->name }}</span>
                                                @else
                                                    <span class="badge badge-info">{{ $loanApplication->status_id < 8 ? 'Processing' : $loanApplication->status->name }}</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{ $loanApplication->loan_type }}
                                        </td>
                                        <td>
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.loan-applications.show', $loanApplication->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><br>
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
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

});

</script>
@endsection