@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="col-md-10 p-5 border-2 border border-secondary rounded justify-content-center ">

                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show w-50">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    {{ session()->get('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                <h2>Electoral Boundary</h2>
                <form action="{{route('admin.boundary')}}" class="form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label>Select Excel File</label>
                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx, .xls">

                    @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mt-5">
                        <button type="submit" class="btn btn-info">Import</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
