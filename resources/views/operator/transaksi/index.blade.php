<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - Smart Pocket</title>
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
                <h1 class="text-xl lg:text-2xl font-bold text-slate-900">Manajemen Transaksi</h1>
                <p class="text-sm text-slate-500 mt-1">Riwayat seluruh aktivitas setoran dan penarikan nasabah.</p>
            </div>

            <!-- Riwayat Transaksi Table -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <h3 class="text-sm font-bold text-slate-900">Riwayat Transaksi Terbaru</h3>
                    <div class="flex gap-2">
                        <select class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                            <option>Semua Jenis</option>
                            <option>Setoran</option>
                            <option>Penarikan</option>
                        </select>
                        <input type="date" class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-semibold text-slate-500 uppercase tracking-wider" style="min-width: 140px;">Waktu</th>
                                <th class="px-6 py-4 text-left text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Nasabah</th>
                                <th class="px-6 py-4 text-left text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-4 text-right text-[10px] font-semibold text-slate-500 uppercase tracking-wider" style="min-width: 130px;">Debit (Tarik)</th>
                                <th class="px-6 py-4 text-right text-[10px] font-semibold text-slate-500 uppercase tracking-wider" style="min-width: 130px;">Kredit (Setor)</th>
                                <th class="px-6 py-4 text-center text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            
                            @forelse($transaksi as $item)
                                @php
                                    // Tentukan jenis transaksi (1 = Setoran, 2 = Penarikan)
                                    $isSetoran = $item->id_jenis_transaksi == 1;
                                    $amountFormatted = 'Rp ' . number_format($item->jumlah, 0, ',', '.');
                                    
                                    // Tentukan warna badge status
                                    $statusClass = 'bg-slate-100 text-slate-700';
                                    $statusText = ucfirst($item->status);
                                    if ($item->status == 'berhasil') {
                                        $statusClass = 'bg-emerald-100 text-emerald-700';
                                    } elseif ($item->status == 'pending') {
                                        $statusClass = 'bg-amber-100 text-amber-700';
                                    } elseif (in_array($item->status, ['ditolak', 'gagal'])) {
                                        $statusClass = 'bg-red-100 text-red-700';
                                    }
                                @endphp

                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 align-middle">
                                        <p class="text-sm font-bold text-slate-900">{{ $item->tanggal_transaksi->format('H:i') }} WIB</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $item->tanggal_transaksi->format('d M Y') }}</p>
                                    </td>
                                    <td class="px-6 py-4 align-middle">
                                        <p class="text-sm font-semibold text-slate-900">{{ $item->rekening->nasabah->nama ?? 'Data Tidak Ditemukan' }}</p>
                                        <p class="text-[10px] text-slate-500 font-mono mt-0.5">{{ $item->rekening->no_rek ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4 align-middle">
                                        @if($isSetoran)
                                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-semibold">Setoran</span>
                                        @else
                                            <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-semibold">Penarikan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right align-middle">
                                        @if(!$isSetoran)
                                            <span class="text-sm font-bold text-red-600">{{ $amountFormatted }}</span>
                                        @else
                                            <span class="text-slate-300 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right align-middle">
                                        @if($isSetoran)
                                            <span class="text-sm font-bold text-emerald-600">{{ $amountFormatted }}</span>
                                        @else
                                            <span class="text-slate-300 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center align-middle">
                                        <span class="px-2.5 py-1 {{ $statusClass }} rounded-full text-[10px] font-semibold">{{ $statusText }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-900">Belum ada data transaksi</p>
                                        <p class="text-xs text-slate-500 mt-1">Data akan muncul setelah ada aktivitas setoran atau penarikan.</p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <!-- Pagination Dinamis -->
                @if($transaksi->hasPages())
                <div class="p-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <p class="text-xs text-slate-500">
                        Menampilkan {{ $transaksi->firstItem() }}-{{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} transaksi
                    </p>
                    <div class="flex gap-1">
                        {{ $transaksi->links() }}
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>