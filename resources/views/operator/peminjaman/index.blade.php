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
                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-chart-bar w-5 text-center"></i> Laporan
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
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-wallet text-emerald-600"></i>
                        </div>
                    </div>
                    <p class="text-[10px] font-semibold text-slate-500 uppercase mb-1">Total Pinjaman Aktif</p>
                    <p class="text-2xl font-bold text-slate-900 mb-1">Rp {{ number_format($totalAktif ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-500">Dari {{ $totalPeminjam ?? 0 }} peminjam</p>
                </div>

                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-blue-600"></i>
                        </div>
                    </div>
                    <p class="text-[10px] font-semibold text-slate-500 uppercase mb-1">Cicilan Bulan Ini</p>
                    <p class="text-2xl font-bold text-slate-900 mb-1">Rp {{ number_format($totalCicilanBulanIni ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-500">{{ $jumlahCicilanBulanIni ?? 0 }} peminjam</p>
                </div>

                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-amber-600"></i>
                        </div>
                    </div>
                    <p class="text-[10px] font-semibold text-slate-500 uppercase mb-1">Jatuh Tempo Bulan Ini</p>
                    <p class="text-2xl font-bold text-slate-900 mb-1">{{ $jatuhTempoBulanIni ?? 0 }}</p>
                    <p class="text-xs text-slate-500">Perlu ditagih</p>
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
                            @forelse($peminjamans as $peminjaman)
                                @php
                                    $sisaBulan = $peminjaman->tenor;
                                    $statusClass = 'bg-emerald-100 text-emerald-700';
                                    $statusText = 'Lancar';
                                    
                                    if ($peminjaman->sisa_pinjaman <= 0) {
                                        $statusClass = 'bg-blue-100 text-blue-700';
                                        $statusText = 'Lunas';
                                    }
                                @endphp

                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">{{ $peminjaman->nasabah->nama ?? 'N/A' }}</p>
                                            <p class="text-[10px] text-slate-500">{{ $peminjaman->nasabah->kategori ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                        Rp {{ number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-600">
                                        {{ $peminjaman->tenor }} Bulan
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-600">
                                        {{ $sisaBulan }} Bulan
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 {{ $statusClass }} rounded-full text-[10px] font-semibold">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <button onclick="openMutasiModal({{ $peminjaman->id_nasabah }}, '{{ $peminjaman->nasabah->nama ?? '' }}', '{{ $peminjaman->nasabah->no_rek ?? '' }}')" 
                                                class="w-7 h-7 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center transition-colors" 
                                                title="Lihat Mutasi Peminjaman">
                                                <i class="fas fa-eye text-xs"></i>
                                            </button>
                                            <button class="w-7 h-7 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition-colors" title="Edit">
                                                <i class="fas fa-edit text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <i class="fas fa-inbox text-4xl text-slate-300 mb-3"></i>
                                        <p class="text-sm text-slate-500">Belum ada pinjaman yang disetujui</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <p class="text-xs text-slate-500">Menampilkan {{ $peminjamans->firstItem() ?? 0 }}-{{ $peminjamans->lastItem() ?? 0 }} dari {{ $peminjamans->total() }} data</p>
                    <div class="flex gap-1">
                        {{ $peminjamans->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ============================================ -->
    <!-- MODAL MUTASI PEMINJAMAN -->
    <!-- ============================================ -->
    <div id="mutasiModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeMutasiModal()"></div>
        
        <!-- Modal Content -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[95%] max-w-5xl max-h-[90vh] overflow-y-auto bg-white rounded-2xl shadow-2xl">
            
            <!-- Header Modal -->
            <div class="sticky top-0 bg-emerald-600 text-white px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                <div>
                    <h3 class="text-lg font-bold">Mutasi Peminjaman Nasabah</h3>
                    <p class="text-xs text-emerald-100 mt-0.5" id="modalNamaNasabah">-</p>
                </div>
                <button onclick="closeMutasiModal()" class="w-8 h-8 rounded-lg bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Loading State -->
            <div id="modalLoading" class="p-12 text-center">
                <div class="w-12 h-12 border-4 border-emerald-200 border-t-white rounded-full animate-spin mx-auto mb-3"></div>
                <p class="text-sm text-slate-500">Memuat data mutasi peminjaman...</p>
            </div>

            <!-- Content Modal -->
            <div id="modalContent" class="hidden">
                <div class="p-6">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead class="bg-emerald-600 text-white">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-bold uppercase w-32">GT045<br><span class="font-normal text-emerald-200 text-[10px]">No. Rekening</span></th>
                                        <th class="px-4 py-3 text-left font-bold uppercase">Nama</th>
                                        <th class="px-4 py-3 text-center font-bold uppercase w-24">TGL<br><span class="font-normal text-emerald-200 text-[10px]">Tanggal</span></th>
                                        <th class="px-4 py-3 text-right font-bold uppercase w-32">Debet<br><span class="font-normal text-emerald-200 text-[10px]">(Pinjaman)</span></th>
                                        <th class="px-4 py-3 text-right font-bold uppercase w-32">Kredit<br><span class="font-normal text-emerald-200 text-[10px]">(Cicilan)</span></th>
                                        <th class="px-4 py-3 text-right font-bold uppercase w-32">Saldo<br><span class="font-normal text-emerald-200 text-[10px]">Sisa Hutang</span></th>
                                    </tr>
                                </thead>
                                <tbody id="modalTableBody" class="divide-y divide-gray-100">
                                    <!-- Data akan diisi via JS -->
                                </tbody>
                                <tfoot class="bg-emerald-50 border-t-2 border-emerald-600">
                                    <tr>
                                        <th colspan="3" class="px-4 py-3 text-left font-bold text-emerald-900 uppercase text-[10px]">Total</th>
                                        <th class="px-4 py-3 text-right font-bold text-emerald-900 text-[10px]" id="totalDebet">0</th>
                                        <th class="px-4 py-3 text-right font-bold text-emerald-900 text-[10px]" id="totalKredit">0</th>
                                        <th class="px-4 py-3 text-right font-bold text-emerald-900 text-[10px]" id="totalSaldo">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Empty State -->
                        <div id="modalEmptyState" class="hidden p-8 text-center">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-receipt text-slate-400"></i>
                            </div>
                            <p class="text-sm text-slate-500">Belum ada riwayat peminjaman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Modal -->
    <script>
        const formatRupiah = (angka) => {
            return new Intl.NumberFormat('id-ID').format(angka || 0);
        };

        function openMutasiModal(idNasabah, namaNasabah, noRek) {
            const modal = document.getElementById('mutasiModal');
            const loading = document.getElementById('modalLoading');
            const content = document.getElementById('modalContent');
            const emptyState = document.getElementById('modalEmptyState');
            const tableBody = document.getElementById('modalTableBody');

            // Reset & show modal
            modal.classList.remove('hidden');
            loading.classList.remove('hidden');
            content.classList.add('hidden');
            emptyState.classList.add('hidden');
            tableBody.innerHTML = '';
            document.getElementById('modalNamaNasabah').textContent = namaNasabah + (noRek ? ' - ' + noRek : '');

            // Fetch data dari server
            fetch(`/operator/peminjaman/rekening/${idNasabah}`)
                .then(res => res.json())
                .then(data => {
                    loading.classList.add('hidden');
                    
                    if (!data.success) {
                        content.classList.remove('hidden');
                        tableBody.innerHTML = `<tr><td colspan="6" class="px-4 py-6 text-center text-sm text-red-600">${data.message}</td></tr>`;
                        return;
                    }

                    let saldoBerjalan = 0;
                    let totalDebet = 0;
                    let totalKredit = 0;

                    if (data.transaksi.length === 0) {
                        emptyState.classList.remove('hidden');
                    } else {
                        data.transaksi.forEach((t) => {
                            totalDebet += t.debit;
                            totalKredit += t.kredit;
                            
                            // Hitung sisa hutang berjalan
                            saldoBerjalan += (t.debit - t.kredit);
                            
                            const row = document.createElement('tr');
                            row.className = 'hover:bg-gray-50 transition-colors';
                            row.innerHTML = `
                                <td class="px-4 py-3 text-[10px] font-mono text-slate-600">${data.nasabah.no_rek || '-'}</td>
                                <td class="px-4 py-3 text-[10px] font-semibold text-slate-900">${namaNasabah}</td>
                                <td class="px-4 py-3 text-[10px] text-center text-slate-600">${t.tanggal}</td>
                                <td class="px-4 py-3 text-[10px] font-semibold text-right ${t.debit > 0 ? 'text-emerald-600' : 'text-gray-400'}">
                                    ${t.debit > 0 ? formatRupiah(t.debit).replace(/\./g, ' ') : '0'}
                                </td>
                                <td class="px-4 py-3 text-[10px] font-semibold text-right ${t.kredit > 0 ? 'text-red-600' : 'text-gray-400'}">
                                    ${t.kredit > 0 ? formatRupiah(t.kredit).replace(/\./g, ' ') : '0'}
                                </td>
                                <td class="px-4 py-3 text-[10px] font-bold text-right text-slate-900 bg-gray-50">
                                    ${formatRupiah(saldoBerjalan).replace(/\./g, ' ')}
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }

                    // Update footer total
                    document.getElementById('totalDebet').textContent = formatRupiah(totalDebet).replace(/\./g, ' ');
                    document.getElementById('totalKredit').textContent = formatRupiah(totalKredit).replace(/\./g, ' ');
                    document.getElementById('totalSaldo').textContent = formatRupiah(saldoBerjalan).replace(/\./g, ' ');

                    content.classList.remove('hidden');
                })
                .catch(err => {
                    loading.classList.add('hidden');
                    content.classList.remove('hidden');
                    tableBody.innerHTML = `<tr><td colspan="6" class="px-4 py-6 text-center text-sm text-red-600">Gagal memuat data</td></tr>`;
                });
        }

        function closeMutasiModal() {
            document.getElementById('mutasiModal').classList.add('hidden');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeMutasiModal();
        });
    </script>
</body>
</html>