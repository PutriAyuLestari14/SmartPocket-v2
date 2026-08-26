<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nasabah - SMKN 11 Banking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
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
                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-home w-5 text-center"></i> Dashboard
                </a>
                
                <div class="pt-2">
                    <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium transition-colors">
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
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Data Nasabah</h1>
                        <p class="text-sm text-slate-500 mt-1">Kelola data siswa, guru, dan staf SMKN 11.</p>
                    </div>
                    <a href="{{ route('operator.nasabah.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-semibold text-sm flex items-center gap-2 transition-colors">
                        <i class="fas fa-plus"></i> Tambah Nasabah Baru
                    </a>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="grid grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Total Nasabah Aktif</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $totalNasabah ?? 1245 }}</p>
                            <p class="text-xs text-emerald-600 mt-1"><i class="fas fa-arrow-up"></i> +12% bulan ini</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Nasabah Baru (Bln Ini)</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $nasabahBaru ?? 48 }}</p>
                            <p class="text-xs text-emerald-600 mt-1"><i class="fas fa-arrow-up"></i> +5 dari bulan lalu</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-plus text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Rata-Rata Saldo</p>
                            <p class="text-2xl font-bold text-slate-900">Rp 450.000</p>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 75%"></div>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-wallet text-emerald-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6">
                <div class="p-4 border-b border-gray-100">
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" placeholder="Cari NIS, Nama..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>
                        <select class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option>Semua Kelas</option>
                            <option>X RPL 1</option>
                            <option>X RPL 2</option>
                            <option>XI TKJ 1</option>
                            <option>XI TKJ 2</option>
                        </select>
                        <select class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option>Semua Status</option>
                            <option>Aktif</option>
                            <option>Non-Aktif</option>
                        </select>
                        <button class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">NIS</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Nama Nasabah</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Kelas/Jurusan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Saldo Terakhir</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($nasabahs as $n)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $n->user->username ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                                            <span class="text-xs font-bold text-emerald-600">{{ substr($n->nama, 0, 2) }}</span>
                                        </div>
                                        <span class="font-semibold text-slate-800">{{ $n->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">XI RPL 1</td>
                                <td class="px-6 py-4 font-semibold text-slate-900">Rp {{ number_format($n->rekening->saldo ?? 0, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">
                                        {{ ucfirst($n->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('operator.nasabah.destroy', $n->id_nasabah) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Yakin mau hapus data nasabah?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-8 h-8 bg-red-100 hover:bg-red-200 rounded-lg flex items-center justify-center text-red-600 transition-colors" 
                                                    title="Hapus">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('operator.nasabah.edit', $n->id_nasabah) }}" class="w-8 h-8 bg-green-100 hover:bg-gray-200 rounded-lg flex items-center justify-center text-gray-600 transition-colors">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                    <p>Belum ada data nasabah</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-gray-100 flex justify-between items-center">
                    <p class="text-sm text-slate-500">
                        Menampilkan {{ $nasabahs->firstItem() ?? 1 }} sampai {{ $nasabahs->lastItem() ?? $nasabahs->count() }} dari {{ $nasabahs->total() ?? 1245 }} data
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