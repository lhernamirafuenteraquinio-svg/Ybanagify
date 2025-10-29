<x-guest-layout>
    <div class="text-center mb-4">
        <h5 class="fw-bold text-dark">Forgot Your Password?</h5>
        <p class="text-muted" style="font-size: 14px;">
            Enter your email address below and we’ll send you a password reset link.
        </p>
    </div>

    <!-- Success Message -->
    @if (session('status'))
        <div class="alert alert-success text-center">
            {{ session('status') }}
        </div>
    @endif

    <!-- Forgot Password Form -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input 
                id="email" 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus
                placeholder="Enter your email">
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn w-100 text-white" 
            style="background-color: #004aad; font-weight: 600;">
            <i class="bi bi-envelope-fill me-1"></i> Send Reset Link
        </button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #004aad;">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>
