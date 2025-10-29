<nav class="navbar navbar-expand-sm navbar-dark shadow-sm">
    <div class="container-fluid">
        <!-- Logo & Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="YBANAGIFY Logo" height="40">
            <span class="fw-bold text-light">YBANAGIFY</span>
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse mobile-menu" id="navbarNav">
            <!-- Center links -->
            <ul class="navbar-nav mx-auto mb-2 mb-sm-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active fw-semibold text-light' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active fw-semibold text-light' : '' }}" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dictionary') ? 'active fw-semibold text-light' : '' }}" href="{{ route('dictionary.index') }}">Ybanag Words</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('translate') ? 'active fw-semibold text-light' : '' }}" href="{{ route('translate') }}">Translate</a>
                </li>
            </ul>

            <!-- Right-aligned auth links -->
            <!-- <ul class="navbar-nav">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="nav-link text-light">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link text-light">Admin Login</a>
                        </li>
                    @endauth
                @endif
            </ul> -->
        </div>
    </div>
</nav>

<!-- Styles for Navbar -->
<style>
    :root {
        --brown: #8B4513;
        --beige: #F5DEB3;
        --light-brown: #D2B48C;
        --green: #556B2F;
        --terracotta: #E2725B;
    }

    .navbar {
        background-color: var(--brown);
    }

    .navbar-nav .nav-link {
        color: var(--beige);
        transition: all 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
        color: var(--light-brown);
        opacity: 0.8;
    }

    .navbar .nav-link.active {
        font-weight: 600;
        border-bottom: 2px solid var(--light-brown);
    }

    .navbar-toggler-icon {
        background-color: var(--beige);
    }

    /* Custom style to prevent full width collapse */
    @media (max-width: 576px) {
        .mobile-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 220px;
            background-color: var(--brown);
            border-radius: 0 0 10px 10px;
            padding: 15px;
            z-index: 999;
        }

        .mobile-menu ul {
            flex-direction: column !important;
            align-items: flex-start;
        }

        .navbar-nav .nav-item {
            width: 100%;
        }

        .navbar-nav .nav-link {
            width: 100%;
            padding: 8px 0;
        }
    }
</style>
