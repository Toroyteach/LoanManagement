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
            <div>{{ $user->name}}</div>
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

      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="center">1</td>
        <td class="left strong">{{ \Carbon\Carbon::parse($monthlystatement->modified_at)->format('m-d-Y H:i:s') }}</td>
        <td class="left">ksh {{ $monthlystatement->total_contributed }}</td>
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
        <th class="right">Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        @foreach($loanstatements as $id => $loan)
        <td class="center">{{ $id++ }}</td>
        <td class="left strong">{{ \Carbon\Carbon::parse($loan->created_at)->format('m-d-Y H:i:s') }}</td>
        <td class="left">{{$loan->loan_type}}</td>
        <td class="right">{{$loan->description}}</td>
        <td class="left">{{$user->is_user && $loan->status_id < 8 ? 'Processing' : $loan->status->name }}</td>
        <td class="right">{{$loan->loan_amount}}</td>
        @endforeach
      </tr>
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