@extends('layouts.admin')
@section('content')

    @forelse($notifications as $notice)
        @if($notice->data['notification_type'] == 'NewLoanApplication')
                                  <!-- new loan application notification -->

                                    <div class="container_fluid bg-secondary" style="padding:1em;">
                                    @if(empty($notice->read_at))
                                            <div class="conatiner">
                                                <a href="#" class="btn btn-info btn-sm mark-as-read" data-id="{{ $notice->id }}">
                                                    Mark as read
                                                </a>
                                            </div>
                                            @endif

                                            <div class="container">
                                                @if(Auth::user()->is_user)
                                                    <strong class="">Dear {{ $notice->data['message_name'] }}</strong>
                                                @else
                                                    <strong class="">New Loan Application</strong>
                                                @endif
                                                <div>
                                                    <p class="">{{ $notice->data['message_desc'] }}</p>
                                                </div>
                                            </div>

                                            <div class="float-right">
                                                <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                            </div>

                                        </div>

                                    </div>

                              @elseif($notice->data['notification_type'] == 'StatusAnalysis')
                                  <!-- status analysis internal -->

                                    <div class="container_fluid bg-secondary" style="padding:1em;">
                                        <div class="alert alert-success" role="alert">
                                        @if(empty($notice->read_at))
                                            <div class="conatiner">
                                                <a href="#" class="btn btn-info btn-sm mark-as-read" data-id="{{ $notice->id }}">
                                                    Mark as read
                                                </a>
                                            </div>
                                            @endif

                                            <div class="container">
                                                <strong class="">New Loan Application Status</strong>
                                                <div>
                                                    <p class="">{{ $notice->data['message_desc'] }}</p>
                                                </div>
                                            </div>

                                            <div class="float-right">
                                                <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                            </div>

                                        </div>

                                    </div>

                              @elseif($notice->data['notification_type'] == 'LoanAnalysis')
                                  <!-- loanAnalysis notice -->

                                    <div class="container_fluid bg-secondary" style="padding:1em;">
                                        <div class="alert alert-success" role="alert">
                                        @if(empty($notice->read_at))
                                            <div class="conatiner">
                                                <a href="#" class="btn btn-info btn-sm mark-as-read" data-id="{{ $notice->id }}">
                                                    Mark as read
                                                </a>
                                            </div>
                                            @endif

                                            <div class="container">
                                                <strong class="">New Loan Analysis Report</strong>
                                                <div>
                                                    <p class="">{{ $notice->data['message_desc'] }}</p>
                                                </div>
                                            </div>

                                            <div class="float-right">
                                                <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                            </div>

                                        </div>

                                    </div>
                                

                              @elseif($notice->data['notification_type'] == 'CompleteLoanApplication')
                                  <!-- StatusAnalyis user (approved or rejected) -->


                                    <div class="container_fluid bg-secondary" style="padding:1em;">
                                        <div class="alert alert-success" role="alert">
                                        @if(empty($notice->read_at))
                                            <div class="conatiner">
                                                <a href="#" class="btn btn-info btn-sm mark-as-read" data-id="{{ $notice->id }}">
                                                    Mark as read
                                                </a>
                                            </div>
                                            @endif

                                            <div class="container">
                                                <strong class="">Loan Application Status </strong>
                                                <div>
                                                    <p class="">{{ $notice->data['message_desc'] }}</p>
                                                </div>
                                            </div>

                                            <div class="float-right">
                                                <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                            </div>

                                        </div>

                                    </div>
                    

                              @elseif($notice->data['notification_type'] == 'MonthlyContribution')

                                  <!-- Monthly payment Analysis -->

                                    <div class="container_fluid bg-secondary" style="padding:1em;">
                                        <div class="alert alert-success" role="alert">
                                        @if(empty($notice->read_at))
                                            <div class="conatiner">
                                                <a href="#" class="btn btn-info btn-sm mark-as-read" data-id="{{ $notice->id }}">
                                                    Mark as read
                                                </a>
                                            </div>
                                            @endif

                                            <div class="container">
                                                <strong class="">Monthly Contribution</strong>
                                                <div>
                                                    <p class="">{{ $notice->data['message_desc'] }}</p>
                                                </div>
                                            </div>

                                            <div class="float-right">
                                                <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                            </div>

                                        </div>

                                    </div>

                                    @elseif($notice->data['notification_type'] == 'GuarantorRequest')

                                  <!-- Monthly payment Analysis -->

                                  <div class="container-fluid bg-secondary gurantor" style="padding:1em;">
                                        <div class="alert alert-success">
                                            @if(empty($notice->read_at))
                                            <div class="conatiner" role="alert">
                                                <a href="#" class="btn btn-info btn-sm mark-as-read" data-id="{{ $notice->id }}">
                                                    Mark as read
                                                </a>
                                            </div>
                                            @endif

                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <strong class="">Gurantor Request</strong>
                                                        <div>
                                                            <p class="">{{ $notice->data['message_desc'] }}</p>
                                                        </div>
                                                    </div>
                                                @if(empty($notice->read_at))
                                                    <div class="col-md-5">
                                                    <input type="hidden" value="{{ $notice->data['member_id'] ?? '' }}" id="loanrequestid">
                                                        <div>
                                                            <button class="btn btn-sm btn-warning " onclick="submitResponse('Rejected')">Reject</button>
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-sm btn-success " onclick="submitResponse('Accepted')">Accept</button>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                </div>
                                            </div>

                                            <div class="float-right">
                                                <small class="text-primary">{{ $notice->created_at->diffForHumans() }}</small>
                                            </div>

                                        </div>

                                    </div>

                                  @endif


        @if($loop->last)
            <a class="btn btn-warning btn-sm" href="#" id="mark-all">
                Mark all as read
            </a>
        @endif
    @empty
        There are no new notifications
    @endforelse

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    $(function() {
        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));
            request.done(() => {
                $(this).parents('div.alert').remove();
                            Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: "Request submitted successfully",
                                  showConfirmButton: false,
                                  timer: 2000
                              });

                              setTimeout(function(){
                                    location.reload();
                            }, 1000);
            });
        });
        $('#mark-all').click(function() {
            let request = sendMarkRequest();
            request.done(() => {
                 $('div.alert').remove();

                            Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: "Request submitted successfully",
                                  showConfirmButton: false,
                                  timer: 2000
                              });

                              setTimeout(function(){
                                    location.reload();
                            }, 1000);
            })
        });
        $('.accept-gurantor').click(function() {
            let request = sendGurantorRequest('Accepted', $(this).data('id'), $(this).data('loan'));
            request.done(() => {
                $('.gurantor').remove();
            })
        });
        $('.reject-gurantor').click(function() {
            // console.log("this line")
            let request = sendGurantorRequest('Rejected', $(this).data('id'), $(this).data('loan'));
            request.done(() => {
                $('.gurantor').remove();
            })
        });
    });

    function submitResponse(choice = null) {

        let choiceMade = choice;
        let loanid = document.getElementById('loanrequestid').value
        let noticeid = "{{ $notice->id ?? '' }}";
        let _token = $('meta[name="csrf-token"]').attr('content');

        swal.fire({
            title: "Gurantor Request",
            icon: 'question',
            text: "Are you sure you want to take this action. The request will be "+choiceMade+". This action is irreversible",
            showCancelButton: !0,
            confirmButtonText: "Yes, Submit",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {

            if (e.value === true) {

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.requestGurantor') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        loan_id: loanid,
                        choice: choiceMade,
                        requestid: noticeid
                        },
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.status === true) {

                            swal.fire("Done!", results.message, "success");
                            // refresh page after 2 seconds
                            setTimeout(function(){
                                location.reload();
                            },3000);

                        } else if(results.status === false) {

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

    function sendMarkRequest(id = null) {
        console.log("this")
        return $.ajax("{{ route('admin.markNotification') }}", {
            method: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                id
            },

        });
    }

    function sendGurantorRequest(choice = null, loanid, id) {
        console.log(choice+" "+loanid+" "+id)
        return $.ajax("{{ route('admin.requestGurantor') }}", {
            method: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "choice" : choice,
                "laonid" : loanid,
                id
            }, 

            success:function(data) {

                if(data.status){

                            Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: "request submitted successfully",
                                  showConfirmButton: false,
                                  timer: 2000
                              });   

                              setTimeout(function(){
                                    location.reload();
                            }, 2000);

                } else {

                            Swal.fire({
                                  position: 'top-end',
                                  icon: 'error',
                                  title: "Oops! Something went wrong",
                                  showConfirmButton: false,
                                  timer: 2000
                              });
                    
                }

            }

        });
    }

    </script>
