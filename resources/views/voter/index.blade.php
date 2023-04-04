@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Registered Voters</h1>
                <form method="GET" action="{{ route('voter.index') }}" class="form-inline my-2 my-lg-0">
                    <div class="input-group">
                        <input class="form-control mr-sm-2" type="search" name="search" value="{{ $search }}" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </div>
                    </div>
                </form>


                <table class="table border">
                    <thead>
                        <tr>
                            <th>#</th>    
                            <th>Name</th>
                            <th>Date Of Birth</th>
                            <th>Address</th>
                            <th>Postcode</th>
                            <th>Region</th>
                            <th>Constituency</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voters as $voter)
                            <tr>
                            <!-- <td>{{ $loop->iteration }}</td> -->
                            <td>{{ ($voters->currentPage() - 1) * $voters->perPage() + $loop->iteration }}</td>
                                <td>{{ $voter->fullname }}</td>
                                <td>{{ $voter->dob }}</td>
                                <td>{{ $voter->address }}</td>
                                <td>{{ $voter->postcode }}</td>
                                <td>{{ $voter->boundary ? $voter->boundary->region : '' }}</td>
                                <td>{{ $voter->boundary ? $voter->boundary->constituency : '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                 {{ $voters->appends(['search' => $search])->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
