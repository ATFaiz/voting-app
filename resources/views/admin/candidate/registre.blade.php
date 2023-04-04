
@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('Candidate Registration Form') }}</div>

                <div class="card-body">
               
                    <a href="{{route('admin.candidate.index')}}" class="btn btn-success btn-sm" title="Back to Your Contact List">
                            <i class="fa fa-arrow-left"></i> Go Back
                        </a>
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

                    <form action="{{route('admin.candidate.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <label> First Name</label></br>
                        <input type="text" name="fullname" id="fullname" value="{{ old('fullname') }}" class="form-control"></br>
                        <input class="form-control" name="image" type="file" id="image"></br>
                        <select name="party_id" id="party_id" required class="form-control">
                        <option selected>Select Party</option>
                        @foreach($parties as $party)
                        <option value={{$party->id}}>{{$party->name}}</option>
                        @endforeach
                        </select>
                         <br>
                        <select name="region_id" id="region_id" class="form-control">
                            <option value="">Select a region</option>
                            <option value="0">None</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->region }}</option>
                            @endforeach
                        </select>
                        <br>
                        <select name="constituency_id" id="constituency_id" class="form-control">
                            <option value="">Select a constituency</option>
                            <option value="0">None</option>
                            @foreach ($constituencies as $constituency)
                                <option value="{{ $constituency->id }}">{{ $constituency->constituency }}</option>
                            @endforeach
                        </select>
                        <br>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                        $(document).ready(function () {
                            $('#region_id').change(function () {
                                var region_id = $(this).val();
                                if (region_id == "0") {
                                    $('#constituency_id').html('');
                                    @foreach ($constituencies as $constituency)
                                        $('#constituency_id').append('<option value="{{ $constituency->id }}">{{ $constituency->constituency }}</option>');
                                    @endforeach
                                } else {
                                    $.ajax({
                                        url: "{{ route('admin.filter.constituencies') }}",
                                        type: "POST",
                                        data: {
                                            region_id: region_id,
                                            _token: "{{ csrf_token() }}"
                                        },
                                        success: function (response) {
                                        var constituencies = response;
                                        var options = '<option value="">None</option>';
                                        for (var i = 0; i < constituencies.length; i++) {
                                            options += '<option value="' + constituencies[i].id + '">' + constituencies[i].constituency + '</option>';
                                        }
                                        $('#constituency_id').html(options);
                                    }

                                    });
                                }
                            });
                        });

                        </script>


    
                        <input type="submit" value="Submit" class="btn btn-success" title="submit"></br>
                        
                    </form>
                       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection