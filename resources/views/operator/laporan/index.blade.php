<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Umum - Smart Pocket</title>
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

                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman
                </a>

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-check-circle w-5 text-center text-slate-400"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-chart-bar w-5 text-center text-mint"></i> Laporan
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
                <header class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1 flex-wrap">
                            <span>Laporan</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-forest font-bold">Jurnal Umum</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Jurnal Umum
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Catatan transaksi tabungan dan peminjaman BMT.
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

                <!-- Summary Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-5">

                    <!-- Total Jurnal -->
                    <div class="bg-white rounded-2xl p-4 lg:p-5 border border-slate-200/80 shadow-sm hover-lift">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-9 h-9 lg:w-11 lg:h-11 bg-slate-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-file-lines text-slate-600 text-sm lg:text-lg"></i>
                            </div>
                        </div>
                        <p class="text-[10px] lg:text-xs text-slate-500 font-semibold mb-0.5 lg:mb-1">Total Jurnal</p>
                        <p class="text-lg lg:text-2xl font-black text-slate-900">{{ $laporan->count() }}</p>
                    </div>

                    <!-- Total Debit -->
                    <div class="gradient-forest rounded-2xl p-4 lg:p-5 shadow-lg shadow-forest/20 relative overflow-hidden">
                        <div class="absolute -top-8 -right-8 w-28 h-28 bg-white/10 rounded-full"></div>
                        <div class="relative z-10">
                            <div class="w-9 h-9 lg:w-11 lg:h-11 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center mb-3">
                                <i class="fas fa-arrow-down text-white text-sm lg:text-lg"></i>
                            </div>
                            <p class="text-[10px] lg:text-xs text-emerald-100 font-semibold mb-0.5 lg:mb-1">Total Debit</p>
                            <p class="text-base lg:text-2xl font-black text-white break-all leading-tight">Rp {{ number_format($totalDebit ?? $laporan->sum('debit'), 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Total Kredit -->
                    <div class="col-span-2 lg:col-span-1 bg-white rounded-2xl p-4 lg:p-5 border border-slate-200/80 shadow-sm hover-lift">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-9 h-9 lg:w-11 lg:h-11 bg-red-50 rounded-xl flex items-center justify-center">
                                <i class="fas fa-arrow-up text-red-600 text-sm lg:text-lg"></i>
                            </div>
                        </div>
                        <p class="text-[10px] lg:text-xs text-slate-500 font-semibold mb-0.5 lg:mb-1">Total Kredit</p>
                        <p class="text-base lg:text-2xl font-black text-red-600 break-all leading-tight">Rp {{ number_format($totalKredit ?? $laporan->sum('kredit'), 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Filter Card -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 lg:p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                            <i class="fas fa-filter text-forest"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Filter Jurnal</h3>
                            <p class="text-[11px] text-slate-500">Pilih periode dan jenis transaksi</p>
                        </div>
                    </div>

                    <form action="{{ route('operator.laporan.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                            <!-- Tanggal Mulai -->
                            <div>
                                <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint bg-slate-50 focus:bg-white transition-all">
                            </div>

                            <!-- Tanggal Akhir -->
                            <div>
                                <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint bg-slate-50 focus:bg-white transition-all">
                            </div>

                            <!-- Jenis -->
                            <div>
                                <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Jenis</label>
                                <select name="jenis"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint transition-all cursor-pointer font-semibold">
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
                                <button type="submit" class="flex-1 px-5 py-2.5 rounded-xl bg-mint hover:bg-forest text-white text-sm font-extrabold transition-colors shadow-md shadow-mint/20 flex items-center justify-center gap-2">
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
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

                    <div class="p-4 lg:p-5 border-b border-slate-100 flex items-center gap-2">
                        <div class="w-1 h-5 bg-gradient-to-b from-mint to-forest rounded-full"></div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Jurnal Transaksi</h3>
                            <p class="text-[11px] text-slate-500">Pemasukan dan pengeluaran BMT</p>
                        </div>
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50/80">
                                <tr>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Jenis</th>
                                    <th class="px-5 py-3.5 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Debit</th>
                                    <th class="px-5 py-3.5 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Kredit</th>
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

                                    <tr class="hover:bg-mintLight/30 transition-colors">
                                        <td class="px-5 py-3.5 text-xs font-bold text-slate-700 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold border {{ $badge }}">
                                                {{ ucfirst($item['jenis'] ?? '-') }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3.5 text-right text-sm font-extrabold text-emerald-600 whitespace-nowrap">
                                            @if (!empty($item['debit']) && $item['debit'] > 0)
                                                Rp {{ number_format($item['debit'], 0, ',', '.') }}
                                            @else
                                                <span class="text-slate-300">—</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-right text-sm font-extrabold text-red-500 whitespace-nowrap">
                                            @if (!empty($item['kredit']) && $item['kredit'] > 0)
                                                Rp {{ number_format($item['kredit'], 0, ',', '.') }}
                                            @else
                                                <span class="text-slate-300">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-16 text-center">
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
                            <tfoot class="gradient-forest text-white">
                                <tr>
                                    <td colspan="2" class="px-5 py-4 font-extrabold text-sm tracking-wide">TOTAL</td>
                                    <td class="px-5 py-4 text-right font-extrabold text-emerald-300 whitespace-nowrap">
                                        Rp {{ number_format($totalDebit ?? $laporan->sum('debit'), 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-4 text-right font-extrabold text-red-300 whitespace-nowrap">
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
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold border {{ $badge }}">
                                        {{ ucfirst($item['jenis'] ?? '-') }}
                                    </span>
                                    <p class="text-[11px] text-slate-500 font-bold whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-emerald-50 rounded-xl px-3 py-2 border border-emerald-100">
                                        <p class="text-[9px] font-bold text-emerald-600 uppercase tracking-wider mb-0.5">Debit</p>
                                        <p class="text-xs font-extrabold text-emerald-700 truncate">
                                            @if (!empty($item['debit']) && $item['debit'] > 0)
                                                Rp {{ number_format($item['debit'], 0, ',', '.') }}
                                            @else
                                                —
                                            @endif
                                        </p>
                                    </div>
                                    <div class="bg-red-50 rounded-xl px-3 py-2 border border-red-100">
                                        <p class="text-[9px] font-bold text-red-500 uppercase tracking-wider mb-0.5">Kredit</p>
                                        <p class="text-xs font-extrabold text-red-600 truncate">
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
                            <div class="p-4 gradient-forest text-white">
                                <p class="text-[10px] font-extrabold tracking-widest text-emerald-100 uppercase mb-3">Total Keseluruhan</p>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <p class="text-[9px] text-emerald-100 font-bold uppercase tracking-wider mb-0.5">Debit</p>
                                        <p class="text-sm font-black text-emerald-300 break-all">
                                            Rp {{ number_format($totalDebit ?? $laporan->sum('debit'), 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] text-emerald-100 font-bold uppercase tracking-wider mb-0.5">Kredit</p>
                                        <p class="text-sm font-black text-red-300 break-all">
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
                    <p class="font-semibold">Smart Pocket • BMT SMKN 11 Bandung</p>
                    <p class="font-semibold">Jurnal Umum</p>
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