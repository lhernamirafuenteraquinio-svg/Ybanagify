@extends('layouts.Admin.app')

@section('content')
@can('admin-access')
<div class="head-title">
    <div class="left">
        <h1>Our Team</h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="{{ route('admin.team.index') }}">Team</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a href="{{ route('admin.gallery.index') }}">Gallery</a></li>
        </ul>
    </div>
</div>

<!-- Add New Member Button -->
<div class="mb-3">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMemberModal">
        <i class='bx bx-plus-circle me-1'></i> Add New Member
    </button>
</div>

<div class="row">
    @foreach($teamMembers as $member)
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 text-center p-4 h-100 team-card position-relative">
            <!-- Options Dropdown -->
            <div class="position-absolute top-0 end-0 m-2">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                        <i class='bx bx-dots-vertical-rounded'></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $member->id }}">
                                <i class='bx bx-edit-alt me-1'></i> Edit
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $member->id }}">
                                <i class='bx bx-trash me-1'></i> Delete
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Profile Image -->
            <div class="mb-3 d-flex justify-content-center">
                <div style="width: 130px; height: 130px; border-radius: 50%; overflow: hidden; border: 3px solid #fff; box-shadow: 0px 4px 10px rgba(0,0,0,0.1);">
                    <img src="{{ $member->image_url }}" 
                         alt="{{ $member->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>

            <!-- Name & Role -->
            <h5 class="fw-bold mb-1">{{ $member->name }}</h5>
            <p class="text-muted small mb-1">{{ $member->role }}</p>

            <!-- Contact Info -->
            @if($member->phone)
            <p class="mb-3"><i class="bx bx-phone text-success me-1"></i>{{ $member->phone }}</p>
            @endif

            <div class="d-flex justify-content-center gap-2 mb-2">
                @if($member->email)
                <a href="mailto:{{ $member->email }}" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class='bx bx-envelope'></i>
                </a>
                @endif
                @if($member->fb)
                <a href="{{ $member->fb }}" target="_blank" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class='bx bxl-facebook'></i>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal{{ $member->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $member->id }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
          <form action="{{ route('admin.team.update', $member->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-header bg-warning text-white">
              <h5 class="modal-title"><i class="bx bx-edit-alt me-1"></i> Edit {{ $member->name }}</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $member->name }}" required>
                </div>
                <div class="mb-3">
                    <label>Role</label>
                    <input type="text" name="role" class="form-control" value="{{ $member->role }}" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $member->email }}" required>
                </div>
                <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $member->phone }}" required>
                </div>
                <div class="mb-3">
                    <label>Facebook URL</label>
                    <input type="url" name="fb" class="form-control" value="{{ $member->fb }}">
                </div>
                <div class="mb-3">
                    <label>Profile Image</label>
                    <input type="file" name="img" class="form-control" onchange="previewEditImage(this, {{ $member->id }})">
                    <img id="editPreview{{ $member->id }}" src="{{ $member->image_url }}" class="img-fluid rounded shadow mt-2">
                    <small class="text-muted">Leave empty to keep current image.</small>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bx bx-x me-1"></i> Cancel</button>
              <button type="submit" class="btn btn-warning text-white"><i class="bx bx-save me-1"></i> Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal{{ $member->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $member->id }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title"><i class="bx bx-error-circle me-1"></i> Confirm Delete</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <p>Are you sure you want to remove <strong>{{ $member->name }}</strong> from the team?</p>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bx bx-x me-1"></i> Cancel</button>
            <form action="{{ route('admin.team.destroy', $member->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger"><i class="bx bx-trash me-1"></i> Yes, Delete</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title"><i class="bx bx-plus-circle me-1"></i> Add New Member</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Role</label>
                <input type="text" name="role" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Facebook URL</label>
                <input type="url" name="fb" class="form-control">
            </div>
            <div class="mb-3">
                <label>Profile Image</label>
                <input type="file" name="img" class="form-control" onchange="previewAddImage(this)">
                <img id="addPreview" class="img-fluid rounded shadow mt-2 d-none">
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success"><i class="bx bx-check me-1"></i> Add Member</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.team-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
.team-card:hover { transform: translateY(-5px); box-shadow: 0 6px 18px rgba(0,0,0,0.15); }
</style>

<script>
function previewAddImage(input) {
    const preview = document.getElementById('addPreview');
    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.classList.remove('d-none'); };
        reader.readAsDataURL(input.files[0]);
    }
}
function previewEditImage(input, id){
    const preview = document.getElementById('editPreview'+id);
    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endcan
@endsection
