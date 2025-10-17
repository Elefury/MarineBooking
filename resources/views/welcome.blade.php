<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marine Booking - Luxury Water Transport</title>
    <link rel="icon" href="images/apple-touch-icon.ico">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, rgba(0, 40, 80, 0.9) 0%, rgba(0, 20, 40, 0.95) 100%);
        }
        .btn-hover-effect {
            transition: all 0.3s ease;
            transform: translateY(0);
        }
        .btn-hover-effect:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .logo-container {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            padding: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Hero Section -->
    <div class="min-h-screen bg-cover bg-center bg-no-repeat bg-fixed flex items-center justify-center" 
         style="background-image: url('{{ asset('images/welcome-bg.jpg') }}')">
         
        <div class="min-h-screen w-full hero-gradient flex items-center justify-center px-4">
            <div class="max-w-4xl mx-auto text-center p-8 rounded-xl backdrop-blur-sm bg-white/5">
                @if (Route::has('login'))
                    <div class="space-y-10">
                        <!-- Logo & Title -->
                        <div class="space-y-6">
                            <div class="logo-container">
                                <img src="{{ asset('images/logo.jpg') }}" alt="Marine Booking Logo" class="w-full h-auto rounded-full">
                            </div>
                            <h1 class="text-5xl font-bold text-white">
                                Marine<span class="text-blue-300"> Booking</span>
                            </h1>
                            <p class="text-xl text-blue-500 py-4 max-w-2.5xl mx-auto">
                                Премиальные услуги водного транспорта для незабываемых путешествий
                            </p>
                        </div>

                        @auth
                            <div class="space-y-6">
                                <a href="{{ route('dashboard') }}" 
                                   class="btn-hover-effect flex-1 bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-full text-lg font-semibold shadow-lg text-center">
                                    На главную
                                </a>
                            </div>
                        @else
                            <div class="flex flex-col sm:flex-row justify-center gap-4 px-8 py-2 mx-auto">
                                <a href="{{ route('login') }}" 
                                   class="btn-hover-effect flex-1 bg-white hover:bg-gray-100 text-blue-800 px-8 py-4 rounded-full text-lg font-semibold shadow-lg text-center">
                                    Авторизация
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="btn-hover-effect flex-1 bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-full text-lg font-semibold shadow-lg text-center">
                                        Регистрация
                                    </a>
                                @endif
                            </div>
                        @endauth

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-12 text-white">
                            <div class="bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                                <svg class="w-8 h-8 mx-auto mb-2 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <p class="text-sm">Безопасные платежи</p>
                            </div>
                            <div class="bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                                <svg class="w-8 h-8 mx-auto mb-2 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm">Поддержка 24/7</p>
                            </div>
                            <div class="bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                                <svg class="w-8 h-8 mx-auto mb-2 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <p class="text-sm">Проверенные партнеры</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>