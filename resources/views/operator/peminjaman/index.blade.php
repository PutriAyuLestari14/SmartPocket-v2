<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman - Smart Pocket</title>
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
        .gradient-mint { background: linear-gradient(135deg, #4E9F3D 0%, #1A4D2E 100%); }
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); }
        @keyframes modalIn {
            from { opacity: 0; transform: translate(-50%, -50%) scale(0.95); }
            to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
        }
        @keyframes backdropIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-in { animation: modalIn 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .backdrop-in { animation: backdropIn 0.2s ease-out; }
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

                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>

                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Data Nasabah
                </a>

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-exchange-alt w-5 text-center text-slate-400"></i> Transaksi
                </a>

                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-hand-holding-usd w-5 text-center text-mint"></i> Peminjaman
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

            <!-- Mobile Top Bar -->
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

                <!-- Header -->
                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1 flex-wrap">
                            <span>Utama</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-forest font-bold">Peminjaman</span>
                        </div>

                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Peminjaman Staf & Guru
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Kelola data pengajuan dan angsuran pinjaman khusus pegawai.
                        </p>
                    </div>

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

                <!-- Action Buttons (mobile + desktop) -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button class="px-4 py-2.5 border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors flex items-center justify-center gap-2 bg-white">
                        <i class="fas fa-download text-xs"></i> Export Data
                    </button>
                    <a href="{{ route('operator.peminjaman.create') }}" class="px-4 py-2.5 bg-mint hover:bg-forest text-white rounded-xl text-sm font-extrabold transition-colors flex items-center justify-center gap-2 shadow-md shadow-mint/20">
                        <i class="fas fa-plus text-xs"></i> Input Peminjaman
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-5">

                    <div class="col-span-2 lg:col-span-1 gradient-forest rounded-2xl p-4 lg:p-5 shadow-lg shadow-forest/20 relative overflow-hidden">
                        <div class="absolute -top-8 -right-8 w-28 h-28 bg-white/10 rounded-full"></div>
                        <div class="relative z-10">
                            <div class="w-9 h-9 lg:w-11 lg:h-11 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center mb-3">
                                <i class="fas fa-wallet text-white text-sm lg:text-lg"></i>
                            </div>
                            <p class="text-[10px] lg:text-xs text-emerald-100 font-semibold mb-0.5 lg:mb-1">Total Pinjaman Aktif</p>
                            <p class="text-base lg:text-2xl font-black text-white break-all leading-tight">Rp {{ number_format($totalAktif ?? 0, 0, ',', '.') }}</p>
                            <p class="text-[9px] lg:text-[10px] text-emerald-200 mt-0.5 lg:mt-1">Dari {{ $totalPeminjam ?? 0 }} peminjam</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-4 lg:p-5 border border-slate-200/80 shadow-sm hover-lift">
                        <div class="w-9 h-9 lg:w-11 lg:h-11 bg-blue-50 rounded-xl flex items-center justify-center mb-3">
                            <i class="fas fa-calendar-check text-blue-600 text-sm lg:text-lg"></i>
                        </div>
                        <p class="text-[10px] lg:text-xs text-slate-500 font-semibold mb-0.5 lg:mb-1">Jasa</p>
                        <p class="text-base lg:text-2xl font-black text-slate-900 break-all leading-tight">Rp {{ number_format($jasaAktif, 0, ',', '.') }}</p>
                        <p class="text-[9px] lg:text-[10px] text-slate-400 mt-0.5 lg:mt-1">Jasa 1% dari peminjaman</p>
                    </div>

                    <div class="bg-white rounded-2xl p-4 lg:p-5 border border-slate-200/80 shadow-sm hover-lift">
                        <div class="w-9 h-9 lg:w-11 lg:h-11 bg-amber-50 rounded-xl flex items-center justify-center mb-3">
                            <i class="fas fa-exclamation-triangle text-amber-600 text-sm lg:text-lg"></i>
                        </div>
                        <p class="text-[10px] lg:text-xs text-slate-500 font-semibold mb-0.5 lg:mb-1">Provisi</p>
                        <p class="text-base lg:text-2xl font-black text-slate-900 break-all leading-tight">Rp {{ number_format($provisiAktif, 0, ',', '.') }}</p>
                        <p class="text-[9px] lg:text-[10px] text-slate-400 mt-0.5 lg:mt-1">Provisi 1% dari pinjaman</p>
                    </div>
                </div>

                <!-- Search & Table -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

                    <div class="p-4 lg:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <div class="w-1 h-5 bg-gradient-to-b from-mint to-forest rounded-full"></div>
                            <h3 class="text-sm font-extrabold text-slate-900">Daftar Peminjaman Aktif</h3>
                        </div>
                        <div class="relative sm:w-72">
                            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" id="searchPeminjaman" placeholder="Cari nama peminjam..."
                                class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all"
                                autocomplete="off">
                        </div>
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50/80">
                                <tr>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Nominal Pinjaman</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Tenor</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Sisa Cicilan</th>
                                    <th class="px-5 py-3.5 text-center text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($peminjamans as $peminjaman)
                                    @php
                                        $sisaBulan = $peminjaman->tenor;
                                    @endphp

                                    <tr class="hover:bg-mintLight/30 transition-colors">
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-mintLight to-emerald-200 flex items-center justify-center flex-shrink-0">
                                                    <span class="text-[11px] font-extrabold text-forest">
                                                        {{ strtoupper(substr($peminjaman->nasabah->nama ?? 'N', 0, 2)) }}
                                                    </span>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-bold text-slate-900 truncate max-w-[180px]">
                                                        {{ $peminjaman->nasabah->nama ?? 'N/A' }}
                                                    </p>
                                                    <p class="text-[10px] text-slate-500">
                                                        {{ $peminjaman->nasabah->kategori ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5 text-sm font-extrabold text-slate-900">
                                            Rp {{ number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') }}
                                        </td>
                                        <td class="px-5 py-3.5 text-xs font-bold text-slate-600">
                                            {{ $peminjaman->tenor }} Bulan
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-700 rounded-lg text-[10px] font-bold border border-blue-200">
                                                <i class="fas fa-clock text-[8px]"></i> {{ $sisaBulan }} Bulan
                                            </span>
                                        </td>
                                        <td class="px-5 py-3.5 text-center">
                                            <div class="flex justify-center gap-1.5">
                                                <button onclick="openMutasiPinjaman({{ $peminjaman->id_pinjaman }}, '{{ $peminjaman->nasabah->nama ?? '' }}', '{{ $peminjaman->nasabah->no_rek ?? '' }}')"
                                                    class="w-8 h-8 bg-emerald-50 hover:bg-mint hover:text-white text-emerald-600 rounded-lg flex items-center justify-center transition-colors"
                                                    title="Lihat Mutasi Peminjaman">
                                                    <i class="fas fa-eye text-xs"></i>
                                                </button>
                                                <button class="w-8 h-8 bg-blue-50 hover:bg-blue-500 hover:text-white text-blue-600 rounded-lg flex items-center justify-center transition-colors" title="Edit">
                                                    <i class="fas fa-edit text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-16 text-center">
                                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                                            </div>
                                            <p class="text-sm font-bold text-slate-900">Belum ada pinjaman yang disetujui</p>
                                            <p class="text-xs text-slate-500 mt-1">Data pinjaman aktif akan muncul di sini</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="md:hidden divide-y divide-slate-100">
                        @forelse($peminjamans as $peminjaman)
                            @php
                                $sisaBulan = $peminjaman->tenor;
                            @endphp
                            <div class="p-4 active:bg-slate-50 transition-colors peminjam-card">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-mintLight to-emerald-200 flex items-center justify-center flex-shrink-0">
                                        <span class="text-sm font-extrabold text-forest">
                                            {{ strtoupper(substr($peminjaman->nasabah->nama ?? 'N', 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-extrabold text-slate-900 truncate">{{ $peminjaman->nasabah->nama ?? 'N/A' }}</p>
                                        <p class="text-[10px] text-slate-500">{{ $peminjaman->nasabah->kategori ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2 mb-3">
                                    <div class="bg-slate-50 rounded-xl px-3 py-2">
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Pinjaman</p>
                                        <p class="text-xs font-extrabold text-slate-900 truncate">Rp {{ number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-blue-50 rounded-xl px-3 py-2">
                                        <p class="text-[9px] font-bold text-blue-500 uppercase tracking-wider mb-0.5">Sisa Cicilan</p>
                                        <p class="text-xs font-extrabold text-blue-700">{{ $sisaBulan }} Bulan</p>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <button onclick="openMutasiPinjaman({{ $peminjaman->id_pinjaman }}, '{{ $peminjaman->nasabah->nama ?? '' }}', '{{ $peminjaman->nasabah->no_rek ?? '' }}')"
                                        class="flex-1 py-2 bg-emerald-50 hover:bg-mint hover:text-white text-emerald-600 rounded-xl flex items-center justify-center gap-1.5 text-xs font-bold transition-colors">
                                        <i class="fas fa-eye text-[10px]"></i> Mutasi
                                    </button>
                                    <button class="flex-1 py-2 bg-blue-50 hover:bg-blue-500 hover:text-white text-blue-600 rounded-xl flex items-center justify-center gap-1.5 text-xs font-bold transition-colors">
                                        <i class="fas fa-edit text-[10px]"></i> Edit
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-900">Belum ada pinjaman yang disetujui</p>
                                <p class="text-xs text-slate-500 mt-1">Data pinjaman aktif akan muncul di sini</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="p-4 lg:p-5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                        <p class="text-[11px] text-slate-500 font-semibold">
                            Menampilkan {{ $peminjamans->firstItem() ?? 0 }}–{{ $peminjamans->lastItem() ?? 0 }} dari {{ $peminjamans->total() }} data
                        </p>
                        <div class="flex gap-1">
                            {{ $peminjamans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ═══ MODAL MUTASI PEMINJAMAN ═══ -->
    <div id="mutasiModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-forestDark/60 backdrop-blur-sm backdrop-in" onclick="closeMutasiModal()"></div>

        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[95%] max-w-5xl max-h-[90vh] overflow-y-auto bg-white rounded-3xl shadow-2xl modal-in">

            <!-- Header Modal -->
            <div class="sticky top-0 gradient-mint text-white px-5 lg:px-6 py-5 flex items-center justify-between rounded-t-3xl z-10 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4 min-w-0">
                    <div class="w-11 h-11 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-receipt text-white"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-base lg:text-lg font-extrabold">Mutasi Peminjaman</h3>
                        <p class="text-xs text-emerald-100 mt-0.5 truncate" id="modalNamaNasabah">-</p>
                    </div>
                </div>
                <button onclick="closeMutasiModal()" class="relative z-10 w-9 h-9 rounded-xl bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors flex-shrink-0">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Loading -->
            <div id="modalLoading" class="p-12 text-center">
                <div class="w-12 h-12 border-4 border-mintLight border-t-mint rounded-full animate-spin mx-auto mb-3"></div>
                <p class="text-sm text-slate-500 font-semibold">Memuat data mutasi peminjaman...</p>
            </div>

            <!-- Content -->
            <div id="modalContent" class="hidden">
                <div class="p-4 lg:p-6">
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead class="bg-slate-50/80">
                                    <tr>
                                        <th class="px-3 py-3 text-left font-extrabold text-slate-500 uppercase text-[10px] tracking-wider w-24">No. Rek</th>
                                        <th class="px-3 py-3 text-left font-extrabold text-slate-500 uppercase text-[10px] tracking-wider">Nama</th>
                                        <th class="px-3 py-3 text-center font-extrabold text-slate-500 uppercase text-[10px] tracking-wider w-24">Tanggal</th>
                                        <th class="px-3 py-3 text-center font-extrabold text-slate-500 uppercase text-[10px] tracking-wider w-28">Jenis</th>
                                        <th class="px-3 py-3 text-right font-extrabold text-slate-500 uppercase text-[10px] tracking-wider w-28">Debet</th>
                                        <th class="px-3 py-3 text-right font-extrabold text-slate-500 uppercase text-[10px] tracking-wider w-28">Kredit</th>
                                        <th class="px-3 py-3 text-right font-extrabold text-slate-500 uppercase text-[10px] tracking-wider w-32">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody id="modalTableBody" class="divide-y divide-slate-100"></tbody>
                                <tfoot class="bg-mintLight border-t-2 border-mint">
                                    <tr>
                                        <th colspan="4" class="px-3 py-3 text-left font-extrabold text-forest uppercase text-[10px] tracking-wider">Total</th>
                                        <th class="px-3 py-3 text-right font-extrabold text-forest text-[10px]" id="totalDebet">0</th>
                                        <th class="px-3 py-3 text-right font-extrabold text-forest text-[10px]" id="totalKredit">0</th>
                                        <th class="px-3 py-3 text-right font-extrabold text-forest text-[10px]" id="totalSaldo">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div id="modalEmptyState" class="hidden p-10 text-center">
                            <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-receipt text-slate-400 text-lg"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-700">Belum ada riwayat peminjaman</p>
                            <p class="text-xs text-slate-400 mt-1">Mutasi akan muncul setelah ada transaksi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══ SCRIPT (LOGIC TETAP SAMA) ═══ -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        const formatRupiah = (angka) => {
            return new Intl.NumberFormat('id-ID').format(angka || 0);
        };

        function openMutasiPinjaman(idPinjaman, namaNasabah, noRek) {
            console.log('Membuka mutasi untuk pinjaman ID:', idPinjaman);

            const modal = document.getElementById('mutasiModal');
            const loading = document.getElementById('modalLoading');
            const content = document.getElementById('modalContent');
            const emptyState = document.getElementById('modalEmptyState');
            const tableBody = document.getElementById('modalTableBody');

            modal.classList.remove('hidden');
            loading.classList.remove('hidden');
            content.classList.add('hidden');
            emptyState.classList.add('hidden');
            tableBody.innerHTML = '';
            document.getElementById('modalNamaNasabah').textContent = namaNasabah + (noRek ? ' - ' + noRek : '');

            const url = `/operator/peminjaman/mutasi/${idPinjaman}`;
            console.log('Fetching URL:', url);

            fetch(url)
                .then(res => {
                    console.log('Response status:', res.status);
                    return res.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    loading.classList.add('hidden');

                    if (!data.success) {
                        content.classList.remove('hidden');
                        tableBody.innerHTML = `<tr><td colspan="7" class="px-4 py-6 text-center text-sm text-red-600">${data.message || 'Data tidak ditemukan'}</td></tr>`;
                        return;
                    }

                    if (!data.transaksi || data.transaksi.length === 0) {
                        emptyState.classList.remove('hidden');
                        content.classList.remove('hidden');
                        return;
                    }

                    // Render transaksi
                    data.transaksi.forEach((t) => {
                        const row = document.createElement('tr');
                        row.className = 'hover:bg-mintLight/30 transition-colors';
                        row.innerHTML = `
                            <td class="px-3 py-3 text-[10px] font-mono text-slate-600">${data.nasabah.no_rek || '-'}</td>
                            <td class="px-3 py-3 text-[10px] font-semibold text-slate-900">${namaNasabah.substring(0, 15)}</td>
                            <td class="px-3 py-3 text-[10px] text-center text-slate-600">${t.tanggal}</td>
                            <td class="px-3 py-3 text-center">
                                ${t.jenis === 'bunga'
                                    ? '<span class="inline-block px-2 py-1 bg-amber-50 text-amber-700 rounded-lg text-[9px] font-bold border border-amber-200">BUNGA</span>'
                                    : t.jenis === 'pokok'
                                        ? '<span class="inline-block px-2 py-1 bg-blue-50 text-blue-700 rounded-lg text-[9px] font-bold border border-blue-200">POKOK</span>'
                                        : t.jenis === 'keduanya'
                                            ? '<span class="inline-block px-2 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[9px] font-bold border border-emerald-200">POKOK+BUNGA</span>'
                                            : '<span class="inline-block px-2 py-1 bg-purple-50 text-purple-700 rounded-lg text-[9px] font-bold border border-purple-200">PENCAIRAN</span>'}
                            </td>
                            <td class="px-3 py-3 text-[10px] font-semibold text-right ${t.debit > 0 ? 'text-emerald-600' : 'text-slate-400'}">
                                ${t.debit > 0 ? formatRupiah(t.debit).replace(/\./g, ' ') : '0'}
                            </td>
                            <td class="px-3 py-3 text-[10px] font-semibold text-right ${t.kredit > 0 ? 'text-red-600' : 'text-slate-400'}">
                                ${t.kredit > 0 ? formatRupiah(t.kredit).replace(/\./g, ' ') : '0'}
                            </td>
                            <td class="px-3 py-3 text-[10px] font-bold text-right text-slate-900 bg-slate-50">
                                ${formatRupiah(t.saldo).replace(/\./g, ' ')}
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });

                    document.getElementById('totalDebet').textContent = formatRupiah(data.total_debet).replace(/\./g, ' ');
                    document.getElementById('totalKredit').textContent = formatRupiah(data.total_kredit).replace(/\./g, ' ');
                    document.getElementById('totalSaldo').textContent = formatRupiah(data.saldo_akhir).replace(/\./g, ' ');

                    content.classList.remove('hidden');
                })
                .catch(err => {
                    console.error('Error fetching data:', err);
                    loading.classList.add('hidden');
                    content.classList.remove('hidden');
                    tableBody.innerHTML = `<tr><td colspan="7" class="px-4 py-6 text-center text-sm text-red-600">Gagal memuat data. Lihat console untuk detail error.</td></tr>`;
                });
        }

        function closeMutasiModal() {
            document.getElementById('mutasiModal').classList.add('hidden');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeMutasiModal();
        });

        document.getElementById('searchPeminjaman').addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('table tbody tr');
            const cards = document.querySelectorAll('.peminjam-card');

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