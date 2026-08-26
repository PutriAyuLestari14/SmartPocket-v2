<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Dashboard - Smart Pocket</title>
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
        
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-screen">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-university text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900">SMKN 11 Banking</h1>
                        <p class="text-xs text-slate-500">Operator Dashboard</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-4 space-y-1 flex-1 overflow-y-auto">

                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-home w-5 text-center"></i> Dashboard
                </a>
                
                <div class="pt-2">
                    <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-users w-5 text-center"></i> Data Nasabah
                    </a>
                </div>

                <div class="pt-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-exchange-alt w-5 text-center"></i> Transaksi
                    </a>
                </div>

                <div class="pt-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-hand-holding-usd w-5 text-center"></i> Peminjaman
                    </a>
                </div>

                <div class="pt-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-check-circle w-5 text-center"></i> Verifikasi
                    </a>
                </div>

                <div class="pt-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-chart-bar w-5 text-center"></i> Laporan
                    </a>
                </div>

                <div class="pt-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-cog w-5 text-center"></i> Pengaturan
                    </a>
                </div>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <!-- Header -->
            <header class="mb-8">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900">Selamat Datang, Operator</h1>
                        <div class="flex items-center gap-3 mt-2 text-sm text-slate-600">
                            <i class="far fa-calendar"></i>
                            <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                        </div>
                    </div>
                    
                    <!-- Icon Notifikasi -->
                    <a href="#" class="relative w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-slate-500 hover:text-slate-700 hover:border-gray-300 transition-colors">
                        <i class="far fa-bell text-lg"></i>
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                    </a>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="grid grid-cols-4 gap-6 mb-6">
                <!-- Total Nasabah -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <span class="text-xs text-emerald-600 font-semibold bg-emerald-50 px-2 py-1 rounded">+12 bulan ini</span>
                    </div>
                    <p class="text-sm text-slate-500 mb-1">Total Nasabah Aktif</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $totalNasabah ?? 1248 }}</p>
                </div>

                <!-- Total Saldo (Hijau Besar) -->
                <div class="bg-emerald-600 rounded-xl p-6 shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-wallet text-white"></i>
                            </div>
                        </div>
                        <p class="text-sm text-emerald-100 mb-1">Total Saldo Kas</p>
                        <p class="text-3xl font-bold text-white mb-1">Rp 84.500.000</p>
                        <p class="text-xs text-emerald-200">Terakhir diperbarui 10:42</p>
                    </div>
                </div>

                <!-- Transaksi Berhasil -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-emerald-600"></i>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500 mb-1">Transaksi Berhasil</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $transaksiHariIni ?? 156 }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $transaksiMingguIni ?? 89 }} transaksi minggu ini</p>
                </div>

                <!-- Penarikan Menunggu -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-red-600"></i>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500 mb-1">Transaksi Pending</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $penarikanMenunggu ?? 8 }}</p>
                    <p class="text-xs text-red-500 font-semibold mt-1">⚡ Butuh tindakan segera</p>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-3 gap-6">
                <!-- Left Content (2/3) -->
                <div class="col-span-2 space-y-6">
                    <!-- Aksi Cepat -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Aksi Cepat</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <a href="{{ route('operator.setoran.create') ?? '#' }}" class="group bg-emerald-50 hover:bg-emerald-100 border-2 border-emerald-200 rounded-xl p-6 text-center transition-all">
                                <div class="w-14 h-14 bg-emerald-500 group-hover:bg-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3 transition-colors">
                                    <i class="fas fa-plus-circle text-white text-xl"></i>
                                </div>
                                <p class="font-semibold text-slate-900">Input Setoran</p>
                                <p class="text-xs text-slate-500 mt-1">Setor tunai nasabah</p>
                            </a>

                            <a href="{{ route('operator.penarikan.create') ?? '#' }}" class="group bg-red-50 hover:bg-red-100 border-2 border-red-200 rounded-xl p-6 text-center transition-all">
                                <div class="w-14 h-14 bg-red-500 group-hover:bg-red-600 rounded-full flex items-center justify-center mx-auto mb-3 transition-colors">
                                    <i class="fas fa-minus-circle text-white text-xl"></i>
                                </div>
                                <p class="font-semibold text-slate-900">Input Penarikan</p>
                                <p class="text-xs text-slate-500 mt-1">Tarik tunai nasabah</p>
                            </a>

                            <a href="{{ route('operator.pembayaran.create') ?? '#' }}" class="group bg-blue-50 hover:bg-blue-100 border-2 border-blue-200 rounded-xl p-6 text-center transition-all">
                                <div class="w-14 h-14 bg-blue-500 group-hover:bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 transition-colors">
                                    <i class="fas fa-hand-holding-usd text-white text-xl"></i>
                                </div>
                                <p class="font-semibold text-slate-900">Input Pembayaran</p>
                                <p class="text-xs text-slate-500 mt-1">Cicilan & angsuran</p>
                            </a>
                        </div>
                    </div>

                    <!-- Transaksi Terkini -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-slate-900">Transaksi Terkini</h3>
                            <a href="#" class="text-sm text-emerald-600 hover:text-emerald-700 font-semibold">LIHAT SEMUA</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Waktu</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Nasabah</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Jenis</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Nominal</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-slate-600">10:42</td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="font-semibold text-slate-900">Ahmad Fauzi</p>
                                                <p class="text-xs text-slate-500">NIS: 123456</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Setoran</span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-slate-900">+ Rp 150.000</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                                <i class="fas fa-check-circle"></i> Sukses
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-slate-600">10:35</td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="font-semibold text-slate-900">Siti Putri</p>
                                                <p class="text-xs text-slate-500">NIS: 123412</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Penarikan</span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-slate-900">- Rp 50.000</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                                <i class="fas fa-check-circle"></i> Sukses
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-slate-600">10:15</td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="font-semibold text-slate-900">Budi Prakoso</p>
                                                <p class="text-xs text-slate-500">Guru</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Peminjaman</span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-slate-900">+ Rp 500.000</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Proses</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar (1/3) -->
                <div class="space-y-6">
                    <!-- Target Kas Hari Ini -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Target Kas Hari Ini</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-slate-700">Pemasukan Setoran</span>
                                    <span class="text-sm font-bold text-emerald-600">75%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-emerald-500 h-2 rounded-full" style="width: 75%"></div>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">Rp 1.5jt / Rp 2jt</p>
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-slate-700">Pencairan Pinjaman</span>
                                    <span class="text-sm font-bold text-blue-600">40%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 40%"></div>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">Rp 400rb / Rp 1jt</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Singkat -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                        <h3 class="font-bold mb-4">Statistik Bulan Ini</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b border-blue-400">
                                <span class="text-sm text-blue-100">Total Transaksi</span>
                                <span class="font-bold">1,247</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-blue-400">
                                <span class="text-sm text-blue-100">Total Setoran</span>
                                <span class="font-bold">Rp 45.2jt</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-blue-400">
                                <span class="text-sm text-blue-100">Total Penarikan</span>
                                <span class="font-bold">Rp 32.8jt</span>
                            </div>
                            <div class="flex justify-between items-center pt-1">
                                <span class="text-sm text-blue-100">Saldo Akhir</span>
                                <span class="font-bold text-emerald-300">Rp 12.4jt</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>