@extends('dashboard.layout.template')
@section('content')
    <div class="col-xl">
        <div class="card mb-4">
            {{-- @foreach ($tables as $table) --}}
            <button class="btn btn-primary"><a href="{{ route('createTable.create') }}">jnjn</a></button>
            {{-- @endforeach --}}
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tambah Database</h5>
                <small class="text-muted float-end">ini adalah form untuk menambah database</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('createTable.store') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="table_name">Table Name:</label>
                        <input type="text" class="form-control" id="table_name" name="table_name">
                    </div>
                    <div class="form-group">
                        <label for="columns">Columns:</label>
                        <table class="table table-bordered" id="dynamicTable">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Length</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><input type="text" name="columns[0][name]" placeholder="Enter column name"
                                        class="form-control" /></td>
                                <td>
                                    <select name="columns[0][type]" class="form-control">
                                        <option value="string">String</option>
                                        <option value="integer">Integer</option>
                                        <option value="bigInteger">Big Integer</option>
                                        <option value="text">Text</option>
                                        <option value="date">Date</option>
                                        <option value="datetime">Datetime</option>
                                        <option value="time">Time</option>
                                    </select>
                                </td>
                                <td><input type="text" name="columns[0][length]" placeholder="Enter length"
                                        class="form-control" /></td>
                                <td>
                                    <button type="button" name="add" id="add" class="btn btn-success">Add
                                        More</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group mt-3">
                        <label for="related_table">Related Table:</label>
                        <input type="text" class="form-control" id="related_table" name="related_table">
                    </div>
                    <div class="form-group mt-3">
                        <label for="foreign_key">Foreign Key Column Name:</label>
                        <input type="text" class="form-control" id="foreign_key" name="foreign_key">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="dynamicTable">
                <thead>
                    <tr>
                        <th>Table Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tables as $table)
                        <tr>
                            <td>{{ $table->Tables_in_kuncupbahari }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="{{ route('createTable.destroy', $table->Tables_in_kuncupbahari) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('createTable.edit', $table->Tables_in_kuncupbahari) }}"
                                            class="btn btn-primary">Edit</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <script type="text/javascript">
        var i = 0;

        $("#add").click(function() {
            ++i;
            $("#dynamicTable").append('<tr><td><input type="text" name="columns[' + i +
                '][name]" placeholder="Enter column name" class="form-control" /></td><td><select name="columns[' +
                i +
                '][type]" class="form-control"><option value="string">String</option><option value="integer">Integer</option><option value="bigInteger">Big Integer</option><option value="text">Text</option><option value="date">Date</option><option value="datetime">Datetime</option><option value="time">Time</option></select></td><td><input type="text" name="columns[' +
                i +
                '][length]" placeholder="Enter length" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'
            );
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @if (Session::has('message'))
        <script>
            Swal.fire(
                'Success!',
                '{{ Session::get('message') }}',
                'success'
            )
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            Swal.fire(
                'Error!',
                '{{ Session::get('error') }}',
                'error'
            )
        </script>
    @endif
@endsection
