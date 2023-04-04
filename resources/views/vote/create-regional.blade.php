@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <h2 class="text-center formal-font">Regional: {{$voter->regional}}</h2><br><br>
                <form method="POST" action="{{ route('vote.storeRegional') }}">
                    <div class="row justify-content-center" name="vote">
                        @csrf
                        @foreach ($parties as $party)
                        <div class="col-md-3 mb-3 card ballot-card">
                          <div class="card-body align-items-center ">
                            <img src="{{ asset($party->image) }}" width="50" height="50" class="img img-responsive rounded-circle mb-2">
                            <h5 class="card-title mb-0">{{ $party->name }}</h5><br>                          
                            <button type="button" name="party_id" data-party-id="{{ $party->id }}" class="btn btn-primary store-button">Vote</button>
                        
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
                                            Are you sure you want to vote for this party?
                                            <form id="store-form" action="{{ route('vote.storeRegional') }}" method="POST">
                                                @csrf
                                                
                                                <input type="hidden" name="party_id" id="store-modal-party-id" value="">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-danger" id="confirm-store-button">Vote</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('.store-button').click(function() {
                                        var partyId = $(this).data('party-id');
                                        $('#store-modal-party-id').val(partyId);
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
