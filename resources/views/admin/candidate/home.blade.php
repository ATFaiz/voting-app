@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Candidates') }}</div>

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

                    <form action="{{ route('admin.candidate.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Search...">
                    <button type="submit">Go</button>
                    </form><br>
             
                    <a href="{{route('admin.candidate.create')}}" class="btn btn-success btn-sm" title="Add new condidate">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add Candidate
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Constituency</th>
                                        <th>Region</th>
                                        <th>Party</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                </thead>
                                </thead>
                                <tbody>
                                @php($count=1)
                                @foreach($candidates as $candidate)
                                    <tr>
                                        <td>{{ ($candidates->currentPage() - 1) * $candidates->perPage() + $loop->iteration }}</td>
                                        <td>{{ $candidate->fullname }}</td>
                                        <td>{{ $candidate->constituency }}</td>
                                        <td>{{ $candidate->regional }}</td>                                      
                                        <td>
                                        {{ $candidate->party ? $candidate->party->name : '' }} 
                                        </td>
                                        <td>
                                            <img src="{{ asset($candidate->image) }}" width= '50' height='50' class="img img-responsive" />
                                        </td> 
                                        </td>           
                                        <td>
                                        <a href="{{ route('admin.candidate.edit', $candidate->id) }}" class="btn btn-sm btn-outline-success" title="Edit Contact"><i class="fa fa-pencil-square-o"></i></a>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-button" data-candidate-id="{{$candidate->id}}"><i class="fa fa-trash"></i></button>

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
                                            Are you sure you want to delete this candidate?
                                            <form id="delete-form" action="{{ route('admin.candidate.destroy', 0) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" id="delete-modal-candidate-id" value="">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" onclick="$('#delete-modal').modal('hide')">Cancel</button>
                                            <button type="button" class="btn btn-danger" id="delete-button">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                            {{ $candidates->appends(['search' => $search])
                                ->withQueryString()->links() }}
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('.delete-button').click(function() {
                                        var candidateId = $(this).data('candidate-id');
                                        $('#delete-modal-candidate-id').val(candidateId);
                                        $('#delete-modal').modal('show');
                                    });
                                });

                            </script>

                            <script>
                                $(document).ready(function() {
                                    $('#delete-button').click(function() {
                                        $('#delete-form').attr('action', '/admin/candidate/' + $('#delete-modal-candidate-id').val());
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