<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Marine Booking') }}</title>
    <link rel="icon" href="images/apple-touch-icon.ico">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .auth-bg {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('/images/login-bg.jpg');
            background-size: cover;
            background-position: center;
            z-index: -1;
            opacity: 0.7;
        }
        
        .auth-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 27, 71, 0.8);
        }
        
        .auth-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 28rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 59, 149, 0.2);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        

        .login-bg {
            background-image: url('/images/login-bgggg.jpg');
        }
        .register-bg {
            background-image: url('/images/login-bggg.jpg');
        }
    </style>
</head>
<body class="font-sans antialiased">

    <div class="auth-bg @if(request()->is('login')) login-bg @else register-bg @endif"></div>
    
    <div class="min-h-screen flex flex-col sm:justify-center items-center p-4">


        
        <div class="mb-8 text-center">
    <a href="/" wire:navigate class="inline-block">
        @if(file_exists(public_path('images/logo.jpg')))
            <img src="{{ asset('images/logo.jpg') }}" 
                 alt="Marine Booking" 
                 class="h-20 w-auto mx-auto transform hover:scale-105 transition-transform">
        @else
            <div class="text-3xl font-bold text-blue-600">Marine Booking</div>
        @endif
    </a>
</div>

        <div class="auth-container">
            <div class="px-8 py-10">
                {{ $slot }}
            </div>

        <div class="wave-divider mt-6">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#1e88e5"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#1e88e5"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#1e88e5"></path>
            </svg>
        </div>
        </div>
    </div>
</body>
</html>