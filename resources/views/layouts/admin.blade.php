<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset ( 'onepage/logo.jpeg')}}" rel="icon">
    <link href="{{ asset ( 'onepage/logo.jpeg')}}" rel="apple-touch-icon">

    <title>{{ trans('panel.site_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@3.2/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />
    <link href="{{ asset ( 'frontend/assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
    <link href="{{ asset ( 'frontend/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset( 'css/custom.css' ) }}" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>

    <!-- sweet alert cdn -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireStyles
    @yield('styles')
</head>

<body class="c-app">
    @include('partials.menu')
    @include('sweetalert::alert')
    <div class="c-wrapper">
        <header class="c-header c-header-fixed px-3">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                <i class="fas fa-fw fa-bars"></i>
            </button>


            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
                <i class="fas fa-fw fa-bars"></i>
            </button>

            <ul class="c-header-nav ml-auto col">

            </ul>


              <nav class="navbar navbar-dark bg-dark navbar-expand-sm">

              <div class="row">

                <div class="collapse navbar-collapse col-md-2 col-sm-4 col-lg-2" id="navbarSupportedContent" style="display: unset !important;">
                  <ul class="nav nav-pills mr-auto justify-content-end">
                      <li class="nav-item dropdown">
                        <div class="">
                            <a class="nav-link text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              @if($notifications < 1)
                              <span class="">0</span><i class="fa fa-bell"></i>
                              @else
                              <span class="num text-danger">{{ $notifications }}</span><i class="fa fa-bell"></i>
                              @endif
                            </a>
                          </div>

                        <ul class="dropdown-menu">


                          @if($notifications < 1)

                          
                          <li class="head text-light bg-dark">
                            <div class="row">
                              <div class="col-lg-12 col-sm-12 col-12">
                              <span>No New Notifications</span>
                            </div>
                          </li>

                          @else

                            <li class="head text-light bg-dark">
                              <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12">
                                <span>Notifications {{ $notifications }}</span>
                                <a href="" class="float-right text-light" id="mark-all">Mark all as read</a>
                              </div>
                            </li>

                            @foreach($notificationDescription as $key => $notice)

                              @if($notice->data['notification_type'] == 'NewLoanApplication')
                                  <!-- new loan application notification -->
                                <li class="notification-box bg-gray">
                                  <div class="row">
                                      <div class="col-lg-3 col-sm-3 col-3 text-center">
                                        <i class="fa fa-envelope fa-5x" aria-hidden="true"></i>
                                      </div>

                                      <div class="col-lg-7 col-sm-8 col-8">
                                          @if(Auth::user()->is_user)
                                          <strong class="">Dear {{ $notice->data['message_name'] }}</strong>
                                          @else
                                            <strong class="">New Loan Application</strong>
                                          @endif

                                          <div>

                                            <p class="text-info">{{ $notice->data['message_desc'] }}</p>
                                            <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                          </div>
                                      </div>

                                      <div class="col-lg-2 col-sm-1 col-1">
                                            <a href="#" class="float-right mark-as-read" id="mark-as-read" data-id="{{ $notice->id }}">Mark as read</a>
                                      </div>

                                  </div>
                                </li>

                              @elseif($notice->data['notification_type'] == 'StatusAnalysis')
                                  <!-- status analysis internal -->
                                <li class="notification-box bg-gray">
                                    <div class="row">
                                      <div class="col-lg-3 col-sm-3 col-3 text-center">
                                        <i class="fa fa-flag fa-4x" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-lg-7 col-sm-8 col-8">
                                            <strong class=""> New Loan Application Status</strong>
                                            <div>
                                          <p class="text-info">{{ $notice->data['message_desc'] }}</p>
                                          <h4>{{ $notice->data['message_desc_1'] }}</h4>
                                        </div>
                                        <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                        </div>

                                          <div class="col-lg-2 col-sm-1 col-1">
                                            <a href="#" class="float-right mark-as-read" data-id="{{ $notice->id }}">Mark as read</a>
                                          </div>
                                    </div>
                                  </li>

                              @elseif($notice->data['notification_type'] == 'LoanAnalysis')
                                  <!-- loanAnalysis notification -->
                                <li class="notification-box bg-gray">
                                      <div class="row">
                                        <div class="col-lg-3 col-sm-3 col-3 text-center">
                                          <i class="fa fa-line-chart fa-4x" aria-hidden="true"></i>
                                          </div>
                                          <div class="col-lg-7 col-sm-8 col-8">
                                            <strong class="">New Loan Analysis Request</strong>
                                          <div>
                                            <p class="text-info">{{ $notice->data['message_desc'] }}</p>
                                          </div>
                                          <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                          </div>
                                          <div class="col-lg-2 col-sm-1 col-1">
                                            <a href="#" class="float-right mark-as-read" data-id="{{ $notice->id }}">Mark as read</a>
                                            </div>
                                      </div>
                                    </li>

                              @elseif($notice->data['notification_type'] == 'CompleteLoanApplication')
                                  <!-- StatusAnalyis user (approved or rejected) -->
                                <li class="notification-box bg-gray">
                                      <div class="row">
                                        <div class="col-lg-3 col-sm-3 col-3 text-center">
                                          <i class="fa fa-hourglass-end fa-4x" aria-hidden="true"></i>
                                          </div>
                                          <div class="col-lg-7 col-sm-8 col-8">
                                            <strong class="">Loan Application Status</strong>
                                          <div>
                                            <p class="text-info">{{ $notice->data['message_desc'] }}</p>
                                          </div>
                                          <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                          </div>
                                          <div class="col-lg-2 col-sm-1 col-1">
                                            <a href="#" class="float-right mark-as-read" data-id="{{ $notice->id }}">Mark as read</a>
                                            </div>
                                      </div>
                                    </li>

                              @elseif($notice->data['notification_type'] == 'MonthlyContribution')

                                  <!-- Monthly payment Analysis -->
                                  <li class="notification-box bg-gray">
                                      <div class="row">
                                        <div class="col-lg-3 col-sm-3 col-3 text-center">
                                          <i class="fa fa-calender fa-4x" aria-hidden="true"></i>
                                          </div>
                                          <div class="col-lg-7 col-sm-8 col-8">
                                            <strong class="">Monthly Contribution</strong>
                                          <div>
                                            <p class="text-info">{{ $notice->data['message_desc'] }}</p>
                                          </div>
                                          <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                          </div>
                                          <div class="col-lg-2 col-sm-1 col-1">
                                            <a href="#" class="float-right mark-as-read" data-id="{{ $notice->id }}">Mark as read</a>
                                            </div>
                                      </div>
                                    </li>

                                    @elseif($notice->data['notification_type'] == 'GuarantorRequest')

                                  <!-- Monthly payment Analysis -->
                                  <li class="notification-box bg-gray">
                                      <div class="row">
                                        <div class="col-lg-3 col-sm-3 col-3 text-center">
                                          <i class="fa fa-user-plus fa-4x" aria-hidden="true"></i>
                                          </div>
                                          <div class="col-lg-7 col-sm-8 col-8">
                                            <strong class="">Gurantor Request</strong>
                                          <div>
                                            <p class="text-info">{{ $notice->data['message_desc'] }}</p>
                                          </div>
                                          <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                          </div>
                                          <div class="col-lg-2 col-sm-1 col-1">
                                            <a href="#" class="float-right mark-as-read" data-id="{{ $notice->id }}">Mark as read</a>
                                            </div>
                                      </div>
                                    </li>
                                  @endif
                            
                            @endforeach

                            <li class="footer bg-dark text-center">
                                  <a href="{{ route('admin.viewnotification') }}" class="text-light">View All</a>
                              </li>

                          @endif


                      </ul>
                    </li>
                  </ul>
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6">
                    <a class="navbar-brand" href="#">
                    {{ Auth::user()->firstname }} 
                    <span class="badge badge-pill badge-warning">{{ Auth::user()->roles[0]->title }}</span> 
                    </a>
                </div>
                <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-4" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button> -->
                <div class="collapse navbar-collapse col-md-4 col-sm-2 col-lg-4" id="navbar-list-4">
                  <ul class="navbar-nav">
                      <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      @if(!empty(Auth::user()->avatar))
                          <img src="{{ asset( 'img/uploads/profileavatar/'.Auth::user()->avatar ) }}" width="40" height="40" class="rounded-circle">
                        @else
                          <img src="{{ asset( 'images/avatar.jpg' ) }}" width="40" height="40" class="rounded-circle">
                        @endif                    </a>
                      <div class="dropdown-menu notification-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <a class="dropdown-item" href="{{ route('profile.password.edit') }}">Edit Profile</a>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">Log Out</a>
                      </div>
                    </li>   
                  </ul>
                </div>
              </div>

              </nav>
            
        </header>

  

        <div class="c-body">
            <main class="c-main">


                <div class="container-fluid">
                    @if(session('message'))
                        <script type="text/javascript">
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'info',
                                  title: "{{ session('message') }}",
                                  showConfirmButton: false,
                                  timer: 2000
                              })
                      </script>
                    @endif
                    @if(session('success'))
                        <script type="text/javascript">
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: "{{ session('success') }}",
                                  showConfirmButton: false,
                                  timer: 2000
                              })
                      </script>
                    @endif
                    @if(session('error'))
                        <script type="text/javascript">
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'error',
                                  title: "{{ session('error') }}",
                                  showConfirmButton: false,
                                  timer: 2000
                              })
                      </script>
                    @endif
                    @if($errors->count() > 0)
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @yield('content')

                </div>


            </main>
            <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
    @livewireScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="https://unpkg.com/@coreui/coreui@3.2/dist/js/coreui.min.js"></script>

    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
    
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
      
    function sendMarkRequest(id = null) {
          return $.ajax("{{ route('admin.markNotification') }}", {
              method: 'POST',
              data: {
                  _token,
                  id
              }
          });
      }
      $(function() {
          $('#mark-as-read').click(function() {
              let request = sendMarkRequest($(this).data('id'));
              console.log('marked as read');
              request.done(() => {
                  $(this).parents('div.alert').remove();
              });
          });
          $('#mark-all').click(function() {
              let request = sendMarkRequest();
              request.done(() => {
                  $('div.alert').remove();
              })
          });
      });

        $(function() {
  let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
  let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
  let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
  let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
  let printButtonTrans = '{{ trans('global.datatables.print') }}'
  let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
  let selectAllButtonTrans = '{{ trans('global.select_all') }}'
  let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

  let languages = {
    'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
  };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
    language: {
      url: languages['{{ app()->getLocale() }}']
    },
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
    }, {
        orderable: false,
        searchable: false,
        targets: -1
    }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
    order: [],
    scrollX: true,
    pageLength: 100,
    dom: 'lBfrtip<"actions">',
    buttons: [
      {
        extend: 'selectAll',
        className: 'btn-primary',
        text: selectAllButtonTrans,
        exportOptions: {
          columns: ':visible'
        },
        action: function(e, dt) {
          e.preventDefault()
          dt.rows().deselect();
          dt.rows({ search: 'applied' }).select();
        }
      },
      {
        extend: 'selectNone',
        className: 'btn-primary',
        text: selectNoneButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'csv',
        className: 'btn-default',
        text: csvButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        className: 'btn-default',
        text: excelButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        className: 'btn-default',
        text: pdfButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        className: 'btn-default',
        text: printButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
    ]
  });

  $.fn.dataTable.ext.classes.sPageButton = '';
});

    </script>
    @yield('scripts')
</body>

</html>