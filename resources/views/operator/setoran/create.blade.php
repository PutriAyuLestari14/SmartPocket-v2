<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Setoran Tunai - Smart Pocket</title>
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
                <h1 class="text-xl lg:text-2xl font-bold text-slate-900">Input Setoran Tunai</h1>
                <p class="text-sm text-slate-500 mt-1">Proses penyetoran dana tunai nasabah ke rekening mereka sekolah.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column: Search & Nasabah Data -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Search Nasabah -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h3 class="text-sm font-bold text-slate-900 mb-4">Cari Nasabah</h3>
                        <div class="flex gap-3">
                            <div class="flex-1 relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input type="text" id="searchNasabah" placeholder="Masukkan NIS / NIP..." 
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                            </div>
                            <button class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                                <i class="fas fa-search text-xs"></i> Temukan
                            </button>
                        </div>
                    </div>

                    <!-- Data Nasabah (Hidden by default, shown after search) -->
                    <div id="nasabahCard" class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-sm font-bold text-slate-900">Data Nasabah</h3>
                            <button class="text-xs text-emerald-600 hover:text-emerald-700 font-semibold flex items-center gap-1">
                                <i class="fas fa-sync-alt"></i> Ganti
                            </button>
                        </div>

                        <div class="flex items-start gap-4">
                            <!-- Foto Nasabah -->
                            <div class="w-20 h-20 bg-gray-200 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="https://via.placeholder.com/80" alt="Foto Nasabah" class="w-full h-full object-cover">
                            </div>

                            <!-- Info Nasabah -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <p class="text-[10px] text-slate-500 uppercase font-semibold mb-0.5">Nama Lengkap</p>
                                        <p class="text-base font-bold text-slate-900">Budi Santoso Raya</p>
                                    </div>
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-semibold">Aktif</span>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <p class="text-[10px] text-slate-500 uppercase font-semibold mb-0.5">NIS / NIP</p>
                                        <p class="text-xs font-mono text-slate-900">11223344 / 0012345678</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-slate-500 uppercase font-semibold mb-0.5">No Rekening</p>
                                        <p class="text-xs text-slate-900">RK 001</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Saldo -->
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-[10px] text-slate-500 uppercase font-semibold mb-1">Total Saldo Tersedia</p>
                            <p class="text-xl font-bold text-emerald-600">Rp 1.250.000</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Detail Setoran -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 sticky top-4">
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-coins text-emerald-600 text-sm"></i>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900">Detail Setoran</h3>
                        </div>

                        <form action="{{ route('operator.setoran.store') }}" method="POST">
                            @csrf
                            
                            <!-- Nominal Setoran -->
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-2">Nominal Setoran</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm font-semibold">Rp</span>
                                    <input type="number" name="nominal" id="nominalSetoran" value="0" 
                                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-right">
                                </div>
                                
                                <!-- Quick Amount Buttons -->
                                <div class="grid grid-cols-3 gap-2 mt-2">
                                    <button type="button" onclick="setNominal(50000)" class="py-1.5 border border-gray-200 rounded-lg text-[10px] font-semibold text-slate-600 hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-700 transition-colors">50.000</button>
                                    <button type="button" onclick="setNominal(100000)" class="py-1.5 border border-gray-200 rounded-lg text-[10px] font-semibold text-slate-600 hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-700 transition-colors">100.000</button>
                                    <button type="button" onclick="setNominal(200000)" class="py-1.5 border border-gray-200 rounded-lg text-[10px] font-semibold text-slate-600 hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-700 transition-colors">200.000</button>
                                </div>
                            </div>

                            <!-- Sumber Dana -->


                            <!-- Catatan Transaksi -->
                            <div class="mb-5">
                                <label class="block text-xs font-semibold text-slate-700 mb-2">Catatan Transaksi (Opsional)</label>
                                <textarea name="catatan" rows="3" placeholder="Tambahkan catatan khusus jika diperlukan..." 
                                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 resize-none"></textarea>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <a href="{{ route('operator.transaksi.index') }}" class="flex-1 px-4 py-2.5 border border-gray-200 text-slate-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors text-sm text-center">
                                    Batal
                                </a>
                                <button type="submit" class="flex-1 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2 text-sm shadow-sm">
                                    <i class="fas fa-check text-xs"></i> Proses Setoran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function setNominal(amount) {
            document.getElementById('nominalSetoran').value = amount;
        }
    </script>
</body>
</html>