@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Online Voting Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}

                        </div>
                    @endif

                            <div class="row">
                                <div class="col-md-6 col-xl-4 mb-4">
                                    <a style="text-decoration:none;" href="{{ route('admin.boundary') }}"> 
                                        <div class="card bg-primary text-white">
                                            <div class="card-body">
                                                <h5 class="card-title">PostCode</h5>
                                                <p class="card-text">Import Data into Database</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                                
                            <div class="col-md-6 col-xl-4">
                                <a style="text-decoration:none;" href="{{ url('admin/candidate') }}">
                                    <div class="card bg-success text-white mb-4">
                                        <div class="card-header">
                                            <h6 class="m-b-20">Stand for</h6>
                                            <h2 class="text-right"><i class="fa fa-address-card f-left"></i><span>Candidates</span></h2>
                                        </div>
                                        <div class="card-body">
                                            <p class="m-b-0">Constituency and Regional<span class="f-right"></span></p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            
                            <div  class="col-md-6 col-xl-4 mb-4">
                            <a style="text-decoration:none;" href="{{ url('admin/party') }}">                     
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Parties</h5>
                                        <p class="card-text">Add and Edit Parties</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6 col-xl-4 mb-4">
                            <a style="text-decoration:none;" href="{{ url('admin/voters') }}"> 
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Registered Voters</h5>
                                        <p class="card-text"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                            
                        <div class="col-md-6 col-xl-4 mb-4">
                        <a style="text-decoration:none;" href="{{ url('admin/constituency-votes/search') }}">  
                            <div class="card bg-secondary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Constituency Election Results</h5>
                                    <p class="card-text"></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-xl-4 mb-4">
                    <a style="text-decoration:none;" href="{{ url('admin/regional-votes/search') }}"> 
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Regional Election Results</h5>
                                <p class="card-text"></p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-xl-4 mb-4">
                <a style="text-decoration:none;" href="{{ url('#') }}"> 
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Create</h5>
                            <p class="card-text">Admin Account Registration</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-xl-4">
                <a style="text-decoration:none;" href="{{ url('#') }}">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-key fa-lg mr-3"></i>Forget Password</h5>
                            <p class="card-text">Reset password for admin account.</p>
                        </div>
                    </div>
                </a>
            </div>


                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
