@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <h2 class="text-center formal-font">Constituency: {{$voter->constituency}}</h2><br><br>
                
                <form method="POST" action="{{ route('vote.storeConstituency') }}">
                    <div class="row justify-content-center" name="vote">
                        @csrf
                        @foreach ($candidates as $candidate)
                        <div class="col-md-3 mb-3 card ballot-card">
                          <div class="card-body align-items-center ">
                            <img src="{{ asset($candidate->image) }}" width="50" height="50" 
                            class="img img-responsive rounded-circle mb-2">
                            <h5 class="card-title mb-0">{{ $candidate->fullname }}</h5>
                            <p class="card-text">{{ $candidate->party->name }}</p>
                            <p class="card-text">{{ $candidate->constituency }}</p>
                            <button type="button" name="candidate_id" 
                            data-candidate-id="{{ $candidate->id }}" 
                            class="btn btn-primary store-button">Vote</button>
                        
                              <div class="ballot-box">
                                <span class="ballot-checkmark">&#10004;</span>
                              </div>
                          </div>
                        </div>
                      @endforeach
                    </div>
                </form>
                
                <div class="modal fade" id="store-modal" tabindex="-1" role="dialog" aria-labelledby="store-modal-label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="store-modal-label">Confirm Vote</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to vote for this candidate?
                                            <form id="store-form" action="{{ route('vote.storeConstituency') }}" method="POST">
                                                @csrf
                                                
                                                <input type="hidden" name="candidate_id" id="store-modal-candidate-id" value="">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" onclick="$('#store-modal').modal('hide')">Cancel</button>
                                            <button type="button" class="btn btn-danger" id="confirm-store-button">Vote</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('.store-button').click(function() {
                                        var candidateId = $(this).data('candidate-id');
                                        $('#store-modal-candidate-id').val(candidateId);
                                        $('#store-modal').modal('show');
                                    });

                                    $('#confirm-store-button').click(function() {
                                        $('#store-form').submit();
                                    });
                                });
                            </script>
            </div>
        </div>
    </div>
@endsection
