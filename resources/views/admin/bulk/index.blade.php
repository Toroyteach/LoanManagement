@extends('layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-sm-6">
            <h4>Bulk File Update</h4>
        </div>
    </div>
<hr/>
</div>

<div class="container">
    <form method="GET" enctype="multipart/form-data" id="template-download" action="{{ route('admin.template.download') }}">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="cars">Select Template type to download:</label>
                    <select name="type" id="type" required>
                        <option value="">--Please choose an option--</option>
                        <option value="loan">Loan Application</option>
                        <option value="monthly">Monthly Savings</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Download</button>
            </div>
        </div>     
    </form>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-sm-6">
            <h4>File Upload</h4>
        </div>
    </div>
<hr/>
</div>
<div class="container">
    <form method="POST" enctype="multipart/form-data" id="file-upload" action="javascript:void(0)" >
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="cars">Select Update type:</label>
                    <select name="type" id="type" required>
                        <option value="">--Please choose an option--</option>
                        <option value="loan">Loan Repayment</option>
                        <option value="monthly">Monthly Contribution</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="file" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file" placeholder="Choose File" id="file">
                    <span class="text-danger">{{ $errors->first('file') }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>     
    </form>
</div>

<div class="container">

    <div class="container" style="display:none;" id="loantableV">
        <div class="alert alert-warning">
            <h4>Loan Application Changes. Please review the file you uploaded and submit</h4>
        </div>

        <a class="btn btn-success" id="submitfile"> Submit</a>
        <a class="btn btn-danger" id="deletefile"> Delete</a>
        <input type="hidden" value="loan" id="typef" name="typef">

        <table class="table table-bordered data-table" id="loantable">

            <thead>

                <tr>

                    <th>No</th>

                    <th>Loan Entry Number</th>

                    <th>Member Number</th>

                    <th>Amount</th>

                </tr>

            </thead>

            <tbody>

            </tbody>

        </table>
    </div>

 
    <div class="container" style="display:none;" id="monthlytableV">
        <div class="alert alert-warning">
            <h4>Monthly Contribution Changes. Please review the file you uploaded and submit</h4>
        </div>

        <a class="btn btn-success" href="javascript:void(0)" id="submitfileM"> Submit</a>
        <a class="btn btn-danger" href="javascript:void(0)" id="deletefileM"> Delete</a>
        <input type="hidden" value="monthly" id="typeM" name="typeM">
            <div class="row">
                <div class="col-12">

                    <table class="table table-bordered data-tablee" id="monthlytable">
    
                        <thead>
    
                            <tr>
    
                                <th>No</th>
    
                                <th>Member No</th>
    
                                <th>Amount</th>
    
                            </tr>
    
                        </thead>
    
                        <tbody>
    
                        </tbody>
    
                    </table>
                </div>
            </div>
    </div>


</div>

@endsection
@section('scripts')
@parent

<script type="text/javascript">


    let loanDataTable = document.getElementById("loantableV");
    let MonthlyDataTable = document.getElementById("monthlytableV");
    let _token   = $('meta[name="csrf-token"]').attr('content');
    let fullScreenLoader = document.getElementById("fullLoader");

    //fetchDataTableLoan()

    $(document).ready(function (e) {

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $('#template-download').submit(function(e) {
        //     //validate that the template to be download has been selected
        //     //then down the file for the user.


        // });

        $('#file-upload').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            fullScreenLoader.style.display = "block";

            $.ajax({
                type:'POST',
                url: "{{ route('admin.bulkFile') }}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (data) => {

                        this.reset();
                        swal.fire("Done!", " File Uploaded succesfully", "success");
                        isDirty = true;

                        if(data.file === 'loan'){

                            fullScreenLoader.style.display = "none";
                            fetchDataTableLoan()

                        } else {
                            fullScreenLoader.style.display = "none";
                            fetchDataTableMonthly()
                        }

                },

                error: function(data){
                    fullScreenLoader.style.display = "none";
                    swal.fire("Error!", "", " Error Uploading File");
                }
            });
        });

        $('#submitfile').click(function (e) {
            e.preventDefault()

            var type = document.getElementById('typef').value;

            fullScreenLoader.style.display = "block";

            $.ajax({
                type:'POST',
                url: "{{ route('admin.updatefileuploaddetails') }}",
                data: {
                    type: type
                },
                cache:false,
                processData: true,
                success: (data) => {

                        fullScreenLoader.style.display = "none";
                        swal.fire("Done!", "File Changes were added succesfully", "success");

                        setTimeout(function(){
                            location.reload();
                        },1000);

                },

                error: function(data){
                    fullScreenLoader.style.display = "none";
                    swal.fire("Error!", "", " Error Making changes File.");
                }
            });

        });

        $('#deletefile').click(function () {

            var type = document.getElementById('typef').value;
            
            fullScreenLoader.style.display = "block";

            $.ajax({
                type:'POST',
                url: "{{ route('admin.deletefileuploaddetails') }}",
                data: {
                    type: type,
                },
                cache:false,
                processData: true,
                success: (data) => {

                        fullScreenLoader.style.display = "none";
                        swal.fire("Done!", "File Details was deleted succesfully", "success");

                        setTimeout(function(){
                            location.reload();
                        },1000);
                },

                error: function(data){
                    fullScreenLoader.style.display = "none";
                    swal.fire("Error!", "", " Error Deleteing File Details");
                }
            });

        });

        $('#submitfileM').click(function () {

            let type = document.getElementById('typeM').value;

            fullScreenLoader.style.display = "block";

            $.ajax({
                type:'POST',
                url: "{{ route('admin.updatefileuploaddetails') }}",
                data: {
                    type: type
                },
                cache:false,
                processData: true,
                success: (data) => {

                        fullScreenLoader.style.display = "none";
                        swal.fire("Done!", "File Changes were added succesfully", "success");

                        setTimeout(function(){
                            location.reload();
                        },1000);

                },

                error: function(data){
                    fullScreenLoader.style.display = "none";
                    swal.fire("Error!", "", " Error Making changes File.");
                }
            });

        });

        $('#deletefileM').click(function () {

         var type = document.getElementById('typeM').value;

         fullScreenLoader.style.display = "block";

            $.ajax({
                type:'POST',
                url: "{{ route('admin.deletefileuploaddetails') }}",
                data: {
                    type: type
                },
                cache:false,
                processData: true,
                success: (data) => {

                        fullScreenLoader.style.display = "none";
                        swal.fire("Done!", "File Details was deleted succesfully", "success");

                        setTimeout(function(){
                            location.reload();
                        },1000);
                },

                error: function(data){
                    fullScreenLoader.style.display = "none";
                    swal.fire("Error!", "", " Error Deleteing File Details");
                }
            });

        });

    });


    function fetchDataTableLoan()
    {

        loanDataTable.style.display = "block";

        $('#loantable').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('admin.loadFile') }}",

        columns: [

            {data: 'DT_RowIndex', name: 'DT_RowIndex'},

            {data: 'entry_number', name: 'entry_number'},

            {data: 'member_number', name: 'member_number'},

            {data: 'amount', name: 'amount'},

        ]

        });
    }

    function fetchDataTableMonthly()
    {

        MonthlyDataTable.style.display = "block";

        $('.data-tablee').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('admin.loadFileMo') }}",

        columns: [

            {data: 'DT_RowIndex', name: 'DT_RowIndex'},

            {data: 'member_number', name: 'member_number'},

            {data: 'amount', name: 'amount'},

        ]

        });
    }

</script>

@endsection