<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PEKA APBD</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/notif/dist/css/iziToast.min.css">
    <script src="/notif/dist/js/iziToast.min.js" type="text/javascript"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 1s ease-out',
                        'slide-in-left': 'slideInLeft 1s ease-out',
                        'slide-in-right': 'slideInRight 1s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'gradient': 'gradient 3s ease infinite',
                        'wave': 'wave 4s ease-in-out infinite',
                        'tilt': 'tilt 4s ease-in-out infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes wave {

            0%,
            100% {
                transform: translateX(0px);
            }

            50% {
                transform: translateX(-50px);
            }
        }

        @keyframes tilt {

            0%,
            100% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(2deg);
            }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-wave {
            animation: wave 4s ease-in-out infinite;
        }

        .animate-tilt {
            animation: tilt 4s ease-in-out infinite;
        }

        .animation-delay-1000 {
            animation-delay: 1s;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .bg-300 {
            background-size: 300% 300%;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
        }

        .btn-glow {
            transition: all 0.3s ease;
        }

        .btn-glow:hover {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }
    </style>
</head>

<body class="font-poppins bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">

    <!--====== NAVBAR PART START ======-->
    <nav
        class="bg-gradient-to-r from-blue-600/90 via-indigo-600/90 to-purple-600/90 backdrop-blur-lg shadow-lg sticky top-0 z-50 border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div
                                class="absolute inset-0 bg-white/20 backdrop-blur-sm rounded-lg blur-lg opacity-75 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <img src="/logo/peka.png" alt="PEKA APBD" class="relative h-12 w-auto rounded-lg" />
                        </div>
                        <div>
                            <span class="font-bold text-xl text-white">PEKA APBD</span>
                            <p class="text-xs text-blue-100">Sistem Evaluasi Kinerja</p>
                        </div>
                    </a>
                </div>

                <!-- Back to Home -->
                <div class="hidden md:block">
                    <a href="/"
                        class="relative text-white bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full font-medium text-sm hover:bg-white/30 transform hover:scale-105 transition-all duration-300 border border-white/30">
                        <i class="fas fa-home mr-2"></i>
                        Beranda
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <a href="/"
                        class="bg-white/20 backdrop-blur-sm p-2 rounded-lg text-white hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-all duration-300 border border-white/30">
                        <i class="fas fa-home h-6 w-6"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!--====== LOGIN SECTION START ======-->
    <section class="relative overflow-hidden min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div
                class="absolute top-20 left-10 w-72 h-72 bg-gradient-to-r from-blue-300 to-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse">
            </div>
            <div
                class="absolute top-40 right-10 w-72 h-72 bg-gradient-to-r from-purple-300 to-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse animation-delay-2000">
            </div>
            <div
                class="absolute bottom-20 left-1/2 w-72 h-72 bg-gradient-to-r from-yellow-300 to-orange-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse animation-delay-4000">
            </div>
        </div>

        <!-- Animated Wave Background -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden z-0">
            <svg class="relative block w-full h-32 animate-wave" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1200 120" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="wave-gradient-bg" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:0.1" />
                        <stop offset="33%" style="stop-color:#8B5CF6;stop-opacity:0.15" />
                        <stop offset="66%" style="stop-color:#EC4899;stop-opacity:0.1" />
                        <stop offset="100%" style="stop-color:#F59E0B;stop-opacity:0.05" />
                    </linearGradient>
                    <linearGradient id="wave-gradient-bg2" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#8B5CF6;stop-opacity:0.08" />
                        <stop offset="50%" style="stop-color:#EC4899;stop-opacity:0.12" />
                        <stop offset="100%" style="stop-color:#3B82F6;stop-opacity:0.08" />
                    </linearGradient>
                </defs>

                <!-- Back wave layer -->
                <path d="M0,60 C150,90 350,30 600,60 C850,90 1050,30 1200,60 L1200,120 L0,120 Z"
                    fill="url(#wave-gradient-bg)" opacity="0.6">
                    <animate attributeName="d" values="M0,60 C150,90 350,30 600,60 C850,90 1050,30 1200,60 L1200,120 L0,120 Z;
                                M0,60 C150,30 350,90 600,60 C850,30 1050,90 1200,60 L1200,120 L0,120 Z;
                                M0,60 C150,90 350,30 600,60 C850,90 1050,30 1200,60 L1200,120 L0,120 Z" dur="8s"
                        repeatCount="indefinite" />
                </path>

                <!-- Middle wave layer -->
                <path d="M0,80 C200,50 400,110 600,80 C800,50 1000,110 1200,80 L1200,120 L0,120 Z"
                    fill="url(#wave-gradient-bg2)" opacity="0.8">
                    <animate attributeName="d" values="M0,80 C200,50 400,110 600,80 C800,50 1000,110 1200,80 L1200,120 L0,120 Z;
                                M0,80 C200,110 400,50 600,80 C800,110 1000,50 1200,80 L1200,120 L0,120 Z;
                                M0,80 C200,50 400,110 600,80 C800,50 1000,110 1200,80 L1200,120 L0,120 Z" dur="6s"
                        repeatCount="indefinite" />
                </path>

                <!-- Front wave layer -->
                <path d="M0,100 C150,70 350,130 600,100 C850,70 1050,130 1200,100 L1200,120 L0,120 Z"
                    fill="url(#wave-gradient-bg)" opacity="1">
                    <animate attributeName="d" values="M0,100 C150,70 350,130 600,100 C850,70 1050,130 1200,100 L1200,120 L0,120 Z;
                                M0,100 C150,130 350,70 600,100 C850,130 1050,70 1200,100 L1200,120 L0,120 Z;
                                M0,100 C150,70 350,130 600,100 C850,70 1050,130 1200,100 L1200,120 L0,120 Z" dur="10s"
                        repeatCount="indefinite" />
                </path>
            </svg>
        </div>

        <div class="relative z-10 w-full max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-8 items-center">

                <!-- Left Side - Logo and Info -->
                <div class="text-center lg:text-left animate-slide-in-left">
                    <div class="space-y-8">
                        <!-- Logo Section -->
                        <div class="flex items-center justify-center lg:justify-start gap-6">
                            <div
                                class="flex-shrink-0 w-24 h-24 bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/30 animate-float flex items-center justify-center">
                                <img src="/logo/peka.png" alt="PEKA APBD" class="w-16 h-16">
                            </div>
                            <div>
                                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                                    <span
                                        class="block bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent animate-gradient bg-300">
                                        PEKA
                                    </span>
                                    <span
                                        class="block bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent animate-gradient bg-300 animation-delay-1000">
                                        APBD
                                    </span>
                                </h1>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-4">
                            <h2 class="text-2xl text-gray-700 font-semibold">
                                Penilaian dan Evaluasi Kinerja APBD
                            </h2>
                            <p class="text-lg text-gray-600 leading-relaxed">
                                Platform modern dan terintegrasi untuk monitoring, evaluasi, dan analisis kinerja
                                Anggaran Pendapatan dan Belanja Daerah dengan teknologi terkini yang user-friendly.
                            </p>
                        </div>

                        <!-- Government Logo -->
                        <div class="flex items-center justify-center lg:justify-start">
                            <div class="relative group">
                                <div
                                    class="absolute -inset-4 bg-gradient-to-r from-blue-500/20 to-purple-600/20 rounded-3xl blur-2xl group-hover:blur-3xl transition-all duration-500 opacity-75">
                                </div>
                                <div
                                    class="relative bg-white/90 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/50 p-6 card-hover">
                                    <img src="/logo/com.png" alt="Pemerintah Kota" class="w-64 h-auto">
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="grid grid-cols-3 gap-4 pt-4">
                            <div class="text-center">
                                <div
                                    class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    150+</div>
                                <div class="text-sm text-gray-600">Instansi</div>
                            </div>
                            <div class="text-center">
                                <div
                                    class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                    99.9%</div>
                                <div class="text-sm text-gray-600">Uptime</div>
                            </div>
                            <div class="text-center">
                                <div
                                    class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                    24/7</div>
                                <div class="text-sm text-gray-600">Support</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="animate-slide-in-right">
                    <div class="relative">
                        <!-- Glow Effect Background -->
                        <div
                            class="absolute -inset-4 bg-gradient-to-r from-blue-500/20 to-purple-600/20 rounded-3xl blur-2xl opacity-75">
                        </div>

                        <!-- Login Card -->
                        <div
                            class="relative bg-white/90 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
                            <!-- Gradient Top Border -->
                            <div class="h-2 bg-gradient-to-r from-blue-500 via-blue-600 to-purple-600"></div>

                            <!-- Form Content -->
                            <div class="p-8">
                                <!-- Section Title -->
                                <div class="text-center mb-8">
                                    <div
                                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-4">
                                        <i class="fas fa-sign-in-alt text-white text-2xl"></i>
                                    </div>
                                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Login</h2>
                                    <p class="text-gray-600">Masukkan Username dan Password Anda</p>
                                </div>

                                <!-- Login Form -->
                                <form action="/login" method="post" class="space-y-6">
                                    @csrf

                                    <!-- Username Field -->
                                    <div class="space-y-2">
                                        <label for="username" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-user mr-2 text-blue-500"></i>
                                            Username
                                        </label>
                                        <div class="relative">
                                            <input type="text" id="username" name="username"
                                                placeholder="Masukkan username" value="{{old('username')}}" required
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none bg-white/50 backdrop-blur-sm input-focus"
                                                autocomplete="username">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <i class="fas fa-user text-gray-400"></i>
                                            </div>
                                        </div>
                                        @error('username')
                                        <p class="text-red-500 text-sm mt-1">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{$message}}
                                        </p>
                                        @enderror
                                    </div>

                                    <!-- Password Field -->
                                    <div class="space-y-2">
                                        <label for="password" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-lock mr-2 text-blue-500"></i>
                                            Password
                                        </label>
                                        <div class="relative">
                                            <input type="password" id="password" name="password"
                                                placeholder="Masukkan password" value="{{old('password')}}" required
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none bg-white/50 backdrop-blur-sm input-focus"
                                                autocomplete="current-password">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <button type="button" onclick="togglePassword()"
                                                    class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                                    <i id="passwordToggle" class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('password')
                                        <p class="text-red-500 text-sm mt-1">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{$message}}
                                        </p>
                                        @enderror
                                    </div>

                                    <!-- Remember Me & Forgot Password -->
                                    <div class="flex items-center justify-between">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="remember"
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                                        </label>
                                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                                            Lupa password?
                                        </a>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3 px-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-[1.02] transition-all duration-300 shadow-lg hover:shadow-xl btn-glow">
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Login
                                    </button>
                                </form>

                                <!-- Register Link -->
                                <div class="text-center mt-6">
                                    <p class="text-gray-600">
                                        Belum punya akun?
                                        <a href="#"
                                            class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                                            Daftar sekarang
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->


    <!-- Password Toggle Script -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('passwordToggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            }
        }
    </script>

    <!-- Notification Script -->
    <script type="text/javascript">
        @include('layouts.notif')
    </script>
</body>

</html>