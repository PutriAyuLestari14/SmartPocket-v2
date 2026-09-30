<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nasabah - Admin Smart Pocket</title>
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

                <a href="{{ route('admin.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-users w-5 text-center text-mint"></i> Data Nasabah
                </a>

                <a href="{{ route('admin.saldo.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-wallet w-5 text-center text-slate-400"></i> Update Saldo
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
                    <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center shadow-md shadow-forest/20 flex-shrink-0">
                        <i class="fas fa-wallet text-white text-lg"></i>
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
                            <span class="text-forest font-bold">Data Nasabah</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Data Master Nasabah
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Kelola dan pantau data seluruh nasabah BMT.
                        </p>
                    </div>
                </header>

                <!-- Table Card -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

                    <!-- Header Card -->
                    <div class="p-4 lg:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <div class="w-1 h-5 bg-gradient-to-b from-mint to-forest rounded-full"></div>
                            <h3 class="text-sm font-extrabold text-slate-900">Daftar Nasabah</h3>
                        </div>
                        <div class="relative sm:w-72">
                            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" id="searchNasabah" placeholder="Cari nama, username, atau no. rek..."
                                class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all"
                                autocomplete="off">
                        </div>
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50/80">
                                <tr>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">No</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Username</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">No. Rekening</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-5 py-3.5 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Saldo</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Alamat</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Tgl Daftar</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($nasabahs as $index => $n)
                                <tr class="hover:bg-mintLight/30 transition-colors nasabah-row">
                                    <td class="px-5 py-3.5 text-xs font-bold text-slate-500">{{ $index + 1 }}</td>
                                    <td class="px-5 py-3.5 text-xs font-bold text-slate-700">{{ $n->user->username ?? '-' }}</td>
                                    <td class="px-5 py-3.5 text-xs font-bold text-forest font-mono">{{ $n->rekening->no_rek ?? '-' }}</td>
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-mintLight to-emerald-200 flex items-center justify-center flex-shrink-0">
                                                <span class="text-[10px] font-extrabold text-forest">{{ strtoupper(substr($n->nama ?? 'N', 0, 2)) }}</span>
                                            </div>
                                            <span class="text-sm font-bold text-slate-900">{{ $n->nama }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-sm font-extrabold text-slate-900 text-right whitespace-nowrap">
                                        Rp {{ number_format($n->rekening->saldo ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3.5 text-xs text-slate-600 max-w-[180px] truncate" title="{{ $n->alamat }}">
                                        {{ $n->alamat }}
                                    </td>
                                    <td class="px-5 py-3.5 text-xs font-semibold text-slate-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($n->tanggal_daftar)->format('d M Y') }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 {{ $n->status === 'aktif' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' }} rounded-lg text-[10px] font-bold border">
                                            <span class="w-1.5 h-1.5 {{ $n->status === 'aktif' ? 'bg-emerald-500' : 'bg-red-500' }} rounded-full"></span>
                                            {{ ucfirst($n->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-16 text-center">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                                        </div>
                                        <p class="text-sm font-bold text-slate-900">Belum ada data nasabah</p>
                                        <p class="text-xs text-slate-500 mt-1">Data nasabah akan muncul di sini.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="md:hidden divide-y divide-slate-100">
                        @forelse($nasabahs as $index => $n)
                            <div class="p-4 active:bg-slate-50 transition-colors nasabah-card">
                                <div class="flex justify-between items-start gap-3 mb-3">
                                    <div class="flex items-center gap-3 min-w-0 flex-1">
                                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-mintLight to-emerald-200 flex items-center justify-center flex-shrink-0">
                                            <span class="text-sm font-extrabold text-forest">{{ strtoupper(substr($n->nama ?? 'N', 0, 2)) }}</span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-extrabold text-slate-900 truncate">{{ $n->nama }}</p>
                                            <p class="text-[10px] text-slate-500 font-mono truncate">
                                                {{ $n->rekening->no_rek ?? '-' }} · {{ $n->user->username ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 {{ $n->status === 'aktif' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' }} rounded-lg text-[9px] font-bold border flex-shrink-0">
                                        {{ ucfirst($n->status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 gap-2 mb-3">
                                    <div class="bg-mintLight rounded-xl px-3 py-2">
                                        <p class="text-[9px] font-bold text-forest uppercase tracking-wider mb-0.5">Saldo</p>
                                        <p class="text-xs font-extrabold text-forest truncate">Rp {{ number_format($n->rekening->saldo ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-slate-50 rounded-xl px-3 py-2">
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Tgl Daftar</p>
                                        <p class="text-xs font-bold text-slate-700">{{ \Carbon\Carbon::parse($n->tanggal_daftar)->format('d M Y') }}</p>
                                    </div>
                                </div>

                                @if($n->alamat)
                                    <div class="bg-slate-50 rounded-xl px-3 py-2">
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Alamat</p>
                                        <p class="text-xs font-semibold text-slate-600 line-clamp-2">{{ $n->alamat }}</p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="px-4 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-900">Belum ada data nasabah</p>
                                <p class="text-xs text-slate-500 mt-1">Data nasabah akan muncul di sini.</p>
                            </div>
                        @endforelse
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

        // Search filter (desktop tabel + mobile card)
        document.getElementById('searchNasabah').addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.nasabah-row');
            const cards = document.querySelectorAll('.nasabah-card');

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