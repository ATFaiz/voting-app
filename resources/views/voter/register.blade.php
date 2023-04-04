@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <h1 class="text-center">Register to Vote in the Scottish Parliamentary Election</h1>
                <p>Welcome to the registration page for the upcoming Scottish Parliamentary Election. This election is an opportunity for you to have your say in shaping the future of Scotland and ensuring that your voice is heard.

                <br> <br>To be eligible to vote in the election, you must be:<br><br>
•	A resident of Scotland<br>
•	Aged 16 or over on the day of the election<br>
•	A British citizen, a qualifying Commonwealth citizen, or a citizen of the Republic of Ireland<br><br>

If you meet these criteria, you can register to vote by completing the form below. You will need to provide your personal details, including your name, address, and date of birth. You will also need to provide your National Insurance number, which is used to verify your identity.<br><br>
Once you have registered, you will receive an email, which will instruct you when and how to access a secure voting platform to cast your vote.
Don't miss out on your chance to have a say in the future of Scotland.
!</p>
                <h3>register to vote today!</h3>
                @error('postcode')
                    <div class="alert alert-danger">{{ $message }}</div>
                 @enderror
                 @error('dob')
                    <div class="alert alert-danger">{{ $message }}</div>
                 @enderror
                <form action="{{ route('voter.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="fullname">Name</label>
                        <input type="text" name="fullname" id="fullname" value="{{ old('fullname') }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date Of Birth</label>
                        <input type="dob" name="dob" id="dob" value="{{ old('dob') }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="postcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode" value="{{ old('postcode') }}" class="form-control" onkeyup="this.value = this.value.toUpperCase();" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                    
                </form>
            </div>
        </div>
    </div>
@endsection
