@extends('dashboard.layout.template')
@section('content')
    <div class="container">
        <h1>tes List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tes as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <a href="#" class="btn btn-primary" data-toggle="modal"
                                data-target="#edit-modal-{{ $item->id }}">Edit</a>
                            <a href="#" class="btn btn-danger" data-toggle="modal"
                                data-target="#delete-modal-{{ $item->id }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @foreach ($tes as $item)
        <div class="modal fade" id="edit-modal-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="edit-modal-label-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('tes.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label-{{ $item->id }}">Edit tes</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $item->name }}">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
