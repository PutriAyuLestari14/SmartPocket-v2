<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nasabah - Smart Pocket</title>
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
        
        <!-- Sidebar (Sama seperti sebelumnya) -->
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
                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-users w-5 text-center"></i> Data Nasabah
                </a>
                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-exchange-alt w-5 text-center"></i> Transaksi
                </a>
                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-hand-holding-usd w-5 text-center"></i> Peminjaman
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
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
            <header class="mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-slate-900">Data Nasabah</h1>
                        <p class="text-sm text-slate-500 mt-1">Kelola data siswa, guru, dan staf SMKN 11.</p>
                    </div>
                    <a href="{{ route('operator.nasabah.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold py-2 px-4 rounded-lg transition-colors flex items-center gap-2 shadow-sm">
                        <i class="fas fa-plus text-xs"></i> 
                        <span class="hidden sm:inline">Tambah Nasabah Baru</span>
                        <span class="sm:hidden">Tambah</span>
                    </a>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6 mb-6">
                <div class="bg-white rounded-xl p-4 lg:p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold text-slate-500 uppercase mb-1">Total Nasabah Aktif</p>
                            <p class="text-xl lg:text-2xl font-bold text-slate-900">{{ $totalNasabah ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-4 lg:p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold text-slate-500 uppercase mb-1">Nasabah Baru (Bln Ini)</p>
                            <p class="text-xl lg:text-2xl font-bold text-slate-900">{{ $nasabahBaru ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus text-amber-600"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-4 lg:p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-semibold text-slate-500 uppercase mb-1">Total Saldo Kas</p>
                            <p class="text-xl lg:text-2xl font-bold text-slate-900">Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-wallet text-emerald-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6">
                <div class="p-4 border-b border-gray-100">
                    <form method="GET" action="{{ route('operator.nasabah.index') }}" class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1 relative">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIS atau Nama..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        </div>
                        <select name="status_filter" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status_filter') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status_filter') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        <button type="submit" class="px-4 py-2.5 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-search text-sm"></i> Cari
                        </button>
                        @if(request('search') || request('status_filter'))
                            <a href="{{ route('operator.nasabah.index') }}" class="px-4 py-2.5 bg-gray-100 text-slate-600 rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-times text-sm"></i> Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">No. Rekening</th>
                                <th class="px-4 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">NIS / NIP</th>
                                <th class="px-4 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Nama Nasabah</th>
                                <th class="px-4 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Saldo</th>
                                <th class="px-4 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-center text-[10px] font-semibold text-slate-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($nasabahs as $n)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-xs font-mono text-slate-600">{{ $n->rekening->no_rek ?? '-' }}</td>
                                <td class="px-4 py-3 text-xs text-slate-600">{{ $n->user->username ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-[10px] font-bold text-emerald-600">{{ substr($n->nama, 0, 2) }}</span>
                                        </div>
                                        <span class="text-sm font-semibold text-slate-900">{{ $n->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-slate-900">Rp {{ number_format($n->rekening->saldo ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    @if($n->status == 'aktif')
                                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-semibold">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-semibold">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('operator.nasabah.edit', $n->id_nasabah) }}" class="w-7 h-7 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center transition-colors" title="Edit">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('operator.nasabah.destroy', $n->id_nasabah) }}" method="POST" onsubmit="return confirm('Yakin mau hapus data nasabah ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-7 h-7 bg-red-50 hover:bg-red-100 rounded-lg flex items-center justify-center text-red-600 transition-colors" title="Hapus">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                                    <i class="fas fa-inbox text-2xl text-gray-300 mb-2"></i>
                                    <p class="text-sm">Tidak ada data nasabah yang ditemukan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <p class="text-xs text-slate-500">
                        Menampilkan {{ $nasabahs->firstItem() ?? 0 }} sampai {{ $nasabahs->lastItem() ?? 0 }} dari {{ $nasabahs->total() ?? 0 }} data
                    </p>
                    <div class="flex gap-1">
                        {{ $nasabahs->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>