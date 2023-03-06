@foreach ($menu as $mn)
<div class="modal fade" id="hapus{{ $mn->id }}" aria-labelledby="modalToggleLabel" tabindex="-1"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalToggleLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('menumanagemen.destroy', $mn->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn rounded-pill btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
