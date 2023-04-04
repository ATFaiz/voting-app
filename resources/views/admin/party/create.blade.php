@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('Cerate New Party') }}</div>

                <div class="card-body">
               
                    <a href="{{ route('admin.party.index') }}" class="btn btn-success btn-sm" title="Back to Your Contact List">
                            <i class="fa fa-arrow-left"></i> Go Back
                        </a>
                        <br/>
                        <br/>

                        <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show w-50">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.party.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <label> Name</label></br>
                        <input type="text" name="name" id="name" class="form-control"></br>
                        <input class="form-control" name="image" type="file" id="image"></br>
                                       
                        <input type="submit" value="Create" class="btn btn-success" title="Create new Party"></br>
                    </form>
                       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection