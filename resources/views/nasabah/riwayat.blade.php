<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .hover-lift { transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 8px 20px -5px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased">
    <div class="flex min-h-screen">
        
        <!-- Sidebar (Sudah Diperbaiki) -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-screen z-20">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-wallet text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900">Smart Pocket</h1>
                        <p class="text-[10px] text-slate-500 font-medium">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-4 space-y-1 flex-1">
                <p class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menu Utama</p>
                
                <!-- PERBAIKAN: Link Dashboard -->
                <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-home w-5 text-center"></i> Dashboard
                </a>
                
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-wallet w-5 text-center"></i> Saldo
                </a>
                
                <!-- PERBAIKAN: Link Tarik -->
                <a href="{{ route('nasabah.penarikan.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-money-bill-wave w-5 text-center"></i> Tarik
                </a>
                
                <!-- PERBAIKAN: Link Pinjam -->
                <a href="{{ route('nasabah.peminjaman.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-hand-holding-usd w-5 text-center"></i> Pinjam
                </a>
                
                <!-- Menu Aktif: Riwayat -->
                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium">
                    <i class="fas fa-history w-5 text-center"></i> Riwayat
                </a>
                
                <p class="px-4 py-2 mt-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lainnya</p>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-cog w-5 text-center"></i> Pengaturan
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100 space-y-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-white border border-gray-200 hover:bg-red-50 hover:text-red-600 text-slate-600 text-sm font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content (Tetap Sama) -->
        <main class="flex-1 ml-64 p-4 lg:p-8">
            <!-- Header -->
            <header class="mb-6 lg:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold text-slate-900">Riwayat Transaksi</h2>
                        <p class="text-sm text-slate-500 mt-1">Lihat semua aktivitas transaksi Anda</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button class="px-4 py-2 bg-white border border-gray-200 text-slate-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                            <i class="fas fa-download text-xs"></i>
                            <span class="hidden sm:inline">Export</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Stats Summary -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-arrow-down text-emerald-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-0.5">Total Pemasukan</p>
                            <p class="text-lg font-bold text-slate-900">Rp 450.000</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-arrow-up text-red-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-0.5">Total Pengeluaran</p>
                            <p class="text-lg font-bold text-slate-900">Rp 150.000</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-amber-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-0.5">Transaksi Pending</p>
                            <p class="text-lg font-bold text-slate-900">2</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6">
                <div class="p-4 flex flex-col sm:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" placeholder="Cari transaksi..." 
                               class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>
                    
                    <!-- Filter Type -->
                    <select class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        <option value="">Semua Tipe</option>
                        <option value="setor">Setor Tunai</option>
                        <option value="tarik">Penarikan</option>
                        <option value="pinjam">Pinjaman</option>
                    </select>
                    
                    <!-- Filter Status -->
                    <select class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        <option value="">Semua Status</option>
                        <option value="success">Berhasil</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
                
                <!-- Filter Tags -->
                <div class="px-4 pb-4 flex flex-wrap gap-2">
                    <button class="px-3 py-1.5 bg-emerald-500 text-white text-xs font-semibold rounded-lg">Semua</button>
                    <button class="px-3 py-1.5 bg-gray-100 text-slate-600 text-xs font-semibold rounded-lg hover:bg-gray-200 transition-colors">Masuk</button>
                    <button class="px-3 py-1.5 bg-gray-100 text-slate-600 text-xs font-semibold rounded-lg hover:bg-gray-200 transition-colors">Keluar</button>
                    <button class="px-3 py-1.5 bg-gray-100 text-slate-600 text-xs font-semibold rounded-lg hover:bg-gray-200 transition-colors">Pending</button>
                </div>
            </div>

            <!-- Transaction List -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="divide-y divide-gray-100">
                    
                    <!-- Transaction Item 1 - Success -->
                    <div class="p-4 hover:bg-gray-50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-arrow-down text-emerald-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 mb-0.5">Setoran Tunai</p>
                                    <p class="text-xs text-slate-500">26 Agustus 2026 • 08:00 WIB</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Operator: Admin BMT</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-emerald-600 mb-1">+ Rp 50.000</p>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span class="text-[10px] font-bold text-emerald-700">Berhasil</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Item 2 - Success -->
                    <div class="p-4 hover:bg-gray-50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-arrow-up text-red-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 mb-0.5">Penarikan Tunai</p>
                                    <p class="text-xs text-slate-500">25 Agustus 2026 • 14:30 WIB</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Operator: Admin BMT</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-red-600 mb-1">- Rp 100.000</p>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span class="text-[10px] font-bold text-emerald-700">Disetujui</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Item 3 - Pending -->
                    <div class="p-4 hover:bg-gray-50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-clock text-amber-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 mb-0.5">Pengajuan Penarikan</p>
                                    <p class="text-xs text-slate-500">25 Agustus 2026 • 10:15 WIB</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Menunggu persetujuan operator</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-slate-700 mb-1">- Rp 20.000</p>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    <span class="text-[10px] font-bold text-amber-700">Pending</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Item 4 - Rejected -->
                    <div class="p-4 hover:bg-gray-50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-times text-red-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 mb-0.5">Pengajuan Pinjaman</p>
                                    <p class="text-xs text-slate-500">24 Agustus 2026 • 16:45 WIB</p>
                                    <p class="text-xs text-red-500 mt-0.5">Alasan: Saldo tidak mencukupi</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-slate-400 mb-1">Rp 500.000</p>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    <span class="text-[10px] font-bold text-red-700">Ditolak</span>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-xs text-slate-500">Menampilkan 1-4 dari 4 transaksi</p>
                    <div class="flex items-center gap-2">
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-slate-400 hover:bg-gray-50 transition-colors" disabled>
                            <i class="fas fa-chevron-left text-xs"></i>
                        </button>
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-500 text-white text-sm font-semibold">1</button>
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-slate-600 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>