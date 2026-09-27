<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - Smart Pocket</title>
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

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-exchange-alt w-5 text-center text-mint"></i> Transaksi
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
                            <span>Utama</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-forest font-bold">Transaksi</span>
                        </div>

                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Manajemen Transaksi
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Riwayat seluruh aktivitas setoran dan penarikan nasabah.
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

                <!-- Table Section -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

                    <!-- Header + Filter -->
                    <div class="p-4 lg:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <div class="w-1 h-5 bg-gradient-to-b from-mint to-forest rounded-full"></div>
                            <h3 class="text-sm font-extrabold text-slate-900">Riwayat Transaksi</h3>
                        </div>

                        <form method="GET" action="{{ route('operator.transaksi.index') }}" class="flex gap-2">
                            <select name="jenis" onchange="this.form.submit()"
                                class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all cursor-pointer">
                                <option value="">Semua Jenis</option>
                                <option value="setoran" {{ request('jenis') == 'setoran' ? 'selected' : '' }}>Setoran</option>
                                <option value="penarikan" {{ request('jenis') == 'penarikan' ? 'selected' : '' }}>Penarikan</option>
                            </select>
                        </form>
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50/80">
                                <tr>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider" style="min-width: 140px;">Waktu</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Nasabah</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Jenis</th>
                                    <th class="px-5 py-3.5 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider" style="min-width: 130px;">Tarik</th>
                                    <th class="px-5 py-3.5 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider" style="min-width: 130px;">Setor</th>
                                    <th class="px-5 py-3.5 text-center text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($transaksi as $item)
                                    @php
                                        $isSetoran = $item->id_jenis_transaksi == 1;
                                        $isPenarikan = $item->id_jenis_transaksi == 2;
                                        $amountFormatted = 'Rp ' . number_format($item->jumlah, 0, ',', '.');

                                        $statusClass = 'bg-slate-100 text-slate-700 border-slate-200';
                                        $statusText = ucfirst($item->status);
                                        if ($item->status == 'berhasil') {
                                            $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                        } elseif ($item->status == 'pending') {
                                            $statusClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                        } elseif (in_array($item->status, ['ditolak', 'gagal'])) {
                                            $statusClass = 'bg-red-50 text-red-700 border-red-200';
                                        }
                                    @endphp

                                    <tr class="hover:bg-mintLight/30 transition-colors">
                                        <td class="px-5 py-3.5 align-middle">
                                            <p class="text-sm font-bold text-slate-900">
                                                {{ $item->tanggal_transaksi->copy()->timezone('Asia/Jakarta')->format('H:i') }} WIB
                                            </p>
                                            <p class="text-[10px] text-slate-400 mt-0.5">
                                                {{ $item->tanggal_transaksi->format('d M Y') }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-3.5 align-middle">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-mintLight to-emerald-200 flex items-center justify-center flex-shrink-0">
                                                    <span class="text-[10px] font-extrabold text-forest">
                                                        {{ strtoupper(substr($item->rekening->nasabah->nama ?? 'N', 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-bold text-slate-900 truncate max-w-[180px]">
                                                        {{ $item->rekening->nasabah->nama ?? 'Data Tidak Ditemukan' }}
                                                    </p>
                                                    <p class="text-[10px] text-slate-500 font-mono">
                                                        {{ $item->rekening->no_rek ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5 align-middle">
                                            @if($isSetoran)
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[10px] font-bold border border-emerald-200">
                                                    <i class="fas fa-arrow-down text-[8px]"></i> Setoran
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-700 rounded-lg text-[10px] font-bold border border-red-200">
                                                    <i class="fas fa-arrow-up text-[8px]"></i> Penarikan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-right align-middle">
                                            @if(!$isSetoran)
                                                <span class="text-sm font-extrabold text-red-600">{{ $amountFormatted }}</span>
                                            @else
                                                <span class="text-slate-300 text-sm">—</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-right align-middle">
                                            @if($isSetoran)
                                                <span class="text-sm font-extrabold text-emerald-600">{{ $amountFormatted }}</span>
                                            @else
                                                <span class="text-slate-300 text-sm">—</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-center align-middle">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 {{ $statusClass }} rounded-lg text-[10px] font-bold border">
                                                @if($item->status == 'berhasil')
                                                    <i class="fas fa-check-circle text-[8px]"></i>
                                                @elseif($item->status == 'pending')
                                                    <i class="fas fa-clock text-[8px]"></i>
                                                @elseif(in_array($item->status, ['ditolak', 'gagal']))
                                                    <i class="fas fa-times-circle text-[8px]"></i>
                                                @endif
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center">
                                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                                            </div>
                                            <p class="text-sm font-bold text-slate-900">Belum ada data transaksi</p>
                                            <p class="text-xs text-slate-500 mt-1">Data akan muncul setelah ada aktivitas setoran atau penarikan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="md:hidden divide-y divide-slate-100">
                        @forelse($transaksi as $item)
                            @php
                                $isSetoran = $item->id_jenis_transaksi == 1;
                                $isPenarikan = $item->id_jenis_transaksi == 2;
                                $amountFormatted = 'Rp ' . number_format($item->jumlah, 0, ',', '.');

                                $statusClass = 'bg-slate-100 text-slate-700 border-slate-200';
                                $statusText = ucfirst($item->status);
                                if ($item->status == 'berhasil') {
                                    $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                } elseif ($item->status == 'pending') {
                                    $statusClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                } elseif (in_array($item->status, ['ditolak', 'gagal'])) {
                                    $statusClass = 'bg-red-50 text-red-700 border-red-200';
                                }
                            @endphp

                            <div class="p-4 active:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start gap-3 mb-3">
                                    <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-mintLight to-emerald-200 flex items-center justify-center flex-shrink-0">
                                            <span class="text-xs font-extrabold text-forest">
                                                {{ strtoupper(substr($item->rekening->nasabah->nama ?? 'N', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-extrabold text-slate-900 truncate">
                                                {{ $item->rekening->nasabah->nama ?? 'Data Tidak Ditemukan' }}
                                            </p>
                                            <p class="text-[10px] text-slate-500 font-mono truncate">
                                                {{ $item->rekening->no_rek ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 {{ $statusClass }} rounded-lg text-[9px] font-bold border flex-shrink-0">
                                        @if($item->status == 'berhasil')
                                            <i class="fas fa-check-circle text-[7px]"></i>
                                        @elseif($item->status == 'pending')
                                            <i class="fas fa-clock text-[7px]"></i>
                                        @elseif(in_array($item->status, ['ditolak', 'gagal']))
                                            <i class="fas fa-times-circle text-[7px]"></i>
                                        @endif
                                        {{ $statusText }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-end gap-3">
                                    <div>
                                        @if($isSetoran)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-md text-[10px] font-bold border border-emerald-200">
                                                <i class="fas fa-arrow-down text-[8px]"></i> Setoran
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-50 text-red-700 rounded-md text-[10px] font-bold border border-red-200">
                                                <i class="fas fa-arrow-up text-[8px]"></i> Penarikan
                                            </span>
                                        @endif
                                        <p class="text-[10px] text-slate-400 mt-1.5 font-semibold">
                                            {{ $item->tanggal_transaksi->copy()->timezone('Asia/Jakarta')->format('H:i') }} WIB
                                            · {{ $item->tanggal_transaksi->format('d M Y') }}
                                        </p>
                                    </div>
                                    <p class="text-sm font-black {{ $isSetoran ? 'text-emerald-600' : 'text-red-600' }} whitespace-nowrap">
                                        {{ $isSetoran ? '+ ' : '- ' }}{{ $amountFormatted }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-900">Belum ada data transaksi</p>
                                <p class="text-xs text-slate-500 mt-1">Data akan muncul setelah ada aktivitas setoran atau penarikan.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($transaksi->hasPages())
                    <div class="p-4 lg:p-5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                        <p class="text-[11px] text-slate-500 font-semibold">
                            Menampilkan {{ $transaksi->firstItem() }}–{{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} transaksi
                        </p>
                        <div class="flex gap-1">
                            {{ $transaksi->links() }}
                        </div>
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