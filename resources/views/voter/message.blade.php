@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="alert alert-success col-md-8" role="alert">
                <h4 class="alert-heading ">Dear {{ Auth::user()->name }},</h4><br>
                
                
                <p> We regret to inform you that you have already registered to vote in the Scottish parliamentary election. Your registration has been processed and you will be eligible to vote on election day.<br><br>

                    If you have any questions or concerns, please do not hesitate to contact us.<br><br>

                    Best regards,<br><br>
                    [...Election Comettee...]
                    </p>
           </div>
        </div>
    </div>
@endsection
