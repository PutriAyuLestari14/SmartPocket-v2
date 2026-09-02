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

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-exchange-alt w-5 text-center"></i> Transaksi
                </a>

                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-hand-holding-usd w-5 text-center"></i> Peminjaman
                </a>

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-check-circle w-5 text-center"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-chart-bar w-5 text-center"></i> Laporan
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-white border border-gray-200 hover:bg-red-50 hover:text-red-600 text-slate-600 text-sm font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-6">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="text-xl font-bold text-slate-900">Input Penarikan Dana</h1>
                <p class="text-sm text-slate-500 mt-1">Lakukan verifikasi data nasabah dan saldo sebelum memproses penarikan.</p>
            </div>

            <!-- Notifikasi -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-lg flex items-start gap-2">
                    <i class="fas fa-check-circle text-emerald-600 mt-0.5"></i>
                    <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg flex items-start gap-2">
                    <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
                    <p class="text-sm font-semibold text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('operator.penarikan.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-4">
                        
                        <!-- Identitas Nasabah -->
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-user-circle text-emerald-600"></i>
                                <h3 class="text-sm font-bold text-slate-900">Identitas Nasabah</h3>
                            </div>

                            <!-- Search by Nama -->
                            <div class="mb-3">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Cari Nasabah (Nama / NIS)</label>
                                <div class="flex gap-2">
                                    <input type="text" id="searchNama" placeholder="Ketik nama atau NIS..." 
                                        class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                                        onkeyup="filterNasabah()">
                                    <button type="button" onclick="cariNasabah()" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition-colors">
                                        <i class="fas fa-search text-xs"></i>
                                    </button>
                                </div>
                                
                                <!-- Dropdown Hasil Pencarian -->
                                <div id="dropdownNasabah" class="hidden mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto z-10">
                                    @foreach($nasabah as $n)
                                        <div onclick="pilihNasabah('{{ $n->id_nasabah }}', '{{ $n->nama }}', '{{ $n->rekening->no_rek ?? '-' }}', {{ $n->rekening->saldo ?? 0 }})" 
                                             class="px-3 py-2 hover:bg-emerald-50 cursor-pointer border-b border-gray-100 last:border-0">
                                            <p class="text-sm font-semibold text-slate-900">{{ $n->nama }}</p>
                                            <p class="text-xs text-slate-500">NIS: {{ $n->user->username }} | No. Rek: {{ $n->rekening->no_rek ?? '-' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                @error('id_nasabah') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Nasabah Info -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                                    <input type="hidden" name="id_nasabah" id="id_nasabah">
                                    <div class="px-3 py-2 bg-blue-50 border border-blue-200 rounded-lg min-h-[38px] flex items-center">
                                        <p id="displayNama" class="text-sm font-semibold text-slate-900">-</p>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">No Rekening</label>
                                    <div class="px-3 py-2 bg-blue-50 border border-blue-200 rounded-lg min-h-[38px] flex items-center">
                                        <p id="displayNoRek" class="text-sm font-semibold text-slate-900">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Penarikan -->
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-money-bill-wave text-red-600"></i>
                                <h3 class="text-sm font-bold text-slate-900">Detail Penarikan</h3>
                            </div>

                            <div class="mb-3">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Jumlah Tarik Tunai <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm font-semibold">Rp</span>
                                    <input type="number" name="jumlah" id="nominalPenarikan" value="{{ old('jumlah') }}" min="1000" step="1000"
                                        class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 text-right" required>
                                </div>
                                @error('jumlah') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                
                                <!-- Quick Amount Buttons -->
                                <div class="grid grid-cols-4 gap-2 mt-2">
                                    <button type="button" onclick="setNominal(50000)" class="py-1.5 border border-gray-200 rounded text-xs font-semibold text-slate-600 hover:bg-red-50 hover:border-red-200 hover:text-red-700 transition-colors">50.000</button>
                                    <button type="button" onclick="setNominal(100000)" class="py-1.5 border border-gray-200 rounded text-xs font-semibold text-slate-600 hover:bg-red-50 hover:border-red-200 hover:text-red-700 transition-colors">100.000</button>
                                    <button type="button" onclick="setNominal(200000)" class="py-1.5 border border-gray-200 rounded text-xs font-semibold text-slate-600 hover:bg-red-50 hover:border-red-200 hover:text-red-700 transition-colors">200.000</button>
                                    <button type="button" onclick="setNominal(500000)" class="py-1.5 border border-gray-200 rounded text-xs font-semibold text-slate-600 hover:bg-red-50 hover:border-red-200 hover:text-red-700 transition-colors">500.000</button>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-2">
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Keterangan <span class="text-red-500">*</span></label>
                                <textarea name="keterangan" rows="2" placeholder="Contoh: Penarikan tunai untuk kebutuhan sekolah" 
                                    class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 resize-none" required>{{ old('keterangan') }}</textarea>
                                @error('keterangan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Ringkasan -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 sticky top-4">
                            <h3 class="text-sm font-bold text-slate-900 mb-3">Ringkasan Transaksi</h3>
                            
                            <div class="space-y-2 mb-4 text-sm">
                                <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                    <span class="text-xs text-slate-600">Jenis Transaksi</span>
                                    <span class="text-xs font-bold text-slate-900">Penarikan</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                    <span class="text-xs text-slate-600">Saldo Saat Ini</span>
                                    <span class="text-sm font-bold text-emerald-600" id="summarySaldo">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                    <span class="text-xs text-slate-600">Nominal Tarik</span>
                                    <span class="text-xs font-bold text-slate-900" id="summaryNominal">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                    <span class="text-xs text-slate-600">Biaya Admin</span>
                                    <span class="text-xs font-bold text-slate-900">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center pt-1">
                                    <span class="text-xs text-slate-600">Total Potongan</span>
                                    <span class="text-sm font-bold text-red-600" id="summaryTotal">Rp 0</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2 text-sm shadow-sm mb-2">
                                <i class="fas fa-print text-xs"></i> Proses
                            </button>
                            
                            <a href="{{ route('operator.transaksi.index') }}" class="w-full py-2 border border-gray-200 text-slate-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors text-sm text-center block">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script>
        let currentSaldo = 0;

        function filterNasabah() {
            const searchValue = document.getElementById('searchNama').value.toLowerCase();
            const dropdown = document.getElementById('dropdownNasabah');
            const items = dropdown.getElementsByClassName('cursor-pointer');
            
            let hasVisible = false;
            for (let item of items) {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                    item.style.display = 'block';
                    hasVisible = true;
                } else {
                    item.style.display = 'none';
                }
            }
            
            if (searchValue.length > 0 && hasVisible) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }

        function cariNasabah() {
            filterNasabah();
        }

        function pilihNasabah(id, nama, norek, saldo) {
            document.getElementById('id_nasabah').value = id;
            document.getElementById('displayNama').textContent = nama;
            document.getElementById('displayNoRek').textContent = norek;
            document.getElementById('searchNama').value = nama;
            document.getElementById('dropdownNasabah').classList.add('hidden');
            
            currentSaldo = saldo;
            updateSummary();
        }

        function setNominal(amount) {
            document.getElementById('nominalPenarikan').value = amount;
            updateSummary();
        }

        function updateSummary() {
            const nominal = parseInt(document.getElementById('nominalPenarikan').value) || 0;
            
            document.getElementById('summarySaldo').textContent = 'Rp ' + currentSaldo.toLocaleString('id-ID');
            document.getElementById('summaryNominal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
            document.getElementById('summaryTotal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
            
            if (nominal > currentSaldo && currentSaldo > 0) {
                document.getElementById('summarySaldo').classList.remove('text-emerald-600');
                document.getElementById('summarySaldo').classList.add('text-red-600');
            } else {
                document.getElementById('summarySaldo').classList.remove('text-red-600');
                document.getElementById('summarySaldo').classList.add('text-emerald-600');
            }
        }

        document.addEventListener('click', function(event) {
            const searchBox = document.getElementById('searchNama');
            const dropdown = document.getElementById('dropdownNasabah');
            
            if (!searchBox.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        updateSummary();
        document.getElementById('nominalPenarikan').addEventListener('input', updateSummary);
    </script>
</body>
</html>