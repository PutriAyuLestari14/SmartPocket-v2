<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 12px 20px -8px rgba(21, 128, 61, 0.15); }
        @keyframes softPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.15); opacity: 0.7; }
        }
        .pulse-dot { animation: softPulse 1.8s ease-in-out infinite; }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-primaryDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">

        <!-- Sidebar (Admin Version) -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl shadow-slate-200/50">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 gradient-vibrant rounded-xl flex items-center justify-center shadow-lg shadow-primary/30">
                            <i class="fas fa-wallet text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-base font-black text-primary tracking-tight">Smart Pocket</h1>
                            <p class="text-[10px] text-primaryDark font-bold tracking-wider">ADMIN PANEL</p>
                        </div>
                    </div>
                    <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-primary p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-1.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu Admin</p>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-mintLight to-white text-primary rounded-xl text-sm font-bold transition-all shadow-sm border border-primary/30">
                    <i class="fas fa-chart-line w-5 text-center text-primary"></i> Dashboard
                </a>

                <a href="{{ route('admin.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Kelola Nasabah
                </a>

                <a href="{{ route('admin.saldo.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-wallet w-5 text-center text-slate-400"></i> Update Saldo
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-money-bill-transfer w-5 text-center text-slate-400"></i> Laporan
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
                    <div class="w-10 h-10 gradient-soft rounded-xl flex items-center justify-center text-white shadow-md shadow-primary/30 flex-shrink-0">
                        <i class="fas fa-wallet text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-black text-primary tracking-tight leading-none">Smart Pocket</h1>
                        <p class="text-[10px] text-primaryDark font-bold tracking-wider mt-1">Admin Panel</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button onclick="toggleSidebar()" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform shadow-sm">
                        <i class="fas fa-bars text-base"></i>
                    </button>
                </div>
            </header>

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- Header -->
                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-1 flex-wrap">
                            <span>Overview</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-primary font-bold">Dashboard</span>
                        </div>
                        <h2 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Dashboard Admin
                        </h2>
                        <p class="text-sm text-slate-500 mt-2 flex items-center gap-2 font-medium">
                            <i class="fas fa-chart-line text-primary"></i>
                            Pantau performa sistem dan aktivitas pengguna Smart Pocket.
                        </p>
                    </div>

                    <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                        <div class="text-right">
                            <p class="text-xs font-black text-slate-800 leading-tight">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-0.5">Administrator</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl overflow-hidden gradient-vibrant text-white font-black text-sm flex items-center justify-center border-2 border-white shadow-lg shadow-primary/20 flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                </header>

                <!-- STATISTIK SISTEM (4 cards) -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-5">

                    <!-- Total Nasabah -->
                    <div class="hover-lift bg-white rounded-2xl p-4 lg:p-5 border border-blue-100 shadow-lg shadow-blue-500/5 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 lg:w-11 lg:h-11 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                                    <i class="fas fa-users text-white text-sm lg:text-base"></i>
                                </div>
                                <span class="text-[9px] lg:text-[10px] font-black text-primary bg-mintLight px-2 py-1 rounded-full border border-primary/20">
                                    <i class="fas fa-arrow-up text-[8px]"></i> 12%
                                </span>
                            </div>
                            <p class="text-[10px] lg:text-xs text-slate-500 font-black uppercase tracking-wider mb-0.5">Total Nasabah</p>
                            <p class="text-lg lg:text-2xl font-black text-slate-900">{{ $totalNasabah ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Total Transaksi -->
                    <div class="hover-lift bg-white rounded-2xl p-4 lg:p-5 border border-purple-100 shadow-lg shadow-purple-500/5 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-purple-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 lg:w-11 lg:h-11 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/30">
                                    <i class="fas fa-money-bill-transfer text-white text-sm lg:text-base"></i>
                                </div>
                                <span class="text-[9px] lg:text-[10px] font-black text-primary bg-mintLight px-2 py-1 rounded-full border border-primary/20">
                                    <i class="fas fa-arrow-up text-[8px]"></i> 8%
                                </span>
                            </div>
                            <p class="text-[10px] lg:text-xs text-slate-500 font-black uppercase tracking-wider mb-0.5">Total Transaksi</p>
                            <p class="text-lg lg:text-2xl font-black text-slate-900">{{ $totalTransaksi ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Total Saldo Kas -->
                    <div class="hover-lift gradient-soft rounded-2xl p-4 lg:p-5 shadow-xl shadow-primary/20 relative overflow-hidden group">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 lg:w-11 lg:h-11 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center mb-3 border border-white/30">
                                <i class="fas fa-wallet text-white text-sm lg:text-base"></i>
                            </div>
                            <p class="text-[10px] lg:text-xs text-emerald-100 font-black uppercase tracking-wider mb-0.5">Total Saldo Kas</p>
                            <p class="text-base lg:text-xl font-black text-white break-all leading-tight">Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}</p>
                            <p class="text-[9px] lg:text-[10px] text-emerald-100 mt-1">
                                <i class="fas fa-sync-alt text-[7px]"></i> {{ now()->format('H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Operator Aktif -->
                    <div class="hover-lift bg-white rounded-2xl p-4 lg:p-5 border border-primary/20 shadow-lg shadow-primary/5 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-mintLight rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 lg:w-11 lg:h-11 bg-gradient-to-br from-primary to-primaryDark rounded-xl flex items-center justify-center shadow-lg shadow-primary/30">
                                    <i class="fas fa-user-tie text-white text-sm lg:text-base"></i>
                                </div>
                                <span class="w-2.5 h-2.5 bg-primary rounded-full pulse-dot ring-4 ring-primary/20"></span>
                            </div>
                            <p class="text-[10px] lg:text-xs text-slate-500 font-black uppercase tracking-wider mb-0.5">Operator Aktif</p>
                            <p class="text-lg lg:text-2xl font-black text-slate-900">{{ $operatorAktif ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- GRAFIK + TRANSAKSI HARI INI -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-6">

                    <!-- Grafik Transaksi -->
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-5 lg:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                            <div>
                                <h3 class="text-sm lg:text-base font-black text-slate-900 flex items-center gap-2">
                                    <div class="w-1 h-5 bg-gradient-to-b from-primary to-primaryDark rounded-full"></div>
                                    Grafik Transaksi
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-1">Statistik 7 hari terakhir</p>
                            </div>

                            <!-- Filter Range -->
                            <div class="flex gap-1 p-1 bg-slate-100 rounded-xl">
                                <button onclick="setRange('harian')" id="btn-harian" class="px-3 py-1.5 text-[11px] font-black rounded-lg bg-white text-primary shadow-sm transition-all">Harian</button>
                                <button onclick="setRange('mingguan')" id="btn-mingguan" class="px-3 py-1.5 text-[11px] font-bold rounded-lg text-slate-500 hover:text-slate-700 transition-all">Mingguan</button>
                                <button onclick="setRange('bulanan')" id="btn-bulanan" class="px-3 py-1.5 text-[11px] font-bold rounded-lg text-slate-500 hover:text-slate-700 transition-all">Bulanan</button>
                            </div>
                        </div>

                        <div class="h-64 lg:h-72">
                            <canvas id="chartTransaksi"></canvas>
                        </div>
                    </div>

                    <!-- TRANSAKSI HARI INI -->
                    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-5 lg:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                                <div class="w-1 h-5 bg-gradient-to-b from-primary to-primaryDark rounded-full"></div>
                                Transaksi Hari Ini
                            </h3>
                            <span class="text-[10px] font-black text-primary bg-mintLight px-2 py-1 rounded-full border border-primary/20">
                                {{ $transaksiHariIniList->count() ?? 0 }}
                            </span>
                        </div>

                        <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                            @forelse($transaksiHariIniList ?? [] as $trx)
                                @php
                                    $jenisId = $trx->jenisTransaksi->id_jenis_transaksi ?? null;
                                    $isSetoran = $jenisId == 1;
                                    $isPenarikan = $jenisId == 2;
                                @endphp

                                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                                    <div class="w-9 h-9 {{ $isSetoran ? 'bg-mintLight' : 'bg-rose-50' }} rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas {{ $isSetoran ? 'fa-arrow-down text-primary' : 'fa-arrow-up text-rose-600' }} text-xs"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-slate-900 leading-snug truncate">
                                            {{ $trx->rekening->nasabah->nama ?? 'Nasabah' }}
                                        </p>
                                        <p class="text-[10px] text-slate-500 mt-0.5 leading-relaxed truncate font-medium">
                                            {{ $isSetoran ? 'Setoran' : ($isPenarikan ? 'Penarikan' : 'Transaksi') }}
                                            · {{ $trx->tanggal_transaksi ? $trx->tanggal_transaksi->timezone('Asia/Jakarta')->format('H:i') : '' }} WIB
                                        </p>
                                        <p class="text-xs font-black {{ $isSetoran ? 'text-primary' : 'text-rose-600' }} mt-1">
                                            {{ $isSetoran ? '+' : '-' }} Rp {{ number_format($trx->jumlah ?? 0, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                                    <div class="w-14 h-14 bg-mintLight rounded-2xl flex items-center justify-center mb-3">
                                        <i class="fas fa-receipt text-primary text-lg"></i>
                                    </div>
                                    <p class="text-xs font-bold text-slate-700">Belum ada transaksi hari ini</p>
                                    <p class="text-[10px] text-slate-400 mt-1">Transaksi baru akan muncul di sini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- AKTIVITAS TERBARU -->
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 overflow-hidden">
                    <div class="p-5 lg:p-6 border-b border-slate-100 flex items-center justify-between gap-3">
                        <div>
                            <h3 class="text-sm lg:text-base font-black text-slate-900 flex items-center gap-2">
                                <div class="w-1 h-5 bg-gradient-to-b from-primary to-primaryDark rounded-full"></div>
                                Aktivitas Terbaru
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-1">Log aktivitas operator & nasabah</p>
                        </div>
                        <a href="#" class="text-[11px] font-black text-primary hover:text-primaryDark transition-colors whitespace-nowrap flex items-center gap-1">
                            Lihat Semua <i class="fas fa-arrow-right text-[9px]"></i>
                        </a>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse($aktivitasTerbaru ?? [] as $log)
                            <div class="p-4 hover:bg-slate-50/60 transition-colors flex items-start gap-3.5">
                                <div class="w-9 h-9 bg-{{ $log->warna ?? 'slate' }}-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-{{ $log->icon ?? 'circle' }} text-{{ $log->warna ?? 'slate' }}-600 text-xs"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs lg:text-sm font-semibold text-slate-800 leading-snug">
                                        {!! $log->deskripsi ?? '' !!}
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-1 font-medium">
                                        <i class="far fa-clock text-[9px]"></i>
                                        {{ $log->created_at ? $log->created_at->diffForHumans() : '' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <!-- Demo aktivitas kalau belum ada data -->
                            <div class="p-4 hover:bg-slate-50/60 transition-colors flex items-start gap-3.5">
                                <div class="w-9 h-9 bg-mintLight rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-plus text-primary text-xs"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs lg:text-sm font-semibold text-slate-800 leading-snug">
                                        Operator <strong>Budi</strong> menambahkan nasabah baru <strong>Ahmad Fauzi</strong>
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-1 font-medium">
                                        <i class="far fa-clock text-[9px]"></i> 5 menit lalu
                                    </p>
                                </div>
                            </div>
                            <div class="p-4 hover:bg-slate-50/60 transition-colors flex items-start gap-3.5">
                                <div class="w-9 h-9 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check text-amber-600 text-xs"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs lg:text-sm font-semibold text-slate-800 leading-snug">
                                        Operator <strong>Siti</strong> menyetujui penarikan <strong>Rp 150.000</strong>
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-1 font-medium">
                                        <i class="far fa-clock text-[9px]"></i> 12 menit lalu
                                    </p>
                                </div>
                            </div>
                            <div class="p-4 hover:bg-slate-50/60 transition-colors flex items-start gap-3.5">
                                <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-right-to-bracket text-blue-600 text-xs"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs lg:text-sm font-semibold text-slate-800 leading-snug">
                                        Nasabah <strong>Dewi Lestari</strong> login ke sistem
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-1 font-medium">
                                        <i class="far fa-clock text-[9px]"></i> 30 menit lalu
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center text-[10px] text-slate-400 font-bold pt-2">
                    Smart Pocket • Admin Panel • BMT SMKN 11 Bandung
                </p>

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

        // ═══ CHART SETUP ═══
        const ctx = document.getElementById('chartTransaksi').getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(21, 128, 61, 0.25)');
        gradient.addColorStop(1, 'rgba(21, 128, 61, 0.0)');

        const chartConfig = {
            borderColor: '#15803d',
            backgroundColor: gradient,
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#15803d',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
        };

        const dataHarian = {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Transaksi',
                data: @json($grafikHarian ?? []),
                ...chartConfig
            }]
        };

        const dataMingguan = {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            datasets: [{
                label: 'Transaksi',
                data: @json($grafikMingguan ?? []),
                ...chartConfig
            }]
        };

        const dataBulanan = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Transaksi',
                data: @json($grafikBulanan ?? []),
                ...chartConfig
            }]
        };

        const chart = new Chart(ctx, {
            type: 'line',
            data: dataHarian,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#166534',
                        titleColor: '#dcfce7',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 10,
                        titleFont: { size: 11, weight: 'bold' },
                        bodyFont: { size: 12, weight: 'bold' },
                        displayColors: false,
                        callbacks: {
                            label: function (context) {
                                return context.parsed.y + ' transaksi';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#F1F5F9', drawBorder: false },
                        ticks: { color: '#94A3B8', font: { size: 10, weight: '600' }, padding: 8 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94A3B8', font: { size: 10, weight: '600' }, padding: 8 }
                    }
                }
            }
        });

        function setRange(range) {
            const buttons = ['harian', 'mingguan', 'bulanan'];
            buttons.forEach(b => {
                const btn = document.getElementById('btn-' + b);
                if (b === range) {
                    btn.classList.add('bg-white', 'text-primary', 'shadow-sm', 'font-black');
                    btn.classList.remove('text-slate-500', 'font-bold');
                } else {
                    btn.classList.remove('bg-white', 'text-primary', 'shadow-sm', 'font-black');
                    btn.classList.add('text-slate-500', 'font-bold');
                }
            });

            if (range === 'harian') chart.data = dataHarian;
            if (range === 'mingguan') chart.data = dataMingguan;
            if (range === 'bulanan') chart.data = dataBulanan;
            chart.update();
        }
    </script>
</body>
</html>