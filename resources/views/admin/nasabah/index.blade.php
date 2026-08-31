<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nasabah - Admin Smart Pocket</title>
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
                        <p class="text-[10px] text-slate-500 font-medium">Admin Panel</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-4 space-y-1 flex-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-home w-5 text-center"></i> Dashboard
                </a>
                
                <!-- MENU AKTIF -->
                <a href="{{ route('admin.nasabah.index') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-users w-5 text-center"></i> Data Nasabah
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-chart-bar w-5 text-center"></i> Laporan
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-cog w-5 text-center"></i> Pengaturan
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
        <main class="flex-1 ml-64 p-4 lg:p-8">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-xl lg:text-2xl font-bold text-slate-900">Data Master Nasabah</h1>
                    <p class="text-sm text-slate-500 mt-1">Kelola dan pantau data seluruh nasabah BMT.</p>
                </div>

                <button class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2 shadow-sm">
                    <i class="fas fa-plus text-xs"></i> Update saldo nasabah
                </button>
            </div>

            <!-- Table Container -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase tracking-wider">No. Rekening</th>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Saldo</th>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Alamat</th>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Tgl Daftar</th>
                                <th class="px-6 py-3 text-left text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($nasabahs as $index => $n)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $n->user->username ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-emerald-600 font-mono">{{ $n->rekening->no_rek ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-medium">{{ $n->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-slate-900">
                                    Rp {{ number_format($n->rekening->saldo ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate" title="{{ $n->alamat }}">{{ $n->alamat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ \Carbon\Carbon::parse($n->tanggal_daftar)->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full {{ $n->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($n->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-sm text-slate-500">
                                    <i class="fas fa-inbox text-3xl mb-2 text-gray-300"></i>
                                    <p>Belum ada data nasabah.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>