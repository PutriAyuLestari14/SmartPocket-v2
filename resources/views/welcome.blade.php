<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartPocket - BMT SMKN 11 Bandung</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        .hero-bg {
            background-image: url('/images/gedung-bmt.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero-overlay {
            background:
                linear-gradient(
                    to bottom,
                    rgba(0, 0, 0, 0.72) 0%,
                    rgba(0, 0, 0, 0.38) 45%,
                    rgba(0, 0, 0, 0.52) 100%
                );
        }

        .topbar {
            background: #15803d;
        }

        .nav-glass {
            background: rgba(0, 0, 0, 0.18);
            backdrop-filter: blur(5px);
        }

        .btn-primary {
            background: #15803d;
            transition: .25s ease;
        }

        .btn-primary:hover {
            background: #166534;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(21, 128, 61, .30);
        }

        .btn-light {
            background: white;
            color: #15803d;
            transition: .25s ease;
        }

        .btn-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, .18);
        }

        .floating-card {
            box-shadow: 0 15px 40px rgba(0, 0, 0, .16);
        }

        .feature-card {
            transition: .25s ease;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, .10);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <!-- TOP BAR -->
    <div class="topbar h-9 flex items-center justify-end px-6 md:px-12">
        <div class="flex items-center gap-4 text-white">
            <span class="text-xs font-medium opacity-90">BMT SMKN 11 BANDUNG</span>
            <span class="h-4 w-px bg-white/30"></span>
            <span class="text-xs opacity-90">Smart Financial Service</span>
        </div>
    </div>

    <!-- HERO -->
    <section class="relative min-h-[760px] md:min-h-screen hero-bg">

        <div class="absolute inset-0 hero-overlay"></div>

        <!-- NAVBAR -->
        <nav class="relative z-20 nav-glass border-b border-white/10">
            <div class="max-w-7xl mx-auto px-5 md:px-10">
                <div class="h-24 flex items-center justify-between">

                    <!-- BRAND -->
                    <a href="#" class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-lg">
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-green-700 to-green-500 flex items-center justify-center">
                                <span class="text-white text-sm font-black">SP</span>
                            </div>
                        </div>

                        <div class="leading-tight">
                            <h1 class="text-white text-xl font-extrabold">SmartPocket</h1>
                            <p class="text-white/75 text-xs font-medium">BMT SMKN 11 Bandung</p>
                        </div>
                    </a>

                    <!-- MENU -->
                    <div class="hidden lg:flex items-center gap-8">
                        <a href="#" class="text-white font-semibold text-sm hover:text-green-200 transition">Beranda</a>
                        <a href="#tentang" class="text-white/90 font-medium text-sm hover:text-white transition">Tentang BMT</a>
                        <a href="#layanan" class="text-white/90 font-medium text-sm hover:text-white transition">Layanan</a>
                        <a href="#fitur" class="text-white/90 font-medium text-sm hover:text-white transition">Fitur</a>
                        <a href="#kontak" class="text-white/90 font-medium text-sm hover:text-white transition">Kontak</a>
                    </div>

                    <!-- LOGIN -->
                    <a href="{{ route('login') }}"
                       class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white text-green-700 text-sm font-bold hover:bg-green-50 transition">
                        Masuk
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>

                </div>
            </div>
        </nav>

        <!-- HERO CONTENT -->
        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center pt-28 md:pt-32 pb-48">

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm mb-7">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                <span class="text-white text-xs md:text-sm font-semibold tracking-wide">
                    BANK MINI TERPADU SMKN 11 BANDUNG
                </span>
            </div>

            <h2 class="text-5xl md:text-7xl lg:text-8xl font-black text-white tracking-tight leading-none">
                SmartPocket
            </h2>

            <p class="mt-5 text-xl md:text-2xl text-white/95 font-medium">
                Solusi Digital BMT SMKN 11 Bandung
            </p>

            <p class="mt-6 max-w-3xl mx-auto text-base md:text-lg text-white/80 leading-relaxed">
                Kelola tabungan, transaksi, dan layanan keuangan BMT dengan lebih mudah,
                cepat, transparan, dan terintegrasi dalam satu platform digital.
            </p>

            <div class="mt-9 flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="{{ route('register') }}"
                   class="btn-primary px-8 py-4 rounded-full text-white font-bold text-base flex items-center gap-2">
                    Mulai Sekarang
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>

                <a href="#fitur"
                   class="btn-light px-8 py-4 rounded-full font-bold text-base">
                    Lihat Layanan
                </a>
            </div>
        </div>

        <!-- FLOATING INFORMATION CARD -->
        <div class="absolute z-20 left-1/2 -translate-x-1/2 bottom-[-72px] w-[92%] max-w-6xl">
            <div class="floating-card bg-white rounded-3xl p-5 md:p-7">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <div class="flex items-center gap-4 lg:border-r border-slate-200">
                        <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2m9-4a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">Tabungan</p>
                            <p class="text-sm text-slate-500">Kelola saldo dengan mudah</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 lg:border-r border-slate-200">
                        <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">Transaksi</p>
                            <p class="text-sm text-slate-500">Catatan transaksi lebih rapi</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 lg:border-r border-slate-200">
                        <div class="w-12 h-12 rounded-2xl bg-yellow-50 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">Real-time</p>
                            <p class="text-sm text-slate-500">Informasi saldo lebih cepat</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">Aman</p>
                            <p class="text-sm text-slate-500">Data dan transaksi terlindungi</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- TENTANG -->
    <section id="tentang" class="pt-40 pb-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                <div>
                    <p class="text-green-600 font-bold text-sm uppercase tracking-wider mb-3">
                        Tentang SmartPocket
                    </p>

                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight">
                        BMT sekolah yang lebih
                        <span class="text-green-600">modern dan terintegrasi.</span>
                    </h2>

                    <p class="mt-6 text-slate-600 leading-relaxed text-lg">
                        SmartPocket merupakan platform digital untuk mendukung pengelolaan
                        BMT SMKN 11 Bandung agar proses tabungan, transaksi, dan layanan
                        keuangan dapat dilakukan secara lebih praktis dan terorganisir.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div class="rounded-3xl bg-green-50 p-7">
                        <p class="text-4xl font-black text-green-700">01</p>
                        <p class="mt-3 font-bold text-slate-900">Digital</p>
                        <p class="mt-1 text-sm text-slate-600">Proses BMT lebih mudah diakses.</p>
                    </div>

                    <div class="rounded-3xl bg-green-50 p-7">
                        <p class="text-4xl font-black text-green-700">02</p>
                        <p class="mt-3 font-bold text-slate-900">Transparan</p>
                        <p class="mt-1 text-sm text-slate-600">Riwayat transaksi lebih jelas.</p>
                    </div>

                    <div class="rounded-3xl bg-yellow-50 p-7">
                        <p class="text-4xl font-black text-yellow-700">03</p>
                        <p class="mt-3 font-bold text-slate-900">Efisien</p>
                        <p class="mt-1 text-sm text-slate-600">Mengurangi proses manual.</p>
                    </div>

                    <div class="rounded-3xl bg-purple-50 p-7">
                        <p class="text-4xl font-black text-purple-700">04</p>
                        <p class="mt-3 font-bold text-slate-900">Terintegrasi</p>
                        <p class="mt-1 text-sm text-slate-600">Informasi berada dalam satu sistem.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- LAYANAN / FITUR -->
    <section id="layanan" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="text-green-600 font-bold text-sm uppercase tracking-wider mb-3">
                    Layanan SmartPocket
                </p>
                <h2 class="text-4xl md:text-5xl font-black text-slate-900">
                    Semua kebutuhan BMT dalam satu platform
                </h2>
                <p class="mt-5 text-slate-600">
                    Dirancang untuk membantu nasabah, operator, dan admin mengelola
                    aktivitas BMT dengan lebih praktis.
                </p>
            </div>

            <div id="fitur" class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">

                <div class="feature-card bg-white rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2m9-4a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Tabungan Digital</h3>
                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Memudahkan pengguna melihat dan mengelola informasi tabungan
                        dalam satu sistem.
                    </p>
                </div>

                <div class="feature-card bg-white rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                  d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Transaksi Online</h3>
                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Pencatatan transaksi dibuat lebih cepat dan terstruktur sehingga
                        memudahkan pengelolaan data.
                    </p>
                </div>

                <div class="feature-card bg-white rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Notifikasi</h3>
                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Informasi penting mengenai transaksi dan aktivitas BMT dapat
                        disampaikan dengan lebih cepat.
                    </p>
                </div>

                <div class="feature-card bg-white rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Verifikasi</h3>
                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Membantu operator memeriksa dan memvalidasi transaksi agar
                        pengelolaan data lebih terkontrol.
                    </p>
                </div>

                <div class="feature-card bg-white rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Keamanan Data</h3>
                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Informasi akun dan transaksi dikelola melalui sistem dengan
                        autentikasi pengguna.
                    </p>
                </div>

                <div class="feature-card bg-white rounded-3xl p-8">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                  d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h2a2 2 0 012 2v6zm6 0a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2a2 2 0 00-2 2v12z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Laporan BMT</h3>
                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Data aktivitas BMT dapat dirangkum sehingga membantu operator
                        dan admin memantau kondisi layanan.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-green-700">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-black text-white">
                Kelola BMT dengan lebih mudah bersama SmartPocket
            </h2>
            <p class="mt-5 text-white/80 text-lg max-w-2xl mx-auto">
                Satu platform untuk membantu menciptakan pengelolaan BMT SMKN 11 Bandung
                yang lebih praktis, tertata, dan modern.
            </p>

            <a href="{{ route('register') }}"
               class="inline-flex mt-8 px-8 py-4 rounded-full bg-white text-green-700 font-bold hover:bg-green-50 transition">
                Daftar Sekarang
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="kontak" class="bg-slate-950 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">

            <div class="grid md:grid-cols-3 gap-10">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-green-600 flex items-center justify-center">
                            <span class="font-black">SP</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">SmartPocket</h3>
                            <p class="text-xs text-slate-400">BMT SMKN 11 Bandung</p>
                        </div>
                    </div>

                    <p class="mt-5 text-sm text-slate-400 leading-relaxed max-w-sm">
                        Platform digital untuk mendukung pengelolaan layanan dan transaksi
                        BMT SMKN 11 Bandung.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Navigasi</h4>
                    <div class="space-y-3 text-sm text-slate-400">
                        <a href="#" class="block hover:text-white">Beranda</a>
                        <a href="#tentang" class="block hover:text-white">Tentang BMT</a>
                        <a href="#fitur" class="block hover:text-white">Fitur</a>
                        <a href="#kontak" class="block hover:text-white">Kontak</a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold mb-4">BMT SMKN 11 Bandung</h4>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        SmartPocket — Bank Mini Terpadu untuk mendukung layanan keuangan
                        di lingkungan SMKN 11 Bandung.
                    </p>
                </div>
            </div>

            <div class="border-t border-white/10 mt-10 pt-6 text-center text-sm text-slate-500">
                © 2026 SmartPocket - BMT SMKN 11 Bandung
            </div>
        </div>
    </footer>

</body>
</html>