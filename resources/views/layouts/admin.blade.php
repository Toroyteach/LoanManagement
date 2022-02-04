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

    <!-- dropzone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">

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

            <div class=" navbar-collapse" id="navbarSupportedContent" id="menunav">
            
                <ul class="ml-auto navbar-right-top list-inline">

                    <li class="nav-item dropdown notification list-inline-item"> 

                      @if($notifications < 1)
                      
                          <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-fw fa-bell"></i>
                            <span class=""></span>
                          </a>                     

                      @else
                      
                          <a class="nav-link nav-icons" style="color: #59f01d;" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-fw fa-bell"></i>
                            <span class="indicator"></span>{{ $notifications }}
                          </a>

                      @endif

                        <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                            <li>
                                <div class="notification-title"> Notifications</div>

                                @if($notifications < 1)

                                    <div class="notification-list">
                                      <div class="notification-info text-center">
                                        <span>No Notifications</span>
                                      </div>
                                    </div>

                                @else

                                    <div class="notification-list">
                                        <div class="list-group"> 

                                        @foreach($notificationDescription as $key => $notice)

                                              @if($notice->data['notification_type'] == 'NewLoanApplication')
                                              <!-- new loan application notification -->
                                                <a href="{{ route('admin.loan-applications.show', $notice->data['loan_id']) }}" class="list-group-item list-group-item-action active">
                                                      <div class="notification-info">
                                                        <div class="notification-list-user-img"><i class="fa fa-envelope fa-3x" aria-hidden="true"></i></div>
                                                        <div class="notification-list-user-block">
                                                          <span class="notification-list-user-name">New Loan Application</span>
                                                            {{ $notice->data['message_desc'] }}
                                                          <div class="notification-date">{{ $notice->created_at->diffForHumans() }}</div>
                                                      </div>
                                                    </div>
                                                </a> 
                                              @elseif($notice->data['notification_type'] == 'StatusAnalysis')
                                              <!-- loan status analysis notification -->
                                              <a href="{{ route('admin.loan-applications.show', $notice->data['loan_id']) }}" class="list-group-item list-group-item-action active">
                                                      <div class="notification-info">
                                                        <div class="notification-list-user-img"><i class="fa fa-flag fa-3x" aria-hidden="true"></i></div>
                                                        <div class="notification-list-user-block">
                                                          <span class="notification-list-user-name">New Loan Application Status</span>
                                                            {{ $notice->data['message_desc'] }}
                                                          <div class="notification-date">{{ $notice->created_at->diffForHumans() }}</div>
                                                      </div>
                                                    </div>
                                                </a> 
                                              @elseif($notice->data['notification_type'] == 'LoanAnalysis')
                                              <!-- loan analysis notification -->
                                              <a href="{{ route('admin.loan-applications.show', $notice->data['loan_id']) }}" class="list-group-item list-group-item-action active">
                                                      <div class="notification-info">
                                                        <div class="notification-list-user-img"><i class="fa fa-line-chart fa-3x" aria-hidden="true"></i></div>
                                                        <div class="notification-list-user-block">
                                                          <span class="notification-list-user-name">New Loan Analysis Request</span>
                                                            {{ $notice->data['message_desc'] }} 
                                                          <div class="notification-date">{{ $notice->created_at->diffForHumans() }}</div>
                                                      </div>
                                                    </div>
                                                </a> 
                                              @elseif($notice->data['notification_type'] == 'CompleteLoanApplication')
                                              <!-- completed loan notification -->
                                              <a href="{{ route('admin.loan-applications.show', $notice->data['loan_id']) }}" class="list-group-item list-group-item-action active">
                                                      <div class="notification-info">
                                                        <div class="notification-list-user-img"><i class="fa fa-hourglass-end fa-3x" aria-hidden="true"></i></div>
                                                        <div class="notification-list-user-block">
                                                          <span class="notification-list-user-name">Loan Application Status</span>
                                                            {{ $notice->data['message_desc'] }}
                                                          <div class="notification-date">{{ $notice->created_at->diffForHumans() }}</div>
                                                      </div>
                                                    </div>
                                                </a> 
                                              @elseif($notice->data['notification_type'] == 'MonthlyContribution')
                                              <!-- monthly contribution -->
                                              <a href="{{ route('admin.viewnotification') }}" class="list-group-item list-group-item-action active">
                                                      <div class="notification-info">
                                                        <div class="notification-list-user-img"><i class="fa fa-calendar fa-3x" aria-hidden="true"></i></div>
                                                        <div class="notification-list-user-block">
                                                          <span class="notification-list-user-name">Monthly Contribution</span>
                                                            {{ $notice->data['message_desc'] }}
                                                          <div class="notification-date">{{ $notice->created_at->diffForHumans() }}</div>
                                                      </div>
                                                    </div>
                                                </a> 
                                              @elseif($notice->data['notification_type'] == 'GuarantorRequest')
                                              <!-- gurantor request notification -->
                                              <a href="{{ route('admin.viewnotification') }}" class="list-group-item list-group-item-action active">
                                                      <div class="notification-info">
                                                        <div class="notification-list-user-img"><i class="fa fa-user-plus fa-3x" aria-hidden="true"></i></div>
                                                        <div class="notification-list-user-block">
                                                          <span class="notification-list-user-name">Gurantor Request</span>
                                                            {{ $notice->data['message_desc'] }}
                                                          <div class="notification-date">{{ $notice->created_at->diffForHumans() }}</div>
                                                      </div>
                                                    </div>
                                                </a> 
                                              @elseif($notice->data['notification_type'] == 'FailedLoanRequest')
                                              <!-- monthly contribution -->
                                              <a href="{{ route('admin.viewnotification') }}" class="list-group-item list-group-item-action active">
                                                      <div class="notification-info">
                                                        <div class="notification-list-user-img"><i class="fa fa-calendar fa-3x" aria-hidden="true"></i></div>
                                                        <div class="notification-list-user-block">
                                                          <span class="notification-list-user-name">Rejected Loan Request</span>
                                                            {{ $notice->data['message_desc'] }}
                                                          <div class="notification-date">{{ $notice->created_at->diffForHumans() }}</div>
                                                      </div>
                                                    </div>
                                                </a> 
                                              @elseif($notice->data['notification_type'] == 'RepaymentLoanRepayment')
                                              <!-- monthly contribution -->
                                              <a href="{{ route('admin.viewnotification') }}" class="list-group-item list-group-item-action active">
                                                      <div class="notification-info">
                                                        <div class="notification-list-user-img"><i class="fa fa-calendar fa-3x" aria-hidden="true"></i></div>
                                                        <div class="notification-list-user-block">
                                                          <span class="notification-list-user-name">Loan Repayment</span>
                                                            {{ $notice->data['message_desc'] }}
                                                          <div class="notification-date">{{ $notice->created_at->diffForHumans() }}</div>
                                                      </div>
                                                    </div>
                                                </a> 
                                              @elseif($notice->data['notification_type'] == 'UpdateLoanRequestAmount')
                                              <!-- monthly contribution -->
                                              <a href="{{ route('admin.loan-applications.show', $notice->data['loan_id']) }}" class="list-group-item list-group-item-action active">
                                                      <div class="notification-info">
                                                        <div class="notification-list-user-img"><i class="fa fa-calendar fa-3x" aria-hidden="true"></i></div>
                                                        <div class="notification-list-user-block">
                                                          <span class="notification-list-user-name">Update Loan Request</span>
                                                            {{ $notice->data['message_desc'] }}
                                                          <div class="notification-date">{{ $notice->created_at->diffForHumans() }}</div>
                                                      </div>
                                                    </div>
                                                </a> 
                                              @endif

                                        @endforeach

                                        </div>
                                    </div>

                                @endif

                            </li>

                            <li>
                            @if($notifications < 1)
                              
                            @else
                              <div class="list-footer"> <a href="{{ route('admin.viewnotification') }}">View all notifications</a></div>
                            @endif
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown nav-user list-inline-item"> 
                        <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          @if(!empty(Auth::user()->avatar) && Auth::user()->avatar != 'default.jpg')
                              <img src="{{ asset( 'img/uploads/profileavatar/'.Auth::user()->avatar ) }}" alt="" class="user-avatar-md rounded-circle">
                          @else
                              <img src="{{ asset( 'images/avatar.jpg' ) }}" width="40" height="40" class="rounded-circle">
                          @endif  
                        </a>

                        <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">

                            <div class="nav-user-info">
                                <h5 class="mb-0 text-white nav-user-name">{{ Auth::user()->name }}</h5> 
                                  <span class="status"></span><span class="ml-2">{{ Auth::user()->roles[0]->title }}</span>
                            </div> 

                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-user mr-2"></i>Dashboard</a>
                            <a class="dropdown-item" href="{{ route('profile.password.edit') }}"><i class="fas fa-key mr-2"></i>Change Password</a>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i class="fas fa-sign-out-alt mr-2"></i>Log Out</a>

                        </div>
                    </li>

                </ul>
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