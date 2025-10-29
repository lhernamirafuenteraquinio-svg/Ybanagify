<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>YBANAGIFY - Admin Login</title>

    <!-- Icons -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            height: 100vh;
            overflow: hidden;
            overflow-x: hidden;   
            overflow-y: auto;    
        }

        .login-container {
            display: flex;
            min-height: 100vh;
            flex-wrap: wrap;
        }

        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #002855, #004aad);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 80px;
            min-width: 300px;
        }

        .left-panel img {
            width: 260px;
            margin-bottom: 25px;
        }

        .left-panel h2 {
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .left-panel p {
            opacity: 0.9;
            margin-bottom: 20px;
            max-width: 480px;
            font-size: 15px;
            line-height: 1.6;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            margin-bottom: 10px;
            font-size: 15px;
        }

        .feature-list li i {
            color: #00d9ff;
            margin-right: 8px;
        }

        .right-panel {
            flex: 1;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            min-width: 300px;
            position: relative;
        }

        .login-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            position: relative;
            height: 100%;
        }

        .login-box {
            width: 380px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
            background-color: #fff;
        }

        .login-header {
            background-color: #004aad;
            color: white;
            text-align: center;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .login-body {
            padding: 25px;
        }

        footer {
            position: relative;
            margin-top: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 13px;
            color: gray;
            text-align: center;
            width: 100%;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
                height: auto;
                overflow-y: auto;
            }

            .left-panel {
                align-items: center;
                text-align: center;
                padding: 40px 20px;
            }

            .left-panel img {
                width: 200px;
            }

            .right-panel {
                padding: 30px 15px;
            }

            footer {
                position: relative;
                margin-top: 20px;
            }
        }
    </style>
</head> 
<body>
    <div class="login-container">
        <!-- LEFT SIDE -->
        <div class="left-panel">
            <img src="{{ asset('images/logo.png') }}" alt="YBANAGIFY Logo">
            <h2>Welcome to YBANAGIFY</h2>
            <p>Preserving Aparri’s Native Language through Innovation</p>
            <ul class="feature-list">
                <li><i class="bi bi-check-circle-fill"></i> Fast and reliable word translation</li>
                <li><i class="bi bi-check-circle-fill"></i> Easy-to-use admin management</li>
                <li><i class="bi bi-check-circle-fill"></i> Secure and modern web interface</li>
            </ul>
        </div>

        <!-- RIGHT SIDE -->
        <div class="right-panel">
            <div class="login-content">
                <div class="login-box">
                    <div class="login-header">
                        <i class="bi bi-lock-fill"></i> {{ $title ?? 'ADMIN LOGIN' }}
                    </div>
                    <div class="login-body">
                        {{ $slot }}
                    </div>
                </div>

                <footer>© 2025 YBANAGIFY. All rights reserved.</footer>
            </div>
        </div>
    </div>
</body>
</html>
