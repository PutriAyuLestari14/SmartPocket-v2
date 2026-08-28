<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi - Smart Pocket</title>
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
                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-home w-5 text-center"></i> Dashboard
                </a>
                
                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-users w-5 text-center"></i> Data Nasabah
                </a>

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-exchange-alt w-5 text-center"></i> Transaksi
                </a>

                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-hand-holding-usd w-5 text-center"></i> Peminjaman
                </a>

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium">
                    <i class="fas fa-check-circle w-5 text-center"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-chart-bar w-5 text-center"></i> Laporan
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-cog w-5 text-center"></i> Pengaturan
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-white border border-gray-200 hover:bg-red-50 text-slate-600 text-sm font-medium py-2.5 px-4 rounded-lg">
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-2">Verifikasi</h1>
            <p class="text-sm text-slate-500">Halaman verifikasi - Coming soon</p>
            
            <div class="mt-8 bg-white rounded-xl border border-gray-200 p-8 text-center">
                <i class="fas fa-tools text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-lg font-semibold text-slate-900 mb-2">Halaman Dalam Pengembangan</h2>
                <p class="text-slate-500">Fitur verifikasi akan segera hadir</p>
            </div>
        </main>
    </div>
</body>
</html>