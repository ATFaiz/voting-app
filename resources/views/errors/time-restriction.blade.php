@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="height: 100vh; padding-bottom: 20%;">
    <div class="alert alert-danger text-center" role="alert" style="font-size: 24px;">
        {{ $message }}
    </div>
</div>

@endsection
