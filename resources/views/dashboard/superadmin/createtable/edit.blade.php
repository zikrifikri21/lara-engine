@extends('dashboard.layout.template')
@section('content')
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tambah Database</h5>
                <small class="text-muted float-end">ini adalah form untuk menambah database</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('createTable.update', $table->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="table_name">Table Name:</label>
                        <input type="text" class="form-control" id="table_name" name="table_name"
                            value="{{ $table->table_name }}">
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
                            @foreach ($table->columns as $column)
                                <tr>
                                    <td><input type="text" name="columns[{{ $column->id }}][name]"
                                            placeholder="Enter column name" class="form-control"
                                            value="{{ $column->name }}" /></td>
                                    <td>
                                        <select name="columns[{{ $column->id }}][type]" class="form-control">
                                            <option value="string" @if ($column->type == 'string') selected @endif>String
                                            </option>
                                            <option value="integer" @if ($column->type == 'integer') selected @endif>
                                                Integer</option>
                                            <option value="bigInteger" @if ($column->type == 'bigInteger') selected @endif>Big
                                                Integer
                                            </option>
                                            <option value="text" @if ($column->type == 'text') selected @endif>Text
                                            </option>
                                            <option value="date" @if ($column->type == 'date') selected @endif>Date
                                            </option>
                                            <option value="datetime" @if ($column->type == 'datetime') selected @endif>
                                                Datetime</option>
                                            <option value="time" @if ($column->type == 'time') selected @endif>Time
                                            </option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="columns[{{ $column->id }}][length]"
                                            placeholder="Enter length" class="form-control" value="{{ $column->length }}" />
                                    </td>
                                    <td>
                                        <button type="button" name="add" id="add" class="btn btn-success">Add
                                            More</button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="form-group mt-3">
                        <label for="related_table">Related Table:</label>
                        <input type="text" class="form-control" id="related_table" name="related_table"
                            value="{{ $table->related_table }}">
                    </div>
                    <div class="form-group mt-3">
                        <label for="foreign_key">Foreign Key Column Name:</label>
                        <input type="text" class="form-control" id="foreign_key" name="foreign_key"
                            value="{{ $table->foreign_key }}">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
