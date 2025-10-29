@extends('layouts.Admin.app')

@section('content')
@can('admin-access')
<div class="head-title">
    <div class="left">
        <h1>Gallery</h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="{{ route('admin.gallery.index') }}">Gallery</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a href="{{ route('admin.team.index') }}">Team</a></li>
        </ul>
    </div>
</div>

<!-- Add Image Button -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addImageModal">
    <i class='bx bx-plus-circle me-1'></i> Add Image
</button>

<div class="row">
    @foreach ($images as $image)
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm position-relative">
            <!-- Image -->
            <img src="{{ asset('storage/' . $image->image) }}" class="card-img-top rounded">

            <!-- Options Dropdown -->
            <div class="dropdown position-absolute top-0 end-0 m-2">
                <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                    <i class='bx bx-dots-vertical-rounded'></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $image->id }}">
                            <i class='bx bx-edit-alt me-1'></i> Edit
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $image->id }}">
                            <i class='bx bx-trash me-1'></i> Delete
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal{{ $image->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $image->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form action="{{ route('admin.gallery.update', $image->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">
                            <i class="bx bx-edit-alt me-2"></i> Edit Image
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="editImagePreview{{ $image->id }}" src="{{ asset('storage/' . $image->image) }}" class="img-fluid rounded shadow mb-2">
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">
                                <i class="bx bx-upload me-1"></i> Replace Image
                            </label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewEditImage(this, {{ $image->id }})">
                            <small class="text-muted">Leave blank to keep current image.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning text-white"><i class="bx bx-save me-1"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal{{ $image->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $image->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger fw-bold">
                        <i class="bx bx-trash me-2"></i> Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Are you sure you want to delete this image?</p>
                    <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid rounded shadow">
                </div>
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.gallery.destroy', $image->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bx bx-trash me-1"></i> Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Add Image Modal -->
<div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bx bx-image me-2"></i> Add Image
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="addImagePreview" src="#" class="img-fluid rounded shadow d-none mb-2" alt="Preview">
                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewAddImage(this)" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="bx bx-plus me-1"></i> Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS for tooltips & image preview -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Add Image Preview
function previewAddImage(input) {
    const preview = document.getElementById('addImagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Edit Image Preview
function previewEditImage(input, id) {
    const preview = document.getElementById('editImagePreview' + id);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => preview.src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
@endcan