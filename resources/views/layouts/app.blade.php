<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>YBANAGIFY</title>

    <!-- Icons -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --brown: #8B4513;
            --beige: #F5DEB3;
            --light-brown: #D2B48C;
            --green: #556B2F;
            --terracotta: #E2725B;
        }

        body {
            background-color: #fffaf2;
            font-family: 'Figtree', sans-serif;
            color: #3b2f2f;
        }

        footer {
            background-color: var(--brown);
            color: white;
        }

        footer a {
            color: #D7CCC8;
        }

        footer a:hover {
            color: var(--beige);
        }
    </style>

    @stack('styles')
</head>
<body class="antialiased">
<div class="container-fluid p-0">
    @include('layouts.navigation')

    <div>
        @yield('content')
    </div>
</div>

<footer class="py-4 mt-5">
    <div class="container text-center">
        <h5 class="fw-bold" style="color: #A1887F;">YBANAGIFY</h5>
        <p class="small mb-2" style="color: #D7CCC8;">
            A digital platform dedicated to preserving the Ybanag language and culture.
            Learn, translate, and connect with Aparri's heritage.
        </p>
        <div class="mb-2">
            <a href="/" class="text-decoration-none me-3">Home</a>
            <a href="/dictionary" class="text-decoration-none me-3">Dictionary</a>
            <a href="/translate" class="text-decoration-none me-3">Translate</a>
            <a href="/about" class="text-decoration-none">About</a>
        </div>
        <!-- <div class="mt-3">
            <a href="#" class="me-2"><i class="bi bi-facebook"></i></a>
            <a href="#" class="me-2"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-github"></i></a>
        </div> -->
        <hr class="my-3" style="border-color: #A1887F;">
        <p class="small mb-0" style="color: #D7CCC8;">&copy; {{ date('Y') }} YBANAGIFY. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
