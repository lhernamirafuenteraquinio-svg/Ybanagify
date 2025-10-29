@extends('layouts.Admin.app')

@section('content')
@can('admin-access')
<div class="head-title">
    <div class="left">
        <h1>Profile Settings</h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="{{ route('profile.edit') }}">Profile</a></li>
        </ul>
    </div>
</div>

<div class="profile-wrapper">

    {{-- SUCCESS MESSAGE --}}
    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
        </div>
    @endif

    <div class="profile-grid">
        {{-- PROFILE UPDATE FORM --}}
        <div class="profile-box">
            <h3 class="section-title"><i class="bi bi-person-circle me-2"></i>Admin Information</h3>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-form">
                @csrf
                @method('PATCH')

                <div class="profile-pic-section">
                    <img 
                        id="profilePreview" 
                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default.png') }}" 
                        alt="Profile Picture"
                        class="profile-img"
                    >
                    <label for="profile_picture" class="upload-btn">
                        <i class="bi bi-upload me-1"></i> Change Photo
                    </label>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*" hidden>
                </div>

                <div class="form-group">
                    <label for="name"><i class="bi bi-person-fill me-2"></i>Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email"><i class="bi bi-envelope-fill me-2"></i>Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                </div>

                <button type="submit" class="btn-save">
                    <i class="bi bi-save2 me-2"></i> Save Changes
                </button>
            </form>
        </div>

        {{-- PASSWORD UPDATE SECTION --}}
        <div class="password-box">
            <h3 class="section-title"><i class="bi bi-shield-lock-fill me-2"></i>Change Password</h3>

            <form method="POST" action="{{ route('password.update') }}" class="password-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password"><i class="bi bi-key-fill me-2"></i>Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label for="password"><i class="bi bi-lock-fill me-2"></i>New Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation"><i class="bi bi-lock me-2"></i>Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn-update">
                    <i class="bi bi-arrow-repeat me-2"></i> Update Password
                </button>
            </form>
        </div>
    </div>
</div>

{{-- STYLES --}}
<style>
/* Container */
.profile-wrapper {
    max-width: 1000px;
    margin: 40px auto;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    padding: 40px 50px;
}

/* Grid Layout */
.profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

/* Section Boxes */
.profile-box, .password-box {
    background: #f9fafc;
    border-radius: 12px;
    padding: 25px;
    border: 1px solid #e0e0e0;
}

.section-title {
    font-weight: 700;
    font-size: 1.25rem;
    margin-bottom: 20px;
    color: #2c3e50;
    border-left: 4px solid #007bff;
    padding-left: 10px;
}

/* Profile Image */
.profile-pic-section {
    text-align: center;
    margin-bottom: 20px;
}
.profile-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #007bff;
    margin-bottom: 10px;
}
.upload-btn {
    display: inline-block;
    background: #007bff;
    color: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
}
.upload-btn:hover {
    background: #0056b3;
}

/* Form Groups */
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    font-weight: 600;
    color: #333;
    display: block;
    margin-bottom: 6px;
}
.form-group input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    transition: all 0.3s ease;
}
.form-group input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0,123,255,0.2);
}

/* Buttons */
.btn-save, .btn-update {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    transition: 0.3s;
}
.btn-save {
    background: #007bff;
}
.btn-save:hover {
    background: #0056b3;
}
.btn-update {
    background: #6c757d;
}
.btn-update:hover {
    background: #565e64;
}

/* Alert */
.alert {
    background: #d4edda;
    color: #155724;
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 25px;
}

/* Responsive */
@media (max-width: 900px) {
    .profile-grid {
        grid-template-columns: 1fr;
    }
}
</style>

{{-- SCRIPT --}}
<script>
document.getElementById('profile_picture').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('profilePreview').src = URL.createObjectURL(file);
    }
});
</script>

{{-- BOOTSTRAP ICONS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endcan
@endsection
