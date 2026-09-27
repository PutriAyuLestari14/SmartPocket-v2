<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Dashboard - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
        .gradient-forest { background: linear-gradient(135deg, #1A4D2E 0%, #123720 100%); }
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -10px rgba(26, 77, 46, 0.15); }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-forestDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center shadow-md shadow-forest/20">
                        <i class="fas fa-wallet text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-forest tracking-tight">Smart Pocket</h1>
                        <p class="text-[10px] text-mint font-bold tracking-wider">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-2 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-home w-5 text-center text-mint"></i> Dashboard
                </a>

                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Data Nasabah
                </a>

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-exchange-alt w-5 text-center text-slate-400"></i> Transaksi
                </a>

                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman
                </a>

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-check-circle w-5 text-center text-slate-400"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-chart-bar w-5 text-center text-slate-400"></i> Laporan
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

            <!-- Mobile Top Bar (persis gambar) -->
            <header class="lg:hidden bg-white border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center text-white shadow-md shadow-forest/20">
                        <i class="fas fa-wallet text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-forest tracking-tight leading-none">Smart Pocket</h1>
                        <p class="text-[10px] text-mint font-bold tracking-wider mt-1">BMT SMKN 11</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('operator.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative active:scale-95 transition-transform">
                        <i class="far fa-bell text-base"></i>
                        <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-mint rounded-full ring-2 ring-white"></span>
                    </a>
                    <button onclick="toggleSidebar()" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform">
                        <i class="fas fa-bars text-base"></i>
                    </button>
                </div>
            </header>

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- HEADER Selamat Datang -->
                <header class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1">
                            <span>Utama</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-forest font-bold">Dashboard</span>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
                            <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                                Selamat Datang, {{ auth()->user()->petugas->nama_lengkap ?? auth()->user()->name }}
                            </h2>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-mintLight text-forest border border-mint/20">
                                Operator
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 flex items-center gap-2">
                            <i class="far fa-calendar text-mint"></i>
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>

                    <!-- Profil + notif desktop -->
                    <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-800 leading-tight">
                                {{ auth()->user()->petugas->nama_lengkap ?? auth()->user()->name }}
                            </p>
                            <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Operator</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl overflow-hidden bg-forest text-white font-bold text-sm flex items-center justify-center border border-slate-200 shadow-sm flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->petugas->nama_lengkap ?? auth()->user()->name, 0, 1)) }}
                        </div>
                        <a href="{{ route('operator.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200/80 rounded-xl flex items-center justify-center text-slate-600 hover:text-forest hover:border-mint transition-all relative shadow-sm ml-1">
                            <i class="far fa-bell text-base"></i>
                            @php $pendingNotif = \App\Models\DetailTabungan::where('status', 'pending')->count(); @endphp
                            @if($pendingNotif > 0)
                                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-mint rounded-full ring-2 ring-white"></span>
                            @endif
                        </a>
                    </div>
                </header>

                <!-- Stats Grid - 2 kolom mobile, 4 kolom desktop -->
                <div class="grid grid-cols-2 xl:grid-cols-4 gap-3 lg:gap-6">

                    <!-- Total Nasabah -->
                    <div class="bg-white rounded-2xl p-4 lg:p-5 border border-slate-200/80 shadow-sm hover-lift">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-9 h-9 lg:w-11 lg:h-11 bg-blue-50 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-sm lg:text-lg"></i>
                            </div>
                            <span class="text-[9px] lg:text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 lg:py-1 rounded-full border border-emerald-200">● Aktif</span>
                        </div>
                        <p class="text-[10px] lg:text-xs text-slate-500 font-semibold mb-0.5 lg:mb-1">Total Nasabah</p>
                        <p class="text-lg lg:text-2xl font-black text-slate-900">{{ $totalNasabah ?? 3 }}</p>
                    </div>

                    <!-- Total Saldo (highlight) -->
                    <div class="gradient-forest rounded-2xl p-4 lg:p-5 shadow-xl shadow-forest/20 relative overflow-hidden">
                        <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 lg:w-11 lg:h-11 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <i class="fas fa-wallet text-white text-sm lg:text-lg"></i>
                                </div>
                            </div>
                            <p class="text-[10px] lg:text-xs text-emerald-100 font-semibold mb-0.5 lg:mb-1">Saldo Kas</p>
                            <p class="text-base lg:text-2xl font-black text-white mb-0.5 lg:mb-1 break-all leading-tight">Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}</p>
                            <p class="text-[9px] lg:text-[10px] text-emerald-200 flex items-center gap-1">
                                <i class="fas fa-sync-alt text-[7px]"></i> {{ now()->format('H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Transaksi Berhasil -->
                    <div class="bg-white rounded-2xl p-4 lg:p-5 border border-slate-200/80 shadow-sm hover-lift">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-9 h-9 lg:w-11 lg:h-11 bg-emerald-50 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-emerald-600 text-sm lg:text-lg"></i>
                            </div>
                            <i class="fas fa-arrow-trend-up text-emerald-500 text-xs"></i>
                        </div>
                        <p class="text-[10px] lg:text-xs text-slate-500 font-semibold mb-0.5 lg:mb-1">Berhasil</p>
                        <p class="text-lg lg:text-2xl font-black text-slate-900">{{ $transaksiHariIni ?? 156 }}</p>
                        <p class="text-[9px] lg:text-[10px] text-slate-400 mt-0.5 lg:mt-1">{{ $transaksiMingguIni ?? 89 }} minggu ini</p>
                    </div>

                    <!-- Pending -->
                    <div class="bg-white rounded-2xl p-4 lg:p-5 border border-slate-200/80 shadow-sm hover-lift">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-9 h-9 lg:w-11 lg:h-11 bg-amber-50 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-amber-600 text-sm lg:text-lg"></i>
                            </div>
                        </div>
                        <p class="text-[10px] lg:text-xs text-slate-500 font-semibold mb-0.5 lg:mb-1">Pending</p>
                        <p class="text-lg lg:text-2xl font-black text-slate-900">{{ $penarikanPending ?? 8 }}</p>
                        <p class="text-[9px] lg:text-[10px] text-amber-600 font-bold mt-0.5 lg:mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> Butuh tindakan
                        </p>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-6">

                    <!-- Left Content -->
                    <div class="xl:col-span-2 space-y-5 lg:space-y-6 min-w-0">

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 lg:p-6">
                            <h3 class="text-sm lg:text-base font-extrabold text-slate-900 mb-4 lg:mb-5 flex items-center gap-2">
                                <i class="fas fa-bolt text-mint"></i> Aksi Cepat
                            </h3>
                            <div class="grid grid-cols-3 gap-2.5 sm:gap-4">

                                <a href="{{ route('operator.setoran.create')}}" class="group bg-gradient-to-br from-emerald-50 to-emerald-100/50 hover:from-emerald-100 hover:to-emerald-200 border-2 border-emerald-200/60 hover:border-emerald-300 rounded-2xl p-3 sm:p-5 text-center transition-all hover-lift">
                                    <div class="w-10 h-10 sm:w-14 sm:h-14 bg-emerald-500 group-hover:bg-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-2 sm:mb-3 transition-all shadow-lg shadow-emerald-500/30">
                                        <i class="fas fa-plus-circle text-white text-sm sm:text-xl"></i>
                                    </div>
                                    <p class="text-[11px] sm:text-sm font-bold text-slate-900">Setoran</p>
                                    <p class="hidden sm:block text-[10px] text-slate-500 mt-0.5">Setor tunai</p>
                                </a>

                                <a href="{{ route('operator.penarikan.create')}}" class="group bg-gradient-to-br from-red-50 to-red-100/50 hover:from-red-100 hover:to-red-200 border-2 border-red-200/60 hover:border-red-300 rounded-2xl p-3 sm:p-5 text-center transition-all hover-lift">
                                    <div class="w-10 h-10 sm:w-14 sm:h-14 bg-red-500 group-hover:bg-red-600 rounded-2xl flex items-center justify-center mx-auto mb-2 sm:mb-3 transition-all shadow-lg shadow-red-500/30">
                                        <i class="fas fa-minus-circle text-white text-sm sm:text-xl"></i>
                                    </div>
                                    <p class="text-[11px] sm:text-sm font-bold text-slate-900">Penarikan</p>
                                    <p class="hidden sm:block text-[10px] text-slate-500 mt-0.5">Tarik tunai</p>
                                </a>

                                <a href="{{route('operator.pembayaran.create')}}" class="group bg-gradient-to-br from-blue-50 to-blue-100/50 hover:from-blue-100 hover:to-blue-200 border-2 border-blue-200/60 hover:border-blue-300 rounded-2xl p-3 sm:p-5 text-center transition-all hover-lift">
                                    <div class="w-10 h-10 sm:w-14 sm:h-14 bg-blue-500 group-hover:bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-2 sm:mb-3 transition-all shadow-lg shadow-blue-500/30">
                                        <i class="fas fa-hand-holding-usd text-white text-sm sm:text-xl"></i>
                                    </div>
                                    <p class="text-[11px] sm:text-sm font-bold text-slate-900">Pembayaran</p>
                                    <p class="hidden sm:block text-[10px] text-slate-500 mt-0.5">Cicilan</p>
                                </a>
                            </div>
                        </div>

                        <!-- Recent Transactions -->
                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                            <div class="p-4 lg:p-6 border-b border-slate-100 flex justify-between items-center gap-3">
                                <h3 class="text-sm lg:text-base font-extrabold text-slate-900 flex items-center gap-2 min-w-0">
                                    <i class="fas fa-history text-mint"></i>
                                    <span class="truncate">Transaksi Terkini</span>
                                </h3>
                                <a href="{{ route('operator.transaksi.index') }}" class="text-[10px] lg:text-xs font-bold text-mint hover:text-forest transition-colors whitespace-nowrap flex-shrink-0">
                                    LIHAT SEMUA <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>

                            <!-- Desktop Table -->
                            <div class="hidden md:block overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Waktu</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Nasabah</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Jenis</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Nominal</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse($transaksiTerkini as $trx)
                                        <tr class="hover:bg-slate-50/80 transition-colors">
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-bold text-slate-900">
                                                    {{ \Carbon\Carbon::parse($trx->tanggal_transaksi, 'UTC')->setTimezone('Asia/Jakarta')->format('H:i') }}
                                                </p>
                                                <p class="text-[10px] text-slate-400">
                                                    {{ \Carbon\Carbon::parse($trx->tanggal_transaksi, 'UTC')->setTimezone('Asia/Jakarta')->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div>
                                                    <p class="text-sm font-bold text-slate-900">
                                                        {{ $trx->rekening->nasabah->nama ?? 'Nasabah Tidak Ditemukan' }}
                                                    </p>
                                                    <p class="text-[10px] text-slate-500">
                                                        {{ $trx->rekening->nasabah->kategori ?? '-' }}
                                                    </p>
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
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-xl text-[10px] font-bold border border-emerald-200">
                                                        <i class="fas fa-arrow-down text-[8px]"></i> Setoran
                                                    </span>
                                                @elseif($jenis === 'penarikan')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 rounded-xl text-[10px] font-bold border border-red-200">
                                                        <i class="fas fa-arrow-up text-[8px]"></i> Penarikan
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-xl text-[10px] font-bold border border-blue-200">
                                                        <i class="fas fa-exchange-alt text-[8px]"></i> {{ ucfirst($jenis ?: 'Lainnya') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-black text-slate-900">
                                                    {{ $jenis === 'penarikan' ? '- ' : '+ ' }}Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                                                </p>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($trx->status === 'pending')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 rounded-xl text-[10px] font-bold border border-amber-200">
                                                        <i class="fas fa-clock text-[8px]"></i> Pending
                                                    </span>
                                                @elseif($trx->status === 'berhasil')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-xl text-[10px] font-bold border border-emerald-200">
                                                        <i class="fas fa-check-circle text-[8px]"></i> Sukses
                                                    </span>
                                                @elseif($trx->status === 'ditolak')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 rounded-xl text-[10px] font-bold border border-red-200">
                                                        <i class="fas fa-times-circle text-[8px]"></i> Ditolak
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 rounded-xl text-[10px] font-bold border border-slate-200">
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
                                                <p class="text-sm font-semibold text-slate-900">Belum ada transaksi</p>
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
                                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-mintLight to-emerald-100 flex items-center justify-center flex-shrink-0">
                                                    <span class="text-[11px] font-bold text-forest">
                                                        {{ strtoupper(substr($trx->rekening->nasabah->nama ?? 'N', 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-bold text-slate-900 truncate">
                                                        {{ $trx->rekening->nasabah->nama ?? 'Nasabah Tidak Ditemukan' }}
                                                    </p>
                                                    <p class="text-[10px] text-slate-500 truncate">
                                                        {{ $trx->rekening->nasabah->kategori ?? '-' }} ·
                                                        {{ \Carbon\Carbon::parse($trx->tanggal_transaksi, 'UTC')->setTimezone('Asia/Jakarta')->format('H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                            @if($trx->status === 'pending')
                                                <span class="text-[9px] font-bold text-amber-700 bg-amber-50 px-2 py-1 rounded-md border border-amber-200 flex-shrink-0">Pending</span>
                                            @elseif($trx->status === 'berhasil')
                                                <span class="text-[9px] font-bold text-emerald-700 bg-emerald-50 px-2 py-1 rounded-md border border-emerald-200 flex-shrink-0">Sukses</span>
                                            @elseif($trx->status === 'ditolak')
                                                <span class="text-[9px] font-bold text-red-700 bg-red-50 px-2 py-1 rounded-md border border-red-200 flex-shrink-0">Ditolak</span>
                                            @else
                                                <span class="text-[9px] font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded-md border border-slate-200 flex-shrink-0">{{ ucfirst($trx->status ?? '-') }}</span>
                                            @endif
                                        </div>
                                        <div class="flex justify-between items-center pl-11">
                                            @if($jenis === 'setoran')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-md text-[10px] font-bold">
                                                    <i class="fas fa-arrow-down text-[8px]"></i> Setoran
                                                </span>
                                            @elseif($jenis === 'penarikan')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-50 text-red-700 rounded-md text-[10px] font-bold">
                                                    <i class="fas fa-arrow-up text-[8px]"></i> Penarikan
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-50 text-blue-700 rounded-md text-[10px] font-bold">
                                                    {{ ucfirst($jenis ?: 'Lainnya') }}
                                                </span>
                                            @endif
                                            <p class="text-sm font-black {{ $jenis === 'penarikan' ? 'text-red-600' : 'text-emerald-600' }}">
                                                {{ $jenis === 'penarikan' ? '- ' : '+ ' }}Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-4 py-12 text-center">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-900">Belum ada transaksi</p>
                                        <p class="text-xs text-slate-500 mt-1">Transaksi akan muncul di sini</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar -->
                    <div class="space-y-5 lg:space-y-6">

                        <!-- Monthly Stats -->
                        <div class="gradient-forest rounded-2xl p-5 lg:p-6 shadow-xl shadow-forest/20 text-white">
                            <h3 class="text-sm font-extrabold mb-5 flex items-center gap-2">
                                <i class="fas fa-chart-pie text-mint"></i> Statistik Bulan Ini
                            </h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                    <span class="text-xs text-emerald-100 font-medium">Total Transaksi</span>
                                    <span class="text-sm font-black">{{ \App\Models\DetailTabungan::whereMonth('tanggal_transaksi', now()->month)->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                    <span class="text-xs text-emerald-100 font-medium">Total Setoran</span>
                                    <span class="text-sm font-black text-emerald-300">Rp {{ number_format($totalSetoranBulanIni ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                    <span class="text-xs text-emerald-100 font-medium">Total Penarikan</span>
                                    <span class="text-sm font-black text-red-300">Rp {{ number_format($totalPenarikanBulanIni ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-2">
                                    <span class="text-xs text-emerald-100 font-medium">Saldo Akhir</span>
                                    <span class="text-base font-black text-emerald-300">Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 lg:p-6">
                            <h3 class="text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-info-circle text-mint"></i> Informasi
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3 p-3 bg-mintLight/50 rounded-xl border border-mint/20">
                                    <div class="w-8 h-8 bg-mint rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-shield-alt text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-forest mb-0.5">Sistem Aman</p>
                                        <p class="text-[10px] text-slate-600">Semua transaksi terenkripsi dan tersimpan dengan aman.</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-xl border border-blue-200">
                                    <div class="w-8 h-8 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-headset text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 mb-0.5">Butuh Bantuan?</p>
                                        <p class="text-[10px] text-slate-600">Hubungi admin untuk bantuan teknis.</p>
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