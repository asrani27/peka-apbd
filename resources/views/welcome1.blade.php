<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEKA APBD - Penilaian dan Evaluasi Kinerja APBD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="font-inter bg-gray-50">
    <!-- Header -->
    <header class="fixed top-0 w-full z-50 glass-effect">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img src="/logo/peka.png" alt="PEKA APBD Logo" class="w-12 h-12 rounded-lg shadow-lg">
                    <h1 class="text-2xl font-bold text-white">PEKA APBD</h1>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="#beranda" class="text-white hover:text-purple-200 transition-colors">Beranda</a>
                    <a href="#tentang" class="text-white hover:text-purple-200 transition-colors">Tentang</a>
                    <a href="#layanan" class="text-white hover:text-purple-200 transition-colors">Layanan</a>
                    <a href="#kontak" class="text-white hover:text-purple-200 transition-colors">Kontak</a>
                </nav>
                <button class="md:hidden text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="gradient-bg min-h-screen flex items-center relative overflow-hidden pt-20">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-72 h-72 bg-purple-300 rounded-full filter blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-indigo-300 rounded-full filter blur-3xl animate-pulse-slow" style="animation-delay: 1s;"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-3 gap-12 items-center">
                <!-- Left Side - Mayor -->
                <div class="text-center lg:text-right animate-float" style="animation-delay: 0.2s;">
                    <div class="inline-block">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-white opacity-20 rounded-full blur-lg group-hover:opacity-30 transition-opacity"></div>
                            <img src="/images/walikota.jpeg" 
                                 alt="Walikota" 
                                 class="relative w-64 h-80 object-cover rounded-full mx-auto lg:ml-auto shadow-2xl border-4 border-white/30">
                        </div>
                        <div class="mt-6 space-y-2">
                            <h3 class="text-white text-xl font-semibold">Dr. H. Ahmad Wijaya, S.E., M.M.</h3>
                            <p class="text-purple-100">Walikota</p>
                            <p class="text-purple-200 text-sm italic">"Mewujudkan APBD yang transparan dan akuntabel"</p>
                        </div>
                    </div>
                </div>

                <!-- Center Content -->
                <div class="text-center space-y-8">
                    <div class="space-y-6 animate-float">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-white/20 rounded-full backdrop-blur-lg border-2 border-white/30 mb-6">
                            <img src="/logo/peka.png" alt="PEKA APBD" class="w-16 h-16">
                        </div>
                        
                        <h1 class="text-5xl lg:text-6xl font-bold text-white leading-tight">
                            PEKA APBD
                        </h1>
                        
                        <p class="text-2xl text-purple-100 font-medium">
                            Penilaian dan Evaluasi Kinerja APBD
                        </p>
                        
                        <p class="text-lg text-purple-200 max-w-2xl mx-auto leading-relaxed">
                            Sistem modern untuk monitoring dan evaluasi kinerja Anggaran Pendapatan dan Belanja Daerah yang transparan, efisien, dan akuntabel.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center animate-float" style="animation-delay: 0.4s;">
                        <a href="/login" 
                           class="px-8 py-4 bg-white text-purple-700 font-semibold rounded-full hover:bg-purple-50 transform hover:scale-105 transition-all duration-300 shadow-xl">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk Sistem
                        </a>
                        <button class="px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-purple-700 transform hover:scale-105 transition-all duration-300">
                            <i class="fas fa-info-circle mr-2"></i>
                            Pelajari Lebih Lanjut
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 animate-float" style="animation-delay: 0.6s;">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">50+</div>
                            <div class="text-purple-200 text-sm">OPD Terlayani</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">98%</div>
                            <div class="text-purple-200 text-sm">Tingkat Kepuasan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">24/7</div>
                            <div class="text-purple-200 text-sm">Monitoring Real-time</div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Vice Mayor -->
                <div class="text-center lg:text-left animate-float" style="animation-delay: 0.3s;">
                    <div class="inline-block">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-white opacity-20 rounded-full blur-lg group-hover:opacity-30 transition-opacity"></div>
                            <img src="/images/wakilwalikota.jpeg" 
                                 alt="Wakil Walikota" 
                                 class="relative w-64 h-80 object-cover rounded-full mx-auto lg:mr-auto shadow-2xl border-4 border-white/30">
                        </div>
                        <div class="mt-6 space-y-2">
                            <h3 class="text-white text-xl font-semibold">Drs. H. Budi Santoso, M.Si.</h3>
                            <p class="text-purple-100">Wakil Walikota</p>
                            <p class="text-purple-200 text-sm italic">"Inovasi dalam pengelolaan keuangan daerah"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600">Solusi komprehensif untuk pengelolaan APBD yang lebih baik</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Analisis Real-time</h3>
                    <p class="text-gray-600 leading-relaxed">Pantau kinerja APBD secara langsung dengan dashboard interaktif dan visualisasi data yang informatif.</p>
                    <div class="mt-4">
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium flex items-center justify-center group">
                            Pelajari lebih lanjut
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Keamanan Terjamin</h3>
                    <p class="text-gray-600 leading-relaxed">Sistem dengan enkripsi tingkat tinggi dan akses berbasis peran untuk melindungi data sensitif.</p>
                    <div class="mt-4">
                        <a href="#" class="text-purple-600 hover:text-purple-800 font-medium flex items-center justify-center group">
                            Pelajari lebih lanjut
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Laporan Otomatis</h3>
                    <p class="text-gray-600 leading-relaxed">Generate laporan komprehensif secara otomatis dengan berbagai format yang dapat disesuaikan.</p>
                    <div class="mt-4">
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center justify-center group">
                            Pelajari lebih lanjut
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Light Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Mengapa Memilih PEKA APBD?</h2>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Platform kami dirancang khusus untuk memenuhi kebutuhan pengelolaan keuangan daerah dengan solusi yang inovatif, efisien, dan mudah digunakan.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Monitoring 24/7</h4>
                                <p class="text-gray-600">Akses real-time ke data kinerja APBD kapan saja dan di mana saja</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Analisis Mendalam</h4>
                                <p class="text-gray-600">Alat analisis canggih untuk pengambilan keputusan yang lebih baik</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Kepatuhan Regulasi</h4>
                                <p class="text-gray-600">Memenuhi standar regulasi pengelolaan keuangan daerah terkini</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">100+</div>
                                <div class="text-sm text-gray-600">Instansi</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-purple-600 mb-2">98%</div>
                                <div class="text-sm text-gray-600">Kepuasan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-indigo-600 mb-2">24/7</div>
                                <div class="text-sm text-gray-600">Support</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600 mb-2">A+</div>
                                <div class="text-sm text-gray-600">Keamanan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>
</body>
</html>
