<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operator - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bgMain: '#FAFAFA',
                        // Warna hijau yang SAMA dengan landing page
                        primary: '#15803d',        // Emerald 700
                        primaryDark: '#166534',    // Emerald 800
                        primaryLight: '#16a34a',   // Emerald 600
                        secondary: '#22c55e',      // Emerald 500
                        accent: '#4ade80',         // Emerald 400
                        mint: '#15803d',
                        mintLight: '#dcfce7',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAFAFA; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        
        /* Variasi Gradient yang TIDAK MONOTON */
        .gradient-primary { background: linear-gradient(135deg, #15803d 0%, #166534 100%); }
        .gradient-mint { background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); }
        .gradient-soft { background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%); }
        .gradient-fresh { background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); }
        .gradient-vibrant { background: linear-gradient(135deg, #15803d 0%, #16a34a 50%, #22c55e 100%); }
        
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -10px rgba(21, 128, 61, 0.25); }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-primaryDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl shadow-slate-200/50">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 gradient-vibrant rounded-xl flex items-center justify-center shadow-lg shadow-primary/30">
                        <i class="fas fa-wallet text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-black text-primary tracking-tight">Smart Pocket</h1>
                        <p class="text-[10px] text-primaryDark font-bold tracking-wider">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-mintLight to-white text-primary rounded-xl text-sm font-bold transition-all shadow-sm border border-primary/30">
                    <i class="fas fa-home w-5 text-center text-primary"></i> Dashboard
                </a>

                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Data Nasabah
                </a>

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-exchange-alt w-5 text-center text-slate-400"></i> Transaksi
                </a>

                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman
                </a>

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-check-circle w-5 text-center text-slate-400"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-chart-pie w-5 text-center text-slate-400"></i> Laporan
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-600 text-sm font-bold py-2.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 min-w-0">

            <!-- Mobile Top Bar -->
            <header class="lg:hidden bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 gradient-soft rounded-xl flex items-center justify-center text-white shadow-md shadow-primary/30">
                        <i class="fas fa-wallet text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-black text-primary tracking-tight leading-none">Smart Pocket</h1>
                        <p class="text-[10px] text-primaryDark font-bold tracking-wider mt-1">BMT SMKN 11</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('operator.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative active:scale-95 transition-transform shadow-sm">
                        <i class="far fa-bell text-base"></i>
                        <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                    </a>
                    <button onclick="toggleSidebar()" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform shadow-sm">
                        <i class="fas fa-bars text-base"></i>
                    </button>
                </div>
            </header>

            <div class="p-4 lg:p-8 space-y-6 lg:space-y-8">

                <!-- HEADER Selamat Datang -->
                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-1 flex-wrap">
                            <span>Utama</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-primary font-bold">Dashboard</span>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <h2 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                                Selamat Datang, {{ auth()->user()->petugas->nama_lengkap ?? auth()->user()->name }} 
                            </h2>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider gradient-fresh text-white shadow-lg shadow-secondary/30">
                                Operator
                            </span>
                        </div>
                        <p class="text-sm text-slate-500 mt-2 flex items-center gap-2 font-medium">
                            <i class="far fa-calendar text-primary"></i>
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>

                    <!-- Profil + notif desktop -->
                    <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                        <a href="{{ route('operator.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 hover:text-primary hover:border-primary transition-all relative shadow-sm">
                            <i class="far fa-bell text-base"></i>
                            @php $pendingNotif = \App\Models\DetailTabungan::where('status', 'pending')->count(); @endphp
                            @if($pendingNotif > 0)
                                <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                            @endif
                        </a>
                        <div class="w-px h-8 bg-slate-200"></div>
                        <div class="text-right">
                            <p class="text-xs font-black text-slate-800 leading-tight">
                                {{ auth()->user()->petugas->nama_lengkap ?? auth()->user()->name }}
                            </p>
                            <p class="text-[10px] font-bold text-slate-400 mt-0.5">Operator</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl overflow-hidden gradient-vibrant text-white font-black text-sm flex items-center justify-center border-2 border-white shadow-lg shadow-primary/20 flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->petugas->nama_lengkap ?? auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </header>

                <!-- Stats Grid (VARIASI GRADIENT) -->
                <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-6">

                    <!-- Total Nasabah -->
                    <div class="bg-white rounded-2xl p-5 border border-blue-100 shadow-lg shadow-blue-500/5 hover-lift relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
                                <i class="fas fa-users text-white text-base"></i>
                            </div>
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-wider mb-1">Total Nasabah</p>
                            <p class="text-1xl lg:text-2xl font-black text-slate-900">{{ $totalNasabah ?? 0 }}</p>
                            <p class="text-[10px] font-bold text-blue-600 mt-3 flex items-center gap-1 bg-blue-50 w-fit px-2 py-1 rounded-lg">
                                <i class="fas fa-arrow-up"></i> +5 bulan ini
                            </p>
                        </div>
                    </div>

                    <!-- Total Saldo (gradient-soft) -->
                    <div class="gradient-soft rounded-2xl p-5 shadow-xl shadow-primary/20 relative overflow-hidden hover-lift group">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mb-4 border border-white/30">
                                <i class="fas fa-wallet text-white text-base"></i>
                            </div>
                            <p class="text-[10px] text-emerald-100 font-black uppercase tracking-wider mb-1">Saldo Kas BMT</p>
                            <p class="text-1xl lg:text-2xl font-black text-white mb-2 break-all leading-tight">Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}</p>
                            <p class="text-[10px] font-bold text-emerald-100 flex items-center gap-1 bg-white/10 w-fit px-2 py-1 rounded-lg backdrop-blur-sm border border-white/20">
                                <i class="fas fa-sync-alt fa-spin"></i> Live Update
                            </p>
                        </div>
                    </div>

                    <!-- Transaksi Berhasil (gradient-vibrant) -->
                    <div class="bg-white rounded-2xl p-5 border border-primary/20 shadow-lg shadow-primary/5 hover-lift relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-mintLight rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 gradient-vibrant rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-primary/30">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-wider mb-1">Transaksi Sukses</p>
                            <p class="text-1xl lg:text-2xl font-black text-slate-900">{{ $transaksiHariIni ?? 0 }}</p>
                            <p class="text-[10px] font-bold text-primary mt-3 flex items-center gap-1 bg-mintLight w-fit px-2 py-1 rounded-lg">
                                <i class="fas fa-arrow-trend-up"></i> {{ $transaksiMingguIni ?? 0 }} minggu ini
                            </p>
                        </div>
                    </div>

                    <!-- Pending (gradient-mint) -->
                    <div class="bg-white rounded-2xl p-5 border border-amber-100 shadow-lg shadow-amber-500/5 hover-lift relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 gradient-mint rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-amber-500/30">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-wider mb-1">Menunggu Verifikasi</p>
                            <p class="text-1xl lg:text-2xl font-black text-slate-900">{{ $penarikanPending ?? 0 }}</p>
                            <p class="text-[10px] font-bold text-amber-600 mt-3 flex items-center gap-1 bg-amber-50 w-fit px-2 py-1 rounded-lg">
                                <i class="fas fa-exclamation-circle"></i> Butuh tindakan
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">

                    <!-- Left Content -->
                    <div class="xl:col-span-2 space-y-6 lg:space-y-8 min-w-0">

                        <!-- Quick Actions (TIDAK DIUBAH) -->
                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 lg:p-6">
                            <h3 class="text-sm lg:text-base font-extrabold text-slate-900 mb-4 lg:mb-5 flex items-center gap-2">
                                <i class="fas fa-bolt text-primary"></i> Aksi Cepat
                            </h3>
                            <div class="grid grid-cols-3 gap-2.5 sm:gap-4">

                                <a href="{{ route('operator.setoran.create')}}" class="group bg-gradient-to-br from-emerald-50 to-emerald-100/50 hover:from-emerald-100 hover:to-emerald-200 border-2 border-emerald-200/60 hover:border-emerald-300 rounded-2xl p-3 sm:p-5 text-center transition-all hover-lift">
                                    <div class="w-9 h-9 sm:w-11 sm:h-11 bg-emerald-500 group-hover:bg-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3 transition-all shadow-lg shadow-emerald-500/30">
                                        <i class="fas fa-plus-circle text-white text-sm sm:text-base"></i>
                                    </div>
                                    <p class="text-[11px] sm:text-sm font-bold text-slate-900">Setoran</p>
                                    <p class="hidden sm:block text-[10px] text-slate-500 mt-0.5">Setor tunai</p>
                                </a>

                                <a href="{{ route('operator.penarikan.create')}}" class="group bg-gradient-to-br from-red-50 to-red-100/50 hover:from-red-100 hover:to-red-200 border-2 border-red-200/60 hover:border-red-300 rounded-2xl p-3 sm:p-5 text-center transition-all hover-lift">
                                    <div class="w-9 h-9 sm:w-11 sm:h-11 bg-red-500 group-hover:bg-red-600 rounded-2xl flex items-center justify-center mx-auto mb-2 sm:mb-3 transition-all shadow-lg shadow-red-500/30">
                                        <i class="fas fa-minus-circle text-white text-sm sm:text-xl"></i>
                                    </div>
                                    <p class="text-[11px] sm:text-sm font-bold text-slate-900">Penarikan</p>
                                    <p class="hidden sm:block text-[10px] text-slate-500 mt-0.5">Tarik tunai</p>
                                </a>

                                <a href="{{route('operator.pembayaran.create')}}" class="group bg-gradient-to-br from-blue-50 to-blue-100/50 hover:from-blue-100 hover:to-blue-200 border-2 border-blue-200/60 hover:border-blue-300 rounded-2xl p-3 sm:p-5 text-center transition-all hover-lift">
                                    <div class="w-9 h-9 sm:w-11 sm:h-11 bg-blue-500 group-hover:bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-2 sm:mb-3 transition-all shadow-lg shadow-blue-500/30">
                                        <i class="fas fa-hand-holding-usd text-white text-sm sm:text-xl"></i>
                                    </div>
                                    <p class="text-[11px] sm:text-sm font-bold text-slate-900">Pembayaran</p>
                                    <p class="hidden sm:block text-[10px] text-slate-500 mt-0.5">Cicilan</p>
                                </a>
                            </div>
                        </div>

                        <!-- Recent Transactions -->
                        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 overflow-hidden">
                            <div class="p-5 lg:p-6 border-b border-slate-100 flex justify-between items-center gap-3">
                                <h3 class="text-sm lg:text-base font-black text-slate-900 flex items-center gap-2 min-w-0">
                                    <i class="fas fa-history text-primary"></i>
                                    <span class="truncate">Transaksi Terkini</span>
                                </h3>
                                <a href="{{ route('operator.transaksi.index') }}" class="text-[10px] lg:text-xs font-black text-primary hover:text-primaryDark transition-colors whitespace-nowrap flex-shrink-0 uppercase tracking-wide">
                                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>

                            <!-- Desktop Table -->
                            <div class="hidden md:block overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-slate-50/80">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Waktu</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Nasabah</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Jenis</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Nominal</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse($transaksiTerkini as $trx)
                                        <tr class="hover:bg-mintLight/20 transition-colors">
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-black text-slate-900">
                                                    {{ \Carbon\Carbon::parse($trx->tanggal_transaksi, 'UTC')->setTimezone('Asia/Jakarta')->format('H:i') }}
                                                </p>
                                                <p class="text-[10px] text-slate-400 font-medium">
                                                    {{ \Carbon\Carbon::parse($trx->tanggal_transaksi, 'UTC')->setTimezone('Asia/Jakarta')->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center flex-shrink-0">
                                                        <span class="text-[10px] font-black text-slate-600">
                                                            {{ strtoupper(substr($trx->rekening->nasabah->nama ?? 'N', 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-bold text-slate-900">
                                                            {{ $trx->rekening->nasabah->nama ?? 'Nasabah Tidak Ditemukan' }}
                                                        </p>
                                                        <p class="text-[10px] text-slate-500 font-medium">
                                                            {{ $trx->rekening->nasabah->kategori ?? '-' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $setoran = strtolower(trim($trx->jenisTransaksi->setoran ?? ''));
                                                    $penarikan = strtolower(trim($trx->jenisTransaksi->penarikan ?? ''));
                                                    if ($setoran === 'setoran') { $jenis = 'setoran'; }
                                                    elseif ($penarikan === 'penarikan') { $jenis = 'penarikan'; }
                                                    else { $jenis = 'lainnya'; }
                                                @endphp

                                                @if($jenis === 'setoran')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-xl text-[10px] font-black border border-emerald-200">
                                                        <i class="fas fa-arrow-down text-[8px]"></i> Setoran
                                                    </span>
                                                @elseif($jenis === 'penarikan')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-700 rounded-xl text-[10px] font-black border border-rose-200">
                                                        <i class="fas fa-arrow-up text-[8px]"></i> Penarikan
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-xl text-[10px] font-black border border-blue-200">
                                                        <i class="fas fa-exchange-alt text-[8px]"></i> {{ ucfirst($jenis ?: 'Lainnya') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-black {{ $jenis === 'penarikan' ? 'text-rose-600' : 'text-primary' }}">
                                                    {{ $jenis === 'penarikan' ? '- ' : '+ ' }}Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                                                </p>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($trx->status === 'pending')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 rounded-xl text-[10px] font-black border border-amber-200">
                                                        <i class="fas fa-clock text-[8px]"></i> Pending
                                                    </span>
                                                @elseif($trx->status === 'berhasil')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-mintLight text-primary rounded-xl text-[10px] font-black border border-primary/20">
                                                        <i class="fas fa-check-circle text-[8px]"></i> Sukses
                                                    </span>
                                                @elseif($trx->status === 'ditolak')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-700 rounded-xl text-[10px] font-black border border-rose-200">
                                                        <i class="fas fa-times-circle text-[8px]"></i> Ditolak
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 rounded-xl text-[10px] font-black border border-slate-200">
                                                        <i class="fas fa-question-circle text-[8px]"></i> {{ ucfirst($trx->status ?? 'Tidak diketahui') }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center">
                                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                                                </div>
                                                <p class="text-sm font-bold text-slate-900">Belum ada transaksi</p>
                                                <p class="text-xs text-slate-500 mt-1">Transaksi akan muncul di sini</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card List -->
                            <div class="md:hidden divide-y divide-slate-100">
                                @forelse($transaksiTerkini as $trx)
                                    @php
                                        $setoran = strtolower(trim($trx->jenisTransaksi->setoran ?? ''));
                                        $penarikan = strtolower(trim($trx->jenisTransaksi->penarikan ?? ''));
                                        if ($setoran === 'setoran') { $jenis = 'setoran'; }
                                        elseif ($penarikan === 'penarikan') { $jenis = 'penarikan'; }
                                        else { $jenis = 'lainnya'; }
                                    @endphp
                                    <div class="p-4 active:bg-slate-50 transition-colors">
                                        <div class="flex justify-between items-start gap-3 mb-2.5">
                                            <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-mintLight to-emerald-100 flex items-center justify-center flex-shrink-0">
                                                    <span class="text-[11px] font-black text-primary">
                                                        {{ strtoupper(substr($trx->rekening->nasabah->nama ?? 'N', 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-bold text-slate-900 truncate">
                                                        {{ $trx->rekening->nasabah->nama ?? 'Nasabah Tidak Ditemukan' }}
                                                    </p>
                                                    <p class="text-[10px] text-slate-500 truncate font-medium">
                                                        {{ \Carbon\Carbon::parse($trx->tanggal_transaksi, 'UTC')->setTimezone('Asia/Jakarta')->format('H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                            @if($trx->status === 'pending')
                                                <span class="text-[9px] font-black text-amber-700 bg-amber-50 px-2 py-1 rounded-lg border border-amber-200 flex-shrink-0">Pending</span>
                                            @elseif($trx->status === 'berhasil')
                                                <span class="text-[9px] font-black text-primary bg-mintLight px-2 py-1 rounded-lg border border-primary/20 flex-shrink-0">Sukses</span>
                                            @elseif($trx->status === 'ditolak')
                                                <span class="text-[9px] font-black text-rose-700 bg-rose-50 px-2 py-1 rounded-lg border border-rose-200 flex-shrink-0">Ditolak</span>
                                            @else
                                                <span class="text-[9px] font-black text-slate-700 bg-slate-100 px-2 py-1 rounded-lg border border-slate-200 flex-shrink-0">{{ ucfirst($trx->status ?? '-') }}</span>
                                            @endif
                                        </div>
                                        <div class="flex justify-between items-center pl-11">
                                            @if($jenis === 'setoran')
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[10px] font-black border border-emerald-200">
                                                    <i class="fas fa-arrow-down text-[8px]"></i> Setoran
                                                </span>
                                            @elseif($jenis === 'penarikan')
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-rose-50 text-rose-700 rounded-lg text-[10px] font-black border border-rose-200">
                                                    <i class="fas fa-arrow-up text-[8px]"></i> Penarikan
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-700 rounded-lg text-[10px] font-black border border-blue-200">
                                                    {{ ucfirst($jenis ?: 'Lainnya') }}
                                                </span>
                                            @endif
                                            <p class="text-sm font-black {{ $jenis === 'penarikan' ? 'text-rose-600' : 'text-primary' }}">
                                                {{ $jenis === 'penarikan' ? '- ' : '+ ' }}Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-4 py-12 text-center">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                                        </div>
                                        <p class="text-sm font-bold text-slate-900">Belum ada transaksi</p>
                                        <p class="text-xs text-slate-500 mt-1">Transaksi akan muncul di sini</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar -->
                    <div class="space-y-6 lg:space-y-8">

                        <!-- Monthly Stats (gradient-primary) -->
                        <div class="gradient-primary rounded-2xl p-5 lg:p-6 shadow-xl shadow-primary/20 text-white relative overflow-hidden">
                            <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-secondary to-transparent"></div>
                            <div class="relative z-10">
                                <h3 class="text-sm font-black mb-5 flex items-center gap-2">
                                    <i class="fas fa-chart-pie text-secondary"></i> Statistik Bulan Ini
                                </h3>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                        <span class="text-xs text-emerald-100 font-bold">Total Transaksi</span>
                                        <span class="text-sm font-black text-white">{{ \App\Models\DetailTabungan::whereMonth('tanggal_transaksi', now()->month)->count() }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                        <span class="text-xs text-emerald-100 font-bold">Total Setoran</span>
                                        <span class="text-sm font-black text-emerald-300">Rp {{ number_format($totalSetoranBulanIni ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                        <span class="text-xs text-emerald-100 font-bold">Total Penarikan</span>
                                        <span class="text-sm font-black text-rose-300">Rp {{ number_format($totalPenarikanBulanIni ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2 bg-white/10 rounded-xl p-3 backdrop-blur-sm border border-white/10">
                                        <span class="text-xs text-emerald-50 font-black">Saldo Akhir</span>
                                        <span class="text-base font-black text-white">Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-5 lg:p-6">
                            <h3 class="text-sm font-black text-slate-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-info-circle text-primary"></i> Informasi Sistem
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3 p-3 bg-gradient-to-br from-mintLight to-white rounded-xl border border-primary/20">
                                    <div class="w-8 h-8 gradient-soft rounded-lg flex items-center justify-center flex-shrink-0 shadow-md shadow-primary/30">
                                        <i class="fas fa-shield-alt text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-primary mb-0.5">Sistem Aman</p>
                                        <p class="text-[10px] text-slate-600 leading-relaxed font-medium">Semua transaksi terenkripsi dan tersimpan dengan aman.</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3 p-3 bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-200">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 shadow-md shadow-blue-500/30">
                                        <i class="fas fa-headset text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-slate-900 mb-0.5">Butuh Bantuan?</p>
                                        <p class="text-[10px] text-slate-600 leading-relaxed font-medium">Hubungi admin utama untuk bantuan teknis.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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