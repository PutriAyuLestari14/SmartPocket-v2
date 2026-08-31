<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Peminjaman Baru - Smart Pocket</title>
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
                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-exchange-alt w-5 text-center"></i> Transaksi
                </a>
                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium transition-colors">
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
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-slate-900">Input Peminjaman Baru</h1>
                        <p class="text-sm text-slate-500 mt-1">Ajukan pinjaman baru untuk guru atau staf SMKN 11.</p>
                    </div>
                    <a href="{{ route('operator.peminjaman.index') }}" class="px-4 py-2 border border-gray-200 text-slate-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                        <i class="fas fa-arrow-left text-xs"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column: Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-alt text-emerald-600 text-sm"></i>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900">Formulir Peminjaman</h3>
                        </div>

                        <form action="{{ route('operator.peminjaman.store') }}" method="POST">
                            @csrf
                            
                            <!-- Pilih Peminjam -->
                            <div class="mb-4">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Nama Peminjam (Guru/Staf) <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_peminjam" id="namaPeminjam" 
                                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                                    placeholder="Masukkan nama lengkap peminjam" required>
                                <p class="text-[10px] text-slate-400 mt-1">*Ketik nama guru/staf yang akan meminjam</p>
                                @error('nama_peminjam')
                                    <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nominal & Tenor -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Nominal Pinjaman <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm font-semibold">Rp</span>
                                        <input type="number" name="nominal" id="nominal" value="{{ old('nominal') }}" required
                                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-right">
                                    </div>
                                    @error('nominal')
                                        <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Tenor (Bulan) <span class="text-red-500">*</span></label>
                                    <select name="tenor" id="tenor" required class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                        <option value="">Pilih Tenor</option>
                                        <option value="3">3 Bulan</option>
                                        <option value="6">6 Bulan</option>
                                        <option value="12" selected>12 Bulan</option>
                                        <option value="24">24 Bulan</option>
                                        <option value="36">36 Bulan</option>
                                    </select>
                                    @error('tenor')
                                        <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bunga & Tujuan -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Suku Bunga (% per tahun)</label>
                                    <div class="relative">
                                        <input type="number" name="bunga" value="{{ old('bunga', 5) }}" step="0.1"
                                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-right">
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">%</span>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-1">*Kosongkan jika tanpa bunga</p>
                                    @error('bunga')
                                        <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Tujuan Peminjaman</label>
                                    <select name="tujuan" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                        <option value="">Pilih Tujuan</option>
                                        <option value="modal_usaha">Modal Usaha</option>
                                        <option value="pendidikan">Pendidikan</option>
                                        <option value="kesehatan">Kesehatan</option>
                                        <option value="darurat">Darurat</option>
                                        <option value="renovasi">Renovasi Rumah</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tanggal -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Tanggal Pinjam <span class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_pinjam" id="tanggalPinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required
                                        class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                    @error('tanggal_pinjam')
                                        <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Tanggal Jatuh Tempo <span class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_jatuh_tempo" id="tanggalJatuhTempo" value="{{ old('tanggal_jatuh_tempo') }}" required
                                        class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                    @error('tanggal_jatuh_tempo')
                                        <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="mb-5">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Catatan Tambahan (Opsional)</label>
                                <textarea name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan..." 
                                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 resize-none">{{ old('catatan') }}</textarea>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3 pt-4 border-t border-gray-100">
                                <a href="{{ route('operator.peminjaman.index') }}" class="flex-1 px-4 py-2.5 border border-gray-200 text-slate-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors text-sm text-center">
                                    Batal
                                </a>
                                <button type="submit" class="flex-1 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2 text-sm shadow-sm">
                                    <i class="fas fa-save text-xs"></i> Simpan Peminjaman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Summary -->
                <div class="lg:col-span-1 space-y-4">
                    
                    <!-- Simulasi Angsuran -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-calculator text-emerald-600"></i> Simulasi Angsuran
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Nominal Pinjaman</span>
                                <span class="text-sm font-bold text-slate-900" id="simulasiNominal">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Tenor</span>
                                <span class="text-sm font-bold text-slate-900" id="simulasiTenor">0 Bulan</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Bunga/tahun</span>
                                <span class="text-sm font-bold text-slate-900" id="simulasiBunga">0%</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Total Bunga</span>
                                <span class="text-sm font-bold text-amber-600" id="simulasiTotalBunga">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Total Pinjaman + Bunga</span>
                                <span class="text-sm font-bold text-slate-900" id="simulasiTotal">Rp 0</span>
                            </div>
                            <div class="p-3 bg-emerald-50 rounded-lg border border-emerald-100">
                                <p class="text-[10px] text-emerald-700 font-semibold uppercase mb-1">Angsuran Per Bulan</p>
                                <p class="text-xl font-bold text-emerald-600" id="simulasiAngsuran">Rp 0</p>
                            </div>
                        </div>
                    </div>

                    <!-- Syarat Peminjaman -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-clipboard-check text-blue-500"></i> Syarat Peminjaman
                        </h3>
                        
                        <div class="space-y-2.5">
                            <div class="flex gap-2">
                                <i class="fas fa-check-circle text-emerald-500 text-xs mt-0.5"></i>
                                <div>
                                    <p class="text-xs font-semibold text-slate-900">Status Kepegawaian Aktif</p>
                                    <p class="text-[10px] text-slate-500">Guru SMKN 11</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <i class="fas fa-check-circle text-emerald-500 text-xs mt-0.5"></i>
                                <div>
                                    <p class="text-xs font-semibold text-slate-900">Masa Kerja Minimal</p>
                                    <p class="text-[10px] text-slate-500">Minimal 1 tahun</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <i class="fas fa-check-circle text-emerald-500 text-xs mt-0.5"></i>
                                <div>
                                    <p class="text-xs font-semibold text-slate-900">Slip Gaji Terakhir</p>
                                    <p class="text-[10px] text-slate-500">Untuk verifikasi kemampuan bayar</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <i class="fas fa-check-circle text-emerald-500 text-xs mt-0.5"></i>
                                <div>
                                    <p class="text-xs font-semibold text-slate-900">Tidak Ada Tunggakan</p>
                                    <p class="text-[10px] text-slate-500">Pinjaman sebelumnya harus lancar</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Penting -->
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <div class="flex gap-3">
                            <i class="fas fa-exclamation-triangle text-amber-600 text-sm mt-0.5"></i>
                            <div>
                                <p class="text-xs font-bold text-amber-900 mb-1">Info Penting</p>
                                <ul class="text-[10px] text-amber-800 space-y-1 list-disc list-inside">
                                    <li>Pinjaman hanya untuk guru/staf aktif</li>
                                    <li>Proses persetujuan 1-3 hari kerja</li>
                                    <li>Pencairan setelah disetujui</li>
                                    <li>Pembayaran via potong gaji atau transfer</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Auto-calculate simulasi angsuran
        function calculateSimulasi() {
            const nominal = parseFloat(document.getElementById('nominal').value) || 0;
            const tenor = parseInt(document.getElementById('tenor').value) || 0;
            const bunga = parseFloat(document.querySelector('input[name="bunga"]').value) || 0;
            
            // Hitung total bunga (sederhana: bunga per tahun * tenor/12)
            const totalBunga = nominal * (bunga / 100) * (tenor / 12);
            const total = nominal + totalBunga;
            const angsuran = tenor > 0 ? total / tenor : 0;
            
            // Update tampilan
            document.getElementById('simulasiNominal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
            document.getElementById('simulasiTenor').textContent = tenor + ' Bulan';
            document.getElementById('simulasiBunga').textContent = bunga + '%';
            document.getElementById('simulasiTotalBunga').textContent = 'Rp ' + Math.round(totalBunga).toLocaleString('id-ID');
            document.getElementById('simulasiTotal').textContent = 'Rp ' + Math.round(total).toLocaleString('id-ID');
            document.getElementById('simulasiAngsuran').textContent = 'Rp ' + Math.round(angsuran).toLocaleString('id-ID');
        }

        // Auto-calculate tanggal jatuh tempo berdasarkan tenor
        function calculateJatuhTempo() {
            const tanggalPinjam = document.getElementById('tanggalPinjam').value;
            const tenor = parseInt(document.getElementById('tenor').value) || 0;
            
            if (tanggalPinjam && tenor > 0) {
                const tgl = new Date(tanggalPinjam);
                tgl.setMonth(tgl.getMonth() + tenor);
                
                const year = tgl.getFullYear();
                const month = String(tgl.getMonth() + 1).padStart(2, '0');
                const day = String(tgl.getDate()).padStart(2, '0');
                
                document.getElementById('tanggalJatuhTempo').value = `${year}-${month}-${day}`;
            }
        }

        // Event listeners
        document.getElementById('nominal').addEventListener('input', calculateSimulasi);
        document.getElementById('tenor').addEventListener('change', function() {
            calculateSimulasi();
            calculateJatuhTempo();
        });
        document.querySelector('input[name="bunga"]').addEventListener('input', calculateSimulasi);
        document.getElementById('tanggalPinjam').addEventListener('change', calculateJatuhTempo);

        // Initial calculation
        calculateSimulasi();
    </script>
</body>
</html>