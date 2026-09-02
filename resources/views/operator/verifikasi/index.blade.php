<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Penarikan - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50">
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-screen">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center">
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
                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium transition-colors">
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
        <main class="flex-1 ml-64 p-6 lg:p-8">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">Verifikasi Transaksi</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola dan setujui permintaan transaksi yang tertunda dari nasabah.</p>
            </div>

            <!-- Notifikasi -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3">
                    <i class="fas fa-check-circle text-emerald-600 text-lg mt-0.5"></i>
                    <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-600 text-lg mt-0.5"></i>
                    <p class="text-sm font-semibold text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Tabs -->
            <div class="flex gap-3 mb-6">
                <button class="px-6 py-2.5 bg-emerald-500 text-white rounded-lg text-sm font-semibold shadow-sm">
                    Verifikasi Penarikan ({{ $pendingCount }})
                </button>
                <button class="px-6 py-2.5 bg-white border border-gray-200 text-slate-600 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">
                    Verifikasi Transaksi Pinjaman
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Main Table -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                        <!-- Toolbar -->
                        <div class="p-4 border-b border-gray-100">
                            <div class="flex gap-3 justify-between items-center flex-wrap">
                                <div class="flex gap-2">
                                    <button class="px-4 py-2 border border-gray-200 rounded-lg text-xs font-medium text-slate-600 hover:bg-gray-50 flex items-center gap-2 transition-colors">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                </div>
                                <div class="relative">
                                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                    <input type="text" placeholder="Cari nama/NIS..." 
                                        class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 w-64 transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">No</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Tanggal / Waktu</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Nasabah</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Jenis</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Nominal</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-center text-[10px] font-semibold text-slate-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($pengajuan as $index => $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-xs font-semibold text-slate-900">{{ $pengajuan->firstItem() + $index }}</td>
                                        <td class="px-6 py-4">
                                            <p class="text-xs font-semibold text-slate-900">{{ $item->created_at->format('d M Y') }}</p>
                                            <p class="text-[10px] text-slate-400">{{ $item->created_at->format('H:i') }} WIB</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-semibold text-slate-900">{{ $item->user->nasabah->nama }}</p>
                                            <p class="text-[10px] text-slate-500">NIS: {{ $item->user->username }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-semibold">Penarikan Tunai</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-slate-900">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-semibold">Tertunda</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-2">
                                                <!-- Form Setujui -->
                                                <form action="{{ route('operator.verifikasi.approve', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui penarikan ini? Saldo nasabah akan langsung berkurang.')">
                                                    @csrf
                                                    <button type="submit" class="w-8 h-8 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg flex items-center justify-center transition-colors shadow-sm" title="Setujui">
                                                        <i class="fas fa-check text-xs"></i>
                                                    </button>
                                                </form>
                                                
                                                <!-- Form Tolak -->
                                                <form action="{{ route('operator.verifikasi.reject', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')">
                                                    @csrf
                                                    <button type="submit" class="w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-lg flex items-center justify-center transition-colors shadow-sm" title="Tolak">
                                                        <i class="fas fa-times text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-check-double text-gray-400 text-2xl"></i>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-900">Tidak ada pengajuan pending</p>
                                            <p class="text-xs text-slate-500 mt-1">Semua pengajuan penarikan telah diproses.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($pengajuan->hasPages())
                        <div class="p-4 border-t border-gray-100 flex justify-between items-center">
                            <p class="text-xs text-slate-500">Menampilkan {{ $pengajuan->firstItem() }}-{{ $pengajuan->lastItem() }} dari {{ $pengajuan->total() }} transaksi</p>
                            <div class="flex gap-1">
                                {{ $pengajuan->links('pagination::tailwind') }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="lg:col-span-1 space-y-4">
                    <!-- Ringkasan Hari Ini -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h3 class="text-sm font-bold text-slate-900 mb-4">Ringkasan Hari Ini</h3>
                        
                        <div class="space-y-3">
                            <div class="p-3 bg-amber-50 rounded-lg border border-amber-100">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-semibold text-slate-700">Menunggu Persetujuan</span>
                                    <span class="text-lg font-bold text-amber-600">{{ $pendingCount }}</span>
                                </div>
                                <div class="w-full bg-amber-200 rounded-full h-1.5">
                                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>

                            <div class="p-3 bg-emerald-50 rounded-lg border border-emerald-100">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-semibold text-slate-700">Disetujui</span>
                                    <span class="text-lg font-bold text-emerald-600">{{ $approvedToday }}</span>
                                </div>
                                <div class="w-full bg-emerald-200 rounded-full h-1.5">
                                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $approvedToday > 0 ? '85%' : '0%' }}"></div>
                                </div>
                            </div>

                            <div class="p-3 bg-red-50 rounded-lg border border-red-100">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-semibold text-slate-700">Ditolak</span>
                                    <span class="text-lg font-bold text-red-600">{{ $rejectedToday }}</span>
                                </div>
                                <div class="w-full bg-red-200 rounded-full h-1.5">
                                    <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ $rejectedToday > 0 ? '15%' : '0%' }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SOP Verifikasi -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-clipboard-list text-emerald-600"></i>
                            SOP Verifikasi
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="flex gap-3">
                                <span class="w-5 h-5 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center flex-shrink-0 text-[10px] font-bold">1</span>
                                <p class="text-xs text-slate-600 leading-relaxed">Penarikan > Rp 250.000 wajib persetujuan Kepala Sekolah</p>
                            </div>
                            <div class="flex gap-3">
                                <span class="w-5 h-5 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center flex-shrink-0 text-[10px] font-bold">2</span>
                                <p class="text-xs text-slate-600 leading-relaxed">Verifikasi saldo mencukupi sebelum menyetujui</p>
                            </div>
                            <div class="flex gap-3">
                                <span class="w-5 h-5 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center flex-shrink-0 text-[10px] font-bold">3</span>
                                <p class="text-xs text-slate-600 leading-relaxed">Pastikan data siswa valid dan sesuai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>