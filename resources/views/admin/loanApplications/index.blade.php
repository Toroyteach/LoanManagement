@extends('layouts.admin')
@section('content')
@can('loan_application_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.staff.loanapplications') }}">
                Create {{ trans('cruds.loanApplication.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.loanApplication.title_singular') }} {{ trans('global.list') }}
    </div>

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
                            @if($user->is_admin)
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
                                {{ $key+1 }}
                            </td>
                            <td>
                                {{ $loanApplication->loan_entry_number ?? '' }}
                            </td>
                            <td>
                                {{ $loanApplication->loan_amount ?? '' }}
                            </td>
                            <td>
                                {{ $loanApplication->description ?? '' }}
                            </td>
                            <td>
                            @if(in_array($loanApplication->status_id, [7, 4, 9]))
                                <span class="badge badge-danger">Rejected</span>
                            @else
                                @if($user->is_admin)
                                 <span class="badge badge-info"> {{ $loanApplication->status->name }} </span>
                                @else
                                    @if(in_array($loanApplication->status_id, [1,2,3,5,6]))
                                        <span class="badge badge-info">{{ $loanApplication->status_id < 8 ? 'Processing' : $loanApplication->status->name }}</span>
                                    @else
                                        <span class="badge badge-success">{{ $loanApplication->status_id < 8 ? 'Processing' : $loanApplication->status->name }}</span>
                                    @endif
                                @endif
                            @endif
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
                            @if($user->is_admin || $user->is_cfo)
                                <td>
                                    
                                    @if(in_array($loanApplication->status_id, [7, 4, 9]))
                                        Rejected
                                    @else
                                        {{ $loanApplication->cfo->name ?? '' }}
                                    @endif
                                </td>
                            @endif
                            <td>
                                @if(in_array($loanApplication->status_id, [7, 4, 9])) 

                                @else
                                    @if(($user->is_accountant or $user->is_admin) && in_array($loanApplication->status_id, [1, 2, 3]))
                                        
                                                @if($loanApplication->status_id == 1)
                                                <a class="btn btn-xs btn-success" href="{{ route('admin.loan-applications.showSend', $loanApplication->id) }}">
                                                    Submit to Accountant
                                                </a>
                                                @elseif($loanApplication->status_id == 2)
                                                <a class="btn btn-xs btn-success" href="{{ route('admin.loan-applications.showAnalyze', $loanApplication->id) }}">
                                                    Submit analysis
                                                    <!-- here the credit committee sets the loan to status 6(approved) or 7(rejected) from 5(processing)-->
                                                    <!-- then it is sent back to the accountant -->
                                                </a>
                                                @else
                                                <a class="btn btn-xs btn-success" href="{{ route('admin.loan-applications.showSend', $loanApplication->id) }}">
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
                                @endif

                                @can('loan_application_show')<br>
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.loan-applications.show', $loanApplication->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('loan_application_delete')<br>
                                    <form action="{{ route('admin.loan-applications.destroy', $loanApplication->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
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
@can('loan_application_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.loan-applications.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    pageLength: 100,
  });

  let table = $('.datatable-LoanApplication:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

});

</script>
@endsection
