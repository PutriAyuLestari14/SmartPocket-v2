<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Smart Pocket BMT SMKN 11 Bandung</title>
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
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }

        .hover-lift { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 10px 22px -5px rgba(26, 77, 46, 0.08); }
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

                <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>

                <a href="{{ route('nasabah.penarikan.create') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-money-bill-wave w-5 text-center text-slate-400"></i> Penarikan
                </a>

                @if(auth()->user()->nasabah->kategori == 'guru')
                    <a href="{{ route('nasabah.peminjaman.create') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                        <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman
                    </a>
                @endif

                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-history w-5 text-center text-mint"></i> Riwayat Transaksi
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
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- TOP NAVBAR MOBILE -->
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

            <!-- HEADER -->
            <header class="mb-5 lg:mb-8 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1 flex-wrap">
                        <span>Utama</span>
                        <i class="fas fa-chevron-right text-[9px]"></i>
                        <span class="text-forest font-bold">Riwayat Transaksi</span>
                    </div>

                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                        Riwayat Transaksi
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Daftar lengkap mutasi tabungan, peminjaman, dan pembayaran cicilan Anda.
                    </p>
                </div>

                <!-- Profile Desktop -->
                <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                    <button class="px-4 py-2.5 bg-white border border-slate-200/80 hover:border-mint text-slate-700 hover:text-forest text-xs font-bold rounded-xl transition-all shadow-sm flex items-center gap-2">
                        <i class="fas fa-download text-mint text-xs"></i> Export PDF/Excel
                    </button>
                    <div class="w-px h-8 bg-slate-200 my-auto mx-1"></div>
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
                </div>
            </header>

            <!-- STATS SUMMARY CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-5 lg:mb-6">

                <!-- Total Pemasukan -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm hover-lift flex items-center gap-4">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 bg-mintLight text-forest rounded-xl flex items-center justify-center text-lg font-bold flex-shrink-0">
                        <i class="fas fa-arrow-down text-mint"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-0.5">Total Pemasukan</p>
                        <p class="text-base sm:text-lg font-black text-slate-900 break-all">Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Total Pengeluaran -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm hover-lift flex items-center gap-4">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center text-lg font-bold flex-shrink-0">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-0.5">Total Pengeluaran</p>
                        <p class="text-base sm:text-lg font-black text-slate-900 break-all">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Total Transaksi -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm hover-lift flex items-center gap-4 sm:col-span-2 lg:col-span-1">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 bg-slate-100 text-forest rounded-xl flex items-center justify-center text-lg font-bold flex-shrink-0">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-0.5">Total Transaksi</p>
                        <p class="text-base sm:text-lg font-black text-slate-900">{{ $transaksi->total() }} Transaksi</p>
                    </div>
                </div>
            </div>

            <!-- FILTERS & SEARCH -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm mb-5 lg:mb-6 p-4">
                <div class="flex flex-col lg:flex-row gap-3">

                    <!-- Search -->
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" id="searchTransaksi" placeholder="Cari transaksi berdasarkan keterangan..."
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint transition-all"
                            autocomplete="off">
                    </div>

                    <!-- Filter wrapper: 2 kolom di mobile, side-by-side di desktop -->
                    <div class="grid grid-cols-2 lg:flex gap-2">
                        <select id="filterTipe"
                            class="w-full lg:w-auto px-3 lg:px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint transition-all cursor-pointer">
                            <option value="">Semua Tipe</option>
                            <option value="setoran">Setor Tunai</option>
                            <option value="penarikan">Penarikan Saldo</option>
                            <option value="peminjaman">Peminjaman Dana</option>
                            <option value="angsuran">Pembayaran Cicilan</option>
                        </select>

                        <select id="filterStatus"
                            class="w-full lg:w-auto px-3 lg:px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint transition-all cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="berhasil">Berhasil</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- LIST TRANSAKSI -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="divide-y divide-slate-100">
                    @forelse($transaksi as $trx)
                        @php
                            $isTabungan = $trx->tipe === 'tabungan';
                            $isPeminjaman = $trx->tipe === 'peminjaman';
                            $isAngsuran = $trx->tipe === 'angsuran';
                            $jenis = $trx->jenisTransaksi->id_jenis_transaksi ?? null;
                            $isSetoran = $isTabungan && $jenis == 1;
                            $isPenarikan = $isTabungan && $jenis == 2;
                        @endphp

                        <div
                            class="transaksi-item p-4 sm:p-5 hover:bg-slate-50/80 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4"
                            data-tipe="{{ $isSetoran ? 'setoran' : ($isPenarikan ? 'penarikan' : ($isPeminjaman ? 'peminjaman' : 'angsuran')) }}"
                            data-status="{{ strtolower($trx->status ?? 'berhasil') }}">

                            <!-- KIRI: ICON + DETAIL -->
                            <div class="flex items-center gap-3.5 sm:gap-4 min-w-0 flex-1">

                                @if($isSetoran)
                                    <div class="w-11 h-11 bg-mintLight text-mint rounded-xl flex items-center justify-center font-bold flex-shrink-0">
                                        <i class="fas fa-arrow-down text-base"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-forest leading-snug truncate">Setoran Tunai</p>
                                        <p class="text-[11px] font-semibold text-slate-400 mt-0.5">
                                            {{ $trx->tanggal_transaksi->timezone('Asia/Jakarta')->format('d M Y • H:i') }} WIB
                                        </p>
                                    </div>
                                @elseif($isPenarikan)
                                    <div class="w-11 h-11 bg-red-50 text-red-600 rounded-xl flex items-center justify-center font-bold flex-shrink-0">
                                        <i class="fas fa-arrow-up text-base"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-forest leading-snug truncate">Penarikan Tunai</p>
                                        <p class="text-[11px] font-semibold text-slate-400 mt-0.5">
                                            {{ $trx->tanggal_transaksi->timezone('Asia/Jakarta')->format('d M Y • H:i') }} WIB
                                        </p>
                                    </div>
                                @elseif($isPeminjaman)
                                    <div class="w-11 h-11 bg-forest/10 text-forest rounded-xl flex items-center justify-center font-bold flex-shrink-0">
                                        <i class="fas fa-hand-holding-usd text-base"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-forest leading-snug truncate">Pengajuan Pinjaman</p>
                                        <p class="text-[11px] font-semibold text-slate-400 mt-0.5">
                                            {{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->timezone('Asia/Jakarta')->format('d M Y • H:i') }} WIB
                                        </p>
                                    </div>
                                @elseif($isAngsuran)
                                    <div class="w-11 h-11 bg-mintLight text-forest rounded-xl flex items-center justify-center font-bold flex-shrink-0">
                                        <i class="fas fa-check-circle text-base"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-forest leading-snug truncate">Pembayaran Cicilan</p>
                                        <p class="text-[11px] font-semibold text-slate-400 mt-0.5">
                                            {{ $trx->tanggal_transaksi->timezone('Asia/Jakarta')->format('d M Y • H:i') }} WIB
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- KANAN: NOMINAL + STATUS -->
                            <div class="text-right flex-shrink-0 flex sm:flex-col items-center sm:items-end justify-between sm:justify-center pl-[58px] sm:pl-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 sm:border-0 gap-2 sm:gap-0">
                                @if($isPeminjaman)
                                    <p class="text-sm sm:text-base font-extrabold text-forest sm:mb-1">
                                        Rp {{ number_format($trx->jumlah ?? 0, 0, ',', '.') }}
                                    </p>
                                    @if(in_array($trx->status, ['disetujui', 'berhasil']))
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-mintLight text-forest border border-mint/20">
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-red-50 text-red-600 border border-red-200">
                                            Ditolak
                                        </span>
                                    @endif

                                @elseif($isAngsuran)
                                    <p class="text-sm sm:text-base font-extrabold text-red-600 sm:mb-1">
                                        - Rp {{ number_format($trx->jumlah ?? 0, 0, ',', '.') }}
                                    </p>
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-mintLight text-forest border border-mint/20">
                                        Berhasil
                                    </span>

                                @elseif($isSetoran)
                                    <p class="text-sm sm:text-base font-extrabold text-mint sm:mb-1">
                                        + Rp {{ number_format($trx->jumlah ?? 0, 0, ',', '.') }}
                                    </p>
                                    @if($trx->status === 'berhasil')
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-mintLight text-forest border border-mint/20">
                                            Berhasil
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-red-50 text-red-600 border border-red-200">
                                            Ditolak
                                        </span>
                                    @endif

                                @elseif($isPenarikan)
                                    <p class="text-sm sm:text-base font-extrabold text-red-600 sm:mb-1">
                                        - Rp {{ number_format($trx->jumlah ?? 0, 0, ',', '.') }}
                                    </p>
                                    @if($trx->status === 'berhasil')
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-mintLight text-forest border border-mint/20">
                                            Berhasil
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-red-50 text-red-600 border border-red-200">
                                            Ditolak
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 px-4">
                            <div class="w-14 h-14 bg-mintLight text-forest rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                                <i class="fas fa-receipt text-xl"></i>
                            </div>
                            <h4 class="text-sm font-extrabold text-forest mb-1">Belum Ada Transaksi</h4>
                            <p class="text-xs text-slate-400 max-w-sm mx-auto">
                                Seluruh riwayat transaksi tabungan, peminjaman, dan pembayaran cicilan Anda akan ditampilkan di sini.
                            </p>
                        </div>
                    @endforelse
                </div>

                @if($transaksi->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $transaksi->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchTransaksi');
            const filterTipe = document.getElementById('filterTipe');
            const filterStatus = document.getElementById('filterStatus');
            const transaksiItems = document.querySelectorAll('.transaksi-item');

            function filterTransaksi() {
                const keyword = searchInput.value.toLowerCase().trim();
                const tipe = filterTipe.value.toLowerCase();
                const status = filterStatus.value.toLowerCase();

                transaksiItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    const itemTipe = item.dataset.tipe.toLowerCase();
                    const itemStatus = item.dataset.status.toLowerCase();

                    const cocokSearch = text.includes(keyword);
                    const cocokTipe = !tipe || itemTipe === tipe;
                    const cocokStatus = !status || itemStatus === status;

                    item.style.display =
                        cocokSearch && cocokTipe && cocokStatus
                            ? ''
                            : 'none';
                });
            }

            searchInput.addEventListener('input', filterTransaksi);
            filterTipe.addEventListener('change', filterTransaksi);
            filterStatus.addEventListener('change', filterTransaksi);
        });
    </script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (!sidebar || !backdrop) return;

            const isClosed = sidebar.classList.contains('-translate-x-full');

            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        document.getElementById('closeSidebar')?.addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        });
    </script>
</body>
</html>