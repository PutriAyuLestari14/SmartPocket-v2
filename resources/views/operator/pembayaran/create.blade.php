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
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-screen z-10">
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
            <!-- Alert Success/Error -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3 text-emerald-800">
                    <i class="fas fa-check-circle text-emerald-600"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 text-red-800">
                    <i class="fas fa-exclamation-circle text-red-600"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

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

                        <!-- Search Form -->
                        <form action="{{ route('operator.pembayaran.create') }}" method="GET" class="flex gap-3 mb-4">
                            <div class="flex-1 relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari Nama atau Username/NIP..." 
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                            </div>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition-colors">
                                Cari
                            </button>
                        </form>

                        <!-- Selected Nasabah Card -->
                        @if($nasabah)
                            <div class="bg-emerald-50/50 border border-emerald-100 rounded-lg p-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-emerald-200 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-emerald-700 font-bold text-lg">{{ substr($nasabah->nama, 0, 2) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-base font-bold text-slate-900">{{ $nasabah->nama }}</p>
                                        <p class="text-[10px] text-slate-500">No. Rek: {{ $nasabah->no_rek }} • {{ ucfirst($nasabah->kategori) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-slate-500 uppercase font-semibold">Status Nasabah</p>
                                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold">{{ ucfirst($nasabah->status) }}</span>
                                    </div>
                                </div>
                            </div>
                        @elseif(request('cari'))
                            <div class="p-4 bg-amber-50 border border-amber-100 rounded-lg text-amber-800 text-sm flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i> Data nasabah tidak ditemukan.
                            </div>
                        @endif
                    </div>

                    <!-- 2. Detail Pembayaran -->
                    @if($nasabah && $peminjamanAktif->isNotEmpty())
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
                                <select name="id_pinjaman" id="selectPinjaman" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" required>
                                    <option value="">-- Pilih Pinjaman --</option>
                                    @foreach($peminjamanAktif as $p)
                                        <option value="{{ $p->id_pinjaman }}" 
                                            data-jumlah="{{ $p->jumlah_pinjaman }}" 
                                            data-sisa="{{ $p->sisa_pinjaman }}"
                                            data-tenor="{{ $p->tenor }}">
                                            Pinjaman Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }} (Sisa: Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Cicilan Ke & Tanggal -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Cicilan Ke-</label>
                                    <input type="number" name="cicilan_ke" id="inputCicilanKe" min="1" value="1"
                                        class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Tanggal Pembayaran</label>
                                    <input type="date" name="tanggal_pembayaran" value="{{ date('Y-m-d') }}" 
                                        class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" required>
                                </div>
                            </div>

                            <!-- Nominal Bayar -->
                            <div class="mb-4">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Nominal Pembayaran</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm font-semibold">Rp</span>
                                    <input type="number" name="jumlah" id="nominalBayar" value="0" 
                                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-right" required>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1">*Masukkan nominal yang dibayarkan nasabah</p>
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-5">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">Keterangan</label>
                                <input type="text" name="keterangan" placeholder="Opsional (contoh: Pembayaran via transfer)..." 
                                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
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
                    @elseif($nasabah)
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 text-center">
                            <i class="fas fa-check-circle text-4xl text-emerald-500 mb-3"></i>
                            <p class="text-slate-600 font-medium">Nasabah ini tidak memiliki pinjaman aktif yang perlu dibayar.</p>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Summary & Schedule -->
                <div class="lg:col-span-1 space-y-4">
                    
                    <!-- Info Pinjaman (Dinamis) -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-emerald-500"></i> Info Pinjaman Terpilih
                        </h3>
                        
                        <div class="space-y-3" id="infoPinjaman">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Total Pinjaman</span>
                                <span class="text-sm font-bold text-slate-900" id="infoTotal">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-xs text-slate-600">Tenor</span>
                                <span class="text-sm font-bold text-slate-900" id="infoTenor">0 Bulan</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-600">Sisa Pinjaman</span>
                                <span class="text-sm font-bold text-amber-600" id="infoSisa">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Sisa Pinjaman Setelah Bayar -->
                    <div class="bg-emerald-500 rounded-xl p-5 text-white shadow-md">
                        <p class="text-[10px] text-emerald-100 uppercase font-semibold mb-1">Estimasi Sisa Setelah Bayar</p>
                        <p class="text-2xl font-bold" id="estimasiSisa">Rp 0</p>
                        <p class="text-[10px] text-emerald-100 mt-2">*Akan terupdate saat nominal diisi</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript untuk Update Otomatis Panel Kanan -->
    <script>
        const selectPinjaman = document.getElementById('selectPinjaman');
        const nominalBayar = document.getElementById('nominalBayar');
        const inputCicilanKe = document.getElementById('inputCicilanKe');
        
        const infoTotal = document.getElementById('infoTotal');
        const infoTenor = document.getElementById('infoTenor');
        const infoSisa = document.getElementById('infoSisa');
        const estimasiSisa = document.getElementById('estimasiSisa');

        let currentSisa = 0;

        // Format Rupiah
        const formatRupiah = (angka) => {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
        };

        // Saat pinjaman dipilih
        selectPinjaman.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (this.value) {
                const total = parseInt(selectedOption.dataset.jumlah);
                currentSisa = parseInt(selectedOption.dataset.sisa);
                const tenor = parseInt(selectedOption.dataset.tenor);

                infoTotal.textContent = formatRupiah(total);
                infoTenor.textContent = tenor + ' Bulan';
                infoSisa.textContent = formatRupiah(currentSisa);
                
                // Reset nominal dan update estimasi
                nominalBayar.value = '';
                updateEstimasi();
            } else {
                infoTotal.textContent = 'Rp 0';
                infoTenor.textContent = '0 Bulan';
                infoSisa.textContent = 'Rp 0';
                estimasiSisa.textContent = 'Rp 0';
                currentSisa = 0;
            }
        });

        // Saat nominal diketik
        nominalBayar.addEventListener('input', updateEstimasi);

        function updateEstimasi() {
            if (currentSisa > 0) {
                const bayar = parseInt(nominalBayar.value) || 0;
                const sisaSetelahBayar = Math.max(0, currentSisa - bayar);
                estimasiSisa.textContent = formatRupiah(sisaSetelahBayar);
                
                // Warning jika bayar lebih besar dari sisa
                if (bayar > currentSisa) {
                    estimasiSisa.classList.add('text-red-200');
                } else {
                    estimasiSisa.classList.remove('text-red-200');
                }
            }
        }
    </script>
</body>
</html>