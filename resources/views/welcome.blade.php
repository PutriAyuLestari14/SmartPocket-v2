<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart Pocket - Dompet Digital BMT SMKN 11 Bandung</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300;400;500;600;700;800;900" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 'sans': ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: {
                            50:  '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0',
                            300: '#6ee7b7', 400: '#34d399', 500: '#10b981',
                            600: '#059669', 700: '#047857', 800: '#065f46', 900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .gradient-bg { background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%); }
        .gradient-text {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
        }
        .glass-dark {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px) saturate(180%);
        }

        .navbar-main.scrolled {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }

        .text-balance { text-wrap: balance; }

        /* Hero title gradient animation */
        @keyframes gradientText {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animated-gradient-text {
            background: linear-gradient(90deg, #059669, #10b981, #34d399, #10b981, #059669);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientText 5s linear infinite;
        }
    </style>
</head>
<body class="bg-white text-slate-800 overflow-x-hidden">

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar-main fixed top-0 w-full z-50 transition-all duration-300 border-b border-white/20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="w-11 h-11 gradient-bg rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/40 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <div class="absolute inset-0 gradient-bg rounded-xl blur-lg opacity-40 group-hover:opacity-60 transition"></div>
                    </div>
                    <div>
                        <div class="font-extrabold text-lg text-slate-800 leading-tight">Smart Pocket</div>
                        <div class="text-xs text-slate-500 leading-tight">BMT • SMKN 11 Bandung</div>
                    </div>
                </a>

                <!-- Menu -->
                <div class="hidden lg:flex items-center gap-1">
                    <a href="#home" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition">Beranda</a>
                    <a href="#fitur" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition">Fitur</a>
                    <a href="#tentang" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition">Tentang</a>
                    <a href="#cara-kerja" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition">Cara Kerja</a>
                    <a href="#faq" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition">FAQ</a>
                    <a href="{{ route('contact') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition">Kontak</a>
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:text-primary-600 transition">
                        Login
                    </a>
                    <a href="{{ route('login') }}" class="group relative inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl overflow-hidden">
                        <span class="absolute inset-0 gradient-bg"></span>
                        <span class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></span>
                        <span class="relative flex items-center gap-2">
                            Masuk
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== HERO SECTION ===== -->
    <section id="home" class="relative min-h-screen flex items-center pt-20 overflow-hidden">
        <!-- Animated mesh gradient background -->
        <div class="mesh-gradient">
            <div class="mesh-blob mesh-blob-1"></div>
            <div class="mesh-blob mesh-blob-2"></div>
            <div class="mesh-blob mesh-blob-3"></div>
        </div>
        <div class="noise-overlay"></div>
        <div class="particles-container absolute inset-0 pointer-events-none"></div>

        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(#10b981 1px, transparent 1px), linear-gradient(90deg, #10b981 1px, transparent 1px); background-size: 50px 50px;"></div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-20 z-10">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Text -->
                <div>
                    <!-- Badge -->
                    <div class="reveal inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur border border-primary-200 rounded-full mb-6 shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                        </span>
                        <span class="text-sm font-semibold text-primary-700">Platform Resmi BMT SMKN 11 Bandung</span>
                    </div>

                    <!-- Title -->
                    <h1 class="reveal reveal-delay-1 text-5xl md:text-6xl lg:text-7xl font-black leading-[1.05] tracking-tight text-slate-900 mb-6 text-balance">
                        Dompet Digital <br>
                        <span class="animated-gradient-text">Cerdas</span> untuk<br>
                        Warga SMKN 11
                    </h1>

                    <!-- Description -->
                    <p class="reveal reveal-delay-2 text-lg md:text-xl text-slate-600 mb-8 max-w-xl leading-relaxed">
                        Kelola keuangan BMT dengan mudah. Ajukan <strong class="text-slate-900">penarikan</strong>, <strong class="text-slate-900">peminjaman</strong>, dan <strong class="text-slate-900">cek saldo</strong> kapan saja — semua dalam genggaman.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="reveal reveal-delay-3 flex flex-wrap gap-4 mb-12">
                        <a href="{{ route('login') }}" class="group relative inline-flex items-center gap-2 px-8 py-4 font-bold text-white rounded-2xl overflow-hidden shadow-xl shadow-primary-500/30 hover:shadow-2xl hover:shadow-primary-500/50 transition-all">
                            <span class="absolute inset-0 gradient-bg"></span>
                            <span class="absolute inset-0 bg-gradient-to-r from-primary-700 to-primary-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            <span class="relative flex items-center gap-2">
                                Mulai Sekarang
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </a>
                        <a href="#fitur" class="group inline-flex items-center gap-2 px-8 py-4 font-bold text-slate-700 bg-white/80 backdrop-blur border-2 border-slate-200 hover:border-primary-500 hover:text-primary-600 rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Lihat Demo
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="reveal reveal-delay-4 grid grid-cols-3 gap-6 pt-8 border-t border-slate-200/60">
                        <div>
                            <div class="flex items-baseline gap-1">
                                <span class="counter text-3xl md:text-4xl font-black gradient-text" data-target="550" data-suffix="+">0</span>
                            </div>
                            <div class="text-sm text-slate-500 mt-1 font-medium">Anggota Aktif</div>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-1">
                                <span class="counter text-3xl md:text-4xl font-black gradient-text" data-target="50" data-suffix="M+">0</span>
                            </div>
                            <div class="text-sm text-slate-500 mt-1 font-medium">Dana Terkelola</div>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-1">
                                <span class="counter text-3xl md:text-4xl font-black gradient-text" data-target="99" data-suffix="%">0</span>
                            </div>
                            <div class="text-sm text-slate-500 mt-1 font-medium">Uptime Sistem</div>
                        </div>
                    </div>
                </div>

                <!-- 3D Phone Mockup -->
                <div class="reveal reveal-delay-2 relative phone-3d">
                    <div class="relative mx-auto max-w-sm">
                        <!-- Glow effect -->
                        <div class="absolute inset-0 gradient-bg rounded-[3rem] blur-3xl opacity-30 scale-90"></div>

                        <!-- Phone device -->
                        <div class="phone-device relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-[3rem] p-3 shadow-2xl">
                            <!-- Notch -->
                            <div class="absolute top-3 left-1/2 -translate-x-1/2 w-28 h-6 bg-slate-900 rounded-full z-20"></div>

                            <!-- Screen -->
                            <div class="relative bg-gradient-to-br from-primary-50 to-white rounded-[2.5rem] overflow-hidden">
                                <!-- Status bar -->
                                <div class="flex justify-between items-center px-6 pt-4 pb-2 text-xs font-semibold text-slate-700">
                                    <span>9:41</span>
                                    <div class="flex gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3C7.4 3 3.3 5 .5 8.3l11.5 13 11.5-13C20.7 5 16.6 3 12 3z"/></svg>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M15.67 4H14V2h-4v2H8.33C7.6 4 7 4.6 7 5.33v15.33C7 21.4 7.6 22 8.33 22h7.33c.74 0 1.34-.6 1.34-1.33V5.33C17 4.6 16.4 4 15.67 4z"/></svg>
                                    </div>
                                </div>

                                <!-- App content -->
                                <div class="p-5 pt-2">
                                    <!-- Header -->
                                    <div class="flex justify-between items-center mb-5">
                                        <div>
                                            <p class="text-xs text-slate-500">Selamat datang 👋</p>
                                            <p class="font-bold text-slate-900">Ahmad Fauzi</p>
                                        </div>
                                        <div class="relative">
                                            <div class="w-11 h-11 gradient-bg rounded-full flex items-center justify-center text-white font-bold shadow-lg shadow-primary-500/30">
                                                A
                                            </div>
                                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full border-2 border-white flex items-center justify-center">
                                                <span class="text-[8px] text-white font-bold">3</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Saldo Card -->
                                    <div class="relative gradient-bg rounded-2xl p-5 text-white mb-4 overflow-hidden">
                                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full"></div>
                                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full"></div>
                                        
                                        <div class="relative">
                                            <div class="flex justify-between items-start mb-3">
                                                <div>
                                                    <p class="text-xs opacity-80 mb-1">Saldo BMT Anda</p>
                                                    <p class="text-2xl font-black">Rp 1.250.000</p>
                                                </div>
                                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                <button class="flex-1 bg-white text-primary-700 text-xs font-bold py-2.5 rounded-xl hover:scale-105 transition">
                                                    💸 Tarik
                                                </button>
                                                <button class="flex-1 bg-white/20 backdrop-blur text-xs font-bold py-2.5 rounded-xl hover:bg-white/30 transition">
                                                    💰 Pinjam
                                                </button>
                                                <button class="flex-1 bg-white/20 backdrop-blur text-xs font-bold py-2.5 rounded-xl hover:bg-white/30 transition">
                                                    📊 Riwayat
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="grid grid-cols-4 gap-2 mb-4">
                                        <div class="text-center p-2">
                                            <div class="w-10 h-10 mx-auto bg-primary-100 rounded-xl flex items-center justify-center mb-1">
                                                <span class="text-lg">💳</span>
                                            </div>
                                            <p class="text-[10px] font-semibold text-slate-700">Saldo</p>
                                        </div>
                                        <div class="text-center p-2">
                                            <div class="w-10 h-10 mx-auto bg-emerald-100 rounded-xl flex items-center justify-center mb-1">
                                                <span class="text-lg">💵</span>
                                            </div>
                                            <p class="text-[10px] font-semibold text-slate-700">Tarik</p>
                                        </div>
                                        <div class="text-center p-2">
                                            <div class="w-10 h-10 mx-auto bg-teal-100 rounded-xl flex items-center justify-center mb-1">
                                                <span class="text-lg">📝</span>
                                            </div>
                                            <p class="text-[10px] font-semibold text-slate-700">Pinjam</p>
                                        </div>
                                        <div class="text-center p-2">
                                            <div class="w-10 h-10 mx-auto bg-cyan-100 rounded-xl flex items-center justify-center mb-1">
                                                <span class="text-lg">📈</span>
                                            </div>
                                            <p class="text-[10px] font-semibold text-slate-700">Laporan</p>
                                        </div>
                                    </div>

                                    <!-- Recent Transactions -->
                                    <div class="bg-white rounded-2xl p-3 border border-slate-100">
                                        <div class="flex justify-between items-center mb-2">
                                            <p class="text-xs font-bold text-slate-900">Transaksi Terbaru</p>
                                            <a href="#" class="text-[10px] font-semibold text-primary-600">Lihat semua</a>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-xl">
                                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-sm">💰</div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-semibold text-slate-900 truncate">Penarikan Dana</p>
                                                    <p class="text-[10px] text-slate-500">Hari ini, 10:30</p>
                                                </div>
                                                <p class="text-xs font-bold text-green-600">+Rp 200K</p>
                                            </div>
                                            <div class="flex items-center gap-2 p-2 bg-slate-50 rounded-xl">
                                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-sm">📚</div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-semibold text-slate-900 truncate">Peminjaman</p>
                                                    <p class="text-[10px] text-slate-500">Kemarin, 14:20</p>
                                                </div>
                                                <p class="text-xs font-bold text-blue-600">-Rp 500K</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating notification cards -->
                        <div class="absolute -top-4 -left-8 bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-3 animate-float border border-slate-100" style="animation: phoneFloat 6s ease-in-out infinite;">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Transaksi</p>
                                <p class="text-sm font-bold text-slate-900">Berhasil ✓</p>
                            </div>
                        </div>

                        <div class="absolute -bottom-4 -right-8 bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-3 border border-slate-100" style="animation: phoneFloat 6s ease-in-out 2s infinite;">
                            <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Keamanan</p>
                                <p class="text-sm font-bold text-slate-900">Terenkripsi 🔒</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-slate-400">
            <span class="text-xs font-medium">Scroll</span>
            <div class="w-6 h-10 border-2 border-slate-300 rounded-full flex justify-center p-1">
                <div class="w-1 h-2 bg-slate-400 rounded-full animate-bounce"></div>
            </div>
        </div>
    </section>

    <!-- ===== TRUSTED BY / PARTNERS ===== -->
    <section class="py-12 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <p class="text-center text-sm font-semibold text-slate-500 mb-8 uppercase tracking-wider">
                Didukung oleh ekosistem pendidikan SMKN 11 Bandung
            </p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-70">
                <div class="flex items-center gap-2 text-slate-600 font-bold text-lg">
                    <span class="text-2xl">🏫</span> SMKN 11
                </div>
                <div class="flex items-center gap-2 text-slate-600 font-bold text-lg">
                    <span class="text-2xl">🏦</span> BMT Mini
                </div>
                <div class="flex items-center gap-2 text-slate-600 font-bold text-lg">
                    <span class="text-2xl">🎓</span> Diksi Pendidikan
                </div>
                <div class="flex items-center gap-2 text-slate-600 font-bold text-lg">
                    <span class="text-2xl">📚</span> SMK Pusat
                </div>
                <div class="flex items-center gap-2 text-slate-600 font-bold text-lg">
                    <span class="text-2xl">🌱</span> Literasi Finansial
                </div>
            </div>
        </div>
    </section>

    <!-- ===== BENTO FEATURES ===== -->
    <section id="fitur" class="py-24 lg:py-32 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="reveal inline-flex items-center gap-2 px-4 py-2 bg-primary-50 border border-primary-100 rounded-full mb-6">
                    <span class="text-sm font-semibold text-primary-700">✨ Fitur Unggulan</span>
                </div>
                <h2 class="reveal reveal-delay-1 text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 mb-6 text-balance">
                    Semua yang Anda Butuhkan, <br>
                    <span class="animated-gradient-text">Dalam Satu Aplikasi</span>
                </h2>
                <p class="reveal reveal-delay-2 text-lg text-slate-600">
                    Dirancang khusus untuk siswa dan guru SMKN 11 Bandung dengan antarmuka yang simpel dan pengalaman yang menyenangkan
                </p>
            </div>

            <!-- Bento Grid -->
            <div class="grid md:grid-cols-6 gap-4 md:gap-6">
                <!-- Big Card: Cek Saldo -->
                <div class="reveal bento-card md:col-span-4 bg-gradient-to-br from-primary-600 via-primary-500 to-emerald-500 rounded-3xl p-8 md:p-10 text-white relative overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/10 rounded-full"></div>
                    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full"></div>
                    
                    <div class="relative">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <span class="px-3 py-1 bg-white/20 backdrop-blur rounded-full text-xs font-bold">POPULER</span>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-black mb-3">Cek Saldo Real-time</h3>
                        <p class="text-white/90 text-lg mb-6 max-w-md">
                            Pantau saldo BMT Anda kapan saja dengan update real-time. Lihat riwayat transaksi lengkap dengan detail yang transparan.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <span class="px-4 py-2 bg-white/20 backdrop-blur rounded-full text-sm font-semibold">✓ Live update</span>
                            <span class="px-4 py-2 bg-white/20 backdrop-blur rounded-full text-sm font-semibold">✓ Riwayat lengkap</span>
                            <span class="px-4 py-2 bg-white/20 backdrop-blur rounded-full text-sm font-semibold">✓ Export PDF</span>
                        </div>
                    </div>
                </div>

                <!-- Small Card: Penarikan -->
                <div class="reveal reveal-delay-1 bento-card md:col-span-2 bg-white border-2 border-slate-100 rounded-3xl p-8 relative overflow-hidden">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-emerald-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-3">Ajukan Penarikan</h3>
                    <p class="text-slate-600 mb-5">
                        Tarik dana kapan saja dengan proses cepat, aman, dan langsung disetujui admin BMT.
                    </p>
                    <div class="flex items-center gap-2 text-primary-600 font-bold text-sm">
                        Pelajari lebih lanjut
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>

                <!-- Small Card: Peminjaman -->
                <div class="reveal reveal-delay-2 bento-card md:col-span-2 bg-white border-2 border-slate-100 rounded-3xl p-8">
                    <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-teal-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-3">Peminjaman Mudah</h3>
                    <p class="text-slate-600 mb-5">
                        Ajukan pinjaman dana darurat dengan syarat mudah dan cicilan fleksibel.
                    </p>
                    <div class="flex items-center gap-2 text-primary-600 font-bold text-sm">
                        Pelajari lebih lanjut
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>

                <!-- Big Card: Keamanan -->
                <div class="reveal reveal-delay-3 bento-card md:col-span-4 bg-slate-900 rounded-3xl p-8 md:p-10 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl"></div>
                    
                    <div class="relative">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/50">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-black mb-3">Keamanan Tingkat Bank</h3>
                        <p class="text-slate-300 text-lg mb-6 max-w-md">
                            Data Anda dilindungi dengan enkripsi end-to-end dan autentikasi biometrik. Transaksi aman, data terjaga.
                        </p>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-white/5 backdrop-blur rounded-2xl p-4 border border-white/10">
                                <p class="text-2xl font-black gradient-text">256-bit</p>
                                <p class="text-xs text-slate-400 mt-1">SSL Encryption</p>
                            </div>
                            <div class="bg-white/5 backdrop-blur rounded-2xl p-4 border border-white/10">
                                <p class="text-2xl font-black gradient-text">2FA</p>
                                <p class="text-xs text-slate-400 mt-1">Authentikasi</p>
                            </div>
                            <div class="bg-white/5 backdrop-blur rounded-2xl p-4 border border-white/10">
                                <p class="text-2xl font-black gradient-text">100%</p>
                                <p class="text-xs text-slate-400 mt-1">Data Protected</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== ABOUT SECTION ===== -->
    <section id="tentang" class="py-24 lg:py-32 bg-slate-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Visual -->
                <div class="reveal relative">
                    <div class="relative">
                        <!-- Main card -->
                        <div class="relative gradient-bg rounded-3xl p-10 shadow-2xl shadow-primary-500/30">
                            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                            
                            <div class="relative">
                                <div class="flex items-center gap-3 mb-8">
                                    <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                                        <span class="text-3xl">🏫</span>
                                    </div>
                                    <div>
                                        <p class="text-white/80 text-sm">Didukung oleh</p>
                                        <p class="text-white font-black text-xl">SMKN 11 Bandung</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white/15 backdrop-blur rounded-2xl p-5 border border-white/20">
                                        <p class="text-3xl font-black text-white mb-1">550+</p>
                                        <p class="text-xs text-white/80">Anggota Aktif</p>
                                    </div>
                                    <div class="bg-white/15 backdrop-blur rounded-2xl p-5 border border-white/20">
                                        <p class="text-3xl font-black text-white mb-1">Rp 50M</p>
                                        <p class="text-xs text-white/80">Dana Terkelola</p>
                                    </div>
                                    <div class="bg-white/15 backdrop-blur rounded-2xl p-5 border border-white/20">
                                        <p class="text-3xl font-black text-white mb-1">100%</p>
                                        <p class="text-xs text-white/80">Transparan</p>
                                    </div>
                                    <div class="bg-white/15 backdrop-blur rounded-2xl p-5 border border-white/20">
                                        <p class="text-3xl font-black text-white mb-1">24/7</p>
                                        <p class="text-xs text-white/80">Layanan Online</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating badge -->
                        <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-2xl p-5 flex items-center gap-3 border border-slate-100">
                            <div class="relative">
                                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div class="absolute inset-0 bg-primary-400 rounded-full pulse-ring"></div>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Status</p>
                                <p class="text-sm font-bold text-slate-900">Resmi & Terpercaya</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Text -->
                <div>
                    <div class="reveal inline-flex items-center gap-2 px-4 py-2 bg-primary-50 border border-primary-100 rounded-full mb-6">
                        <span class="text-sm font-semibold text-primary-700">🏫 Tentang Kami</span>
                    </div>
                    <h2 class="reveal reveal-delay-1 text-4xl md:text-5xl font-black text-slate-900 mb-6 text-balance">
                        BMT Bank Mini Terpadu <br>
                        <span class="animated-gradient-text">SMKN 11 Bandung</span>
                    </h2>
                    <p class="reveal reveal-delay-2 text-lg text-slate-600 mb-6 leading-relaxed">
                        Smart Pocket adalah platform dompet digital resmi yang dikembangkan oleh <strong class="text-slate-900">BMT Bank Mini Terpadu SMKN 11 Bandung</strong> untuk memudahkan siswa dan guru dalam mengelola transaksi keuangan sekolah.
                    </p>
                    <p class="reveal reveal-delay-2 text-lg text-slate-600 mb-8 leading-relaxed">
                        Dengan konsep <em class="text-primary-600 font-semibold">learning by doing</em>, kami memberikan pengalaman nyata kepada siswa dalam mengelola keuangan, sekaligus menanamkan nilai-nilai literasi finansial sejak dini.
                    </p>

                    <div class="reveal reveal-delay-3 space-y-4 mb-8">
                        <div class="flex items-start gap-4 p-4 bg-white rounded-2xl border border-slate-100 hover:border-primary-200 hover:shadow-lg transition">
                            <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1">Literasi Finansial</h4>
                                <p class="text-sm text-slate-600">Membangun kebiasaan menabung dan mengelola uang sejak dini</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 bg-white rounded-2xl border border-slate-100 hover:border-primary-200 hover:shadow-lg transition">
                            <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1">Aman & Terpercaya</h4>
                                <p class="text-sm text-slate-600">Dikelola langsung oleh sekolah dengan sistem yang transparan</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 bg-white rounded-2xl border border-slate-100 hover:border-primary-200 hover:shadow-lg transition">
                            <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1">Cepat & Praktis</h4>
                                <p class="text-sm text-slate-600">Transaksi kapan saja tanpa perlu antre di bank mini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== HOW IT WORKS - TIMELINE ===== -->
    <section id="cara-kerja" class="py-24 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <div class="reveal inline-flex items-center gap-2 px-4 py-2 bg-primary-50 border border-primary-100 rounded-full mb-6">
                    <span class="text-sm font-semibold text-primary-700">🚀 Cara Kerja</span>
                </div>
                <h2 class="reveal reveal-delay-1 text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 mb-6 text-balance">
                    Mulai dalam <br>
                    <span class="animated-gradient-text">3 Langkah Mudah</span>
                </h2>
                <p class="reveal reveal-delay-2 text-lg text-slate-600">
                    Proses sederhana untuk mulai menggunakan Smart Pocket
                </p>
            </div>

            <!-- Timeline -->
            <div class="relative max-w-4xl mx-auto">
                <!-- Vertical line -->
                <div class="absolute left-8 md:left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-primary-200 via-primary-400 to-primary-200 md:-translate-x-1/2"></div>

                <!-- Step 1 -->
                <div class="reveal relative flex items-center mb-16 md:mb-24">
                    <div class="flex-1 md:pr-12 md:text-right">
                        <div class="bg-white rounded-3xl p-8 border-2 border-slate-100 hover:border-primary-200 shadow-xl shadow-slate-100 hover:shadow-2xl transition-all">
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary-100 text-primary-700 text-xs font-bold rounded-full mb-3">
                                LANGKAH 01
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 mb-3">Login dengan NIS/NIP</h3>
                            <p class="text-slate-600">
                                Login menggunakan NIS (untuk siswa) atau NIP (untuk guru) yang telah didaftarkan oleh admin sekolah.
                            </p>
                        </div>
                    </div>
                    <div class="absolute left-8 md:left-1/2 w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-xl shadow-primary-500/40 md:-translate-x-1/2 z-10">
                        1
                    </div>
                    <div class="flex-1 hidden md:block"></div>
                </div>

                <!-- Step 2 -->
                <div class="reveal relative flex items-center mb-16 md:mb-24 flex-row-reverse">
                    <div class="flex-1 md:pl-12">
                        <div class="bg-white rounded-3xl p-8 border-2 border-slate-100 hover:border-primary-200 shadow-xl shadow-slate-100 hover:shadow-2xl transition-all">
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary-100 text-primary-700 text-xs font-bold rounded-full mb-3">
                                LANGKAH 02
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 mb-3">Pilih Layanan</h3>
                            <p class="text-slate-600">
                                Pilih layanan yang Anda butuhkan: cek saldo, ajukan penarikan, atau ajukan peminjaman dengan mudah.
                            </p>
                        </div>
                    </div>
                    <div class="absolute left-8 md:left-1/2 w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-xl shadow-primary-500/40 md:-translate-x-1/2 z-10">
                        2
                    </div>
                    <div class="flex-1 hidden md:block"></div>
                </div>

                <!-- Step 3 -->
                <div class="reveal relative flex items-center">
                    <div class="flex-1 md:pr-12 md:text-right">
                        <div class="bg-gradient-to-br from-primary-600 to-emerald-500 rounded-3xl p-8 shadow-xl shadow-primary-500/30 text-white">
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur text-white text-xs font-bold rounded-full mb-3">
                                LANGKAH 03
                            </div>
                            <h3 class="text-2xl font-black mb-3">Selesai! 🎉</h3>
                            <p class="text-white/90">
                                Transaksi diproses dan Anda akan menerima notifikasi real-time. Dana siap digunakan kapan saja.
                            </p>
                        </div>
                    </div>
                    <div class="absolute left-8 md:left-1/2 w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-xl md:-translate-x-1/2 z-10">
                        3
                    </div>
                    <div class="flex-1 hidden md:block"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="py-24 lg:py-32 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="reveal inline-flex items-center gap-2 px-4 py-2 bg-primary-50 border border-primary-100 rounded-full mb-6">
                    <span class="text-sm font-semibold text-primary-700">💬 Testimoni</span>
                </div>
                <h2 class="reveal reveal-delay-1 text-4xl md:text-5xl font-black text-slate-900 mb-6 text-balance">
                    Apa Kata <span class="animated-gradient-text">Mereka?</span>
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="reveal bento-card bg-white rounded-3xl p-8 border border-slate-100">
                    <div class="flex gap-1 mb-4">
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                    </div>
                    <p class="text-slate-700 mb-6 leading-relaxed">
                        "Smart Pocket bikin saya gampang cek saldo BMT tanpa harus ke bank mini. Aplikasinya cepat dan mudah digunakan!"
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center text-white font-bold">
                            R
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">Rina Safitri</p>
                            <p class="text-sm text-slate-500">Siswa Kelas XI RPL</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="reveal reveal-delay-1 bento-card bg-white rounded-3xl p-8 border border-slate-100">
                    <div class="flex gap-1 mb-4">
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                    </div>
                    <p class="text-slate-700 mb-6 leading-relaxed">
                        "Fitur peminjaman sangat membantu saat ada kebutuhan mendesak. Prosesnya cepat dan transparan. Recommended!"
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center text-white font-bold">
                            B
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">Budi Santoso, S.Pd</p>
                            <p class="text-sm text-slate-500">Guru Produktif</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="reveal reveal-delay-2 bento-card bg-white rounded-3xl p-8 border border-slate-100">
                    <div class="flex gap-1 mb-4">
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                        <span class="text-yellow-400 text-xl">★</span>
                    </div>
                    <p class="text-slate-700 mb-6 leading-relaxed">
                        "Sebagai guru, saya bisa pantau transaksi siswa dengan mudah. Smart Pocket membantu literasi finansial sejak dini."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold">
                            S
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">Siti Nurhaliza, M.Pd</p>
                            <p class="text-sm text-slate-500">Kepala BMT</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FAQ ===== -->
    <section id="faq" class="py-24 lg:py-32 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="reveal inline-flex items-center gap-2 px-4 py-2 bg-primary-50 border border-primary-100 rounded-full mb-6">
                    <span class="text-sm font-semibold text-primary-700">❓ FAQ</span>
                </div>
                <h2 class="reveal reveal-delay-1 text-4xl md:text-5xl font-black text-slate-900 mb-6 text-balance">
                    Pertanyaan yang <br>
                    <span class="animated-gradient-text">Sering Diajukan</span>
                </h2>
            </div>

            <div class="space-y-4">
                <div class="reveal faq-item bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex items-center justify-between p-6 text-left hover:bg-slate-100 transition">
                        <span class="font-bold text-slate-900 pr-4">Siapa saja yang bisa menggunakan Smart Pocket?</span>
                        <svg class="faq-icon w-5 h-5 text-primary-600 flex-shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                        <div class="px-6 pb-6 text-slate-600">
                            Smart Pocket dapat digunakan oleh seluruh siswa-siswi dan guru SMKN 11 Bandung yang telah terdaftar sebagai anggota BMT Bank Mini Terpadu.
                        </div>
                    </div>
                </div>

                <div class="reveal reveal-delay-1 faq-item bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex items-center justify-between p-6 text-left hover:bg-slate-100 transition">
                        <span class="font-bold text-slate-900 pr-4">Bagaimana cara mendaftar Smart Pocket?</span>
                        <svg class="faq-icon w-5 h-5 text-primary-600 flex-shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                        <div class="px-6 pb-6 text-slate-600">
                            Pendaftaran dilakukan oleh admin sekolah. Setelah terdaftar, Anda akan menerima NIS/NIP dan password awal yang dapat digunakan untuk login pertama kali.
                        </div>
                    </div>
                </div>

                <div class="reveal reveal-delay-2 faq-item bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex items-center justify-between p-6 text-left hover:bg-slate-100 transition">
                        <span class="font-bold text-slate-900 pr-4">Berapa lama proses penarikan dana?</span>
                        <svg class="faq-icon w-5 h-5 text-primary-600 flex-shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                        <div class="px-6 pb-6 text-slate-600">
                            Proses penarikan dana biasanya memakan waktu 1x24 jam kerja setelah pengajuan disetujui oleh admin BMT. Anda akan menerima notifikasi saat penarikan berhasil.
                        </div>
                    </div>
                </div>

                <div class="reveal reveal-delay-3 faq-item bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex items-center justify-between p-6 text-left hover:bg-slate-100 transition">
                        <span class="font-bold text-slate-900 pr-4">Apakah data saya aman di Smart Pocket?</span>
                        <svg class="faq-icon w-5 h-5 text-primary-600 flex-shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                        <div class="px-6 pb-6 text-slate-600">
                            Ya, sangat aman. Smart Pocket menggunakan enkripsi SSL 256-bit dan autentikasi dua faktor (2FA) untuk melindungi data dan transaksi Anda.
                        </div>
                    </div>
                </div>

                <div class="reveal reveal-delay-4 faq-item bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex items-center justify-between p-6 text-left hover:bg-slate-100 transition">
                        <span class="font-bold text-slate-900 pr-4">Bagaimana jika lupa password?</span>
                        <svg class="faq-icon w-5 h-5 text-primary-600 flex-shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                        <div class="px-6 pb-6 text-slate-600">
                            Anda dapat menggunakan fitur "Lupa Password" di halaman login, atau menghubungi admin BMT untuk reset password secara manual.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="py-24 lg:py-32 bg-slate-50">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="reveal relative gradient-bg rounded-[2.5rem] p-12 md:p-20 overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute -top-20 -right-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-white/5 rounded-full"></div>

                <div class="relative text-center text-white">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur border border-white/30 rounded-full mb-6">
                        <span class="text-sm font-semibold text-white">🚀 Siap Memulai?</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6 text-balance">
                        Kelola Keuangan Lebih <br>
                        Mudah Hari Ini
                    </h2>
                    <p class="text-lg md:text-xl text-white/90 mb-10 max-w-2xl mx-auto">
                        Login sekarang dan nikmati kemudahan transaksi BMT SMKN 11 Bandung dalam genggaman Anda
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('login') }}" class="group inline-flex items-center gap-2 px-8 py-4 bg-white text-primary-700 font-black rounded-2xl hover:shadow-2xl hover:scale-105 transition-all">
                            Login Sekarang
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white/20 backdrop-blur text-white font-black rounded-2xl hover:bg-white/30 transition border-2 border-white/30">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-slate-900 text-slate-300 pt-20 pb-8 relative overflow-hidden">
        <!-- Background glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <!-- Brand -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="relative">
                            <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/40">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="font-black text-xl text-white">Smart Pocket</div>
                            <div class="text-xs text-slate-400">BMT • SMKN 11 Bandung</div>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 max-w-md mb-6 leading-relaxed">
                        Platform dompet digital resmi BMT Bank Mini Terpadu SMKN 11 Bandung untuk memudahkan siswa dan guru dalam mengelola keuangan.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:gradient-bg rounded-xl flex items-center justify-center transition group">
                            <svg class="w-5 h-5 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:gradient-bg rounded-xl flex items-center justify-center transition group">
                            <svg class="w-5 h-5 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:gradient-bg rounded-xl flex items-center justify-center transition group">
                            <svg class="w-5 h-5 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-red-600 hover:bg-red-700 rounded-xl flex items-center justify-center transition">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-black text-white mb-5">Menu</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#home" class="hover:text-primary-400 transition">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-primary-400 transition">Fitur</a></li>
                        <li><a href="#tentang" class="hover:text-primary-400 transition">Tentang</a></li>
                        <li><a href="#cara-kerja" class="hover:text-primary-400 transition">Cara Kerja</a></li>
                        <li><a href="#faq" class="hover:text-primary-400 transition">FAQ</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-black text-white mb-5">Kontak</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Jl. Raya Cibeureum No.52, Bandung</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>info@smkn11bandung.sch.id</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>(022) 123-4567</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-400">
                    &copy; {{ date('Y') }} Smart Pocket - BMT SMKN 11 Bandung. All rights reserved.
                </p>
                <div class="flex gap-6 text-sm text-slate-400">
                    <a href="#" class="hover:text-primary-400 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-primary-400 transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>