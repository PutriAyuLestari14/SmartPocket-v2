<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Umum - Smart Pocket</title>
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
        
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 12px 20px -8px rgba(21, 128, 61, 0.15); }
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

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-check-circle w-5 text-center text-slate-400"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-mintLight to-white text-primary rounded-xl text-sm font-bold transition-all shadow-sm border border-primary/30">
                    <i class="fas fa-chart-pie w-5 text-center text-primary"></i> Laporan
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
                            <span>Laporan</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-primary font-bold">Jurnal Umum</span>
                        </div>
                        <h2 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Jurnal Umum
                        </h2>
                        <p class="text-sm text-slate-500 mt-2 flex items-center gap-2 font-medium">
                            <i class="fas fa-file-lines text-primary"></i>
                            Catatan transaksi tabungan dan peminjaman BMT.
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

                <!-- Summary Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-5">

                    <!-- Total Jurnal -->
                    <div class="bg-white rounded-2xl p-4 lg:p-5 border border-slate-200/60 shadow-xl shadow-slate-200/50 hover-lift">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-9 h-9 lg:w-11 lg:h-11 bg-slate-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-file-lines text-slate-600 text-sm lg:text-lg"></i>
                            </div>
                        </div>
                        <p class="text-[10px] lg:text-xs text-slate-500 font-black uppercase tracking-wider mb-0.5 lg:mb-1">Total Jurnal</p>
                        <p class="text-lg lg:text-2xl font-black text-slate-900">{{ $laporan->count() }}</p>
                    </div>

                    <!-- Total Debit -->
                    <div class="gradient-soft rounded-2xl p-4 lg:p-5 shadow-xl shadow-primary/20 relative overflow-hidden hover-lift group">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-9 h-9 lg:w-11 lg:h-11 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center mb-3 border border-white/30">
                                <i class="fas fa-arrow-down text-white text-sm lg:text-lg"></i>
                            </div>
                            <p class="text-[10px] lg:text-xs text-emerald-100 font-black uppercase tracking-wider mb-0.5 lg:mb-1">Total Debit</p>
                            <p class="text-base lg:text-2xl font-black text-white break-all leading-tight">Rp {{ number_format($totalDebit ?? $laporan->sum('debit'), 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Total Kredit -->
                    <div class="col-span-2 lg:col-span-1 bg-white rounded-2xl p-4 lg:p-5 border border-rose-100 shadow-xl shadow-rose-500/5 hover-lift relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-rose-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="w-9 h-9 lg:w-11 lg:h-11 bg-gradient-to-br from-rose-400 to-rose-600 rounded-xl flex items-center justify-center mb-3 shadow-lg shadow-rose-500/30">
                                <i class="fas fa-arrow-up text-white text-sm lg:text-lg"></i>
                            </div>
                            <p class="text-[10px] lg:text-xs text-slate-500 font-black uppercase tracking-wider mb-0.5 lg:mb-1">Total Kredit</p>
                            <p class="text-base lg:text-2xl font-black text-rose-600 break-all leading-tight">Rp {{ number_format($totalKredit ?? $laporan->sum('kredit'), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Filter Card -->
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-5 lg:p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                            <i class="fas fa-filter text-primary text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">Filter Jurnal</h3>
                            <p class="text-[11px] text-slate-500">Pilih periode dan jenis transaksi</p>
                        </div>
                    </div>

                    <form action="{{ route('operator.laporan.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                            <!-- Tanggal Mulai -->
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-slate-50 focus:bg-white transition-all font-semibold">
                            </div>

                            <!-- Tanggal Akhir -->
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-slate-50 focus:bg-white transition-all font-semibold">
                            </div>

                            <!-- Jenis -->
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Jenis</label>
                                <select name="jenis"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all cursor-pointer font-bold">
                                    <option value="semua" {{ request('jenis', 'semua') == 'semua' ? 'selected' : '' }}>Semua</option>
                                    <option value="tabungan" {{ request('jenis') == 'tabungan' ? 'selected' : '' }}>Tabungan</option>
                                    <option value="peminjaman" {{ request('jenis') == 'peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                                    <option value="jasa" {{ request('jenis') == 'jasa' ? 'selected' : '' }}>Jasa</option>
                                    <option value="provisi" {{ request('jenis') == 'provisi' ? 'selected' : '' }}>Provisi</option>
                                    <option value="kas" {{ request('jenis') == 'kas' ? 'selected' : '' }}>Kas</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-2">
                                <button type="submit" class="flex-1 px-5 py-2.5 rounded-xl bg-primary hover:bg-primaryDark text-white text-sm font-black transition-colors shadow-md shadow-primary/30 flex items-center justify-center gap-2">
                                    <i class="fas fa-filter text-xs"></i> Filter
                                </button>
                                <a href="{{ route('operator.laporan.index') }}"
                                    class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-sm font-bold hover:bg-slate-200 transition-colors flex items-center justify-center">
                                    <i class="fas fa-rotate-left text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table Card -->
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 overflow-hidden">

                    <div class="p-4 lg:p-5 border-b border-slate-100 flex items-center gap-2">
                        <div class="w-1 h-5 bg-gradient-to-b from-primary to-primaryDark rounded-full"></div>
                        <div>
                            <h3 class="text-sm lg:text-base font-black text-slate-900">Jurnal Transaksi</h3>
                            <p class="text-[11px] text-slate-500">Pemasukan dan pengeluaran BMT</p>
                        </div>
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50/80">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Jenis</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-wider">Debit</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-wider">Kredit</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($laporan as $item)
                                    @php
                                        $jenis = strtolower($item['jenis'] ?? '');
                                        $badge = match ($jenis) {
                                            'tabungan' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'peminjaman' => 'bg-purple-50 text-purple-700 border-purple-200',
                                            'jasa' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'provisi' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'kas' => 'bg-slate-100 text-slate-700 border-slate-200',
                                            default => 'bg-slate-100 text-slate-700 border-slate-200',
                                        };
                                    @endphp

                                    <tr class="hover:bg-mintLight/20 transition-colors">
                                        <td class="px-6 py-4 text-xs font-bold text-slate-700 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black border {{ $badge }}">
                                                {{ ucfirst($item['jenis'] ?? '-') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-black text-primary whitespace-nowrap">
                                            @if (!empty($item['debit']) && $item['debit'] > 0)
                                                Rp {{ number_format($item['debit'], 0, ',', '.') }}
                                            @else
                                                <span class="text-slate-300">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-black text-rose-600 whitespace-nowrap">
                                            @if (!empty($item['kredit']) && $item['kredit'] > 0)
                                                Rp {{ number_format($item['kredit'], 0, ',', '.') }}
                                            @else
                                                <span class="text-slate-300">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center">
                                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-file-circle-xmark text-slate-400 text-2xl"></i>
                                            </div>
                                            <p class="text-sm font-bold text-slate-900">Belum ada data jurnal</p>
                                            <p class="text-xs text-slate-500 mt-1">Data transaksi akan muncul di sini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <!-- Total -->
                            <tfoot class="gradient-primary text-white">
                                <tr>
                                    <td colspan="2" class="px-6 py-4 font-black text-sm tracking-wide">TOTAL</td>
                                    <td class="px-6 py-4 text-right font-black text-accent whitespace-nowrap">
                                        Rp {{ number_format($totalDebit ?? $laporan->sum('debit'), 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-rose-300 whitespace-nowrap">
                                        Rp {{ number_format($totalKredit ?? $laporan->sum('kredit'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="md:hidden divide-y divide-slate-100">
                        @forelse ($laporan as $item)
                            @php
                                $jenis = strtolower($item['jenis'] ?? '');
                                $badge = match ($jenis) {
                                    'tabungan' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'peminjaman' => 'bg-purple-50 text-purple-700 border-purple-200',
                                    'jasa' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'provisi' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'kas' => 'bg-slate-100 text-slate-700 border-slate-200',
                                    default => 'bg-slate-100 text-slate-700 border-slate-200',
                                };
                            @endphp
                            <div class="p-4 active:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start gap-3 mb-3">
                                    <span class="inline-flex px-3 py-1.5 rounded-xl text-[10px] font-black border {{ $badge }}">
                                        {{ ucfirst($item['jenis'] ?? '-') }}
                                    </span>
                                    <p class="text-[11px] text-slate-500 font-bold whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-mintLight rounded-xl px-3 py-2 border border-primary/20">
                                        <p class="text-[9px] font-bold text-primary uppercase tracking-wider mb-0.5">Debit</p>
                                        <p class="text-xs font-black text-primary truncate">
                                            @if (!empty($item['debit']) && $item['debit'] > 0)
                                                Rp {{ number_format($item['debit'], 0, ',', '.') }}
                                            @else
                                                —
                                            @endif
                                        </p>
                                    </div>
                                    <div class="bg-rose-50 rounded-xl px-3 py-2 border border-rose-100">
                                        <p class="text-[9px] font-bold text-rose-600 uppercase tracking-wider mb-0.5">Kredit</p>
                                        <p class="text-xs font-black text-rose-700 truncate">
                                            @if (!empty($item['kredit']) && $item['kredit'] > 0)
                                                Rp {{ number_format($item['kredit'], 0, ',', '.') }}
                                            @else
                                                —
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-file-circle-xmark text-slate-400 text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-900">Belum ada data jurnal</p>
                                <p class="text-xs text-slate-500 mt-1">Data transaksi akan muncul di sini.</p>
                            </div>
                        @endforelse

                        @if($laporan->count() > 0)
                            <div class="p-4 gradient-primary text-white">
                                <p class="text-[10px] font-black tracking-widest text-emerald-100 uppercase mb-3">Total Keseluruhan</p>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <p class="text-[9px] text-emerald-100 font-bold uppercase tracking-wider mb-0.5">Debit</p>
                                        <p class="text-sm font-black text-accent break-all">
                                            Rp {{ number_format($totalDebit ?? $laporan->sum('debit'), 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] text-emerald-100 font-bold uppercase tracking-wider mb-0.5">Kredit</p>
                                        <p class="text-sm font-black text-rose-300 break-all">
                                            Rp {{ number_format($totalKredit ?? $laporan->sum('kredit'), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400 gap-2 pt-2">
                    <p class="font-bold">Smart Pocket • BMT SMKN 11 Bandung</p>
                    <p class="font-bold">Jurnal Umum</p>
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