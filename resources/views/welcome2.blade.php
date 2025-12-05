<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEKA APBD - Penilaian dan Evaluasi Kinerja APBD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'jakarta': ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    animation: {
                        'slide-in-left': 'slideInLeft 1s ease-out',
                        'slide-in-right': 'slideInRight 1s ease-out',
                        'fade-in-up': 'fadeInUp 1s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-100px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(100px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .hero-pattern {
            background-image: 
                linear-gradient(135deg, rgba(59, 130, 246, 0.9) 0%, rgba(147, 51, 234, 0.9) 100%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .card-shadow {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .neon-glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5), 0 0 40px rgba(147, 51, 234, 0.3);
        }
    </style>
</head>
<body class="font-jakarta bg-gray-900 text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-gray-900/80 backdrop-blur-lg border-b border-gray-800">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <img src="/logo/peka.png" alt="PEKA APBD" class="w-8 h-8">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">PEKA APBD</h1>
                        <p class="text-xs text-gray-400">Sistem Evaluasi Kinerja</p>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-300 hover:text-white transition-colors">Beranda</a>
                    <a href="#fitur" class="text-gray-300 hover:text-white transition-colors">Fitur</a>
                    <a href="#tentang" class="text-gray-300 hover:text-white transition-colors">Tentang</a>
                    <a href="#kontak" class="text-gray-300 hover:text-white transition-colors">Kontak</a>
                    <a href="/login" class="px-6 py-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full hover:from-blue-600 hover:to-purple-700 transition-all transform hover:scale-105">
                        Masuk
                    </a>
                </div>
                
                <button class="md:hidden text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-pattern min-h-screen flex items-center relative overflow-hidden pt-20">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-500/10 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-12 gap-8 items-center min-h-screen">
                <!-- Mayor Section -->
                <div class="lg:col-span-3 animate-slide-in-left">
                    <div class="bg-gray-800/50 backdrop-blur-lg rounded-2xl p-6 border border-gray-700 card-shadow">
                        <div class="relative mb-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl blur-lg opacity-50"></div>
                            <img src="/images/walikota.jpeg" 
                                 alt="Walikota" 
                                 class="relative rounded-2xl w-full h-auto object-cover border-2 border-gray-600">
                        </div>
                        <div class="text-center space-y-3">
                            <h3 class="text-xl font-bold text-white">Dr. H. Ahmad Wijaya, S.E., M.M.</h3>
                            <div class="inline-block px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full text-sm font-semibold">
                                Walikota
                            </div>
                            <p class="text-gray-300 text-sm italic">
                                "Transparansi dan akuntabilitas adalah kunci pembangunan daerah yang berkelanjutan."
                            </p>
                            <div class="flex justify-center space-x-3 pt-4">
                                <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors cursor-pointer">
                                    <i class="fab fa-facebook-f text-sm"></i>
                                </div>
                                <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors cursor-pointer">
                                    <i class="fab fa-twitter text-sm"></i>
                                </div>
                                <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors cursor-pointer">
                                    <i class="fab fa-instagram text-sm"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-6 text-center space-y-8 animate-fade-in-up">
                    <div class="space-y-6">
                        <div class="inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl p-1 neon-glow">
                            <div class="w-full h-full bg-gray-900 rounded-3xl flex items-center justify-center">
                                <img src="/logo/peka.png" alt="PEKA APBD" class="w-20 h-20">
                            </div>
                        </div>
                        
                        <h1 class="text-6xl lg:text-7xl font-black">
                            <span class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                                PEKA APBD
                            </span>
                        </h1>
                        
                        <div class="space-y-2">
                            <p class="text-2xl text-gray-300 font-medium">
                                Penilaian dan Evaluasi Kinerja APBD
                            </p>
                            <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                                Platform terdepan untuk monitoring, evaluasi, dan analisis kinerja Anggaran Pendapatan dan Belanja Daerah dengan teknologi terkini.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/login" 
                           class="group relative px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl font-semibold text-lg hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-rocket mr-3"></i>
                                Mulai Sekarang
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-700 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        </a>
                        <button class="px-8 py-4 bg-gray-800 border-2 border-gray-700 rounded-xl font-semibold text-lg hover:bg-gray-700 transform hover:scale-105 transition-all duration-300">
                            <i class="fas fa-play-circle mr-3"></i>
                            Demo
                        </button>
                    </div>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-3 gap-6 py-8">
                        <div class="bg-gray-800/50 backdrop-blur-lg rounded-xl p-4 border border-gray-700">
                            <div class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">100+</div>
                            <div class="text-sm text-gray-400">Instansi</div>
                        </div>
                        <div class="bg-gray-800/50 backdrop-blur-lg rounded-xl p-4 border border-gray-700">
                            <div class="text-3xl font-bold bg-gradient-to-r from-purple-400 to-purple-600 bg-clip-text text-transparent">99.9%</div>
                            <div class="text-sm text-gray-400">Uptime</div>
                        </div>
                        <div class="bg-gray-800/50 backdrop-blur-lg rounded-xl p-4 border border-gray-700">
                            <div class="text-3xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">24/7</div>
                            <div class="text-sm text-gray-400">Support</div>
                        </div>
                    </div>
                </div>

                <!-- Vice Mayor Section -->
                <div class="lg:col-span-3 animate-slide-in-right">
                    <div class="bg-gray-800/50 backdrop-blur-lg rounded-2xl p-6 border border-gray-700 card-shadow">
                        <div class="relative mb-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl blur-lg opacity-50"></div>
                            <img src="/images/wakilwalikota.jpeg" 
                                 alt="Wakil Walikota" 
                                 class="relative rounded-2xl w-full h-auto object-cover border-2 border-gray-600">
                        </div>
                        <div class="text-center space-y-3">
                            <h3 class="text-xl font-bold text-white">Drs. H. Budi Santoso, M.Si.</h3>
                            <div class="inline-block px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full text-sm font-semibold">
                                Wakil Walikota
                            </div>
                            <p class="text-gray-300 text-sm italic">
                                "Inovasi teknologi untuk pemerintahan yang lebih efisien dan transparan."
                            </p>
                            <div class="flex justify-center space-x-3 pt-4">
                                <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors cursor-pointer">
                                    <i class="fab fa-facebook-f text-sm"></i>
                                </div>
                                <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors cursor-pointer">
                                    <i class="fab fa-twitter text-sm"></i>
                                </div>
                                <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors cursor-pointer">
                                    <i class="fab fa-instagram text-sm"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
            <div class="flex flex-col items-center space-y-2">
                <span class="text-sm text-gray-400">Scroll untuk melihat lebih</span>
                <div class="w-6 h-10 border-2 border-gray-400 rounded-full flex justify-center">
                    <div class="w-1 h-3 bg-gray-400 rounded-full mt-2 animate-bounce"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Fitur Unggulan
                </h2>
                <p class="text-xl text-gray-600">Teknologi terdepan untuk pengelolaan APBD yang optimal</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-pie text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Dashboard Analytics</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Visualisasi data real-time dengan grafik interaktif</p>
                    <div class="mt-4">
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center group">
                            Selengkapnya
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform text-xs"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-lock text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Keamanan Terpadu</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Enkripsi end-to-end dan autentikasi multi-faktor</p>
                    <div class="mt-4">
                        <a href="#" class="text-purple-600 hover:text-purple-800 font-medium text-sm flex items-center group">
                            Selengkapnya
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform text-xs"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Manajemen User</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Sistem hak akses berbasis peran yang fleksibel</p>
                    <div class="mt-4">
                        <a href="#" class="text-pink-600 hover:text-pink-800 font-medium text-sm flex items-center group">
                            Selengkapnya
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform text-xs"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-export text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Export Reports</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Generate laporan dalam berbagai format profesional</p>
                    <div class="mt-4">
                        <a href="#" class="text-green-600 hover:text-green-800 font-medium text-sm flex items-center group">
                            Selengkapnya
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Light Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Platform Terpercaya</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Bergabunglah dengan puluhan instansi yang telah mempercayai kami untuk pengelolaan APBD yang lebih baik</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 mb-16">
                <div class="text-center p-8 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl">
                    <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-tachometer-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Performa Tinggi</h3>
                    <p class="text-gray-600 leading-relaxed">Sistem yang dioptimalkan untuk kecepatan dan efisiensi maksimal dalam pengolahan data APBD</p>
                </div>

                <div class="text-center p-8 bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl">
                    <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-headset text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Support 24/7</h3>
                    <p class="text-gray-600 leading-relaxed">Tim support profesional siap membantu Anda kapan saja untuk menjaga kelancaran operasional</p>
                </div>

                <div class="text-center p-8 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl">
                    <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-certificate text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Tersertifikasi</h3>
                    <p class="text-gray-600 leading-relaxed">Memenuhi standar keamanan dan regulasi pengelolaan keuangan daerah yang berlaku</p>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-12 text-white">
                <div class="grid md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold mb-2">150+</div>
                        <div class="text-blue-100">Instansi Pemerintah</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">99.9%</div>
                        <div class="text-blue-100">Uptime Server</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">24/7</div>
                        <div class="text-blue-100">Monitoring</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">ISO</div>
                        <div class="text-blue-100">Certified</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>
</body>
</html>
