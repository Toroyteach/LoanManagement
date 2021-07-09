@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add File</div>

                <div class="card-body">

                    <form action="{{ route('admin.files.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        Title:
                        <br>
                        <input type="text" name="title" class="form-control" required>

                        <br>

                        Cover File:
                        <br>
                        <input type="file" name="cover" required>

                        <br><br>

                        <input type="submit" value=" Upload File " class="btn btn-primary">

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection 