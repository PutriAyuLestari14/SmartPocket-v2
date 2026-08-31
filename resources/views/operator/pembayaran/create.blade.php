<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pembayaran Cicilan - Smart Pocket</title>
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
        
        <!-- Sidebar (Standar Smart Pocket) -->
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
                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-exchange-alt w-5 text-center"></i> Transaksi
                </a>
                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-hand-holding-usd w-5 text-center"></i> Peminjaman
                </a>
                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-check-circle w-5 text-center"></i> Verifikasi
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
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
                <h1 class="text-xl lg:text-2xl font-bold text-slate-900">Input Pembayaran Cicilan</h1>
                <p class="text-sm text-slate-500 mt-1">Proses pembayaran angsuran pinjaman untuk guru dan staf.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column: Form & Data -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- 1. Data Peminjam -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-tie text-emerald-600"></i>
                                <h3 class="text-sm font-bold text-slate-900">Data Peminjam (Guru/Staf)</h3>
                            </div>
                        </div>

                        <!-- Search -->
                        <div class="flex gap-3 mb-4">
                            <div class="flex-1 relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input type="text" placeholder="Cari NIP atau Nama Guru..." 
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                            </div>
                            <button class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition-colors">
                                Cari
                            </button>
                        </div>

                        <!-- Selected Peminjam Card -->
                        <div class="bg-emerald-50/50 border border-emerald-100 rounded-lg p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-emerald-200 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-emerald-700 font-bold text-lg">IB</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-base font-bold text-slate-900">Ibu Lilis Tati Elis</p>
                                    <p class="text-[10px] text-slate-500">NIP: 198501012010012001 • Guru Matematika</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-slate-500 uppercase font-semibold">Status Pinjaman</p>
                                    <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold">Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Detail Pembayaran -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <div class="flex items-center gap-2 mb-5">
                            <i class="fas fa-file-invoice-dollar text-emerald-600"></i>
                            <h3 class="text-sm font-bold text-slate-900">Detail Pembayaran Angsuran</h3>
                        </div>

                        <form action="{{ route('operator.pembayaran.store') }}" method="POST">
                            @csrf
                            
                            <!-- Pilih Pinjaman Aktif -->
                            <div class="mb-4">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Pinjaman Aktif</label>
                                <select name="id_peminjaman" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                    <option value="1">Pinjaman Modal Usaha - Rp 10.000.000 (Sisa 8 bulan)</option>
                                    <option value="2">Pinjaman Darurat - Rp 5.000.000 (Lunas)</option>
                                </select>
                            </div>

                            <!-- Cicilan Ke & Tanggal -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Cicilan Ke-</label>
                                    <select name="cicilan_ke" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                        <option value="1">1 dari 12</option>
                                        <option value="2">2 dari 12</option>
                                        <option value="3" selected>3 dari 12</option>
                                        <option value="4">4 dari 12</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Tanggal Pembayaran</label>
                                    <input type="date" name="tanggal_bayar" value="2023-10-24" 
                                        class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                </div>
                            </div>

                            <!-- Nominal Bayar -->
                            <div class="mb-4">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Nominal Pembayaran</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm font-semibold">Rp</span>
                                    <input type="number" name="nominal" id="nominalBayar" value="1000000" 
                                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-right">
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1">*Nominal default sesuai angsuran bulanan</p>
                            </div>

                            <!-- Metode & Catatan -->
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Metode Pembayaran</label>
                                    <select name="metode" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                        <option value="tunai" selected>Tunai (Cash)</option>
                                        <option value="transfer">Transfer Bank</option>
                                        <option value="potong_gaji">Potong Gaji</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Keterangan</label>
                                    <input type="text" name="keterangan" placeholder="Opsional..." 
                                        class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <a href="{{ route('operator.peminjaman.index') }}" class="flex-1 px-4 py-2.5 border border-gray-200 text-slate-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors text-sm text-center">
                                    Batal
                                </a>
                                <button type="submit" class="flex-1 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2 text-sm shadow-sm">
                                    <i class="fas fa-check-circle text-xs"></i> Proses Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Summary & Schedule -->
                <div class="lg:col-span-1 space-y-4">
                    
                    <!-- Info Pinjaman -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-blue-500"></i> Info Pinjaman
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Total Pinjaman</span>
                                <span class="text-sm font-bold text-slate-900">Rp 10.000.000</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Angsuran/Bulan</span>
                                <span class="text-sm font-bold text-slate-900">Rp 1.000.000</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Sudah Dibayar</span>
                                <span class="text-sm font-bold text-emerald-600">2 Bulan</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-600">Sisa Cicilan</span>
                                <span class="text-sm font-bold text-amber-600">10 Bulan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Jadwal Cicilan Berikutnya -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-amber-500"></i> Jadwal Berikutnya
                        </h3>
                        
                        <div class="p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <div class="flex justify-between items-center mb-1">
                                <p class="text-xs font-bold text-slate-900">Cicilan Ke-4</p>
                                <span class="text-[10px] font-semibold text-amber-700 bg-amber-200 px-2 py-0.5 rounded-full">Belum Bayar</span>
                            </div>
                            <p class="text-[10px] text-slate-500">Jatuh Tempo: 24 November 2023</p>
                            <p class="text-sm font-bold text-slate-900 mt-2">Rp 1.000.000</p>
                        </div>
                    </div>

                    <!-- Total Sisa Pinjaman -->
                    <div class="bg-emerald-500 rounded-xl p-5 text-white">
                        <p class="text-[10px] text-emerald-100 uppercase font-semibold mb-1">Estimasi Sisa Pinjaman</p>
                        <p class="text-2xl font-bold">Rp 8.000.000</p>
                        <p class="text-[10px] text-emerald-100 mt-2">Setelah pembayaran ini diproses</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Simple script untuk update estimasi sisa pinjaman (opsional)
        document.getElementById('nominalBayar').addEventListener('input', function(e) {
            // Logic kalkulasi bisa ditambah di sini nanti
        });
    </script>
</body>
</html>