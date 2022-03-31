@extends('layouts.admin')
@section('content')

<div class="alert alert-warning" role="alert">
  <h4 class="alert-heading">Well done!</h4>
  <p>You are getting here because you have not yet verified your email. Please verify your email and try again.</p>
  <hr>
  <p class="mb-0">If you haven't updated your user details please click here.</p>
  <a href="{{ route('users.fill.details') }}"> Click here</a>
</div>
@endsection