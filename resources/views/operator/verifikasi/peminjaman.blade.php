<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Peminjaman - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        .gradient-red { background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); }
        
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        @keyframes backdropIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-in { animation: modalIn 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .backdrop-in { animation: backdropIn 0.2s ease-out; }
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

                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
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

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-mintLight to-white text-primary rounded-xl text-sm font-bold transition-all shadow-sm border border-primary/30">
                    <i class="fas fa-check-circle w-5 text-center text-primary"></i> Verifikasi
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

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- Header -->
                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-1 flex-wrap">
                            <span>Utama</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-primary font-bold">Verifikasi</span>
                        </div>
                        <h2 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Verifikasi Transaksi
                        </h2>
                        <p class="text-sm text-slate-500 mt-2 flex items-center gap-2 font-medium">
                            <i class="fas fa-check-circle text-primary"></i>
                            Kelola dan setujui permintaan transaksi yang tertunda dari nasabah.
                        </p>
                    </div>

                    <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                        <div class="text-right">
                            <p class="text-xs font-black text-slate-800 leading-tight">
                                {{ auth()->user()->petugas->nama_lengkap ?? auth()->user()->name }}
                            </p>
                            <p class="text-[10px] font-bold text-slate-400 mt-0.5">Operator Shift Pagi</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl overflow-hidden gradient-vibrant text-white font-black text-sm flex items-center justify-center border-2 border-white shadow-lg shadow-primary/20 flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->petugas->nama_lengkap ?? auth()->user()->name, 0, 1)) }}
                        </div>
                        <a href="{{ route('operator.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 hover:text-primary hover:border-primary transition-all relative shadow-sm ml-1">
                            <i class="far fa-bell text-base"></i>
                            @php $pendingNotif = \App\Models\DetailTabungan::where('status', 'pending')->count(); @endphp
                            @if($pendingNotif > 0)
                                <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                            @endif
                        </a>
                    </div>
                </header>

                <!-- Session Alert -->
                @if(session('success'))
                    <div class="p-4 bg-mintLight border border-primary/30 rounded-2xl flex items-start gap-3">
                        <div class="w-8 h-8 bg-primary rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <p class="text-sm font-bold text-primary pt-1">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3">
                        <div class="w-8 h-8 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation text-white text-xs"></i>
                        </div>
                        <p class="text-sm font-bold text-red-700 pt-1">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Tab Navigation -->
                <div class="flex gap-2 p-1 bg-white border border-slate-200/60 rounded-2xl shadow-sm w-full sm:w-fit">
                    <a href="{{ route('operator.verifikasi.index') }}"
                        class="flex-1 sm:flex-initial px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-black transition-all text-center {{ request()->routeIs('operator.verifikasi.index') ? 'gradient-primary text-white shadow-md shadow-primary/20' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i class="fas fa-money-bill-wave text-[10px] mr-1"></i> Penarikan ({{ $pendingCount }})
                    </a>
                    <a href="{{ route('operator.verifikasi.peminjaman') }}"
                        class="flex-1 sm:flex-initial px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-black transition-all text-center {{ request()->routeIs('operator.verifikasi.peminjaman') ? 'gradient-primary text-white shadow-md shadow-primary/20' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i class="fas fa-hand-holding-usd text-[10px] mr-1"></i> Pinjaman
                    </a>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 lg:gap-6">

                    <!-- Table Section -->
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 overflow-hidden">

                            <!-- Header + Search -->
                            <div class="p-4 lg:p-5 border-b border-slate-100 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-1 h-5 bg-gradient-to-b from-primary to-primaryDark rounded-full"></div>
                                    <h3 class="text-sm lg:text-base font-black text-slate-900">Pengajuan Pinjaman Pending</h3>
                                </div>
                                <div class="relative sm:w-72">
                                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                    <input type="text" id="searchVerifikasi" placeholder="Cari nama atau no. rekening..."
                                        class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all"
                                        autocomplete="off">
                                </div>
                            </div>

                            <!-- Desktop Table -->
                            <div class="hidden md:block overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-slate-50/80">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Nasabah</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Jenis</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Nominal</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-4 text-center text-[10px] font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse($peminjamans as $index => $item)
                                            <tr class="hover:bg-mintLight/20 transition-colors">
                                                <td class="px-6 py-4 text-xs font-black text-slate-900">{{ $peminjamans->firstItem() + $index }}</td>
                                                <td class="px-6 py-4 text-xs font-bold text-slate-700">
                                                    {{ $item->tanggal_ajuan->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-mintLight to-emerald-100 flex items-center justify-center flex-shrink-0">
                                                            <span class="text-[10px] font-black text-primary">
                                                                {{ strtoupper(substr($item->nasabah->nama ?? 'N', 0, 1)) }}
                                                            </span>
                                                        </div>
                                                        <div class="min-w-0">
                                                            <p class="text-sm font-bold text-slate-900 truncate max-w-[160px]">
                                                                {{ $item->nasabah->nama ?? 'Data tidak tersedia' }}
                                                            </p>
                                                            <p class="text-[10px] text-slate-500 font-medium">
                                                                NIS: {{ $item->nasabah->user->username ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-xl text-[10px] font-black border border-blue-200">
                                                        <i class="fas fa-hand-holding-usd text-[8px]"></i> Peminjaman
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-black text-slate-900">
                                                    Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 rounded-xl text-[10px] font-black border border-amber-200">
                                                        <i class="fas fa-clock text-[8px]"></i> Tertunda
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex justify-center gap-1.5">
                                                        <button type="button" onclick="openApproveLoanModal('{{ $item->id_pinjaman }}', '{{ $item->jumlah_pinjaman }}', '{{ $item->nasabah->nama ?? 'Nasabah' }}')"
                                                            class="w-8 h-8 bg-primary hover:bg-primaryDark text-white rounded-lg flex items-center justify-center transition-colors shadow-md shadow-primary/30" title="Setujui">
                                                            <i class="fas fa-check text-xs"></i>
                                                        </button>
                                                        <button type="button" onclick="openRejectLoanModal('{{ $item->id_pinjaman }}', '{{ $item->nasabah->nama ?? 'Nasabah' }}')"
                                                            class="w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-lg flex items-center justify-center transition-colors shadow-md shadow-red-500/30" title="Tolak">
                                                            <i class="fas fa-times text-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-6 py-16 text-center">
                                                    <div class="w-16 h-16 bg-mintLight rounded-full flex items-center justify-center mx-auto mb-3">
                                                        <i class="fas fa-check-double text-primary text-2xl"></i>
                                                    </div>
                                                    <p class="text-sm font-bold text-slate-900">Tidak ada pengajuan pending</p>
                                                    <p class="text-xs text-slate-500 mt-1">Semua pengajuan peminjaman telah diproses.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card List -->
                            <div class="md:hidden divide-y divide-slate-100">
                                @forelse($peminjamans as $index => $item)
                                    <div class="p-4 active:bg-slate-50 transition-colors verifikasi-card">
                                        <div class="flex justify-between items-start gap-3 mb-3">
                                            <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-mintLight to-emerald-100 flex items-center justify-center flex-shrink-0">
                                                    <span class="text-sm font-black text-primary">
                                                        {{ strtoupper(substr($item->nasabah->nama ?? 'N', 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-bold text-slate-900 truncate">
                                                        {{ $item->nasabah->nama ?? 'Data tidak tersedia' }}
                                                    </p>
                                                    <p class="text-[10px] text-slate-500 truncate font-medium">
                                                        NIS: {{ $item->nasabah->user->username ?? '-' }} · {{ $item->tanggal_ajuan->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-amber-50 text-amber-700 rounded-lg text-[9px] font-black border border-amber-200 flex-shrink-0">
                                                <i class="fas fa-clock text-[7px]"></i> Tertunda
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-2 gap-2 mb-3">
                                            <div class="bg-blue-50 rounded-xl px-3 py-2">
                                                <p class="text-[9px] font-bold text-blue-600 uppercase tracking-wider mb-0.5">Jenis</p>
                                                <p class="text-xs font-black text-blue-700">Peminjaman</p>
                                            </div>
                                            <div class="bg-mintLight rounded-xl px-3 py-2">
                                                <p class="text-[9px] font-bold text-primary uppercase tracking-wider mb-0.5">Nominal</p>
                                                <p class="text-xs font-black text-primary truncate">Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        <div class="flex gap-2">
                                            <button type="button" onclick="openApproveLoanModal('{{ $item->id_pinjaman }}', '{{ $item->jumlah_pinjaman }}', '{{ $item->nasabah->nama ?? 'Nasabah' }}')"
                                                class="flex-1 py-2.5 bg-primary hover:bg-primaryDark text-white rounded-xl flex items-center justify-center gap-1.5 text-xs font-black transition-colors shadow-md shadow-primary/30">
                                                <i class="fas fa-check text-[10px]"></i> Setujui
                                            </button>
                                            <button type="button" onclick="openRejectLoanModal('{{ $item->id_pinjaman }}', '{{ $item->nasabah->nama ?? 'Nasabah' }}')"
                                                class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl flex items-center justify-center gap-1.5 text-xs font-black transition-colors shadow-md shadow-red-500/30">
                                                <i class="fas fa-times text-[10px]"></i> Tolak
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-4 py-16 text-center">
                                        <div class="w-16 h-16 bg-mintLight rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-check-double text-primary text-2xl"></i>
                                        </div>
                                        <p class="text-sm font-bold text-slate-900">Tidak ada pengajuan pending</p>
                                        <p class="text-xs text-slate-500 mt-1">Semua pengajuan peminjaman telah diproses.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Pagination -->
                            @if($peminjamans->hasPages())
                                <div class="p-4 lg:p-5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                                    <p class="text-[11px] text-slate-500 font-semibold">
                                        Menampilkan {{ $peminjamans->firstItem() }}–{{ $peminjamans->lastItem() }} dari {{ $peminjamans->total() }} transaksi
                                    </p>
                                    <div class="flex gap-1">
                                        {{ $peminjamans->links('pagination::tailwind') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Sidebar -->
                    <div class="lg:col-span-1 space-y-5 lg:space-y-6">

                        <!-- Ringkasan Hari Ini -->
                        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-5">
                            <h3 class="text-sm font-black text-slate-900 mb-4 flex items-center gap-2">
                                <div class="w-8 h-8 bg-mintLight rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chart-pie text-primary text-xs"></i>
                                </div>
                                Ringkasan Hari Ini
                            </h3>

                            <div class="space-y-3">
                                <div class="p-3.5 bg-amber-50 rounded-xl border border-amber-200">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-black text-amber-800">Menunggu</span>
                                        <span class="text-lg font-black text-amber-600">{{ $pendingCount }}</span>
                                    </div>
                                    <div class="w-full bg-amber-200 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-amber-500 h-1.5 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>

                                <div class="p-3.5 bg-mintLight rounded-xl border border-primary/20">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-black text-primary">Disetujui</span>
                                        <span class="text-lg font-black text-primary">{{ $approvedToday }}</span>
                                    </div>
                                    <div class="w-full bg-emerald-200 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-primary h-1.5 rounded-full" style="width: {{ $approvedToday > 0 ? '85%' : '0%' }}"></div>
                                    </div>
                                </div>

                                <div class="p-3.5 bg-rose-50 rounded-xl border border-rose-200">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-black text-rose-800">Ditolak</span>
                                        <span class="text-lg font-black text-rose-600">{{ $rejectedToday }}</span>
                                    </div>
                                    <div class="w-full bg-rose-200 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-rose-500 h-1.5 rounded-full" style="width: {{ $rejectedToday > 0 ? '15%' : '0%' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SOP Peminjaman -->
                        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-5">
                            <h3 class="text-sm font-black text-slate-900 mb-4 flex items-center gap-2">
                                <div class="w-8 h-8 bg-mintLight rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-contract text-primary text-xs"></i>
                                </div>
                                SOP Peminjaman
                            </h3>

                            <div class="space-y-3">
                                <div class="flex gap-3">
                                    <span class="w-6 h-6 bg-mintLight text-primary rounded-full flex items-center justify-center flex-shrink-0 text-[10px] font-black">1</span>
                                    <p class="text-xs text-slate-600 leading-relaxed pt-0.5 font-medium">Peminjaman <strong>hanya untuk Guru & Staf</strong> (Siswa tidak dapat mengajukan).</p>
                                </div>
                                <div class="flex gap-3">
                                    <span class="w-6 h-6 bg-mintLight text-primary rounded-full flex items-center justify-center flex-shrink-0 text-[10px] font-black">2</span>
                                    <p class="text-xs text-slate-600 leading-relaxed pt-0.5 font-medium">Pastikan <strong>tenor & jatuh tempo</strong> realistis sesuai kemampuan bayar peminjam.</p>
                                </div>
                                <div class="flex gap-3">
                                    <span class="w-6 h-6 bg-mintLight text-primary rounded-full flex items-center justify-center flex-shrink-0 text-[10px] font-black">3</span>
                                    <p class="text-xs text-slate-600 leading-relaxed pt-0.5 font-medium">Setelah disetujui, <strong>dana pinjaman dapat dicairkan</strong> sesuai prosedur BMT.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ═══ MODAL APPROVE PEMINJAMAN ═══ -->
    <div id="approveLoanModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-primaryDark/60 backdrop-blur-sm backdrop-in" onclick="closeApproveLoanModal()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden modal-in">
            <div class="gradient-primary px-6 py-6 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check-circle text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black">Setujui Peminjaman?</h3>
                        <p class="text-xs text-emerald-100 mt-0.5">Konfirmasi persetujuan pinjaman</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="text-center mb-4">
                    <p class="text-sm font-bold text-slate-800 mb-1">
                        <span id="approveLoanName" class="text-slate-900">-</span>
                    </p>
                    <p class="text-xs text-slate-500 mb-2 font-medium">Nominal pinjaman</p>
                    <p id="approveLoanAmount" class="text-3xl font-black text-primary break-all">Rp 0</p>
                </div>

                <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl flex gap-2">
                    <i class="fas fa-info-circle text-amber-600 text-xs mt-0.5"></i>
                    <p class="text-[11px] text-amber-800 leading-relaxed font-bold">
                        Pastikan data peminjaman sudah sesuai sebelum disetujui.
                    </p>
                </div>
            </div>

            <div class="p-6 pt-0 flex gap-3">
                <button type="button" onclick="closeApproveLoanModal()" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </button>
                <form id="approveLoanForm" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-primary hover:bg-primaryDark text-white rounded-xl font-black text-sm transition-colors flex items-center justify-center gap-2 shadow-md shadow-primary/30">
                        <i class="fas fa-check text-xs"></i> Ya, Setujui
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ═══ MODAL REJECT PEMINJAMAN ═══ -->
    <div id="rejectLoanModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-primaryDark/60 backdrop-blur-sm backdrop-in" onclick="closeRejectLoanModal()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden modal-in">
            <div class="gradient-red px-6 py-6 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-times-circle text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black">Tolak Peminjaman?</h3>
                        <p class="text-xs text-rose-100 mt-0.5">Konfirmasi penolakan pinjaman</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <p class="text-sm text-slate-600 text-center leading-relaxed font-medium">
                    Apakah kamu yakin ingin <span class="font-black text-rose-600">menolak</span> pengajuan peminjaman
                    <span id="rejectLoanName" class="font-bold text-slate-900"></span>?
                </p>

                <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl mt-4 flex gap-2">
                    <i class="fas fa-exclamation-circle text-rose-600 text-xs mt-0.5"></i>
                    <p class="text-[11px] text-rose-700 leading-relaxed font-bold">
                        Pengajuan yang ditolak akan berstatus ditolak.
                    </p>
                </div>
            </div>

            <div class="p-6 pt-0 flex gap-3">
                <button type="button" onclick="closeRejectLoanModal()" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </button>
                <form id="rejectLoanForm" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-black text-sm transition-colors flex items-center justify-center gap-2 shadow-md shadow-red-500/30">
                        <i class="fas fa-times text-xs"></i> Ya, Tolak
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        /* APPROVE LOAN MODAL */
        function openApproveLoanModal(id, amount, name) {
            const modal = document.getElementById('approveLoanModal');
            const form = document.getElementById('approveLoanForm');
            form.action = `/operator/peminjaman/${id}/approve`;
            document.getElementById('approveLoanName').textContent = name;
            document.getElementById('approveLoanAmount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeApproveLoanModal() {
            const modal = document.getElementById('approveLoanModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        /* REJECT LOAN MODAL */
        function openRejectLoanModal(id, name) {
            const modal = document.getElementById('rejectLoanModal');
            const form = document.getElementById('rejectLoanForm');
            form.action = `/operator/peminjaman/${id}/reject`;
            document.getElementById('rejectLoanName').textContent = name;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeRejectLoanModal() {
            const modal = document.getElementById('rejectLoanModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        /* CLOSE ON BACKDROP */
        document.getElementById('approveLoanModal').addEventListener('click', function (e) {
            if (e.target === this) closeApproveLoanModal();
        });

        document.getElementById('rejectLoanModal').addEventListener('click', function (e) {
            if (e.target === this) closeRejectLoanModal();
        });

        /* ESC KEY */
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeApproveLoanModal();
                closeRejectLoanModal();
            }
        });

        /* SEARCH */
        document.getElementById('searchVerifikasi').addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('table tbody tr');
            const cards = document.querySelectorAll('.verifikasi-card');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });

            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(keyword) ? '' : 'none';
            });
        });
    </script>
</body>
</html>