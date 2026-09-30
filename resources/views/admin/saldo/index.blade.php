<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Saldo Nasabah - Admin Smart Pocket</title>
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
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center shadow-md shadow-forest/20">
                            <i class="fas fa-wallet text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-base font-extrabold text-forest tracking-tight">Smart Pocket</h1>
                            <p class="text-[10px] text-mint font-bold tracking-wider">ADMIN PANEL</p>
                        </div>
                    </div>
                    <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-forest p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-chart-line w-5 text-center text-slate-400"></i> Dashboard
                </a>

                <a href="{{ route('admin.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Data Nasabah
                </a>

                <a href="{{ route('admin.saldo.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-wallet w-5 text-center text-mint"></i> Update Saldo
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-money-bill-transfer w-5 text-center text-slate-400"></i> Laporan
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-cog w-5 text-center text-slate-400"></i> Pengaturan
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
                    <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center text-white shadow-md shadow-forest/20 flex-shrink-0">
                        <i class="fas fa-shield-halved text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-forest tracking-tight leading-none">Smart Pocket</h1>
                        <p class="text-[10px] text-mint font-bold tracking-wider mt-1">Admin Panel</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="#" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative active:scale-95 transition-transform">
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
                            <span>Manajemen</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-forest font-bold">Update Saldo</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Update Saldo Nasabah
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Pembagian hasil jasa pinjaman kepada nasabah berdasarkan periode.
                        </p>
                    </div>
                </header>

                <!-- Session Alert -->
                @if(session('success'))
                    <div class="p-4 bg-mintLight border border-mint/30 rounded-2xl flex items-start gap-3">
                        <div class="w-8 h-8 bg-mint rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <p class="text-sm font-bold text-forest pt-1">{{ session('success') }}</p>
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

                <!-- Filter Periode -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 lg:p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-days text-forest"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Periode Pembagian</h3>
                            <p class="text-[11px] text-slate-500">Pilih bulan untuk menghitung pembagian hasil jasa.</p>
                        </div>
                    </div>

                    <form method="GET" action="{{ url()->current() }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div>
                                <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Bulan</label>
                                <input type="month" name="periode" value="{{ request('periode', now()->format('Y-m')) }}"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold bg-slate-50 focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all">
                            </div>

                            <div>
                                <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Total Jasa Bulan Ini</label>
                                <div class="w-full rounded-xl bg-mintLight border border-mint/20 px-4 py-2.5 text-sm font-extrabold text-forest">
                                    Rp {{ number_format($totalJasa ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-mint hover:bg-forest text-white rounded-xl text-sm font-extrabold transition-colors shadow-md shadow-mint/20">
                                    <i class="fas fa-calculator text-xs"></i> Hitung Pembagian
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Ringkasan -->
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-5">
                    <!-- Total Jasa -->
                    <div class="hover-lift bg-white rounded-2xl p-4 lg:p-5 border border-slate-200/80 shadow-sm col-span-2 lg:col-span-1">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 lg:w-11 lg:h-11 bg-blue-50 rounded-xl flex items-center justify-center">
                                <i class="fas fa-hand-holding-dollar text-blue-600 text-sm lg:text-base"></i>
                            </div>
                        </div>
                        <p class="text-[10px] lg:text-xs text-slate-500 font-semibold mb-0.5">Total Jasa</p>
                        <p class="text-base lg:text-xl font-black text-slate-900 break-all">Rp {{ number_format($totalJasa ?? 0, 0, ',', '.') }}</p>
                    </div>

                    <!-- Dana Dibagikan -->
                    <div class="hover-lift gradient-forest rounded-2xl p-4 lg:p-5 shadow-lg shadow-forest/20 relative overflow-hidden">
                        <div class="absolute -top-8 -right-8 w-28 h-28 bg-white/10 rounded-full"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 lg:w-11 lg:h-11 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center mb-3">
                                <i class="fas fa-users text-white text-sm lg:text-base"></i>
                            </div>
                            <p class="text-[10px] lg:text-xs text-emerald-100 font-semibold mb-0.5">Dana Dibagikan</p>
                            <p class="text-base lg:text-xl font-black text-white break-all">Rp {{ number_format($totalBagiHasil ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Jumlah Nasabah -->
                    <div class="hover-lift bg-white rounded-2xl p-4 lg:p-5 border border-slate-200/80 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 lg:w-11 lg:h-11 bg-amber-50 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-group text-amber-600 text-sm lg:text-base"></i>
                            </div>
                        </div>
                        <p class="text-[10px] lg:text-xs text-slate-500 font-semibold mb-0.5">Jumlah Nasabah</p>
                        <p class="text-lg lg:text-2xl font-black text-slate-900">{{ $nasabahs->total() ?? 0 }}</p>
                    </div>
                </div>

                <!-- Status Pembagian -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 lg:p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Status Pembagian</p>

                            @if($sudahDiproses ?? false)
                                <div class="flex items-center gap-2 mt-2 text-forest font-extrabold text-sm">
                                    <div class="w-6 h-6 bg-mint rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    Sudah diproses
                                </div>
                                <p class="text-xs text-slate-500 mt-1">
                                    Pembagian untuk periode <span class="font-bold text-slate-700">{{ request('periode', now()->format('Y-m')) }}</span> sudah dilakukan.
                                </p>
                            @else
                                <div class="flex items-center gap-2 mt-2 text-amber-600 font-extrabold text-sm">
                                    <div class="w-6 h-6 bg-amber-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-clock text-white text-xs"></i>
                                    </div>
                                    Belum diproses
                                </div>
                                <p class="text-xs text-slate-500 mt-1">
                                    Saldo nasabah belum diperbarui untuk periode ini.
                                </p>
                            @endif
                        </div>

                        @if(!($sudahDiproses ?? false))
                            <form method="POST" action="{{ route('admin.saldo.proses') }}"
                                onsubmit="return confirm('Yakin ingin memperbarui saldo seluruh nasabah untuk periode ini?')"
                                class="flex-shrink-0">
                                @csrf
                                <input type="hidden" name="periode" value="{{ request('periode', now()->format('Y-m')) }}">
                                <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 bg-mint hover:bg-forest text-white rounded-xl text-sm font-extrabold transition-colors shadow-md shadow-mint/20">
                                    <i class="fas fa-wallet text-xs"></i> Proses Update Saldo
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Tabel Nasabah -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

                    <div class="p-4 lg:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <div class="w-1 h-5 bg-gradient-to-b from-mint to-forest rounded-full"></div>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900">Daftar Nasabah</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Perkiraan pembagian saldo berdasarkan data nasabah.</p>
                            </div>
                        </div>
                        <div class="text-xs text-slate-500 font-semibold whitespace-nowrap">
                            Periode: <span class="font-extrabold text-forest">{{ request('periode', now()->format('Y-m')) }}</span>
                        </div>
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50/80">
                                <tr>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Nama Nasabah</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">No. Rekening</th>
                                    <th class="px-5 py-3.5 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Saldo Saat Ini</th>
                                    <th class="px-5 py-3.5 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Bagi Hasil</th>
                                    <th class="px-5 py-3.5 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Saldo Setelah Update</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($nasabahs as $n)
                                    @php
                                        $saldo = $n->rekening->saldo ?? 0;
                                        $bagiHasil = $n->bagi_hasil ?? 0;
                                        $saldoSetelah = $saldo + $bagiHasil;
                                    @endphp
                                    <tr class="hover:bg-mintLight/30 transition-colors">
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-mintLight to-emerald-200 flex items-center justify-center flex-shrink-0">
                                                    <span class="text-[11px] font-extrabold text-forest">{{ strtoupper(substr($n->nama ?? 'N', 0, 2)) }}</span>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-bold text-slate-900 truncate">{{ $n->nama }}</p>
                                                    <p class="text-[10px] text-slate-500 truncate">{{ $n->username ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5 text-xs font-bold text-forest font-mono">{{ $n->rekening->no_rek ?? '-' }}</td>
                                        <td class="px-5 py-3.5 text-sm font-bold text-slate-700 text-right whitespace-nowrap">Rp {{ number_format($saldo, 0, ',', '.') }}</td>
                                        <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                            @if($bagiHasil > 0)
                                                <span class="text-sm font-extrabold text-mint">+ Rp {{ number_format($bagiHasil, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-slate-300 text-sm">—</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-sm font-extrabold text-slate-900 text-right whitespace-nowrap">Rp {{ number_format($saldoSetelah, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-16 text-center">
                                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-users text-slate-400 text-2xl"></i>
                                            </div>
                                            <p class="text-sm font-bold text-slate-900">Belum ada data nasabah</p>
                                            <p class="text-xs text-slate-500 mt-1">Data akan muncul di sini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="md:hidden divide-y divide-slate-100">
                        @forelse($nasabahs as $n)
                            @php
                                $saldo = $n->rekening->saldo ?? 0;
                                $bagiHasil = $n->bagi_hasil ?? 0;
                                $saldoSetelah = $saldo + $bagiHasil;
                            @endphp
                            <div class="p-4 active:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-mintLight to-emerald-200 flex items-center justify-center flex-shrink-0">
                                        <span class="text-sm font-extrabold text-forest">{{ strtoupper(substr($n->nama ?? 'N', 0, 2)) }}</span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-extrabold text-slate-900 truncate">{{ $n->nama }}</p>
                                        <p class="text-[10px] text-slate-500 font-mono truncate">{{ $n->rekening->no_rek ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-slate-50 rounded-xl px-3 py-2">
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Saldo</p>
                                        <p class="text-xs font-extrabold text-slate-700 truncate">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-mintLight rounded-xl px-3 py-2">
                                        <p class="text-[9px] font-bold text-forest uppercase tracking-wider mb-0.5">Bagi Hasil</p>
                                        <p class="text-xs font-extrabold text-mint truncate">
                                            @if($bagiHasil > 0)
                                                + Rp {{ number_format($bagiHasil, 0, ',', '.') }}
                                            @else
                                                —
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-span-2 bg-forest/5 rounded-xl px-3 py-2 border border-forest/10">
                                        <p class="text-[9px] font-bold text-forest uppercase tracking-wider mb-0.5">Saldo Setelah Update</p>
                                        <p class="text-sm font-extrabold text-forest truncate">Rp {{ number_format($saldoSetelah, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-users text-slate-400 text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-900">Belum ada data nasabah</p>
                                <p class="text-xs text-slate-500 mt-1">Data akan muncul di sini.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-4 border-t border-slate-100">
                        {{ $nasabahs->links() }}
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center text-[10px] text-slate-400 font-semibold pt-2">
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
    </script>
</body>
</html>