@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header font-weight-bold display-9">{{ __('Constituency Election Results') }}</div> 

                <div class="card-body">

                <form action="{{ url('admin/constituency-votes/search') }}" method="get">
                    <label for="constituency">Select a constituency:</label>
                    <select id="constituency" name="constituency">
                        @foreach ($constituencies as $option)
                            <option value="{{ $option }}" 
                            {{ $constituency == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Search</button>
                </form><br>

                <h4>Results for: {{ $constituency }}</h4>
                @if($winners->count() == 1)
                <div class="alert alert-success" role="alert">
                    The winner of the {{ $constituency }} constituency is 
                    {{ $winners->first()->fullname }} with {{ $winners->first()->total_votes }} votes.
                </div>
                @elseif($winners->count() > 1)
                <div class="alert alert-warning" role="alert">
                    There is a tie for the {{ $constituency }} constituency between the following candidates:
                        <ul>
                            @foreach($winners as $winner)
                               <li>{{ $winner->fullname }} with {{ $winner->total_votes }} votes</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div class="d-flex flex-wrap">
                @foreach ($candidates as $candidate)
                    <div class="card col-md-3 mx-2">
                        <!-- <div class="card-header"></div> -->
                        <div class="card-body">
                            <img src="{{ $candidate->image }}" alt="{{ $candidate->fullname }}" class="img-fluid"  width= '100' height='100'>
                            <h5 class="card-title">{{ $candidate->fullname }}</h5>
                            <h6>Votes: {{ $candidate->total_votes }}</h6>
                        </div>
                    </div>
                @endforeach

                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
