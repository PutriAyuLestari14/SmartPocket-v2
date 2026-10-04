<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Saldo & Bagi Hasil - Admin Smart Pocket</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bgMain: '#FAFAFA',
                        primary: '#15803d',      
                        primaryDark: '#166534',
                        primaryLight: '#16a34a',
                        secondary: '#22c55e',
                        accent: '#4ade80',
                        mint: '#15803d',          
                        mintLight: '#dcfce7',     
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAFAFA; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        
        /* Variasi Gradient Konsisten */
        .gradient-primary { background: linear-gradient(135deg, #15803d 0%, #166534 100%); box-shadow: 0 12px 28px -6px rgba(21, 128, 61, 0.25); }
        .gradient-soft { background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%); }
        .gradient-vibrant { background: linear-gradient(135deg, #15803d 0%, #16a34a 50%, #22c55e 100%); }
        
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 12px 20px -5px rgba(21, 128, 61, 0.15); }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased selection:bg-mintLight selection:text-primary">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-primaryDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl shadow-slate-200/50">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 gradient-vibrant rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30">
                            <i class="fas fa-wallet text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-base font-black text-primary tracking-tight leading-none">SmartPocket</h1>
                            <p class="text-[10px] text-primaryDark font-bold tracking-wider mt-1 uppercase">ADMIN PANEL</p>
                        </div>
                    </div>
                    <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-primary p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-1.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-chart-line w-5 text-center text-slate-400"></i> Dashboard
                </a>

                <a href="{{ route('admin.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Data Nasabah
                </a>

                <a href="{{ route('admin.update.saldo.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-primary rounded-xl text-sm font-bold transition-all shadow-sm border border-primary/20">
                    <i class="fas fa-coins w-5 text-center text-primary"></i> Update Saldo 
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-file-invoice-dollar w-5 text-center text-slate-400"></i> Laporan Keuangan
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-600 text-sm font-bold py-2.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 min-w-0">

            <!-- Mobile Top Bar -->
            <header class="lg:hidden bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 gradient-soft rounded-xl flex items-center justify-center text-white shadow-md shadow-primary/30 flex-shrink-0">
                        <i class="fas fa-shield-halved text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-black text-primary tracking-tight leading-none">Smart Pocket</h1>
                        <p class="text-[10px] text-primaryDark font-bold tracking-wider mt-1 uppercase">Admin Panel</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="#" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative active:scale-95 transition-transform shadow-sm">
                        <i class="far fa-bell text-base"></i>
                        <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                    </a>
                    <button onclick="toggleSidebar()" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform shadow-sm">
                        <i class="fas fa-bars text-base"></i>
                    </button>
                </div>
            </header>

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- Header Page Title -->
                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-1 flex-wrap">
                            <span>Manajemen</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-primary font-bold">Update Saldo</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Distribusi Bagi Hasil Jasa
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-2 flex items-center gap-2 font-medium">
                            <i class="fas fa-info-circle text-primary"></i>
                            Hitung dan bagikan 20% dari total jasa pinjaman ke saldo nasabah secara proporsional.
                        </p>
                    </div>
                </header>

                <!-- Session Alert -->
                @if(session('success'))
                    <div class="p-4 bg-mintLight border border-primary/30 rounded-2xl flex items-start gap-3 shadow-sm">
                        <div class="w-8 h-8 bg-primary rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <p class="text-sm font-bold text-primaryDark pt-1">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3 shadow-sm">
                        <div class="w-8 h-8 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation text-white text-xs"></i>
                        </div>
                        <p class="text-sm font-bold text-red-700 pt-1">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Filter Periode -->
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-5 lg:p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-days text-primary"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">Periode Pembagian</h3>
                            <p class="text-[11px] text-slate-500 font-medium">Pilih bulan untuk menghitung pembagian hasil jasa.</p>
                        </div>
                    </div>

                    <!-- FORM ACTION: Menggunakan Route Index Controller Baru -->
                    <form method="GET" action="{{ route('admin.update.saldo.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Bulan Target</label>
                                <!-- INPUT NAME: 'periode' sesuai validasi controller -->
                                <input type="month" name="periode" value="{{ request('periode', now()->format('Y-m')) }}"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-bold bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Total Jasa Terkumpul</label>
                                <!-- VARIABEL: $totalJasaMasuk -->
                                <div class="w-full rounded-xl bg-mintLight border border-primary/20 px-4 py-2.5 text-sm font-black text-primary">
                                    Rp {{ number_format($totalJasaMasuk ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary hover:bg-primaryDark text-white rounded-xl text-sm font-bold transition-colors shadow-md shadow-primary/30">
                                    <i class="fas fa-calculator text-xs"></i> Hitung Simulasi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Ringkasan Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-5">
                    <!-- Total Jasa -->
                    <div class="hover-lift bg-white rounded-2xl p-5 border border-blue-100 shadow-lg shadow-blue-500/5 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                                    <i class="fas fa-hand-holding-dollar text-white text-sm"></i>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-wider mb-0.5">Total Jasa Masuk</p>
                            <!-- VARIABEL: $totalJasaMasuk -->
                            <p class="text-lg lg:text-xl font-black text-slate-900 break-all">Rp {{ number_format($totalJasaMasuk ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Dana Dibagikan -->
                    <div class="hover-lift gradient-soft rounded-2xl p-5 shadow-xl shadow-primary/20 relative overflow-hidden group">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center mb-3 border border-white/30">
                                <i class="fas fa-users text-white text-sm"></i>
                            </div>
                            <p class="text-[10px] text-emerald-100 font-black uppercase tracking-wider mb-0.5">Dana Siap Dibagi (20%)</p>
                            <!-- VARIABEL: $danaDibagikan -->
                            <p class="text-lg lg:text-xl font-black text-white break-all">Rp {{ number_format($danaDibagikan ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Jumlah Nasabah -->
                    <div class="hover-lift bg-white rounded-2xl p-5 border border-primary/20 shadow-lg shadow-primary/5 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-mintLight rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-primary to-primaryDark rounded-xl flex items-center justify-center shadow-lg shadow-primary/30">
                                    <i class="fas fa-user-group text-white text-sm"></i>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-wider mb-0.5">Penerima Manfaat</p>
                            <!-- PERBAIKAN: Gunakan count($simulasiPembagian) karena itu array dari controller -->
                            <p class="text-lg lg:text-xl font-black text-slate-900">{{ count($simulasiPembagian ?? []) }} Orang</p>
                        </div>
                    </div>
                </div>

                <!-- Status Pembagian Card -->
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-5 lg:p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Eksekusi</p>

                            <!-- PERBAIKAN: Cek $simulasiPembagian bukan $nasabahs -->
                             @if(count($simulasiPembagian ?? []) > 0 && ($danaDibagikan ?? 0) > 0)
                                <div class="flex items-center gap-2 mt-2 text-amber-600 font-black text-sm">
                                    <div class="w-6 h-6 bg-amber-50 border border-amber-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-clock text-amber-500 text-xs"></i>
                                    </div>
                                    Menunggu Proses
                                </div>
                                <p class="text-xs text-slate-500 mt-1">
                                    Terdapat <strong>{{ count($simulasiPembagian ?? []) }} nasabah</strong> siap menerima bagi hasil periode ini.
                                </p>
                            @else
                                <div class="flex items-center gap-2 mt-2 text-slate-500 font-black text-sm">
                                    <div class="w-6 h-6 bg-slate-100 border border-slate-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-minus text-slate-400 text-xs"></i>
                                    </div>
                                    Tidak Ada Aktivitas
                                </div>
                                <p class="text-xs text-slate-500 mt-1">
                                    Belum ada jasa masuk atau nasabah aktif pada periode terpilih.
                                </p>
                            @endif
                        </div>

                        <!-- TOMBOL PROSES -->
                        @if(count($simulasiPembagian ?? []) > 0 && ($danaDibagikan ?? 0) > 0)
                            <!-- FORM ACTION: Route Store Controller Baru -->
                            <form method="POST" action="{{ route('admin.update.saldo.store') }}"
                                onsubmit="return confirm('PERINGATAN:\n\nAnda akan mengubah saldo {{ count($simulasiPembagian ?? []) }} nasabah secara permanen.\nPastikan data sudah benar!\n\nLanjut proses?')"
                                class="flex-shrink-0">
                                @csrf
                                <!-- INPUT HIDDEN: 'periode' -->
                                <input type="hidden" name="periode" value="{{ request('periode', now()->format('Y-m')) }}">
                                <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-primaryDark text-white rounded-xl text-sm font-black transition-all shadow-md shadow-primary/30 transform hover:-translate-y-1">
                                    <i class="fas fa-play-circle text-xs"></i> Proses Update Saldo
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Tabel Nasabah -->
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 overflow-hidden">

                    <div class="p-4 lg:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <div class="w-1 h-5 bg-gradient-to-b from-primary to-primaryDark rounded-full"></div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900">Daftar Penerima Bagi Hasil</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5 font-medium">Simulasi distribusi dana berdasarkan proporsi saldo.</p>
                            </div>
                        </div>
                        <div class="text-xs text-slate-500 font-bold whitespace-nowrap bg-white px-3 py-1.5 rounded-lg border border-slate-200">
                            Periode: <span class="text-primary font-black">{{ request('periode', now()->format('Y-m')) }}</span>
                        </div>
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 text-slate-500">
                                <tr>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-black uppercase tracking-wider">Nama Nasabah</th>
                                    <th class="px-5 py-3.5 text-left text-[10px] font-black uppercase tracking-wider">No. Rekening</th>
                                    <th class="px-5 py-3.5 text-right text-[10px] font-black uppercase tracking-wider">Saldo Saat Ini</th>
                                    <th class="px-5 py-3.5 text-right text-[10px] font-black uppercase tracking-wider">Estimasi Bagi Hasil</th>
                                    <th class="px-5 py-3.5 text-right text-[10px] font-black uppercase tracking-wider">Saldo Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <!-- LOOPING: Menggunakan Array $simulasiPembagian -->
                                @forelse($simulasiPembagian as $row)
                                    <tr class="hover:bg-mintLight/30 transition-colors group">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary to-primaryDark flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                                    <span class="text-[11px] font-black">{{ strtoupper(substr($row['nama_nasabah'] ?? 'N', 0, 1)) }}</span>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-bold text-slate-900 truncate group-hover:text-primary transition-colors">{{ $row['nama_nasabah'] }}</p>
                                                    <p class="text-[10px] text-slate-400 truncate font-medium">Bobot: {{ $row['porsi_persen'] }}%</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-xs font-bold text-slate-600 font-mono">{{ $row['no_rek'] }}</td>
                                        <td class="px-5 py-4 text-sm font-bold text-slate-700 text-right whitespace-nowrap">
                                            Rp {{ number_format($row['saldo_sekarang'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-5 py-4 text-right whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-mintLight text-primary rounded-lg text-xs font-black border border-primary/10">
                                                <i class="fas fa-plus text-[9px]"></i> Rp {{ number_format($row['estimasi_bagian'], 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm font-black text-primary text-right whitespace-nowrap bg-mintLight/20">
                                            Rp {{ number_format($row['saldo_sekarang'] + $row['estimasi_bagian'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-16 text-center">
                                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-users text-slate-400 text-2xl"></i>
                                            </div>
                                            <p class="text-sm font-bold text-slate-900">Belum ada data simulasi</p>
                                            <p class="text-xs text-slate-500 mt-1">Pastikan ada jasa masuk dan saldo nasabah aktif.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="md:hidden divide-y divide-slate-100">
                        @forelse($simulasiPembagian as $row)
                            <div class="p-4 active:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-primaryDark flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                        <span class="text-sm font-black">{{ strtoupper(substr($row['nama_nasabah'] ?? 'N', 0, 1)) }}</span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-black text-slate-900 truncate">{{ $row['nama_nasabah'] }}</p>
                                        <p class="text-[10px] text-slate-500 font-mono truncate">{{ $row['no_rek'] }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-slate-50 rounded-xl px-3 py-2 border border-slate-100">
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Saldo Awal</p>
                                        <p class="text-xs font-bold text-slate-700 truncate">Rp {{ number_format($row['saldo_sekarang'], 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-mintLight rounded-xl px-3 py-2 border border-primary/10">
                                        <p class="text-[9px] font-black text-primary uppercase tracking-wider mb-0.5">Bagi Hasil</p>
                                        <p class="text-xs font-black text-primary truncate">
                                            + Rp {{ number_format($row['estimasi_bagian'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="col-span-2 bg-white rounded-xl px-3 py-2 border border-slate-200 shadow-sm">
                                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-wider mb-0.5">Saldo Setelah Update</p>
                                        <p class="text-sm font-black text-primary truncate">
                                            Rp {{ number_format($row['saldo_sekarang'] + $row['estimasi_bagian'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-users text-slate-400 text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-900">Belum ada data simulasi</p>
                                <p class="text-xs text-slate-500 mt-1">Pastikan ada jasa masuk dan saldo nasabah aktif.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center text-[10px] text-slate-400 font-bold pt-2">
                    Smart Pocket • Admin Panel • BMT SMKN 11 Bandung
                </p>

            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
</body>
</html> 