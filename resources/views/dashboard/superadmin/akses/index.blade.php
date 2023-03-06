@extends('dashboard.layout.template')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Hak Akses Menu</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('akses.store') }}" method="post">
                @csrf
                <div class="mt-3">
                    @foreach ($lvl as $level_user)
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox"name="level_user_id"
                                id="menu_{{ $level_user->id }}" value="{{ $level_user->id }}" data-bs-toggle="modal"
                                data-bs-target="#modal{{ $level_user->id }}">
                            <label class="form-check-label" for="menu_{{ $level_user->id }}">{{ $level_user->nama }}</label>
                        </div>
                    @endforeach

                    <!-- Modal -->
                    @foreach ($lvl as $level_user)
                        <div class="modal fade" id="modal{{ $level_user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Modal title</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="menu_id">Menu</label>
                                            @foreach ($menu as $mn)
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input" type="checkbox" name="menu_id[]"
                                                        id="menu_{{ $mn->id }}" value="{{ $mn->id }}">
                                                    <label class="form-check-label"
                                                        for="menu_{{ $mn->id }}"">{{ $mn->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class=" modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </form>
        </div>
    </div>
@endsection
