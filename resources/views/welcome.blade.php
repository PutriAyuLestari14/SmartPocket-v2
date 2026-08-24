<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Pocket - BMT SMKN 11 Bandung</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0',
                            300: '#6ee7b7', 400: '#34d399', 500: '#10b981',
                            600: '#059669', 700: '#047857', 800: '#065f46', 900: '#064e3b',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delay': 'float 6s ease-in-out 2s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .card-grad-1 { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
        .card-grad-2 { background: linear-gradient(135deg, #047857 0%, #059669 100%); }
        .card-grad-3 { background: linear-gradient(135deg, #064e3b 0%, #065f46 100%); }
        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .gradient-text { background: linear-gradient(135deg, #059669 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased overflow-x-hidden">

    <!-- NAVBAR -->
    <nav class="fixed top-0 w-full z-50 glass border-b border-slate-100 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 card-grad-1 rounded-xl flex items-center justify-center shadow-lg shadow-brand-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-extrabold text-lg tracking-tight">Smart Pocket</div>
                        <div class="text-[10px] text-slate-500 font-medium -mt-1">BMT SMKN 11 BANDUNG</div>
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-1 bg-slate-50 p-1 rounded-full border border-slate-100">
                    <a href="#home" class="px-5 py-2 text-sm font-semibold text-slate-900 bg-white rounded-full shadow-sm">Beranda</a>
                    <a href="#fitur" class="px-5 py-2 text-sm font-medium text-slate-600 hover:text-brand-600 transition">Fitur</a>
                    <a href="#tentang" class="px-5 py-2 text-sm font-medium text-slate-600 hover:text-brand-600 transition">Tentang</a>
                    <a href="#faq" class="px-5 py-2 text-sm font-medium text-slate-600 hover:text-brand-600 transition">FAQ</a>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="hidden sm:block text-sm font-semibold text-slate-700 hover:text-brand-600 transition">Masuk</a>
                    <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-bold text-white card-grad-1 rounded-full shadow-lg shadow-brand-500/30 hover:shadow-xl hover:shadow-brand-500/40 hover:-translate-y-0.5 transition-all">Login Akun</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section id="home" class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden bg-gradient-to-b from-brand-50/50 to-white">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-200/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-brand-100/50 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                
                <div class="reveal">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white border border-brand-100 rounded-full shadow-sm mb-8">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                        </span>
                        <span class="text-xs font-bold text-brand-700 uppercase tracking-wider">Platform Resmi BMT</span>
                    </div>

                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-black leading-[1.1] tracking-tight mb-6">
                        Dompet Digital <br>
                        <span class="gradient-text">Cerdas & Modern</span> <br>
                        untuk Siswa.
                    </h1>

                    <p class="text-lg text-slate-600 mb-10 max-w-lg leading-relaxed">
                        Kelola keuangan BMT SMKN 11 Bandung dengan mudah. Ajukan penarikan, peminjaman, dan cek saldo kapan saja dalam satu aplikasi.
                    </p>

                    <div class="flex flex-wrap gap-4 mb-12">
                        <a href="{{ route('login') }}" class="group inline-flex items-center gap-2 px-8 py-4 font-bold text-white card-grad-1 rounded-full shadow-xl shadow-brand-500/30 hover:shadow-2xl hover:shadow-brand-500/40 transition-all">
                            Mulai Sekarang
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </a>
                        <a href="#fitur" class="inline-flex items-center gap-2 px-8 py-4 font-bold text-slate-700 bg-white border-2 border-slate-100 rounded-full hover:border-brand-300 hover:text-brand-600 transition-all">
                            Pelajari Fitur
                        </a>
                    </div>

                    <div class="flex items-center gap-8 pt-8 border-t border-slate-100">
                        <div>
                            <div class="text-3xl font-black text-slate-900">550+</div>
                            <div class="text-sm text-slate-500 font-medium">Siswa Aktif</div>
                        </div>
                        <div class="w-px h-10 bg-slate-200"></div>
                        <div>
                            <div class="text-3xl font-black text-slate-900">Rp 50M</div>
                            <div class="text-sm text-slate-500 font-medium">Dana Terkelola</div>
                        </div>
                        <div class="w-px h-10 bg-slate-200"></div>
                        <div>
                            <div class="text-3xl font-black text-slate-900">100%</div>
                            <div class="text-sm text-slate-500 font-medium">Aman</div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Preview -->
                <div class="reveal relative">
                    <div class="relative w-full max-w-lg mx-auto">
                        <div class="bg-white rounded-3xl shadow-2xl shadow-brand-900/10 border border-slate-100 p-8 relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <p class="text-xs text-slate-500 font-medium">Selamat datang 👋</p>
                                    <p class="text-lg font-bold text-slate-900">Ahmad Fauzi</p>
                                </div>
                                <div class="w-12 h-12 card-grad-1 rounded-full flex items-center justify-center text-white font-bold shadow-lg shadow-brand-500/30">A</div>
                            </div>

                            <div class="card-grad-1 rounded-2xl p-6 text-white mb-6 relative overflow-hidden">
                                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full"></div>
                                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full"></div>
                                <div class="relative">
                                    <p class="text-xs opacity-80 mb-1">Saldo BMT Anda</p>
                                    <p class="text-3xl font-black mb-4">Rp 1.250.000</p>
                                    <div class="flex gap-2">
                                        <button class="flex-1 bg-white text-brand-700 text-xs font-bold py-2.5 rounded-xl hover:scale-105 transition">Tarik</button>
                                        <button class="flex-1 bg-white/20 backdrop-blur text-xs font-bold py-2.5 rounded-xl hover:bg-white/30 transition">Pinjam</button>
                                        <button class="flex-1 bg-white/20 backdrop-blur text-xs font-bold py-2.5 rounded-xl hover:bg-white/30 transition">Riwayat</button>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-3 mb-6">
                                <div class="text-center">
                                    <div class="w-12 h-12 mx-auto bg-brand-50 rounded-xl flex items-center justify-center mb-2">
                                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-700">Saldo</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-12 h-12 mx-auto bg-emerald-50 rounded-xl flex items-center justify-center mb-2">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-700">Tarik</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-12 h-12 mx-auto bg-teal-50 rounded-xl flex items-center justify-center mb-2">
                                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-700">Pinjam</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-12 h-12 mx-auto bg-cyan-50 rounded-xl flex items-center justify-center mb-2">
                                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-700">Laporan</p>
                                </div>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <p class="text-sm font-bold text-slate-900">Transaksi Terbaru</p>
                                    <a href="#" class="text-xs font-semibold text-brand-600">Lihat semua</a>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-3 p-2 bg-white rounded-xl">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs font-semibold text-slate-900">Penarikan Dana</p>
                                            <p class="text-[10px] text-slate-500">Hari ini, 10:30</p>
                                        </div>
                                        <p class="text-xs font-bold text-green-600">+Rp 200K</p>
                                    </div>
                                    <div class="flex items-center gap-3 p-2 bg-white rounded-xl">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs font-semibold text-slate-900">Peminjaman</p>
                                            <p class="text-[10px] text-slate-500">Kemarin, 14:20</p>
                                        </div>
                                        <p class="text-xs font-bold text-blue-600">-Rp 500K</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -top-4 -left-4 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3 border border-slate-100 animate-float">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Transaksi</p>
                                <p class="text-sm font-bold text-slate-900">Berhasil ✓</p>
                            </div>
                        </div>

                        <div class="absolute -bottom-4 -right-4 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3 border border-slate-100 animate-float-delay">
                            <div class="w-10 h-10 bg-brand-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
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
    </section>

    <!-- FEATURES -->
    <section id="fitur" class="py-24 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20 reveal">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand-50 border border-brand-100 rounded-full mb-6">
                    <span class="text-xs font-bold text-brand-700 uppercase tracking-wider">Fitur Unggulan</span>
                </div>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight mb-6">
                    Semua kebutuhan <br><span class="gradient-text">keuangan dalam satu tempat.</span>
                </h2>
                <p class="text-lg text-slate-600">Dirancang khusus untuk memudahkan siswa dan guru SMKN 11 Bandung.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="reveal md:col-span-2 bg-slate-900 rounded-[2rem] p-10 text-white relative overflow-hidden group hover:scale-[1.02] transition-transform duration-500">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 group-hover:bg-brand-500/30 transition-colors"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur rounded-2xl flex items-center justify-center mb-6 border border-white/10">
                            <svg class="w-7 h-7 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                        </div>
                        <h3 class="text-3xl font-black mb-4">Cek Saldo Real-time</h3>
                        <p class="text-slate-300 text-lg mb-8 max-w-md">Pantau saldo BMT Anda kapan saja dengan update langsung. Lihat riwayat transaksi dengan detail yang transparan.</p>
                        <div class="flex flex-wrap gap-3">
                            <span class="px-4 py-2 bg-white/10 backdrop-blur rounded-full text-sm font-semibold border border-white/10">✓ Live Update</span>
                            <span class="px-4 py-2 bg-white/10 backdrop-blur rounded-full text-sm font-semibold border border-white/10">✓ Export PDF</span>
                            <span class="px-4 py-2 bg-white/10 backdrop-blur rounded-full text-sm font-semibold border border-white/10">✓ Notifikasi</span>
                        </div>
                    </div>
                </div>

                <div class="reveal bg-brand-50 rounded-[2rem] p-8 border border-brand-100 group hover:border-brand-300 transition-colors">
                    <div class="w-14 h-14 card-grad-1 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-brand-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                    </div>
                    <h3 class="text-2xl font-black mb-3 text-slate-900">Penarikan Dana</h3>
                    <p class="text-slate-600 mb-6">Ajukan penarikan kapan saja. Proses cepat dan langsung disetujui admin.</p>
                    <a href="#" class="inline-flex items-center gap-2 text-brand-600 font-bold text-sm group-hover:gap-3 transition-all">
                        Selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>

                <div class="reveal bg-slate-50 rounded-[2rem] p-8 border border-slate-100 group hover:border-brand-200 hover:bg-white transition-all">
                    <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    </div>
                    <h3 class="text-2xl font-black mb-3 text-slate-900">Peminjaman</h3>
                    <p class="text-slate-600 mb-6">Ajukan pinjaman dana darurat dengan syarat mudah dan cicilan fleksibel.</p>
                    <a href="#" class="inline-flex items-center gap-2 text-brand-600 font-bold text-sm group-hover:gap-3 transition-all">
                        Selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>

                <div class="reveal md:col-span-2 bg-gradient-to-br from-brand-500 to-brand-700 rounded-[2rem] p-10 text-white relative overflow-hidden group hover:scale-[1.02] transition-transform duration-500">
                    <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
                    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
                        <div>
                            <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mb-6 border border-white/20">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            </div>
                            <h3 class="text-3xl font-black mb-4">Keamanan Tingkat Bank</h3>
                            <p class="text-white/90 text-lg max-w-md">Data Anda dilindungi dengan enkripsi end-to-end. Transaksi aman, data terjaga privasinya.</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 w-full md:w-auto">
                            <div class="bg-white/10 backdrop-blur rounded-2xl p-4 border border-white/20">
                                <p class="text-2xl font-black">256-bit</p>
                                <p class="text-xs text-white/70">SSL Encryption</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur rounded-2xl p-4 border border-white/20">
                                <p class="text-2xl font-black">2FA</p>
                                <p class="text-xs text-white/70">Authentication</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="tentang" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20 reveal">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white border border-slate-200 rounded-full mb-6 shadow-sm">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Tentang Kami</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black tracking-tight mb-6">BMT Bank Mini Terpadu <br><span class="gradient-text">SMKN 11 Bandung</span></h2>
                <p class="text-lg text-slate-600">Platform dompet digital resmi untuk siswa dan guru.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="reveal bg-white rounded-3xl p-8 border border-slate-100 hover:border-brand-200 transition">
                    <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="text-xl font-black mb-3">Literasi Finansial</h3>
                    <p class="text-slate-600 text-sm">Membangun kebiasaan menabung dan mengelola uang sejak dini.</p>
                </div>

                <div class="reveal bg-white rounded-3xl p-8 border border-slate-100 hover:border-brand-200 transition" style="transition-delay: 100ms;">
                    <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    </div>
                    <h3 class="text-xl font-black mb-3">Aman & Terpercaya</h3>
                    <p class="text-slate-600 text-sm">Dikelola langsung oleh sekolah dengan sistem yang transparan.</p>
                </div>

                <div class="reveal bg-white rounded-3xl p-8 border border-slate-100 hover:border-brand-200 transition" style="transition-delay: 200ms;">
                    <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-black mb-3">Cepat & Praktis</h3>
                    <p class="text-slate-600 text-sm">Transaksi kapan saja tanpa perlu antre di bank mini.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20 reveal">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand-50 border border-brand-100 rounded-full mb-6">
                    <span class="text-xs font-bold text-brand-700 uppercase tracking-wider">Cara Kerja</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black tracking-tight mb-6">Mulai dalam 3 langkah mudah</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="reveal text-center">
                    <div class="w-24 h-24 mx-auto bg-white rounded-3xl flex items-center justify-center shadow-xl shadow-brand-900/5 border border-slate-100 mb-6 relative">
                        <span class="text-4xl font-black gradient-text">01</span>
                    </div>
                    <h3 class="text-xl font-black mb-3">Login Akun</h3>
                    <p class="text-slate-600 text-sm max-w-xs mx-auto">Masuk menggunakan NIS (siswa) atau NIP (guru) yang telah didaftarkan.</p>
                </div>

                <div class="reveal text-center" style="transition-delay: 100ms;">
                    <div class="w-24 h-24 mx-auto bg-white rounded-3xl flex items-center justify-center shadow-xl shadow-brand-900/5 border border-slate-100 mb-6">
                        <span class="text-4xl font-black gradient-text">02</span>
                    </div>
                    <h3 class="text-xl font-black mb-3">Pilih Layanan</h3>
                    <p class="text-slate-600 text-sm max-w-xs mx-auto">Pilih fitur: cek saldo, tarik dana, atau ajukan pinjaman.</p>
                </div>

                <div class="reveal text-center" style="transition-delay: 200ms;">
                    <div class="w-24 h-24 mx-auto card-grad-1 rounded-3xl flex items-center justify-center shadow-xl shadow-brand-500/30 mb-6">
                        <span class="text-4xl font-black text-white">03</span>
                    </div>
                    <h3 class="text-xl font-black mb-3">Selesai! 🎉</h3>
                    <p class="text-slate-600 text-sm max-w-xs mx-auto">Transaksi diproses dan Anda menerima notifikasi real-time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white border border-slate-200 rounded-full mb-6 shadow-sm">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Testimoni</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black tracking-tight">Apa kata mereka?</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="reveal bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand-200 transition-colors">
                    <div class="flex gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-700 mb-6 leading-relaxed">"Smart Pocket bikin saya gampang cek saldo BMT tanpa harus ke bank mini. Aplikasinya cepat dan mudah digunakan!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 card-grad-1 rounded-full flex items-center justify-center text-white font-bold">R</div>
                        <div>
                            <p class="font-bold text-slate-900">Rina Safitri</p>
                            <p class="text-xs text-slate-500">Siswa Kelas XI RPL</p>
                        </div>
                    </div>
                </div>

                <div class="reveal bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand-200 transition-colors" style="transition-delay: 100ms;">
                    <div class="flex gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-700 mb-6 leading-relaxed">"Fitur peminjaman sangat membantu saat ada kebutuhan mendesak. Prosesnya cepat dan transparan. Recommended!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 card-grad-2 rounded-full flex items-center justify-center text-white font-bold">B</div>
                        <div>
                            <p class="font-bold text-slate-900">Budi Santoso, S.Pd</p>
                            <p class="text-xs text-slate-500">Guru Produktif</p>
                        </div>
                    </div>
                </div>

                <div class="reveal bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-brand-200 transition-colors" style="transition-delay: 200ms;">
                    <div class="flex gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-700 mb-6 leading-relaxed">"Sebagai guru, saya bisa pantau transaksi siswa dengan mudah. Smart Pocket membantu literasi finansial sejak dini."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 card-grad-3 rounded-full flex items-center justify-center text-white font-bold">S</div>
                        <div>
                            <p class="font-bold text-slate-900">Siti Nurhaliza, M.Pd</p>
                            <p class="text-xs text-slate-500">Kepala BMT</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand-50 border border-brand-100 rounded-full mb-6">
                    <span class="text-xs font-bold text-brand-700 uppercase tracking-wider">FAQ</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black tracking-tight">Pertanyaan Umum</h2>
            </div>

            <div class="space-y-4">
                <div class="reveal bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex items-center justify-between p-6 text-left hover:bg-slate-100 transition" onclick="toggleFaq(this)">
                        <span class="font-bold text-slate-900 pr-4">Siapa saja yang bisa menggunakan Smart Pocket?</span>
                        <svg class="faq-icon w-5 h-5 text-brand-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-content px-6 pb-0 max-h-0 overflow-hidden transition-all duration-300">
                        <p class="text-slate-600 pb-6">Smart Pocket dapat digunakan oleh seluruh siswa-siswi dan guru SMKN 11 Bandung yang telah terdaftar sebagai anggota BMT Bank Mini Terpadu.</p>
                    </div>
                </div>

                <div class="reveal bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden" style="transition-delay: 100ms;">
                    <button class="faq-btn w-full flex items-center justify-between p-6 text-left hover:bg-slate-100 transition" onclick="toggleFaq(this)">
                        <span class="font-bold text-slate-900 pr-4">Bagaimana cara mendaftar Smart Pocket?</span>
                        <svg class="faq-icon w-5 h-5 text-brand-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-content px-6 pb-0 max-h-0 overflow-hidden transition-all duration-300">
                        <p class="text-slate-600 pb-6">Pendaftaran dilakukan oleh admin sekolah. Setelah terdaftar, Anda akan menerima NIS/NIP dan password awal untuk login pertama kali.</p>
                    </div>
                </div>

                <div class="reveal bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden" style="transition-delay: 200ms;">
                    <button class="faq-btn w-full flex items-center justify-between p-6 text-left hover:bg-slate-100 transition" onclick="toggleFaq(this)">
                        <span class="font-bold text-slate-900 pr-4">Apakah data saya aman di Smart Pocket?</span>
                        <svg class="faq-icon w-5 h-5 text-brand-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-content px-6 pb-0 max-h-0 overflow-hidden transition-all duration-300">
                        <p class="text-slate-600 pb-6">Ya, sangat aman. Smart Pocket menggunakan enkripsi SSL 256-bit dan autentikasi dua faktor (2FA) untuk melindungi data dan transaksi Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-slate-50">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="reveal relative card-grad-1 rounded-[3rem] p-12 md:p-20 overflow-hidden text-center">
                <div class="absolute -top-20 -right-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 tracking-tight">Siap Kelola Keuangan <br>Lebih Mudah?</h2>
                    <p class="text-lg text-white/90 mb-10 max-w-2xl mx-auto">Login sekarang dan nikmati kemudahan transaksi BMT SMKN 11 Bandung dalam genggaman Anda.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('login') }}" class="group inline-flex items-center gap-2 px-8 py-4 bg-white text-brand-700 font-black rounded-full hover:shadow-2xl hover:scale-105 transition-all">
                            Login Sekarang
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-white/20 backdrop-blur text-white font-black rounded-full hover:bg-white/30 transition border border-white/30">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 card-grad-1 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                        </div>
                        <div class="text-white font-extrabold text-lg">Smart Pocket</div>
                    </div>
                    <p class="text-sm max-w-sm leading-relaxed mb-6">Platform dompet digital resmi BMT Bank Mini Terpadu SMKN 11 Bandung untuk memudahkan siswa dan guru.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-brand-600 rounded-xl flex items-center justify-center transition text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-brand-600 rounded-xl flex items-center justify-center transition text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Menu</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#home" class="hover:text-brand-400 transition">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-brand-400 transition">Fitur</a></li>
                        <li><a href="#tentang" class="hover:text-brand-400 transition">Tentang</a></li>
                        <li><a href="#faq" class="hover:text-brand-400 transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Kontak</h4>
                    <ul class="space-y-4 text-sm">
                        <li>Jl. Raya Cibeureum No.52, Bandung</li>
                        <li>info@smkn11bandung.sch.id</li>
                        <li>(022) 123-4567</li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <p>&copy; {{ date('Y') }} Smart Pocket - BMT SMKN 11 Bandung. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-brand-400 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-brand-400 transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('active');
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) navbar.classList.add('shadow-lg', 'bg-white/90');
            else navbar.classList.remove('shadow-lg', 'bg-white/90');
        });

        function toggleFaq(btn) {
            const item = btn.parentElement;
            const content = item.querySelector('.faq-content');
            const icon = btn.querySelector('.faq-icon');
            const isOpen = item.classList.contains('open');

            document.querySelectorAll('.bg-slate-50.rounded-2xl').forEach(i => {
                i.classList.remove('open');
                i.querySelector('.faq-content').style.maxHeight = null;
                i.querySelector('.faq-icon').style.transform = 'rotate(0deg)';
            });

            if (!isOpen) {
                item.classList.add('open');
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
            }
        }
    </script>
</body>
</html>