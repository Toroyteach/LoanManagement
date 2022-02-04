<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  </head>
  <body>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-sm-6">
              @if($type == 'monthly')
            <h6 class="mb-3">Monthly Contribution Statement:</h6>
              @else
            <h6 class="mb-3">Loan Statement:</h6>
              @endif
            <div>
            <strong>{{ $user->name}}</strong>
            </div>
            <div>{{ $user->idno}}</div> 
            <div>{{ $user->email}}</div>
            <div>{{ $user->number}}</div>
          </div>
        </div>
      </div>
    </div>


@switch($type)
    @case('monthly')

<div class="table-responsive-sm">
  <table class="table table-striped">
    <thead>
      <tr>
        <th class="center">#</th>
        <th>Date last contributed</th>
        <th>Total Amount Contributed</th>
        <th>Monthly Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="center">1</td>
        <td class="left strong">{{ \Carbon\Carbon::parse($monthlystatement->modified_at)->format('m-d-Y H:i:s') }}</td>
        <td class="left">ksh {{ $monthlystatement->total_contributed }}</td>
        <td class="left">ksh {{ $monthlystatement->monthly_amount }}</td>
      </tr>
    </tbody>
  </table>
</div>
        @break

    @case('loan')

    <div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th class="center">#</th>
        <th>Date</th>
        <th>Loan type</th>
        <th>Description</th>
        <th>Status</th>
        <th class="">Amount</th>
        <th class="">Interest</th>
        <th>EMI</th>
        <th class="right">Next Due Payment</th>
      </tr>
    </thead>
    <tbody>
      @foreach($loanstatements as $id => $loan)
      <tr>
        <td\>{{ $id++ }}</td>
        <td >{{ \Carbon\Carbon::parse($loan->created_at)->format('m-d-Y H:i:s') }}</td>
        <td >{{$loan->loan_type}}</td>
        <td >{{$loan->description}}</td>
        <td >{{ $user->is_user && $loan->status_id < 8 ? 'Processing' : $loan->status->name }}</td>
        <td >ksh {{$loan->loan_amount}}</td>
        <td >ksh {{ ( $loan->loan_amount_plus_interest - $loan->loan_amount )}}</td>
        <td >ksh {{ $loan->next_months_pay }} </td>
        <td >{{ empty($loan->next_months_pay_date) ? 'Not Set' : \Carbon\Carbon::parse($loan->next_months_pay_date)->format('m-d-Y H:i:s') }} </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
        @break

    @default
        <span>Something went wrong, please try again</span>
@endswitch

</div>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>