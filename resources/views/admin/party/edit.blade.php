@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit {{ $parties->name }} Detail</div>

                <div class="card-body">
                   

                    <a href="{{ route('admin.party.index') }}" class="btn btn-success btn-sm" title="Back to main List">
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

                    <form method="POST" action="{{route('admin.party.update', $parties->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id" value="{{$parties->id}}" id="id" />
                        <label>Name</label></br>
                        <input type="text" name="name" id="name" value="{{$parties->name}}" class="form-control"></br>
                        <input class="form-control" name="image" type="file" id="image">
                        <img src="{{ asset($parties->image) }}" width= '50' height='50' class="img img-responsive" /></br>

                    
                        <input type="submit" value="Update" class="btn btn-success" title="Update"></br>
                     </form>
                       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection