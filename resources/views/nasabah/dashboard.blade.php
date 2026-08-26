<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        /* ATM Card Horizontal */
        .atm-card {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            position: relative;
            overflow: hidden;
        }
        .atm-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        .atm-card::after {
            content: '';
            position: absolute;
            bottom: -40%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            border-radius: 50%;
        }
        .chip {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            border-radius: 8px;
            position: relative;
        }
        .chip::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 10%;
            right: 10%;
            height: 1px;
            background: rgba(0,0,0,0.2);
        }
        .chip::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 10%;
            bottom: 10%;
            width: 1px;
            background: rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased">
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
                        <p class="text-xs text-slate-500">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-4 space-y-1 flex-1">
                <p class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Menu Utama</p>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-home w-5 text-center"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-wallet w-5 text-center"></i> Saldo
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-money-bill-wave w-5 text-center"></i> Tarik
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-hand-holding-usd w-5 text-center"></i> Pinjam
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-chart-bar w-5 text-center"></i> Laporan
                </a>
                
                <p class="px-4 py-2 mt-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">Lainnya</p>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-cog w-5 text-center"></i> Pengaturan
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <button class="w-full bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-plus text-xs"></i> Transaksi Baru
                </button>
            </div>

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
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Selamat datang 👋</h2>
                    <p class="text-sm text-slate-500 mt-1">{{ auth()->user()->name }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-slate-500 hover:text-slate-700 hover:border-gray-300 transition-colors relative">
                        <i class="far fa-bell text-sm"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">Siswa</p>
                        </div>
                        <div class="w-9 h-9 bg-emerald-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            A
                        </div>
                    </div>
                </div>
            </header>

            <!-- Row 1: ATM Card (Wide) + Penarikan & Peminjaman (Stacked) -->
            <div class="grid grid-cols-3 gap-6 mb-6">
                
                <!-- ATM Card (Lebar ke Samping) -->
                <div class="col-span-2">
                    <div class="atm-card rounded-2xl p-8 text-white relative z-10 shadow-xl">
                        <!-- Top Row: Chip + Logo -->
                        <div class="flex justify-between items-start mb-8 relative z-10">
                            <div class="flex items-center gap-4">
                                <div class="chip w-14 h-10"></div>
                                <i class="fas fa-wifi text-white/60 text-2xl rotate-90"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-emerald-100 uppercase tracking-wider">BMT Card</p>
                                <p class="text-sm font-bold">SMKN 11 BANDUNG</p>
                            </div>
                        </div>
                        
                        <!-- Middle: Saldo Besar -->
                        <div class="mb-8 relative z-10">
                            <p class="text-xs text-emerald-100 uppercase tracking-wider mb-2">Saldo BMT Anda</p>
                            <p class="text-4xl font-bold tracking-tight">Rp 1.250.000</p>
                        </div>
                        
                        <!-- Bottom Row: Nomor Kartu + Nama + Berlaku -->
                        <div class="flex justify-between items-end relative z-10 pt-4 border-t border-white/20">
                            <div class="flex-1">
                                <p class="text-xs text-emerald-100 uppercase tracking-wider mb-1">Nomor Kartu</p>
                                <p class="text-xl font-mono tracking-[0.25em] mb-3">•••• •••• •••• 4521</p>
                                <p class="text-xs text-emerald-100 uppercase tracking-wider mb-1">Pemegang Kartu</p>
                                <p class="text-sm font-semibold uppercase tracking-wide">Ahmad Fauzi</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-emerald-100 uppercase tracking-wider mb-1">Berlaku</p>
                                <p class="text-sm font-semibold">08/28</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Penarikan & Peminjaman Stacked -->
                <div class="col-span-1 flex flex-col gap-6">
                    <!-- Ajukan Penarikan -->
                    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex-1 flex flex-col">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-11 h-11 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-money-bill-wave text-emerald-600 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-slate-900 mb-1">Ajukan Penarikan</h3>
                                <p class="text-xs text-slate-500 leading-relaxed">Tarik saldo BMT Anda dengan mudah.</p>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <button class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-arrow-up text-xs"></i>
                                Ajukan
                            </button>
                        </div>
                    </div>

                    <!-- Ajukan Peminjaman -->
                    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex-1 flex flex-col">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-hand-holding-usd text-blue-600 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-slate-900 mb-1">Ajukan Peminjaman</h3>
                                <p class="text-xs text-slate-500 leading-relaxed">Pinjaman bunga rendah, proses cepat.</p>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-hand-holding-usd text-xs"></i>
                                Ajukan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 2: Status Peminjaman (Full Width) -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info-circle text-amber-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 mb-1">Status Peminjaman</h3>
                            <p class="text-sm text-slate-500">
                                @if((auth()->user()->role ?? 'siswa') === 'guru')
                                    Anda memiliki akses penuh untuk mengajukan peminjaman.
                                @else
                                    Fitur peminjaman hanya tersedia untuk guru dan staff.
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        @if((auth()->user()->role ?? 'siswa') === 'guru')
                            <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 px-4 py-2 rounded-full">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                </span>
                                <span class="text-sm font-semibold text-emerald-700">Aktif</span>
                            </div>
                            <button class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold py-2 px-4 rounded-lg transition-colors">
                                Ajukan Sekarang
                            </button>
                        @else
                            <div class="flex items-center gap-2 bg-slate-100 border border-slate-200 px-4 py-2 rounded-full">
                                <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                                <span class="text-sm font-semibold text-slate-600">Nonaktif</span>
                            </div>
                            <button disabled class="bg-slate-200 text-slate-400 text-sm font-semibold py-2 px-4 rounded-lg cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Row 3: Transaksi Terbaru (Empty State) -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-base font-bold text-slate-900">Transaksi Terbaru</h3>
                    <a href="#" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Lihat semua</a>
                </div>

                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-receipt text-gray-400 text-3xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-slate-900 mb-2">Belum ada transaksi</h4>
                    <p class="text-sm text-slate-500 max-w-md mx-auto">
                        Transaksi Anda akan muncul di sini setelah operator/admin memproses penarikan atau peminjaman.
                    </p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>