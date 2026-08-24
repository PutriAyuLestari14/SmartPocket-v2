<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Smart Pocket</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400;500;600;700;800;900" rel="stylesheet" />

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
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%); }
        .gradient-text {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px) saturate(180%);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

    <!-- Background mesh -->
    <div class="fixed inset-0 -z-10">
        <div class="mesh-gradient">
            <div class="mesh-blob mesh-blob-1"></div>
            <div class="mesh-blob mesh-blob-2"></div>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar-main fixed top-0 w-full z-50 glass border-b border-white/20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="w-11 h-11 gradient-bg rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/40">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-extrabold text-lg text-slate-800 leading-tight">Smart Pocket</div>
                        <div class="text-xs text-slate-500 leading-tight">BMT • SMKN 11 Bandung</div>
                    </div>
                </a>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:text-primary-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white gradient-bg rounded-xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <section class="pt-32 pb-20 relative">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="reveal inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur border border-primary-100 rounded-full mb-6 shadow-sm">
                    <span class="text-sm font-semibold text-primary-700">📞 Hubungi Kami</span>
                </div>
                <h1 class="reveal reveal-delay-1 text-5xl md:text-6xl font-black text-slate-900 mb-6 text-balance">
                    Ada Pertanyaan? <br>
                    <span class="animated-gradient-text">Kami Siap Membantu</span>
                </h1>
                <p class="reveal reveal-delay-2 text-lg text-slate-600">
                    Tim BMT SMKN 11 Bandung siap membantu Anda dalam menggunakan Smart Pocket
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Contact Info Cards -->
                <div class="space-y-4">
                    <div class="reveal bento-card bg-white/80 backdrop-blur rounded-3xl p-6 border border-slate-100">
                        <div class="w-14 h-14 gradient-bg rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-primary-500/30">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-black text-slate-900 mb-2 text-lg">Alamat</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            SMKN 11 Bandung<br>
                            Jl. Raya Cibeureum No.52<br>
                            Bandung, Jawa Barat
                        </p>
                    </div>

                    <div class="reveal reveal-delay-1 bento-card bg-white/80 backdrop-blur rounded-3xl p-6 border border-slate-100">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-emerald-500/30">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <h3 class="font-black text-slate-900 mb-2 text-lg">Telepon</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            (022) 123-4567<br>
                            Senin - Jumat<br>
                            08.00 - 16.00 WIB
                        </p>
                    </div>

                    <div class="reveal reveal-delay-2 bento-card bg-white/80 backdrop-blur rounded-3xl p-6 border border-slate-100">
                        <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-teal-500/30">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="font-black text-slate-900 mb-2 text-lg">Email</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            info@smkn11bandung.sch.id<br>
                            bmt@smkn11bandung.sch.id
                        </p>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="reveal lg:col-span-2 bg-white/80 backdrop-blur rounded-3xl p-8 md:p-10 border border-slate-100 shadow-xl shadow-slate-100">
                    <h2 class="text-3xl font-black text-slate-900 mb-2">Kirim Pesan</h2>
                    <p class="text-slate-600 mb-8">Isi form di bawah dan kami akan segera merespon</p>

                    <form class="space-y-5">
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                                <input type="text" class="w-full px-5 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-primary-500 focus:outline-none transition" placeholder="Nama Anda">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">NIS / NIP</label>
                                <input type="text" class="w-full px-5 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-primary-500 focus:outline-none transition" placeholder="NIS untuk siswa / NIP untuk guru">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                            <input type="email" class="w-full px-5 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-primary-500 focus:outline-none transition" placeholder="email@anda.com">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                            <select class="w-full px-5 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-primary-500 focus:outline-none transition">
                                <option>Pertanyaan Umum</option>
                                <option>Masalah Login</option>
                                <option>Masalah Penarikan</option>
                                <option>Masalah Peminjaman</option>
                                <option>Saran & Masukan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pesan</label>
                            <textarea rows="5" class="w-full px-5 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-primary-500 focus:outline-none transition resize-none" placeholder="Tuliskan pesan Anda di sini..."></textarea>
                        </div>

                        <button type="submit" class="group relative w-full inline-flex items-center justify-center gap-2 px-6 py-4 font-black text-white rounded-xl overflow-hidden shadow-xl shadow-primary-500/30 hover:shadow-2xl hover:shadow-primary-500/50 transition-all">
                            <span class="absolute inset-0 gradient-bg"></span>
                            <span class="absolute inset-0 bg-gradient-to-r from-primary-700 to-primary-500 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            <span class="relative flex items-center gap-2">
                                Kirim Pesan
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 py-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center text-sm">
            &copy; {{ date('Y') }} Smart Pocket - BMT SMKN 11 Bandung. All rights reserved.
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>