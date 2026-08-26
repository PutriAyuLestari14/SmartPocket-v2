<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .atm-card {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #047857 100%);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.3);
        }
        .atm-card::before {
            content: '';
            position: absolute;
            top: -40%; right: -15%;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 60%);
            border-radius: 50%;
        }
        .chip {
            background: linear-gradient(135deg, #fcd34d 0%, #fbbf24 50%, #d97706 100%);
            border-radius: 5px;
            position: relative;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        }
        .chip::before {
            content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: rgba(0,0,0,0.15);
        }
        .chip::after {
            content: ''; position: absolute; left: 33%; right: 33%; top: 0; bottom: 0; border-left: 1px solid rgba(0,0,0,0.15); border-right: 1px solid rgba(0,0,0,0.15);
        }

        .hover-lift { transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 8px 20px -5px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased">
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-screen z-20">
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
            
            <nav class="p-4 space-y-1 flex-1">
                <p class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menu Utama</p>
                <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium">
                    <i class="fas fa-home w-5 text-center"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-wallet w-5 text-center"></i> Saldo
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-money-bill-wave w-5 text-center"></i> Tarik
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-hand-holding-usd w-5 text-center"></i> Pinjam
                </a>
                
                <!-- UBAHAN: Menu Riwayat yang sudah terhubung ke route -->
                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-history w-5 text-center"></i> Riwayat
                </a>
                
                <p class="px-4 py-2 mt-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lainnya</p>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-cog w-5 text-center"></i> Pengaturan
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100 space-y-3">
                <button class="w-full bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <i class="fas fa-plus text-xs"></i> Transaksi Baru
                </button>
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
            <header class="flex justify-between items-center mb-6 lg:mb-8">
                <div>
                    <h2 class="text-lg lg:text-xl font-bold text-slate-900">Selamat datang 👋</h2>
                    <p class="text-sm text-slate-500 mt-1">{{ auth()->user()->name }}</p>
                </div>
                <div class="flex items-center gap-3 lg:gap-4">
                    <button class="w-9 h-9 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-slate-500 hover:text-slate-700 hover:border-gray-300 transition-colors relative">
                        <i class="far fa-bell text-sm"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">Siswa</p>
                        </div>
                        <div class="w-9 h-9 bg-emerald-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Row 1: ATM Card + Penarikan & Peminjaman -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-6 mb-4 lg:mb-6">
                
                <!-- ATM Card (Responsif & Proporsional) -->
                <div class="lg:col-span-7">
                    <div class="atm-card rounded-xl p-4 lg:p-5 text-white relative z-10">
                        <!-- Top Row: Chip + Logo -->
                        <div class="flex justify-between items-start mb-4 lg:mb-5 relative z-10">
                            <div class="flex items-center gap-2 lg:gap-3">
                                <div class="chip w-9 h-6 lg:w-10 lg:h-7"></div>
                                <i class="fas fa-wifi text-white/50 text-base lg:text-lg rotate-90"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-[8px] lg:text-[9px] text-emerald-100 uppercase tracking-widest font-semibold mb-0.5">BMT Card</p>
                                <p class="text-[10px] lg:text-[11px] font-bold">SMKN 11 BANDUNG</p>
                            </div>
                        </div>
                        
                        <!-- Middle: Saldo -->
                        <div class="mb-4 lg:mb-5 relative z-10">
                            <p class="text-[8px] lg:text-[9px] text-emerald-100 uppercase tracking-widest font-semibold mb-1">Saldo BMT Anda</p>
                            <p class="text-xl lg:text-2xl font-bold tracking-tight">Rp 1.250.000</p>
                        </div>
                        
                        <!-- Bottom Row: Nomor Kartu + Nama + Berlaku -->
                        <div class="flex justify-between items-end relative z-10 pt-3 border-t border-white/20">
                            <div class="flex-1">
                                <p class="text-[8px] lg:text-[9px] text-emerald-100 uppercase tracking-widest font-semibold mb-0.5">Nomor Kartu</p>
                                <p class="text-xs lg:text-sm font-mono tracking-[0.2em] mb-2">•••• •••• •••• 4521</p>
                                <p class="text-[8px] lg:text-[9px] text-emerald-100 uppercase tracking-widest font-semibold mb-0.5">Pemegang Kartu</p>
                                <p class="text-[10px] lg:text-[11px] font-bold uppercase tracking-wide">Ahmad Fauzi</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[8px] lg:text-[9px] text-emerald-100 uppercase tracking-widest font-semibold mb-0.5">Berlaku</p>
                                <p class="text-[10px] lg:text-[11px] font-bold">08/28</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Penarikan & Peminjaman -->
                <div class="lg:col-span-5 flex flex-col gap-3 lg:gap-4">
                    <!-- Ajukan Penarikan -->
                    <div class="bg-white rounded-xl p-3 lg:p-4 border border-gray-200 shadow-sm hover-lift flex-1 flex flex-col cursor-pointer group">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-9 h-9 lg:w-10 lg:h-10 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-100 transition-colors">
                                <i class="fas fa-money-bill-wave text-emerald-600 text-sm lg:text-base"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-slate-900 mb-0.5">Ajukan Penarikan</h3>
                                <p class="text-xs text-slate-500 leading-relaxed">Tarik saldo BMT dengan mudah.</p>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <button class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-xs py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                                <i class="fas fa-arrow-up text-[10px]"></i>
                                Ajukan
                            </button>
                        </div>
                    </div>

                    <!-- Ajukan Peminjaman -->
                    <div class="bg-white rounded-xl p-3 lg:p-4 border border-gray-200 shadow-sm hover-lift flex-1 flex flex-col cursor-pointer group">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-9 h-9 lg:w-10 lg:h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-100 transition-colors">
                                <i class="fas fa-hand-holding-usd text-blue-600 text-sm lg:text-base"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-slate-900 mb-0.5">Ajukan Peminjaman</h3>
                                <p class="text-xs text-slate-500 leading-relaxed">Pinjaman bunga rendah.</p>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold text-xs py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                                <i class="fas fa-hand-holding-usd text-[10px]"></i>
                                Ajukan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 2: Status Peminjaman -->
            <div class="bg-white rounded-xl p-4 lg:p-5 border border-gray-200 shadow-sm mb-4 lg:mb-6 hover-lift">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info-circle text-amber-600"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 mb-0.5">Status Peminjaman</h3>
                            <p class="text-xs text-slate-500">
                                @if((auth()->user()->role ?? 'siswa') === 'guru')
                                    Anda memiliki akses penuh untuk mengajukan peminjaman.
                                @else
                                    Fitur peminjaman hanya tersedia untuk guru dan staff.
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        @if((auth()->user()->role ?? 'siswa') === 'guru')
                            <div class="flex items-center gap-1.5 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                <span class="text-xs font-semibold text-emerald-700">Aktif</span>
                            </div>
                            <button class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold py-1.5 px-3 rounded-lg transition-colors shadow-sm">
                                Ajukan
                            </button>
                        @else
                            <div class="flex items-center gap-1.5 bg-slate-100 border border-slate-200 px-3 py-1.5 rounded-full">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                <span class="text-xs font-semibold text-slate-600">Nonaktif</span>
                            </div>
                            <button disabled class="bg-slate-200 text-slate-400 text-xs font-semibold py-1.5 px-3 rounded-lg cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Row 3: Transaksi Terbaru -->
            <div class="bg-white rounded-xl p-4 lg:p-5 border border-gray-200 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-bold text-slate-900">Transaksi Terbaru</h3>
                    <a href="{{ route('nasabah.riwayat') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">Lihat semua</a>
                </div>

                <div class="text-center py-8 lg:py-10">
                    <div class="w-14 h-14 lg:w-16 lg:h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-receipt text-gray-400 text-xl lg:text-2xl"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-slate-900 mb-1">Belum ada transaksi</h4>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">
                        Transaksi akan muncul setelah operator memproses penarikan atau peminjaman.
                    </p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>