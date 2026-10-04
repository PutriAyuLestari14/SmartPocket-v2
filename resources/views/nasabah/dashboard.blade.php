<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Smart Pocket BMT SMKN 11 Bandung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bgMain: '#FAFAFA',
                        primary: '#15803d',
                        primaryDark: '#166534',
                        primaryLight: '#16a34a',
                        secondary: '#22c55e',
                        accent: '#4ade80',
                        mint: '#15803d',
                        mintLight: '#dcfce7',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FAFAFA; font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #FAFAFA; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }

        /* Variasi Gradient yang TIDAK MONOTON */
        .gradient-primary { 
            background: linear-gradient(135deg, #15803d 0%, #166534 100%); 
            box-shadow: 0 12px 28px -6px rgba(21, 128, 61, 0.25); 
        }
        .gradient-soft { 
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%); 
        }
        /* ⬇️ INI YANG SEMULANYA HILANG — WAJIB ADA KARENA DIPAKAI DI SIDEBAR & AVATAR ⬇️ */
        .gradient-vibrant { 
            background: linear-gradient(135deg, #15803d 0%, #16a34a 50%, #22c55e 100%); 
        }
        .gradient-mint { 
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); 
        }
        .gradient-fresh { 
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); 
        }

        .card-peminjaman {
            background: #FFFFFF;
            border: 1.5px solid #15803d;
            box-shadow: 0 10px 25px -5px rgba(21, 128, 61, 0.08);
        }

        .chip {
            background: linear-gradient(135deg, #FCD34D 0%, #FBBF24 50%, #D97706 100%);
            border-radius: 4px;
            position: relative;
        }
        .chip::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: rgba(0,0,0,0.15); }
        .chip::after { content: ''; position: absolute; left: 33%; right: 33%; top: 0; bottom: 0; border-left: 1px solid rgba(0,0,0,0.15); border-right: 1px solid rgba(0,0,0,0.15); }

        .hover-lift { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 12px 20px -5px rgba(21, 128, 61, 0.12); }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased selection:bg-mintLight selection:text-primary">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-primaryDark/50 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity"></div>

    <div class="flex flex-col lg:flex-row min-h-screen">

        <!-- SIDEBAR -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl shadow-slate-200/50">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 gradient-vibrant rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30">
                        <i class="fas fa-wallet text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-black text-primary tracking-tight leading-none">SmartPocket</h1>
                        <p class="text-[10px] font-bold text-primaryDark tracking-wider mt-1">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-primary p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-1.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-primary rounded-xl text-sm font-bold transition-all shadow-sm border border-primary/20">
                    <i class="fas fa-home w-5 text-center text-primary"></i> Dashboard
                </a>

                <a href="{{ route('nasabah.penarikan.create') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-money-bill-wave w-5 text-center text-slate-400"></i> Penarikan
                </a>

                @if(auth()->user()->nasabah->kategori == 'guru')
                    <a href="{{ route('nasabah.peminjaman.create') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                        <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman
                    </a>
                @endif

                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-history w-5 text-center text-slate-400"></i> Riwayat Transaksi
                </a>

                <p class="px-3 pt-6 pb-1.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Sistem</p>
                <a href="{{ route('nasabah.profile.edit')}}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-cog w-5 text-center text-slate-400"></i> Pengaturan Profile
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 text-sm font-bold py-2.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- TOP NAVBAR MOBILE -->
        <div class="lg:hidden bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 py-3 flex items-center justify-between sticky top-0 z-20 shadow-sm w-full">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 gradient-soft rounded-xl flex items-center justify-center text-white shadow-sm shadow-primary/30">
                    <i class="fas fa-wallet text-sm"></i>
                </div>
                <div>
                    <h1 class="text-sm font-black text-primary leading-none">Smart Pocket</h1>
                    <p class="text-[9px] font-bold text-primaryDark tracking-wider mt-0.5">BMT SMKN 11</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('nasabah.notifikasi.index') }}" class="w-9 h-9 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative">
                    <i class="far fa-bell text-sm"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                </a>
                <button onclick="toggleSidebar()" class="w-9 h-9 bg-slate-50 border border-slate-200 text-slate-700 rounded-xl flex items-center justify-center hover:bg-slate-100 transition-colors">
                    <i class="fas fa-bars text-sm"></i>
                </button>
            </div>
        </div>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 lg:ml-64 p-4 sm:p-6 lg:p-8 min-w-0">

            <!-- HEADER -->
            <header class="mb-6 lg:mb-8 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-1">
                        <span>Utama</span>
                        <i class="fas fa-chevron-right text-[9px]"></i>
                        <span class="text-primary font-bold">Dashboard</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Selamat datang, {{ auth()->user()->name }}
                        </h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-mintLight text-primary border border-primary/20">
                            {{ auth()->user()->nasabah->kategori ?? 'Siswa' }}
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 flex items-center gap-2 font-medium">
                        <i class="fas fa-chart-pie text-primary"></i>
                        Ringkasan aktivitas keuangan dan saldo BMT SMKN 11 Bandung Anda.
                    </p>
                </div>

                <!-- Profil Desktop -->
                <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                    <a href="{{ route('nasabah.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 hover:text-primary hover:border-primary transition-all relative shadow-sm">
                        <i class="far fa-bell text-base"></i>
                        @php $pendingNotif = \App\Models\DetailTabungan::where('status', 'pending')->count(); @endphp
                        @if($pendingNotif > 0)
                            <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                        @endif
                    </a>
                    <div class="w-px h-8 bg-slate-200"></div>
                    <div class="text-right">
                        <p class="text-xs font-black text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-bold text-slate-400 capitalize mt-0.5">
                            {{ auth()->user()->nasabah->kategori ?? 'Siswa' }}
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl overflow-hidden gradient-vibrant text-white font-black text-sm flex items-center justify-center border-2 border-white shadow-lg shadow-primary/20 flex-shrink-0">
                        @if(auth()->user()->nasabah && auth()->user()->nasabah->photo)
                            <img src="{{ asset('storage/' . auth()->user()->nasabah->photo) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                </div>
            </header>

            <!-- SECTION 1: RINGKASAN REKENING -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Ringkasan Rekening</h3>
                    <span class="text-[11px] font-bold text-slate-400">Update Realtime</span>
                </div>

                <div class="grid grid-cols-1 {{ auth()->user()->nasabah->kategori == 'guru' ? 'lg:grid-cols-2' : 'lg:grid-cols-1' }} gap-4 sm:gap-5">

                    <!-- KARTU 1: TABUNGAN UTAMA -->
                    <div class="gradient-primary rounded-2xl p-5 sm:p-6 text-white relative overflow-hidden flex flex-col justify-between lg:min-h-[210px] hover-lift group">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="flex justify-between items-start relative z-10 gap-3">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="chip w-9 h-6 sm:w-10 sm:h-7 shadow-inner"></div>
                                <i class="fas fa-wifi text-white/40 text-xs sm:text-sm rotate-90"></i>
                            </div>
                            <span class="px-2.5 sm:px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-emerald-200 flex items-center gap-1.5 whitespace-nowrap">
                                <i class="fas fa-piggy-bank text-accent"></i> Tabungan
                            </span>
                        </div>

                        <div class="my-4 sm:my-5 relative z-10">
                            <p class="text-[10px] text-emerald-100 uppercase tracking-widest font-bold mb-1">Saldo Tersedia</p>
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white break-all">
                                Rp {{ number_format($rekening->saldo ?? 0, 0, ',', '.') }}
                            </h3>
                        </div>

                        <div class="pt-3 border-t border-white/15 flex justify-between items-end gap-3 relative z-10 text-xs">
                            <div class="min-w-0">
                                <p class="text-[9px] text-emerald-200/80 uppercase tracking-widest font-semibold">Nomor Rekening</p>
                                <p class="font-mono tracking-widest font-semibold text-white text-[11px] sm:text-sm truncate">
                                    {{ auth()->user()->nasabah->rekening->no_rek ?? '--- --- ---' }}
                                </p>
                            </div>
                            <div class="text-right min-w-0">
                                <p class="text-[9px] text-emerald-200/80 uppercase tracking-widest font-semibold">Pemilik</p>
                                <p class="font-bold uppercase text-[11px] sm:text-xs text-white truncate max-w-[120px] sm:max-w-[180px]">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- KARTU 2: FASILITAS PINJAMAN GURU -->
                    @if(auth()->user()->nasabah->kategori == 'guru')
                        <div class="card-peminjaman rounded-2xl p-5 sm:p-6 relative overflow-hidden flex flex-col justify-between lg:min-h-[260px] hover-lift group">
                            <div class="flex justify-between items-start gap-3 relative z-10">
                                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-mintLight border border-primary/30 rounded-xl flex items-center justify-center text-primary font-bold flex-shrink-0 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-hand-holding-usd text-sm sm:text-lg"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Fasilitas Pinjaman</p>
                                        <p class="text-[11px] sm:text-xs font-black text-primary truncate">Khusus Pendidik / Staff</p>
                                    </div>
                                </div>
                                <span class="px-2.5 sm:px-3 py-1 bg-primary/10 rounded-full text-[9px] sm:text-[10px] font-black uppercase tracking-wider text-primary border border-primary/10 whitespace-nowrap flex-shrink-0">
                                    Kredit
                                </span>
                            </div>

                            <div class="my-3 sm:my-4 relative z-10">
                                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mb-1">Sisa Pokok Pinjaman</p>
                                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-primary break-all">
                                    Rp {{ number_format($totalSisaPokok ?? 0, 0, ',', '.') }}
                                </h3>
                            </div>

                            <div class="pt-3 sm:pt-4 border-t border-slate-100 flex justify-between items-center gap-3 relative z-10 text-xs mt-1 sm:mt-2">
                                <div class="min-w-0">
                                    <p class="text-[9px] text-slate-400 uppercase tracking-widest font-semibold">Status</p>
                                    <p class="font-bold text-[11px] sm:text-xs text-primary flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full {{ $totalSisaPokok > 0 ? 'bg-primary' : 'bg-slate-300' }}"></span>
                                        {{ $totalSisaPokok > 0 ? 'Berjalan' : 'Lunas' }}
                                    </p>
                                </div>
                                <a href="{{ route('nasabah.peminjaman.create') }}" class="px-3 sm:px-4 py-2 bg-primary hover:bg-primaryDark text-white font-black text-[11px] sm:text-xs rounded-xl transition-all shadow-md shadow-primary/30 whitespace-nowrap flex-shrink-0">
                                    Ajukan Baru
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <!-- SECTION 2: AKSES CEPAT -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                <a href="{{ route('nasabah.penarikan.create') }}" class="bg-white rounded-2xl p-5 border border-slate-200/60 shadow-xl shadow-slate-200/50 hover-lift flex items-center justify-between group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-mintLight text-primary rounded-xl flex items-center justify-center text-lg font-bold group-hover:bg-primaryDark group-hover:text-white transition-colors flex-shrink-0">
                            <i class="fas fa-arrow-up-from-bracket"></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-bold text-primary group-hover:text-primaryDark transition-colors">Ajukan Penarikan</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Tarik saldo BMT secara instan</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-primary group-hover:translate-x-1 transition-all text-sm flex-shrink-0"></i>
                </a>

                @if(auth()->user()->nasabah->kategori == 'guru')
                    <a href="{{ route('nasabah.peminjaman.create') }}" class="bg-white rounded-2xl p-5 border border-slate-200/60 shadow-xl shadow-slate-200/50 hover-lift flex items-center justify-between group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center text-lg font-bold group-hover:bg-primaryDark group-hover:text-white transition-colors flex-shrink-0">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-primary group-hover:text-primaryDark transition-colors">Ajukan Peminjaman</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Khusus Tenaga Pendidik SMKN 11</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-slate-300 group-hover:text-primary group-hover:translate-x-1 transition-all text-sm flex-shrink-0"></i>
                    </a>
                @else
                    <div class="bg-slate-50/70 rounded-2xl p-5 border border-slate-200/60 flex items-center justify-between opacity-80">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-slate-200/70 text-slate-400 rounded-xl flex items-center justify-center text-lg font-bold flex-shrink-0">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-slate-600">Peminjaman Khusus Guru</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Akun Siswa aktif untuk Tabungan & Penarikan</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black uppercase px-2.5 py-1 bg-slate-200/70 text-slate-500 rounded-md tracking-wider flex-shrink-0">Terkunci</span>
                    </div>
                @endif
            </div>

            <!-- SECTION 3B: STATUS PENGAJUAN REALTIME -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/60 shadow-xl shadow-slate-200/50 mb-8">
                <div class="flex items-center justify-between mb-4 gap-3">
                    <div class="flex items-center gap-2 min-w-0">
                        <span class="w-2.5 h-2.5 bg-amber-500 rounded-full animate-ping flex-shrink-0"></span>
                        <h3 class="text-sm font-black text-primary truncate">Status Pengajuan Terakhir</h3>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 whitespace-nowrap hidden sm:block">Monitoring</span>
                </div>

                @if($pengajuanPenarikan || $pengajuanPeminjaman)
                    <div class="space-y-3">
                        @if($pengajuanPenarikan)
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3 min-w-0 flex-1">
                                        <div class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-money-bill-wave text-sm"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-slate-800">Pengajuan Penarikan</p>
                                            <p class="text-xs text-slate-500 mt-1">Menunggu verifikasi operator.</p>
                                            <p class="text-sm font-black text-red-600 mt-2">Rp {{ number_format($pengajuanPenarikan->jumlah ?? 0, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 bg-amber-100 text-amber-700 border border-amber-200 rounded-full text-[10px] font-black uppercase flex-shrink-0">Pending</span>
                                </div>
                            </div>
                        @endif

                        @if($pengajuanPeminjaman)
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3 min-w-0 flex-1">
                                        <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-hand-holding-usd text-sm"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-slate-800">Pengajuan Peminjaman</p>
                                            <p class="text-xs text-slate-500 mt-1">Menunggu verifikasi operator.</p>
                                            <p class="text-sm font-black text-primary mt-2">Rp {{ number_format($pengajuanPeminjaman->jumlah_pinjaman ?? 0, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 bg-amber-100 text-amber-700 border border-amber-200 rounded-full text-[10px] font-black uppercase flex-shrink-0">Pending</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-5 text-center">
                        <div class="w-11 h-11 bg-mintLight rounded-xl flex items-center justify-center mx-auto mb-3 text-primary">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-700">Tidak Ada Pengajuan Pending</p>
                        <p class="text-xs text-slate-400 mt-1">Semua pengajuan kamu sudah diproses.</p>
                    </div>
                @endif
            </div>

            <!-- SECTION 4: RIWAYAT TRANSAKSI TERBARU -->
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center gap-3">
                    <div class="min-w-0">
                        <h3 class="text-sm font-black text-primary truncate">Riwayat Transaksi Terbaru</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Aktivitas mutasi rekening Anda</p>
                    </div>
                    <a href="{{ route('nasabah.riwayat') }}" class="text-xs font-black text-primary hover:text-primaryDark flex items-center gap-1.5 transition-colors whitespace-nowrap flex-shrink-0">
                        Lihat Semua <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @if(isset($transaksiTerbaru) && $transaksiTerbaru->count() > 0)
                        @foreach($transaksiTerbaru as $transaksi)
                            @php
                                $isPeminjaman = ($transaksi->tipe ?? null) === 'peminjaman';
                                $isTabungan = ($transaksi->tipe ?? null) === 'tabungan';
                                $isAngsuran = ($transaksi->tipe ?? null) === 'angsuran';

                                $isSetoran = $isTabungan && ($transaksi->id_jenis_transaksi ?? null) == 1;
                                $isPenarikan = $isTabungan && ($transaksi->id_jenis_transaksi ?? null) == 2;

                                $statusClass = 'bg-slate-100 text-slate-700 border-slate-200';
                                if (in_array($transaksi->status, ['berhasil', 'disetujui'])) $statusClass = 'bg-mintLight text-primary border-primary/30';
                                elseif ($transaksi->status === 'pending') $statusClass = 'bg-amber-50 text-amber-800 border-amber-200';
                                elseif (in_array($transaksi->status, ['ditolak', 'gagal'])) $statusClass = 'bg-red-50 text-red-700 border-red-200';

                                if ($isPeminjaman) { $label = 'Pengajuan Peminjaman'; $icon = 'hand-holding-usd'; $iconBgClass = 'bg-primary text-white'; $amountClass = 'text-primary'; $sign = ''; }
                                elseif ($isAngsuran) { $label = 'Pembayaran Cicilan'; $icon = 'check-circle'; $iconBgClass = 'bg-mintLight text-primary'; $amountClass = 'text-red-600'; $sign = '-'; }
                                elseif ($isSetoran) { $label = 'Setoran Tabungan'; $icon = 'arrow-down'; $iconBgClass = 'bg-mintLight text-primary'; $amountClass = 'text-primary'; $sign = '+'; }
                                elseif ($isPenarikan) { $label = 'Penarikan Saldo'; $icon = 'arrow-up'; $iconBgClass = 'bg-red-50 text-red-600'; $amountClass = 'text-red-600'; $sign = '-'; }
                                else { $label = 'Transaksi'; $icon = 'receipt'; $iconBgClass = 'bg-slate-100 text-slate-600'; $amountClass = 'text-slate-800'; $sign = ''; }
                            @endphp

                            <div class="p-4 hover:bg-bgMain transition-colors flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 sm:gap-3.5 min-w-0 flex-1">
                                    <div class="w-10 h-10 {{ $iconBgClass }} rounded-xl flex items-center justify-center font-bold flex-shrink-0">
                                        <i class="fas fa-{{ $icon }} text-sm"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-primary leading-snug truncate">{{ $label }}</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5 truncate">{{ $transaksi->tanggal_transaksi ? $transaksi->tanggal_transaksi->format('d M Y, H:i') : '' }} WIB</p>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm font-black {{ $amountClass }} whitespace-nowrap">
                                        {{ $sign }}{{ $sign ? ' ' : '' }}Rp {{ number_format($transaksi->jumlah ?? 0, 0, ',', '.') }}
                                    </p>
                                    <span class="inline-block border text-[10px] font-black px-2 py-0.5 rounded-full capitalize mt-1 {{ $statusClass }}">
                                        {{ ucfirst($transaksi->status ?? 'Lunas') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-10 px-4">
                            <div class="w-12 h-12 bg-mintLight rounded-2xl flex items-center justify-center mx-auto mb-3 text-primary">
                                <i class="fas fa-receipt text-lg"></i>
                            </div>
                            <h4 class="text-sm font-bold text-primary mb-1">Belum Ada Transaksi</h4>
                            <p class="text-xs text-slate-400 max-w-sm mx-auto">Semua mutasi tabungan dan pinjaman Anda akan tercatat secara otomatis di sini.</p>
                        </div>
                    @endif
                </div>
            </div>

        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
</body>
</html>