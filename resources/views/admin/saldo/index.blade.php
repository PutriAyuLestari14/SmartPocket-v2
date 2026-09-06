<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Saldo - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="p-8 max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Kelola Saldo Nasabah</h1>
                <p class="text-sm text-slate-500">Admin dapat menyesuaikan saldo rekening secara manual.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-emerald-600 hover:underline">
                ← Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-300 text-emerald-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Nama Nasabah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">No. Rekening</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Saldo Saat Ini</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($nasabahs as $n)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $n->nama }}</td>
                        <td class="px-6 py-4 text-sm font-mono text-slate-600">{{ $n->rekening->no_rek ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-emerald-600 text-right">
                            Rp {{ number_format($n->rekening->saldo ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="#" 
                               class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold hover:bg-blue-100 transition-colors">
                                <i class="fas fa-edit"></i> Update Saldo
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data nasabah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="p-4 border-t border-gray-100">
                {{ $nasabahs->links() }}
            </div>
        </div>
    </div>
</body>
</html>