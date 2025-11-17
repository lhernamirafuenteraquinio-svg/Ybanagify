@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-dark">About YBANAGIFY</h1>
            <p class="lead text-muted" style="font-size: 1.1rem;">A digital translator preserving the Ybanag language of Aparri, Cagayan.</p>
        </div>
    </div>

    <!-- Purpose & Cultural Impact Two-Column -->
    <div class="row g-4">
        <!-- Purpose & Objectives Card -->
        <div class="col-md-6 d-flex">
            <div class="card w-100 h-100 shadow-lg" style="background-color: #FFF8E1;">
                <div class="card-header text-white" style="background-color: #6D4C41; font-size: 1.2rem;">
                    <i class="bi bi-lightbulb" style="font-size: 1.5rem;"></i> <strong>Purpose & Objectives</strong>
                </div>
                <div class="card-body text-dark" style="font-size: 1rem;">
                    <ul class="list-unstyled mb-0">
                        <li><i class="bi bi-check-circle" style="color: #6D4C41;"></i> Provide a digital translation tool for the Ybanag language.</li>
                        <li><i class="bi bi-check-circle" style="color: #6D4C41;"></i> Preserve and promote Ybanag through technology.</li>
                        <li><i class="bi bi-check-circle" style="color: #6D4C41;"></i> Facilitate language learning for students and enthusiasts.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Cultural Impact Card -->
        <div class="col-md-6 d-flex">
            <div class="card w-100 h-100 shadow-lg" style="background-color: #FFF8E1;">
                <div class="card-header text-white" style="background-color: #6D4C41; font-size: 1.2rem;">
                    <i class="bi bi-globe" style="font-size: 1.5rem;"></i> <strong>Cultural Impact</strong>
                </div>
                <div class="card-body text-dark" style="font-size: 1rem;">
                    <p class="mb-0"><i class="bi bi-arrow-right-circle" style="color: #6D4C41;"></i> YBANAGIFY plays a vital role in preserving Ybanag and raising awareness of its cultural significance. This platform ensures that the Ybanag language remains part of the community's heritage and continues to be used by future generations.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Team Section -->
    <div class="card my-4 shadow-lg" style="background-color: #FFF8E1;">
        <div class="card-header text-white" style="background-color: #6D4C41; font-size: 1.2rem;">
            <i class="bi bi-people-fill" style="font-size: 1.5rem;"></i> <strong>Our Team</strong>
        </div>
        <div class="card-body text-dark" style="font-size: 1rem;">
            <div class="row">
                @php
                    use Illuminate\Support\Str;
                @endphp

                @foreach ($team as $member)
                    @php
                        // Determine the correct image path
                        $imagePath = Str::startsWith($member->img, 'team/')
                            ? asset('storage/' . $member->img)      // uploaded by admin
                            : asset($member->img ?: 'images/prof.jpg'); // default image
                    @endphp

                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="card h-100 text-center border-0 p-3 about-section-card">

                            <!-- Profile Image -->
                            <div class="mb-3">
                                <img src="{{ $imagePath }}" 
                                    class="rounded-circle border border-3 border-light mx-auto" 
                                    alt="{{ $member->name }}" 
                                    width="130" height="130" 
                                    style="object-fit: cover; box-shadow: 0px 4px 10px rgba(0,0,0,0.1);">
                            </div>

                            <div class="card-body p-2">
                                <h5 class="card-title mb-1">{{ $member->name }}</h5>
                                <p class="text-muted mb-2">{{ $member->role }}</p>
                                <p class="small mb-1">
                                    <a href="mailto:{{ $member->email }}" class="icon-link email">
                                        <i class="bi bi-envelope-fill"></i> {{ $member->email }}
                                    </a>
                                </p>
                                <p class="small mb-1">
                                    <a href="tel:{{ $member->phone }}" class="icon-link phone">
                                        <i class="bi bi-telephone-fill"></i> {{ $member->phone }}
                                    </a>
                                </p>
                                <p class="small mb-0">
                                    <a href="{{ $member->fb }}" target="_blank" class="icon-link fb">
                                        <i class="bi bi-facebook"></i> Facebook
                                    </a>
                                </p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Multimedia Gallery Section -->
    <div class="card my-4 shadow-lg" style="background-color: #FFF8E1;">
        <div class="card-header text-white" style="background-color: #6D4C41; font-size: 1.2rem;">
            <i class="bi bi-image" style="font-size: 1.5rem;"></i> <strong>Multimedia Gallery</strong>
        </div>
        <div class="card-body text-dark" style="font-size: 1rem;">
            <div class="row">
                @forelse ($images as $image)
                    <div class="col-md-4 mb-3">
                        <img src="{{ asset('storage/' . $image->image) }}" 
                            alt="Gallery Image" 
                            class="img-fluid rounded shadow-lg">
                    </div>
                @empty
                    <p class="text-center text-muted">No images available in the gallery.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Feedback Section --> 
    <div class="card my-4 shadow-lg" style="background-color: #FFF8E1;">
        <div class="card-header text-white" style="background-color: #6D4C41; font-size: 1.2rem;">
            <i class="bi bi-chat-left-text-fill" style="font-size: 1.5rem;"></i> <strong>Send Us Your Feedback</strong>
        </div>
        <div class="card-body text-dark" style="font-size: 1rem;">
            <p><i class="bi bi-envelope-fill me-2" style="color: #6D4C41;"></i>We’d love to hear your thoughts! Please fill out the form below to send us your feedback about <strong>YBANAGIFY</strong>.</p>

            <!-- Flash Success Message -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Feedback Response Message -->
            <div id="feedbackResponse"></div>

            <!-- Feedback Form -->
            <form id="feedbackForm" action="{{ route('feedback.store') }}" method="POST" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="General" {{ old('category') == 'General' ? 'selected' : '' }}>General</option>
                        <option value="Bug Report" {{ old('category') == 'Bug Report' ? 'selected' : '' }}>Bug Report</option>
                        <option value="Suggestion" {{ old('category') == 'Suggestion' ? 'selected' : '' }}>Suggestion</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn text-white" style="background-color: #6D4C41; border-color: #6D4C41;">
                    <i class="bi bi-send-fill me-1"></i> Send Feedback
                </button>
            </form>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        $('#feedbackForm').submit(function(e) {
            e.preventDefault(); // prevent form from submitting normally
            const form = $(this);
            const url = form.attr('action');
            const data = form.serialize();

            // Clear old responses and errors
            $('#feedbackResponse').html('');
            form.find('.is-invalid').removeClass('is-invalid');

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    form[0].reset();
                    $('#feedbackResponse').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);

                    // Auto close success alert after 5 seconds
                    setTimeout(() => {
                        $('.alert-success').alert('close');
                    }, 5000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // validation error
                        const errors = xhr.responseJSON.errors;
                        let errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                        $.each(errors, function(key, messages) {
                            errorHtml += `<li>${messages[0]}</li>`;
                            // Mark the invalid fields
                            $(`#${key}`).addClass('is-invalid');
                        });
                        errorHtml += '</ul></div>';
                        $('#feedbackResponse').html(errorHtml);

                        // Auto close error alert after 5 seconds
                        setTimeout(() => {
                            $('.alert-danger').alert('close');
                        }, 5000);
                    } else {
                        $('#feedbackResponse').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Something went wrong. Please try again later.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                }
            });
        });
    });
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
    /* Icon hover colors */
    .icon-link {
        text-decoration: none;
        color: inherit;
        transition: color 0.3s ease;
    }
    .icon-link.email:hover { color: #d9534f; }
    .icon-link.phone:hover { color: #28a745; }
    .icon-link.fb:hover { color: #1877f2; }

    .about-section-card {
        transition: 0.3s ease;
    }

    /* Card hover effect */
    .about-section-card:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .email {
        word-break: break-all;
        display: inline-block;
        max-width: 100%;
    }
</style>
@endpush