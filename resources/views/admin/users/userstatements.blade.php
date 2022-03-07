@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Statements
    </div>

    <div class="card-body">
        <div class="container-fluid">
                <h2 class="section-title"></h2>
            </div><br>
            <div class="row">
                <div class="icon-box col-md-6 text-center" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="title">Monthly Contribution</h4>
                        <div class="icon">
                            <a class="btn btn-primary" href="{{ route('admin.users.pdf', 'monthly') }}">Download PDF</a>
                        </div>                                   
                </div>
                <div class="icon-box col-md-6 text-center" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="title">Loan Application</h4>
                    <div class="icon">
                            <a class="btn btn-primary" href="{{ route('admin.users.pdf', 'loan') }}">Download PDF</a>
                        </div> 
                </div>
            </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Guranteed Loans
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
                            Gurantor Status
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
                            Applicant Member No
                        </th>

                        <th>
                            Member Applicant Number
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gurantors as $key => $gurantor)
                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                {{ $key++ }}
                            </td>
                            <td>
                                {{ $gurantor->loan->loan_entry_number }}
                            </td>
                            <td>
                                {{ $gurantor->loan->loan_amount }}
                            </td>
                            <td>
                                {{ $gurantor->value }}
                            </td>
                            <td>
                                {{ $gurantor->loan->status->name }}
                            </td>
                            <td>
                                {{ $gurantor->loan->loan_type }}
                            </td>
                            <td>
                                {{ $gurantor->loan->created_by->name }}
                            </td>
                            <td>
                                {{ $gurantor->loan->created_by->idno }}
                            </td>
                            <td>
                                {{ $gurantor->loan->created_by->number }}
                            </td>

                        </tr>
                   @empty
                        <p class="alert alert-warning">Sorry you do not have any loan gurantees yet</p>
                   @endforelse
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