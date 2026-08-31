<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Penarikan Dana - Smart Pocket</title>
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
                <h1 class="text-xl lg:text-2xl font-bold text-slate-900">Input Penarikan Dana</h1>
                <p class="text-sm text-slate-500 mt-1">Lakukan verifikasi data nasabah dan saldo sebelum memproses penarikan.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Identitas Nasabah -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fas fa-user-circle text-emerald-600"></i>
                            <h3 class="text-sm font-bold text-slate-900">Identitas Nasabah</h3>
                        </div>

                        <!-- Search -->
                        <div class="flex gap-3 mb-4">
                            <div class="flex-1">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Nomor Rekening / NIS</label>
                                <div class="flex gap-2">
                                    <input type="text" id="searchNasabah" placeholder="1122334455" 
                                        class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                    <button class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition-colors">
                                        <i class="fas fa-search text-xs"></i> Cari
                                    </button>
                                </div>
                            </div>
                            <div class="flex-1">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Status Saldo</label>
                                <div class="px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-lg">
                                    <p class="text-xs font-bold text-emerald-700">Aktif</p>
                                    <p class="text-[10px] text-emerald-600">Saldo minimal bertahan: Rp 50.000</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nasabah Info -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                                <div class="px-3 py-2 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-sm font-semibold text-slate-900">Budi Santoso</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">No Rekening</label>
                                <div class="px-3 py-2 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-sm font-semibold text-slate-900">RK 001</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nominal Penarikan -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fas fa-money-bill-wave text-red-600"></i>
                            <h3 class="text-sm font-bold text-slate-900">Nominal Penarikan</h3>
                        </div>

                        <div class="mb-4">
                            <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Jumlah Tarik Tunai</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm font-semibold">Rp</span>
                                <input type="number" id="nominalPenarikan" value="0" 
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-right">
                            </div>
                            
                            <!-- Quick Amount Buttons -->
                            <div class="grid grid-cols-4 gap-2 mt-3">
                                <button type="button" onclick="setNominal(50000)" class="py-2 border border-gray-200 rounded-lg text-xs font-semibold text-slate-600 hover:bg-red-50 hover:border-red-200 hover:text-red-700 transition-colors">50.000</button>
                                <button type="button" onclick="setNominal(100000)" class="py-2 border border-gray-200 rounded-lg text-xs font-semibold text-slate-600 hover:bg-red-50 hover:border-red-200 hover:text-red-700 transition-colors">100.000</button>
                                <button type="button" onclick="setNominal(200000)" class="py-2 border border-gray-200 rounded-lg text-xs font-semibold text-slate-600 hover:bg-red-50 hover:border-red-200 hover:text-red-700 transition-colors">200.000</button>
                                <button type="button" onclick="setNominal(500000)" class="py-2 border border-gray-200 rounded-lg text-xs font-semibold text-slate-600 hover:bg-red-50 hover:border-red-200 hover:text-red-700 transition-colors">500.000</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Ringkasan Transaksi -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 sticky top-4">
                        <h3 class="text-sm font-bold text-slate-900 mb-4">Ringkasan Transaksi</h3>
                        
                        <div class="space-y-3 mb-5">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Jenis Transaksi</span>
                                <span class="text-xs font-bold text-slate-900">Penarikan Tunai</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Nominal</span>
                                <span class="text-xs font-bold text-slate-900" id="summaryNominal">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Biaya Admin</span>
                                <span class="text-xs font-bold text-slate-900">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Total Potongan Saldo</span>
                                <span class="text-sm font-bold text-red-600" id="summaryTotal">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-600">Estimasi Sisa Saldo</span>
                                <span class="text-sm font-bold text-emerald-600" id="summarySisa">Rp 1.500.000</span>
                            </div>
                        </div>

                        <form action="{{ route('operator.penarikan.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="nominal" id="nominalHidden">
                            
                            <button type="submit" class="w-full px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2 text-sm shadow-sm mb-3">
                                <i class="fas fa-print text-xs"></i> Proses Penarikan
                            </button>
                            
                            <a href="{{ route('operator.transaksi.index') }}" class="w-full px-4 py-2.5 border border-gray-200 text-slate-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors text-sm text-center block">
                                Batalkan
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const saldoAwal = 1500000;

        function setNominal(amount) {
            document.getElementById('nominalPenarikan').value = amount;
            updateSummary();
        }

        function updateSummary() {
            const nominal = parseInt(document.getElementById('nominalPenarikan').value) || 0;
            const sisa = saldoAwal - nominal;

            document.getElementById('summaryNominal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
            document.getElementById('summaryTotal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
            document.getElementById('summarySisa').textContent = 'Rp ' + sisa.toLocaleString('id-ID');
            document.getElementById('nominalHidden').value = nominal;
        }

        document.getElementById('nominalPenarikan').addEventListener('input', updateSummary);
    </script>
</body>
</html>