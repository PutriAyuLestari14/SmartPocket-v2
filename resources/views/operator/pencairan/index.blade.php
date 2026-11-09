<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencairan Pinjaman - Smart Pocket</title>
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

        .gradient-primary { background: linear-gradient(135deg, #15803d 0%, #166534 100%); }
        .gradient-soft { background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%); }
        .gradient-vibrant { background: linear-gradient(135deg, #15803d 0%, #16a34a 50%, #22c55e 100%); }

        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-primaryDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">

        <!-- ================= SIDEBAR ================= -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl shadow-slate-200/50">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 gradient-vibrant rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30">
                            <i class="fas fa-wallet text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-base font-black text-primary tracking-tight leading-none">SmartPocket</h1>
                            <p class="text-[10px] text-primaryDark font-bold tracking-wider mt-1 uppercase">Operator</p>
                        </div>
                    </div>
                    <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-primary p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-1.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ url('/operator/dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Data Nasabah
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-exchange-alt w-5 text-center text-slate-400"></i> Transaksi
                </a>

                <!-- MENU PEMINJAMAN (TETAP ADA) -->
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-check-circle w-5 text-center text-slate-400"></i> Verifikasi
                </a>

                <a href="{{ route('operator.pencairan.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-primary rounded-xl text-sm font-bold transition-all shadow-sm border border-primary/20">
                    <i class="fas fa-money-check-alt w-5 text-center text-primary"></i> Pencairan Transaksi
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
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

        <!-- ================= MAIN ================= -->
        <main class="flex-1 lg:ml-64 min-w-0">

            <!-- Mobile Top Bar -->
            <header class="lg:hidden bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform flex-shrink-0">
                        <i class="fas fa-bars text-base"></i>
                    </button>
                    <div class="w-10 h-10 gradient-soft rounded-xl flex items-center justify-center text-white shadow-md shadow-primary/30 flex-shrink-0">
                        <i class="fas fa-wallet text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-black text-primary tracking-tight leading-none">Smart Pocket</h1>
                        <p class="text-[10px] text-primaryDark font-bold tracking-wider mt-1 uppercase">Operator</p>
                    </div>
                </div>
            </header>

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- Header Halaman -->
                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-1 flex-wrap uppercase tracking-wider">
                            <span>Manajemen</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-primary font-bold">Pencairan Pinjaman</span>
                        </div>
                        <h2 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Pencairan Pinjaman
                        </h2>
                        <p class="text-sm text-slate-500 mt-2 flex items-center gap-2 font-medium">
                            <i class="fas fa-info-circle text-primary"></i>
                            Kelola pencairan pinjaman nasabah yang telah disetujui.
                        </p>
                    </div>

                    <div class="flex-shrink-0">
                        <a href="{{ url('/operator/dashboard') }}" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-600 hover:text-primary hover:border-primary rounded-xl text-xs font-bold transition-all flex items-center gap-2 shadow-sm">
                            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </header>

                <!-- Alerts -->
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

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-5">
                    
                    <!-- Menunggu Pencairan -->
                    <div class="bg-white rounded-2xl p-5 border border-amber-100 shadow-lg shadow-amber-500/5 hover-lift relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/30">
                                    <i class="fas fa-clock text-white text-base"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 font-black uppercase tracking-wider mb-1">Menunggu Pencairan</p>
                            <p class="text-2xl font-black text-slate-900">{{ $totalMenunggu ?? 0 }} <span class="text-sm font-bold text-slate-400">Pengajuan</span></p>
                        </div>
                    </div>

                    <!-- Total Nominal Menunggu -->
                    <div class="gradient-soft rounded-2xl p-5 shadow-xl shadow-primary/20 relative overflow-hidden hover-lift group">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                                    <i class="fas fa-wallet text-white text-base"></i>
                                </div>
                            </div>
                            <p class="text-xs text-emerald-100 font-black uppercase tracking-wider mb-1">Total Nominal Menunggu</p>
                            <p class="text-2xl font-black text-white break-all leading-tight">Rp {{ number_format($totalNominal ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Pinjaman Aktif -->
                    <div class="bg-white rounded-2xl p-5 border border-blue-100 shadow-lg shadow-blue-500/5 hover-lift relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                                    <i class="fas fa-check-double text-white text-base"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 font-black uppercase tracking-wider mb-1">Pinjaman Aktif</p>
                            <p class="text-2xl font-black text-slate-900">{{ $sudahDicairkan ?? 0 }} <span class="text-sm font-bold text-slate-400">Pinjaman</span></p>
                        </div>
                    </div>

                </div>

                <!-- Table Section -->
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 overflow-hidden">
                    <div class="p-5 lg:p-6 border-b border-slate-100 flex items-center gap-3">
                        <div class="w-1 h-6 bg-gradient-to-b from-primary to-primaryDark rounded-full"></div>
                        <h3 class="text-base font-black text-slate-900">Daftar Pinjaman Menunggu Pencairan</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50/80 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">No.</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Nama Nasabah</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Jenis Transaksi</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-center text-[10px] font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($peminjaman as $item)
                                    <tr class="hover:bg-mintLight/20 transition-colors">
                                        <td class="px-6 py-4 text-xs font-bold text-slate-500">{{ $loop->iteration }}</td>
                                        
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-mintLight to-emerald-200 flex items-center justify-center flex-shrink-0">
                                                    <span class="text-[10px] font-black text-primary">{{ strtoupper(substr($item->nasabah->nama_lengkap ?? 'N', 0, 1)) }}</span>
                                                </div>
                                                <span class="text-sm font-bold text-slate-900">{{ $item->nasabah->nama_lengkap ?? 'Nasabah tidak ditemukan' }}</span>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 text-xs font-semibold text-slate-600">
                                            {{ $item->tanggal_ajuan ? \Carbon\Carbon::parse($item->tanggal_ajuan)->format('d M Y') : '-' }}
                                        </td>
                                        
                                        <!-- KOLOM JENIS TRANSAKSI -->
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-mintLight text-primary rounded-xl text-[10px] font-black border border-primary/20">
                                                <i class="fas fa-hand-holding-usd text-[8px]"></i> Pencairan Pinjaman
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 rounded-xl text-[10px] font-black border border-amber-200">
                                                <i class="fas fa-clock text-[8px]"></i> Menunggu Pencairan
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('operator.pencairan.cairkan', $item->id_pinjaman) }}" method="POST" onsubmit="return confirm('Yakin ingin mencairkan pinjaman ini?')">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-primary hover:bg-primaryDark text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-primary/30 flex items-center justify-center gap-2 mx-auto">
                                                    <i class="fas fa-money-bill-wave text-xs"></i> Cairkan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center">
                                            <div class="w-16 h-16 bg-mintLight rounded-full flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-check-double text-primary text-2xl"></i>
                                            </div>
                                            <p class="text-sm font-bold text-slate-900">Belum Ada Pencairan</p>
                                            <p class="text-xs text-slate-500 mt-1">Pinjaman yang sudah disetujui akan muncul di sini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center text-[10px] text-slate-400 font-semibold pt-2">
                    Smart Pocket • Operator Panel • BMT SMKN 11 Bandung
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