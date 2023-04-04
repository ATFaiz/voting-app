@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Regional Election Results') }}</div>

                <div class="card-body">
                <form action="{{ route('vote.searchRegionalVote') }}" method="get">
            <div class="form-group">
                <label for="regional">Select a region:</label>
                <select name="regional" id="regional" class="form-control">
                    <option value="">Select a region</option>
                    @foreach($regions as $region)
                        <option value="{{ $region }}" {{ $region == $regional ? 'selected' : '' }}>{{ $region }}</option>
                    @endforeach
                </select>
            </div><br>
            <button type="submit" class="btn btn-primary">Search</button>
        </form><br>

        @if(collect($parties)->isNotEmpty())
            <table class="table">
                <thead>
                    <tr>
                        <th>Party Name</th>
                        <th>Total Votes</th>
                        <th>Seats</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parties as $party)
                        <tr>
                            <td>{{ $party->name }}</td>
                            <td>{{ $party->total_votes }}</td>
                            <td>{{ $party->seats }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
               
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
