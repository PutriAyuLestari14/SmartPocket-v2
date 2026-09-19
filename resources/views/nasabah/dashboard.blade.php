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
                        forest: '#1A4D2E',
                        forestDark: '#123720',
                        mint: '#4E9F3D',
                        mintLight: '#E8F5E9',
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

        .card-forest {
            background: linear-gradient(135deg, #1A4D2E 0%, #123720 100%);
            box-shadow: 0 12px 28px -6px rgba(26, 77, 46, 0.25);
        }

        .card-peminjaman {
            background: #FFFFFF;
            border: 1.5px solid #1A4D2E;
            box-shadow: 0 10px 25px -5px rgba(26, 77, 46, 0.08);
        }

        .chip {
            background: linear-gradient(135deg, #FCD34D 0%, #FBBF24 50%, #D97706 100%);
            border-radius: 4px;
            position: relative;
        }
        .chip::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: rgba(0,0,0,0.15); }
        .chip::after { content: ''; position: absolute; left: 33%; right: 33%; top: 0; bottom: 0; border-left: 1px solid rgba(0,0,0,0.15); border-right: 1px solid rgba(0,0,0,0.15); }

        .hover-lift { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 12px 20px -5px rgba(26, 77, 46, 0.12); }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased selection:bg-mintLight selection:text-forest">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-forestDark/50 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity"></div>

    <div class="flex flex-col lg:flex-row min-h-screen">
        
        <!-- SIDEBAR -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-sm">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center text-white shadow-md shadow-forest/20">
                        <i class="fas fa-wallet text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-forest tracking-tight leading-none">SmartPocket</h1>
                        <p class="text-[10px] font-bold text-mint tracking-wider mt-1">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-forest p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-1.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-home w-5 text-center text-mint"></i> Dashboard
                </a>
                
                <a href="{{ route('nasabah.penarikan.create') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-money-bill-wave w-5 text-center text-slate-400"></i> Penarikan 
                </a>

                @if(auth()->user()->nasabah->kategori == 'guru')
                    <a href="{{ route('nasabah.peminjaman.create') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                        <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman 
                    </a>
                @endif
                
                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-history w-5 text-center text-slate-400"></i> Riwayat Transaksi
                </a>
                
                <p class="px-3 pt-6 pb-1.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Sistem</p>
                <a href="{{ route('nasabah.profile.edit')}}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-cog w-5 text-center text-slate-400"></i> Pengaturan Profile
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 text-sm font-bold py-2.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- TOP NAVBAR MOBILE (Sama persis kayak halaman Penarikan) -->
        <div class="lg:hidden bg-white border-b border-slate-200/80 px-4 py-3 flex items-center justify-between sticky top-0 z-20 shadow-sm w-full">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-forest rounded-xl flex items-center justify-center text-white shadow-sm">
                    <i class="fas fa-wallet text-sm"></i>
                </div>
                <div>
                    <h1 class="text-sm font-extrabold text-forest leading-none">Smart Pocket</h1>
                    <p class="text-[9px] font-bold text-mint tracking-wider mt-0.5">BMT SMKN 11</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('nasabah.notifikasi.index') }}" class="w-9 h-9 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative">
                    <i class="far fa-bell text-sm"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-mint rounded-full ring-2 ring-white"></span>
                </a>
                <button onclick="toggleSidebar()" class="w-9 h-9 bg-slate-50 border border-slate-200 text-slate-700 rounded-xl flex items-center justify-center hover:bg-slate-100 transition-colors">
                    <i class="fas fa-bars text-sm"></i>
                </button>
            </div>
        </div>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 lg:ml-64 p-4 sm:p-6 lg:p-8 min-w-0">
            
            <!-- HEADER PRESISI -->
            <header class="mb-6 lg:mb-8 flex items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1">
                        <span>Utama</span>
                        <i class="fas fa-chevron-right text-[9px]"></i>
                        <span class="text-forest font-bold">Dashboard</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Selamat datang, {{ auth()->user()->name }}
                        </h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-mintLight text-forest border border-mint/20">
                            {{ auth()->user()->nasabah->kategori ?? 'Siswa' }}
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Ringkasan aktivitas keuangan dan saldo BMT SMKN 11 Bandung Anda.
                    </p>
                </div>

                <!-- Bagian Profil & Lonceng di Layar Desktop -->
                <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-semibold text-slate-400 capitalize mt-0.5">
                            {{ auth()->user()->nasabah->kategori ?? 'Siswa' }}
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-forest text-white font-bold text-sm flex items-center justify-center border border-slate-200 shadow-sm flex-shrink-0">
                        @if(auth()->user()->nasabah && auth()->user()->nasabah->photo)
                            <img src="{{ asset('storage/' . auth()->user()->nasabah->photo) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <a href="{{ route('nasabah.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200/80 rounded-xl flex items-center justify-center text-slate-600 hover:text-forest hover:border-mint transition-all relative shadow-sm ml-1">
                        <i class="far fa-bell text-base"></i>
                        <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-mint rounded-full ring-2 ring-white"></span>
                    </a>
                </div>
            </header>

            <!-- SECTION 1: RINGKASAN REKENING -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">Ringkasan Rekening</h3>
                    <span class="text-[11px] font-bold text-slate-400">Update Realtime</span>
                </div>
                
                <div class="grid grid-cols-1 {{ auth()->user()->nasabah->kategori == 'guru' ? 'lg:grid-cols-2' : 'lg:grid-cols-1' }} gap-5">
                    
                    <!-- KARTU 1: TABUNGAN UTAMA -->
                    <div class="card-forest rounded-2xl p-6 text-white relative overflow-hidden flex flex-col justify-between min-h-[210px] hover-lift">
                        <div class="flex justify-between items-start relative z-10">
                            <div class="flex items-center gap-3">
                                <div class="chip w-10 h-7 shadow-inner"></div>
                                <i class="fas fa-wifi text-white/40 text-sm rotate-90"></i>
                            </div>
                            <span class="px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[10px] font-bold uppercase tracking-wider text-emerald-200 flex items-center gap-1.5">
                                <i class="fas fa-piggy-bank text-mint"></i> Tabungan Utama
                            </span>
                        </div>

                        <div class="my-5 relative z-10">
                            <p class="text-[10px] text-emerald-100 uppercase tracking-widest font-bold mb-1">Saldo Tersedia</p>
                            <h3 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                                Rp {{ number_format($rekening->saldo ?? 0, 0, ',', '.') }}
                            </h3>
                        </div>

                        <div class="pt-3 border-t border-white/15 flex justify-between items-end relative z-10 text-xs">
                            <div>
                                <p class="text-[9px] text-emerald-200/80 uppercase tracking-widest font-semibold">Nomor Rekening</p>
                                <p class="font-mono tracking-widest font-semibold text-white text-xs sm:text-sm">
                                    {{ auth()->user()->nasabah->rekening->no_rek ?? '--- --- ---' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] text-emerald-200/80 uppercase tracking-widest font-semibold">Pemilik Rekening</p>
                                <p class="font-bold uppercase text-xs text-white truncate max-w-[140px] sm:max-w-[200px]">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- KARTU 2: FASILITAS PINJAMAN GURU -->
                    @if(auth()->user()->nasabah->kategori == 'guru')
                        <div class="card-peminjaman rounded-2xl p-6 relative overflow-hidden flex flex-col justify-between min-h-[210px] hover-lift">
                            <div class="flex justify-between items-start relative z-10">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-mintLight border border-mint/30 rounded-xl flex items-center justify-center text-forest font-bold">
                                        <i class="fas fa-hand-holding-usd text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Fasilitas Pinjaman</p>
                                        <p class="text-xs font-extrabold text-forest">Khusus Pendidik / Staff</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-forest/10 rounded-full text-[10px] font-extrabold uppercase tracking-wider text-forest border border-forest/10">
                                    Kredit BMT
                                </span>
                            </div>

                            <h3 class="text-3xl sm:text-4xl font-black tracking-tight text-forest">
                                Rp {{ number_format($totalSisaPinjaman ?? 0, 0, ',', '.') }}
                            </h3>

                            <div class="pt-3 border-t border-slate-100 flex justify-between items-center relative z-10 text-xs">
                                <div>
                                    <p class="text-[9px] text-slate-400 uppercase tracking-widest font-semibold">Status Peminjaman</p>
                                    <p class="font-bold text-xs text-mint flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full {{ isset($peminjamanAktif) && $peminjamanAktif->sisa_pinjaman > 0 ? 'bg-mint' : 'bg-slate-300' }}"></span>
                                        {{ isset($peminjamanAktif) && $peminjamanAktif->sisa_pinjaman > 0 ? 'Sedang Berjalan' : 'Tidak Ada Pinjaman' }}
                                    </p>
                                </div>
                                <a href="{{ route('nasabah.peminjaman.create') }}" class="px-4 py-2 bg-mint hover:bg-forest text-white font-bold text-xs rounded-xl transition-all shadow-md shadow-mint/20">
                                    Ajukan Peminjaman
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <!-- SECTION 2: AKSES CEPAT -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                <a href="{{ route('nasabah.penarikan.create') }}" class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover-lift flex items-center justify-between group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-mintLight text-forest rounded-xl flex items-center justify-center text-lg font-bold group-hover:bg-forest group-hover:text-white transition-colors">
                            <i class="fas fa-arrow-up-from-bracket"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-forest group-hover:text-mint transition-colors">Ajukan Penarikan</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Tarik saldo BMT secara instan</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-mint group-hover:translate-x-1 transition-all text-sm"></i>
                </a>

                @if(auth()->user()->nasabah->kategori == 'guru')
                    <a href="{{ route('nasabah.peminjaman.create') }}" class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover-lift flex items-center justify-between group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-forest/10 text-forest rounded-xl flex items-center justify-center text-lg font-bold group-hover:bg-forest group-hover:text-white transition-colors">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-forest group-hover:text-mint transition-colors">Ajukan Peminjaman</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Khusus Tenaga Pendidik SMKN 11</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-slate-300 group-hover:text-mint group-hover:translate-x-1 transition-all text-sm"></i>
                    </a>
                @else
                    <div class="bg-slate-50/70 rounded-2xl p-5 border border-slate-200/60 flex items-center justify-between opacity-80">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-slate-200/70 text-slate-400 rounded-xl flex items-center justify-center text-lg font-bold">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-600">Peminjaman Khusus Guru</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Akun Siswa aktif untuk Tabungan & Penarikan</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-extrabold uppercase px-2.5 py-1 bg-slate-200/70 text-slate-500 rounded-md tracking-wider">Terkunci</span>
                    </div>
                @endif
            </div>

            <!-- SECTION 3: WIDGET TAGIHAN ANGSURAN (GURU) -->
            @if(auth()->user()->nasabah->kategori == 'guru' && isset($peminjamanAktif) && $peminjamanAktif->sisa_pinjaman > 0)
                <div class="bg-forest rounded-2xl p-5 mb-8 text-white shadow-md border border-forestDark">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-mint/20 text-mint rounded-xl flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-sm font-bold text-white">Tagihan Cicilan Peminjaman</h4>
                                    <span class="px-2 py-0.5 text-[9px] font-extrabold bg-mint text-white rounded uppercase">Aktif</span>
                                </div>
                                <p class="text-xs text-emerald-100/80 mt-1">
                                    Sisa Pokok Pinjaman: <span class="text-white font-bold">Rp {{ number_format($peminjamanAktif->sisa_pinjaman, 0, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-5 pt-3 sm:pt-0 border-t sm:border-t-0 border-white/10">
                            <div class="text-left sm:text-right">
                                <p class="text-[10px] text-emerald-200 uppercase font-bold">Angsuran / Bulan</p>
                                <p class="text-lg font-black text-white">
                                    Rp {{ number_format($peminjamanAktif->angsuran_per_bulan ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <button class="px-4 py-2.5 bg-mint hover:bg-emerald-600 text-white font-bold text-xs rounded-xl transition-all shadow-md flex items-center gap-2">
                                <i class="fas fa-credit-card text-xs"></i> Bayar
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- SECTION 3B: STATUS PENGAJUAN REALTIME (MONITORING ALERT) -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-amber-500 rounded-full animate-ping"></span>
                        <h3 class="text-sm font-bold text-forest">
                            Status Pengajuan Terakhir
                        </h3>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                        Monitoring System
                    </span>
                </div>

                @if($pengajuanPenarikan || $pengajuanPeminjaman)
                    <div class="space-y-3">
                        {{-- pengajuan penarikan --}}
                        @if($pengajuanPenarikan)
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-money-bill-wave text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">
                                                Pengajuan Penarikan
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">
                                                Penarikan saldo sedang menunggu verifikasi operator.
                                            </p>
                                            <p class="text-sm font-extrabold text-red-600 mt-2">
                                                Rp {{ number_format($pengajuanPenarikan->jumlah ?? 0, 0, ',', '.') }}
                                            </p>
                                            <p class="text-[11px] text-slate-400 mt-1">
                                                Diajukan:
                                                {{ $pengajuanPenarikan->created_at
                                                    ? $pengajuanPenarikan->created_at->format('d M Y, H:i')
                                                    : '-' }}
                                                WIB
                                            </p>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 bg-amber-100 text-amber-700 border border-amber-200 rounded-full text-[10px] font-extrabold uppercase flex-shrink-0">
                                        Pending
                                    </span>
                                </div>
                            </div>
                        @endif

                        {{-- pengajuan peminjaman --}}
                        @if($pengajuanPeminjaman)

                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-forest/10 text-forest rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-hand-holding-usd text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">
                                                Pengajuan Peminjaman
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">
                                                Pengajuan pinjaman sedang menunggu verifikasi operator.
                                            </p>
                                            <p class="text-sm font-extrabold text-forest mt-2">
                                                Rp {{ number_format($pengajuanPeminjaman->jumlah_pinjaman ?? 0, 0, ',', '.') }}
                                            </p>
                                            <p class="text-[11px] text-slate-400 mt-1">
                                                Diajukan:
                                                {{ $pengajuanPeminjaman->created_at
                                                    ? $pengajuanPeminjaman->created_at->format('d M Y, H:i')
                                                    : '-' }}
                                                WIB
                                            </p>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 bg-amber-100 text-amber-700 border border-amber-200 rounded-full text-[10px] font-extrabold uppercase flex-shrink-0">
                                        Pending
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                @else

                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-5 text-center">

                        <div class="w-11 h-11 bg-mintLight rounded-xl flex items-center justify-center mx-auto mb-3 text-mint">
                            <i class="fas fa-check text-sm"></i>
                        </div>

                        <p class="text-sm font-bold text-slate-700">
                            Tidak Ada Pengajuan Pending
                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            Semua pengajuan kamu sudah diproses.
                        </p>    
                    </div>
                @endif
            </div>

            <!-- SECTION 4: RIWAYAT TRANSAKSI TERBARU -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-bold text-forest">Riwayat Transaksi Terbaru</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Aktivitas mutasi rekening Anda</p>
                    </div>
                    <a href="{{ route('nasabah.riwayat') }}" class="text-xs font-bold text-mint hover:text-forest flex items-center gap-1.5 transition-colors">
                        Lihat Semua <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @if(isset($transaksiTerbaru) && $transaksiTerbaru->count() > 0)
                        @foreach($transaksiTerbaru as $transaksi)
                            @php
                                $isPeminjaman = ($transaksi->tipe ?? null) === 'peminjaman';
                                $isTabungan = ($transaksi->tipe ?? null) === 'tabungan';

                                $isSetoran = $isTabungan && ($transaksi->id_jenis_transaksi ?? null) == 1;
                                $isPenarikan = $isTabungan && ($transaksi->id_jenis_transaksi ?? null) == 2;

                                $statusClass = 'bg-slate-100 text-slate-700 border-slate-200';

                                if (in_array($transaksi->status, ['berhasil', 'disetujui'])) {
                                    $statusClass = 'bg-mintLight text-forest border-mint/30';
                                } elseif ($transaksi->status === 'pending') {
                                    $statusClass = 'bg-amber-50 text-amber-800 border-amber-200';
                                } elseif (in_array($transaksi->status, ['ditolak', 'gagal'])) {
                                    $statusClass = 'bg-red-50 text-red-700 border-red-200';
                                }

                                if ($isPeminjaman) {
                                    $label = 'Pengajuan Peminjaman';
                                    $icon = 'hand-holding-usd';
                                    $iconBgClass = 'bg-forest text-white';
                                    $amountClass = 'text-forest';
                                    $sign = '';
                                } elseif ($isSetoran) {
                                    $label = 'Setoran Tabungan';
                                    $icon = 'arrow-down';
                                    $iconBgClass = 'bg-mintLight text-mint';
                                    $amountClass = 'text-mint';
                                    $sign = '+';
                                } elseif ($isPenarikan) {
                                    $label = 'Penarikan Saldo';
                                    $icon = 'arrow-up';
                                    $iconBgClass = 'bg-red-50 text-red-600';
                                    $amountClass = 'text-red-600';
                                    $sign = '-';
                                } else {
                                    $label = 'Transaksi';
                                    $icon = 'receipt';
                                    $iconBgClass = 'bg-slate-100 text-slate-600';
                                    $amountClass = 'text-slate-800';
                                    $sign = '';
                                }
                            @endphp

                            <div class="p-4 hover:bg-bgMain transition-colors flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 {{ $iconBgClass }} rounded-xl flex items-center justify-center font-bold flex-shrink-0">
                                        <i class="fas fa-{{ $icon }} text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-forest leading-snug">{{ $label }}</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $transaksi->tanggal_transaksi ? $transaksi->tanggal_transaksi->format('d M Y, H:i') : '' }} WIB</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-extrabold {{ $amountClass }}">
                                        {{ $sign }}{{ $sign ? ' ' : '' }}Rp {{ number_format($transaksi->jumlah ?? 0, 0, ',', '.') }}
                                    </p>
                                    <span class="inline-block border text-[10px] font-bold px-2 py-0.5 rounded-full capitalize mt-1 {{ $statusClass }}">
                                        {{ ucfirst($transaksi->status ?? 'Lunas') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-10 px-4">
                            <div class="w-12 h-12 bg-mintLight rounded-2xl flex items-center justify-center mx-auto mb-3 text-forest">
                                <i class="fas fa-receipt text-lg"></i>
                            </div>
                            <h4 class="text-sm font-bold text-forest mb-1">Belum Ada Transaksi</h4>
                            <p class="text-xs text-slate-400 max-w-sm mx-auto">
                                Semua mutasi tabungan dan pinjaman Anda akan tercatat secara otomatis di sini.
                            </p>
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