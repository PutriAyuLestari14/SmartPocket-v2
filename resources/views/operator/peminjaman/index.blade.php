<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="flex min-h-screen">
        
        <!-- Sidebar (Sesuai punya kamu) -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-screen">
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
            
            <nav class="p-4 space-y-1 flex-1 overflow-y-auto">
                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-home w-5 text-center"></i> Dashboard
                </a>
                
                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-users w-5 text-center"></i> Data Nasabah
                </a>

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-exchange-alt w-5 text-center"></i> Transaksi
                </a>

                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-hand-holding-usd w-5 text-center"></i> Peminjaman
                </a>

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-check-circle w-5 text-center"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-chart-bar w-5 text-center"></i> Laporan
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
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

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-4 lg:p-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-slate-900">Peminjaman Staf & Guru</h1>
                        <p class="text-sm text-slate-500 mt-1">Kelola data pengajuan dan angsuran pinjaman khusus pegawai.</p>
                    </div>
                    <div class="flex gap-3">
                        <button class="px-4 py-2.5 border border-gray-200 text-slate-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                            <i class="fas fa-download text-xs"></i> Export Data
                        </button>
                        <a href="{{ route('operator.peminjaman.create') }}" class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2 shadow-sm">
                            <i class="fas fa-plus text-xs"></i> Input Peminjaman
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6 mb-6">
                <!-- Total Pinjaman Aktif -->
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-wallet text-emerald-600"></i>
                        </div>
                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-semibold">+12% Bulan Ini</span>
                    </div>
                    <p class="text-[10px] font-semibold text-slate-500 uppercase mb-1">Total Pinjaman Aktif</p>
                    <p class="text-2xl font-bold text-slate-900 mb-1">Rp 125.500.000</p>
                    <p class="text-xs text-slate-500">Dari 42 pinjaman aktif</p>
                </div>

                <!-- Pengajuan Menunggu -->
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-amber-600"></i>
                        </div>
                        <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-semibold">Perlu Review</span>
                    </div>
                    <p class="text-[10px] font-semibold text-slate-500 uppercase mb-1">Pengajuan Menunggu</p>
                    <p class="text-2xl font-bold text-slate-900 mb-1">8 Berkas</p>
                    <p class="text-xs text-slate-500">Total Rp 35.000.000</p>
                </div>

                <!-- Peminjam Baru -->
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus text-blue-600"></i>
                        </div>
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-semibold">Segera Tindak Lanjuti</span>
                    </div>
                    <p class="text-[10px] font-semibold text-slate-500 uppercase mb-1">Peminjam Baru</p>
                    <p class="text-2xl font-bold text-slate-900 mb-1">2 Peminjam</p>
                    <p class="text-xs text-slate-500">Menunggu verifikasi</p>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6">
                <div class="p-4 border-b border-gray-100">
                    <div class="flex flex-col lg:flex-row gap-3">
                        <div class="flex-1 relative">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" placeholder="Cari nama peminjam atau NIP..." 
                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        </div>
                        <select class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                            <option>Semua Status</option>
                            <option>Menunggu</option>
                            <option>Disetujui</option>
                            <option>Ditolak</option>
                            <option>Lunas</option>
                        </select>
                        <select class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                            <option>Semua Tenor</option>
                            <option>6 Bulan</option>
                            <option>12 Bulan</option>
                            <option>24 Bulan</option>
                        </select>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Peminjam</th>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Nominal Pinjaman</th>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Tenor</th>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Sisa Cicilan</th>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-center text-[10px] font-semibold text-slate-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">Budi Waluyo, S.Pd</p>
                                        <p class="text-[10px] text-slate-500 font-mono">NIP: 198405102005011003</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">Rp 15.000.000</td>
                                <td class="px-6 py-4 text-xs text-slate-600">24 Bulan</td>
                                <td class="px-6 py-4 text-xs text-slate-600">12 Bulan</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-semibold">Lancar</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button class="w-7 h-7 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center transition-colors" title="Lihat Detail">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        <button class="w-7 h-7 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition-colors" title="Edit">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">Siti Wahyuni, M.Pd</p>
                                        <p class="text-[10px] text-slate-500 font-mono">NIP: 197508272010012001</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">Rp 5.000.000</td>
                                <td class="px-6 py-4 text-xs text-slate-600">12 Bulan</td>
                                <td class="px-6 py-4 text-xs text-slate-600">Menunggu</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-semibold">Pending</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-semibold rounded-lg transition-colors">
                                            Review
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">Ahmad Hidayat</p>
                                        <p class="text-[10px] text-slate-500 font-mono">Dari Tata Usaha</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">Rp 8.000.000</td>
                                <td class="px-6 py-4 text-xs text-slate-600">12 Bulan</td>
                                <td class="px-6 py-4 text-xs text-slate-600">2 Bulan</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-semibold">Terlambat</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button class="w-7 h-7 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center transition-colors" title="Lihat Detail">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        <button class="w-7 h-7 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition-colors" title="Edit">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <p class="text-xs text-slate-500">Menampilkan 1-3 dari 42 data</p>
                    <div class="flex gap-1">
                        <button class="px-3 py-1 border border-gray-200 rounded-lg text-xs hover:bg-gray-50">Previous</button>
                        <button class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-xs">1</button>
                        <button class="px-3 py-1 border border-gray-200 rounded-lg text-xs hover:bg-gray-50">2</button>
                        <button class="px-3 py-1 border border-gray-200 rounded-lg text-xs hover:bg-gray-50">3</button>
                        <button class="px-3 py-1 border border-gray-200 rounded-lg text-xs hover:bg-gray-50">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>