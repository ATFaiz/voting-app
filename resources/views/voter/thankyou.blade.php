@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="alert alert-success col-md-8" role="alert">
                <h3 class="alert-heading text-center">Thank you for registering!</h3><br>
                
                
                <p>Thank you for registering to vote in the upcoming Scottish parliamentary election. Your vote is important, and we appreciate your participation in this democratic process.<br><br>

                    We have sent you an email at {{ Auth::user()->email }} containing a link to confirm your registration and further instructions on how to vote.<br><br>

                    Again, thank you for registering to vote and exercising your right to participate in the democratic process. We look forward to your participation in the upcoming Scottish parliamentary election.</p>
           </div>
        </div>
    </div>
@endsection
