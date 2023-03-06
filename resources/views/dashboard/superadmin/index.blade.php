@extends('dashboard.layout.template')
@section('content')
    <form action="{{ route('menumanagemen.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home"
                                aria-selected="true">
                                Home
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
                                aria-selected="false">
                                Profile
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="navs-pills-top-home" role="tabpanel">
                            <div class="card-header p-0 pb-4">
                                <h5 class="mb-0 mt-0">Pilih Menu</h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-fullname">Nama Menu</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class='bx bx-menu'></i></span>
                                    <input type="text" class="form-control" id="basic-icon-default-fullname"
                                        placeholder="Nama Menu" name="name" aria-label="John Doe"
                                        aria-describedby="basic-icon-default-fullname2">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">Link</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i
                                            class='bx bx-link'></i></span>
                                    <input type="text" id="basic-icon-default-company" class="form-control"
                                        placeholder="Link" name="link" aria-label="ACME Inc."
                                        aria-describedby="basic-icon-default-company2">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-email">Slug</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="menu-icon tf-icons bx bx-box"></i></span>
                                    <input type="text" name="slug" id="basic-icon-default-email" class="form-control"
                                        placeholder="Slug" aria-label="john.doe"
                                        aria-describedby="basic-icon-default-email2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Icon</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-phone2" class="input-group-text"><i
                                                    class="menu-icon tf-icons bx bx-crown"></i></span>
                                            <input type="text" name="icon" id="basic-icon-default-phone"
                                                class="form-control phone-mask" placeholder="Icon" aria-label="Icon"
                                                aria-describedby="basic-icon-default-phone2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-white" for="basic-icon-default-phone">pilih</label>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#iconku">
                                        Icon
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                        <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                            <div class="card-header p-0 pb-4">
                                <h5 class="mb-0 mt-0">List Menu</h5>
                            </div>
                            <table class="table">
                                <caption class="ms-4">
                                    List of Projects
                                </caption>
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>SubMenu</th>
                                        <th>Users</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menu as $mn)
                                        <tr>
                                            <td><strong>{{ $mn->name }}</strong></td>
                                            <td>
                                                <select id="smallSelect" class="form-select form-select-sm">
                                                    <option>Sub Menu</option>
                                                    @foreach ($mn->children as $mnc)
                                                        <option>{{ $mnc->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
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
                                            <td><span class="badge bg-label-primary me-1">Active</span></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="bx bx-trash me-1"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-5">
                <h4 class="fw-bold py-3 mb-0 text-end"><span class="text-muted fw-light">UI elements /</span> Carousel
                </h4>
                <div class="card mb-4 ">
                    <div class="card-header">
                        <h5 class="mb-0">Pilih Menu</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($menu as $mn)
                                <div class="col-6 col-md-4">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" name="parent_id" value="{{ $mn->id }}"
                                            type="checkbox">
                                        <label class="form-check-label">{{ $mn->name }}</label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <select id="smallSelect" class="form-select form-select-sm">
                                        <option>Sub Menu</option>
                                        @foreach ($mn->children as $mnc)
                                            <option>{{ $mnc->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-3">
                                        <div class="col-6 col-md-4">
                                            <button type="button" class="btn rounded-pill btn-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#edit{{ $mn->id }}">Edit
                                            </button>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <button type="button" class="btn rounded-pill btn-danger btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#hapus{{ $mn->id }}">Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('dashboard.superadmin.layout.hapus')
    @include('dashboard.superadmin.layout.editmodal')
    @include('dashboard.superadmin.layout.iconmodal')
@endsection
