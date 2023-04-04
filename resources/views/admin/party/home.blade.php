@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('Parties List') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
              
                    <a href="{{route('admin.party.create')}}" class="btn btn-success btn-sm" title="Add New Party">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add Party
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>image</th>
                                        <th>Action</th>
                                </thead>
                                </thead>
                                <tbody>
                                @php($count=1)
                                @foreach($parties as $party)
                                                                   <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $party->name }}</td>
                                        <td>
                                            <img src="{{ asset($party->image) }}"  class="img img-responsive" />
                                        </td>       
                                        <td>
                                        <a href="{{ route('admin.party.edit', $party->id) }}" class="btn btn-sm btn-outline-success" title="Edit Contact"><i class="fa fa-pencil-square-o"></i></a>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-button" data-party-id="{{$party->id}}"><i class="fa fa-trash"></i></button>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="delete-modal-label">Confirm Deletion</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this party?
                                                    <form id="delete-form" action="{{ route('admin.party.destroy', 0) }}" method="POST">
                                                        @csrf
                                                        @method('Delete')
                                                        <input type="hidden" name="id" id="delete-modal-party-id" value="">
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" onclick="$('#delete-modal').modal('hide')">Cancel</button>

                                                    <button type="button" class="btn btn-danger" id="delete-button">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <script>
                                $(document).ready(function() {
                                    $('.delete-button').click(function() {
                                        var partyId = $(this).data('party-id');
                                        $('#delete-modal-party-id').val(partyId);
                                        $('#delete-modal').modal('show');
                                    });
                                });
                            </script>

                             <script>
                                $(document).ready(function() {
                                $('#delete-button').click(function() {
                                    $('#delete-form').attr('action', '/admin/party/' + $('#delete-modal-party-id').val());
                                    $('#delete-form').submit();
                                });
                            });

                             </script>


                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection