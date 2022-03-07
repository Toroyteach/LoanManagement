@extends('layouts.admin')
@section('content')


@can('loan_application_create')
    <div class="continer" >
                @livewire('request')
    </div>
@endcan



@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">


$(document).ready(function(){

      var route = "{{ url('admin/autocomplete') }}";
        $('.search').typeahead({
            source:  function (term, process) {
            return $.get(route, { term: term }, function (data) {
                    return process(data);
                });
            },
            minLength: 3,
            delay: 3
        });  

});
</script>
