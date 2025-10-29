<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                    name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
            </div>
            <!-- Error message for email -->
            @error('email')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                <input id="password" type="password" class="form-control" name="password" placeholder="Enter your password" required>
            </div>
        </div>

        <!-- Remember & Forgot -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember_me">
                <label class="form-check-label" for="remember_me">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot password?</a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
        </div>
    </form>
</x-guest-layout>
