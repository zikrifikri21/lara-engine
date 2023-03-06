@foreach ($menu as $mn)
    <div class="modal fade" id="edit{{ $mn->id }}" aria-labelledby="modalToggleLabel" tabindex="-1"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" action="{{ route('menumanagemen.update', $mn->id) }}" method="post"
                    style="margin-bottom: -23px;">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="nameWithTitle" class="form-label">Nama
                                    Menu</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                    value="{{ $mn->name }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="nameWithTitle" class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" placeholder="Enter Name"
                                    value="{{ $mn->slug }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="nameWithTitle" class="form-label">Link</label>
                                <input type="text" name="link" class="form-control" placeholder="Enter Name"
                                    value="{{ $mn->link }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="nameWithTitle" class="form-label">Icon</label>
                                <input type="text" name="icon" class="form-control" placeholder="Enter Name"
                                    value="{{ $mn->icon }}">
                            </div>
                            <div class="btn-group dropup">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Dropup
                                </button>
                                <ul class="dropdown-menu" style="">
                                    <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Another action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Something else
                                            here</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn rounded-pill btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn rounded-pill btn-primary">Simpan</button>
                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn rounded-pill btn-primary btn-sm" data-bs-target="#sub{{ $mn->id }}"
                        data-bs-toggle="modal" data-bs-dismiss="modal">
                        Edit Sub Menu
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal 2-->
    <div class="modal fade" id="sub{{ $mn->id }}" aria-labelledby="modalToggleLabel2" tabindex="-1"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel2">Sub Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>SubMenu</th>
                                    <th>Users</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($mn->children as $subc)
                                    <tr>
                                        <td><strong>{{ $mn->name }}</strong></td>
                                        <td>{{ $subc->name }}</td>
                                        <td>
                                            <ul
                                                class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                    title="" data-bs-original-title="Lilian Fuller">
                                                    <img src="../assets/img/avatars/5.png" alt="Avatar"
                                                        class="rounded-circle">
                                                </li>
                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                    title="" data-bs-original-title="Sophia Wilkerson">
                                                    <img src="../assets/img/avatars/6.png" alt="Avatar"
                                                        class="rounded-circle">
                                                </li>
                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                    title="" data-bs-original-title="Christina Parker">
                                                    <img src="../assets/img/avatars/7.png" alt="Avatar"
                                                        class="rounded-circle">
                                                </li>
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button type="button"
                                                    class="btn rounded-pill btn-icon btn-primary btn-sm"
                                                    data-bs-target="#editsub{{ $subc->id }}"
                                                    data-bs-toggle="modal" data-bs-dismiss="modal">
                                                    <span class="tf-icons bx bx-pencil"></span>
                                                </button>
                                                <form action="{{ route('menumanagemen.destroy', $subc->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn rounded-pill btn-icon btn-danger btn-sm">
                                                        <span class="tf-icons bx bx-trash"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button class="btn rounded-pill btn-primary" data-bs-target="#edit{{ $mn->id }}"
                        data-bs-toggle="modal" data-bs-dismiss="modal">Kembali
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
    @foreach ($mn->children as $subc)
        <div class="modal fade" id="editsub{{ $subc->id }}" aria-labelledby="modalToggleLabel5" tabindex="-1"
            aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel2">Sub Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form id="editForm" action="{{ route('menumanagemen.update', $subc->id) }}" method="post"
                        style="margin-bottom: -23px;">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="nameWithTitle" class="form-label">Nama
                                        Menu</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter Name" value="{{ $subc->name }}">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="nameWithTitle" class="form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control"
                                        placeholder="Enter Name" value="{{ $subc->slug }}">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="nameWithTitle" class="form-label">Link</label>
                                    <input type="text" name="link" class="form-control"
                                        placeholder="Enter Name" value="{{ $subc->link }}">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="nameWithTitle" class="form-label">Icon</label>
                                    <input type="text" name="icon" class="form-control"
                                        placeholder="Enter Name" value="{{ $subc->icon }}">
                                </div>
                                <div class="form-group">
                                    @if ($subc->parent_id == null)
                                        <input type="hidden" name="parent_id" value="">
                                    @else
                                        <label for="exampleInputPassword1">Menu</label>
                                        @foreach ($menu as $mn)
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" name="parent_id"
                                                    value="{{ $mn->id }}" type="checkbox"
                                                    id="flexSwitchCheckDefault"
                                                    @if ($mn->id == $subc->parent_id) checked @endif>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckDefault">{{ $mn->name }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mb-3">
                            <button type="submit" class="btn rounded-pill btn-primary">Simpan</button>
                        </div>
                    </form>
                    {{-- <div class="modal-footer">
                        <button class="btn rounded-pill btn-primary" data-bs-target="#sub{{ $subc->id }}"
                            data-bs-toggle="modal" data-bs-dismiss="modal">Kembali
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
    @endforeach
@endforeach
