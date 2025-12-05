<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEKA APBD - Penilaian dan Evaluasi Kinerja APBD</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#beranda"
                            class="relative text-white bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full font-medium text-sm hover:bg-white/30 transform hover:scale-105 transition-all duration-300 border border-white/30">
                            Beranda
                        </a>
                        <a href="/login"
                            class="relative text-white bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full font-medium text-sm hover:bg-white/30 transform hover:scale-105 transition-all duration-300 border border-white/30">
                            Masuk
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button"
                        class="bg-white/20 backdrop-blur-sm p-2 rounded-lg text-white hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-all duration-300 border border-white/30">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu"
            class="hidden md:hidden bg-gradient-to-r from-blue-600/95 via-indigo-600/95 to-purple-600/95 backdrop-blur-lg border-t border-white/20">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#beranda"
                    class="bg-white/20 backdrop-blur-sm text-white block px-3 py-2 rounded-md text-base font-medium border border-white/30">Beranda</a>
                <a href="#fitur"
                    class="text-white hover:bg-white/20 block px-3 py-2 rounded-md text-base font-medium transition-all duration-300">Fitur</a>
                <a href="#tentang"
                    class="text-white hover:bg-white/20 block px-3 py-2 rounded-md text-base font-medium transition-all duration-300">Tentang</a>
                <a href="/login"
                    class="text-white hover:bg-white/20 block px-3 py-2 rounded-md text-base font-medium transition-all duration-300">Masuk</a>
            </div>
        </div>
    </nav>

    <!--====== HERO SECTION START ======-->
    <section class="relative overflow-hidden pt-2 pb-8">
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

        <!-- Animated Wave Background (Behind Cards) -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden z-0">
            <svg class="relative block w-full h-32 animate-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
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
                    <animate attributeName="d" 
                        values="M0,60 C150,90 350,30 600,60 C850,90 1050,30 1200,60 L1200,120 L0,120 Z;
                                M0,60 C150,30 350,90 600,60 C850,30 1050,90 1200,60 L1200,120 L0,120 Z;
                                M0,60 C150,90 350,30 600,60 C850,90 1050,30 1200,60 L1200,120 L0,120 Z"
                        dur="8s" 
                        repeatCount="indefinite" />
                </path>
                
                <!-- Middle wave layer -->
                <path d="M0,80 C200,50 400,110 600,80 C800,50 1000,110 1200,80 L1200,120 L0,120 Z" 
                    fill="url(#wave-gradient-bg2)" opacity="0.8">
                    <animate attributeName="d" 
                        values="M0,80 C200,50 400,110 600,80 C800,50 1000,110 1200,80 L1200,120 L0,120 Z;
                                M0,80 C200,110 400,50 600,80 C800,110 1000,50 1200,80 L1200,120 L0,120 Z;
                                M0,80 C200,50 400,110 600,80 C800,50 1000,110 1200,80 L1200,120 L0,120 Z"
                        dur="6s" 
                        repeatCount="indefinite" />
                </path>
                
                <!-- Front wave layer -->
                <path d="M0,100 C150,70 350,130 600,100 C850,70 1050,130 1200,100 L1200,120 L0,120 Z" 
                    fill="url(#wave-gradient-bg)" opacity="1">
                    <animate attributeName="d" 
                        values="M0,100 C150,70 350,130 600,100 C850,70 1050,130 1200,100 L1200,120 L0,120 Z;
                                M0,100 C150,130 350,70 600,100 C850,130 1050,70 1200,100 L1200,120 L0,120 Z;
                                M0,100 C150,70 350,130 600,100 C850,70 1050,130 1200,100 L1200,120 L0,120 Z"
                        dur="10s" 
                        repeatCount="indefinite" />
                </path>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-8 items-start pt-8">

                <!-- Mayor Section -->
                <div class="lg:col-span-3 animate-slide-in-left">
                    <div class="group relative">
                        <!-- Glow Effect Background -->
                        <div
                            class="absolute -inset-4 bg-gradient-to-r from-blue-500/20 to-purple-600/20 rounded-3xl blur-2xl group-hover:blur-3xl transition-all duration-500 opacity-75">
                        </div>

                        <!-- Main Card -->
                        <div
                            class="relative bg-white/90 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/50 overflow-hidden card-hover">
                            <!-- Gradient Top Border -->
                            <div class="h-2 bg-gradient-to-r from-blue-500 via-blue-600 to-purple-600"></div>

                            <!-- Image Container with Decorative Frame -->
                            <div class="relative p-6 pb-0">
                                <div class="relative mx-auto w-48 h-64">
                                    <!-- Decorative Background Circle -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-blue-100 to-purple-100 rounded-2xl transform rotate-3">
                                    </div>
                                    <div
                                        class="absolute inset-0 bg-gradient-to-tr from-purple-100 to-pink-100 rounded-2xl transform -rotate-3">
                                    </div>

                                    <!-- Image Frame -->
                                    <div
                                        class="relative bg-white rounded-2xl shadow-xl p-2 transform hover:scale-105 transition-transform duration-500">
                                        <div class="relative overflow-hidden rounded-xl">
                                            <img src="/images/walikota.jpeg" alt="Walikota"
                                                class="w-full h-60 object-contain">
                                            <!-- Overlay Gradient -->
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-blue-600/20 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Decorative Elements -->
                                    <div
                                        class="absolute -top-2 -right-2 w-6 h-6 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full shadow-lg">
                                    </div>
                                    <div
                                        class="absolute -bottom-2 -left-2 w-4 h-4 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full shadow-lg">
                                    </div>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-6 pt-4 text-center space-y-4">
                                <!-- Name with Decorative Underline -->
                                <div class="relative">
                                    <h3 class="text-xl font-bold text-gray-900 relative z-10">H. Muhammad Yamin</h3>
                                    <div
                                        class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full">
                                    </div>
                                </div>

                                <!-- Role Badge with Animation -->
                                <div class="relative inline-block">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full blur-lg opacity-50 animate-pulse">
                                    </div>
                                    <div
                                        class="relative px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full text-sm font-bold text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                                        <i class="fas fa-user-tie mr-2"></i>
                                        Walikota
                                    </div>
                                </div>

                                <!-- Quote with Quotes Icon -->
                                <div
                                    class="relative px-4 py-3 bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl border border-blue-100">
                                    <i class="fas fa-quote-left text-blue-400 absolute top-2 left-2 text-xs"></i>
                                    <p class="text-gray-700 text-sm italic leading-relaxed px-6">
                                        Transparansi dan akuntabilitas adalah fondasi pembangunan daerah yang
                                        berkelanjutan.
                                    </p>
                                    <i class="fas fa-quote-right text-purple-400 absolute bottom-2 right-2 text-xs"></i>
                                </div>

                                <!-- Social Media with Hover Effects -->
                                <div class="flex justify-center space-x-3 pt-2">
                                    <div class="group">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center shadow-lg transform hover:scale-110 transition-all duration-300 cursor-pointer">
                                            <i class="fab fa-facebook-f text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-sky-400 to-sky-600 rounded-full flex items-center justify-center shadow-lg transform hover:scale-110 transition-all duration-300 cursor-pointer">
                                            <i class="fab fa-twitter text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-600 rounded-full flex items-center justify-center shadow-lg transform hover:scale-110 transition-all duration-300 cursor-pointer">
                                            <i class="fab fa-instagram text-white text-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-6 text-center space-y-8 animate-fade-in-up">
                    <!-- Badge -->

                    <!-- Logo and Title Container -->
                    <div class="flex items-center justify-center gap-6 mb-8">
                        <!-- Logo -->
                        <div
                            class="flex-shrink-0 w-24 h-24 bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/30 animate-float flex items-center justify-center">
                            <img src="/logo/peka.png" alt="PEKA APBD" class="w-16 h-16">
                        </div>

                        <!-- Main Title -->
                        <div class="text-left">
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
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

                    <!-- Subtitle -->
                    <p class="text-2xl text-gray-700 font-semibold">
                        Penilaian dan Evaluasi Kinerja APBD
                    </p>

                    <!-- Description -->
                    <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                        Platform modern dan terintegrasi untuk monitoring, evaluasi, dan analisis kinerja Anggaran
                        Pendapatan dan Belanja Daerah dengan teknologi terkini yang user-friendly.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/login"
                            class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-3xl">
                            <span class="relative z-10">Masuk Sistem</span>
                            <i
                                class="fas fa-sign-in-alt relative z-10 ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </a>

                        <button
                            class="group inline-flex items-center justify-center px-8 py-4 bg-white/80 backdrop-blur-sm text-gray-700 font-bold rounded-2xl border-2 border-gray-200 hover:border-blue-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-play-circle w-5 h-5 mr-2 group-hover:animate-bounce"></i>
                            Lihat Demo
                        </button>
                    </div>

                    <!-- Features -->
                    <div class="grid grid-cols-3 gap-4 pt-8">
                        <div class="text-center">
                            <div
                                class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                150+</div>
                            <div class="text-sm text-gray-600">Instansi</div>
                        </div>
                        <div class="text-center">
                            <div
                                class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                99.9%</div>
                            <div class="text-sm text-gray-600">Uptime</div>
                        </div>
                        <div class="text-center">
                            <div
                                class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                24/7</div>
                            <div class="text-sm text-gray-600">Support</div>
                        </div>
                    </div>
                </div>

                <!-- Vice Mayor Section -->
                <div class="lg:col-span-3 animate-slide-in-right">
                    <div class="group relative">
                        <!-- Glow Effect Background -->
                        <div
                            class="absolute -inset-4 bg-gradient-to-r from-purple-500/20 to-pink-600/20 rounded-3xl blur-2xl group-hover:blur-3xl transition-all duration-500 opacity-75">
                        </div>

                        <!-- Main Card -->
                        <div
                            class="relative bg-white/90 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/50 overflow-hidden card-hover">
                            <!-- Gradient Top Border -->
                            <div class="h-2 bg-gradient-to-r from-purple-500 via-purple-600 to-pink-600"></div>

                            <!-- Image Container with Decorative Frame -->
                            <div class="relative p-6 pb-0">
                                <div class="relative mx-auto w-48 h-64">
                                    <!-- Decorative Background Circle -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl transform rotate-3">
                                    </div>
                                    <div
                                        class="absolute inset-0 bg-gradient-to-tr from-pink-100 to-rose-100 rounded-2xl transform -rotate-3">
                                    </div>

                                    <!-- Image Frame -->
                                    <div
                                        class="relative bg-white rounded-2xl shadow-xl p-2 transform hover:scale-105 transition-transform duration-500">
                                        <div class="relative overflow-hidden rounded-xl">
                                            <img src="/images/wakilwalikota.jpeg" alt="Wakil Walikota"
                                                class="w-full h-60 object-contain">
                                            <!-- Overlay Gradient -->
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-purple-600/20 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Decorative Elements -->
                                    <div
                                        class="absolute -top-2 -right-2 w-6 h-6 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full shadow-lg">
                                    </div>
                                    <div
                                        class="absolute -bottom-2 -left-2 w-4 h-4 bg-gradient-to-br from-pink-500 to-rose-600 rounded-full shadow-lg">
                                    </div>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-6 pt-4 text-center space-y-4">
                                <!-- Name with Decorative Underline -->
                                <div class="relative">
                                    <h3 class="text-xl font-bold text-gray-900 relative z-10">H. Ananda
                                    </h3>
                                    <div
                                        class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full">
                                    </div>
                                </div>

                                <!-- Role Badge with Animation -->
                                <div class="relative inline-block">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full blur-lg opacity-50 animate-pulse">
                                    </div>
                                    <div
                                        class="relative px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full text-sm font-bold text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                                        <i class="fas fa-user-tie mr-2"></i>
                                        Wakil Walikota
                                    </div>
                                </div>

                                <!-- Quote with Quotes Icon -->
                                <div
                                    class="relative px-4 py-3 bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl border border-purple-100">
                                    <i class="fas fa-quote-left text-purple-400 absolute top-2 left-2 text-xs"></i>
                                    <p class="text-gray-700 text-sm italic leading-relaxed px-6">
                                        Inovasi teknologi adalah kunci untuk pemerintahan yang lebih efisien dan
                                        transparan.
                                    </p>
                                    <i class="fas fa-quote-right text-pink-400 absolute bottom-2 right-2 text-xs"></i>
                                </div>

                                <!-- Social Media with Hover Effects -->
                                <div class="flex justify-center space-x-3 pt-2">
                                    <div class="group">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center shadow-lg transform hover:scale-110 transition-all duration-300 cursor-pointer">
                                            <i class="fab fa-facebook-f text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-sky-400 to-sky-600 rounded-full flex items-center justify-center shadow-lg transform hover:scale-110 transition-all duration-300 cursor-pointer">
                                            <i class="fab fa-twitter text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-600 rounded-full flex items-center justify-center shadow-lg transform hover:scale-110 transition-all duration-300 cursor-pointer">
                                            <i class="fab fa-instagram text-white text-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--====== Mobile Menu Script ======-->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = document.getElementById('mobile-menu-button');
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
