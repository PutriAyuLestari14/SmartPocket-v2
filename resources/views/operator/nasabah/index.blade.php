<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nasabah - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
        
        /* Variasi Gradient yang TIDAK MONOTON */
        .gradient-primary { background: linear-gradient(135deg, #15803d 0%, #166534 100%); }
        .gradient-mint { background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); }
        .gradient-soft { background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%); }
        .gradient-fresh { background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); }
        .gradient-vibrant { background: linear-gradient(135deg, #15803d 0%, #16a34a 50%, #22c55e 100%); }
        
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 12px 20px -8px rgba(21, 128, 61, 0.15); }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-primaryDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl shadow-slate-200/50">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 gradient-vibrant rounded-xl flex items-center justify-center shadow-lg shadow-primary/30">
                        <i class="fas fa-wallet text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-black text-primary tracking-tight">Smart Pocket</h1>
                        <p class="text-[10px] text-primaryDark font-bold tracking-wider">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>

                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-mintLight to-white text-primary rounded-xl text-sm font-bold transition-all shadow-sm border border-primary/30">
                    <i class="fas fa-users w-5 text-center text-primary"></i> Data Nasabah
                </a>

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-exchange-alt w-5 text-center text-slate-400"></i> Transaksi
                </a>

                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman
                </a>

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-check-circle w-5 text-center text-slate-400"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-chart-pie w-5 text-center text-slate-400"></i> Laporan
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
            <header class="lg:hidden bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 gradient-soft rounded-xl flex items-center justify-center text-white shadow-md shadow-primary/30">
                        <i class="fas fa-wallet text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-black text-primary tracking-tight leading-none">Smart Pocket</h1>
                        <p class="text-[10px] text-primaryDark font-bold tracking-wider mt-1">BMT SMKN 11</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('operator.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative active:scale-95 transition-transform shadow-sm">
                        <i class="far fa-bell text-base"></i>
                        <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                    </a>
                    <button onclick="toggleSidebar()" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform shadow-sm">
                        <i class="fas fa-bars text-base"></i>
                    </button>
                </div>
            </header>

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- Error Alert -->
                @if(session('error'))
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3">
                        <div class="w-8 h-8 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation text-white text-xs"></i>
                        </div>
                        <p class="text-sm font-bold text-red-700 pt-1">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Header -->
                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-1 flex-wrap">
                            <span>Utama</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-primary font-bold">Data Nasabah</span>
                        </div>

                        <h2 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Data Nasabah
                        </h2>
                        <p class="text-sm text-slate-500 mt-2 flex items-center gap-2 font-medium">
                            <i class="fas fa-users text-primary"></i>
                            Kelola data siswa dan guru SMKN 11 Bandung.
                        </p>
                    </div>

                    <!-- Profil + notif desktop -->
                    <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                        <a href="{{ route('operator.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 hover:text-primary hover:border-primary transition-all relative shadow-sm">
                            <i class="far fa-bell text-base"></i>
                            @php $pendingNotif = \App\Models\DetailTabungan::where('status', 'pending')->count(); @endphp
                            @if($pendingNotif > 0)
                                <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                            @endif
                        </a>
                        <div class="w-px h-8 bg-slate-200"></div>
                        <div class="text-right">
                            <p class="text-xs font-black text-slate-800 leading-tight">
                                {{ auth()->user()->petugas->nama_lengkap ?? auth()->user()->name }}
                            </p>
                            <p class="text-[10px] font-bold text-slate-400 mt-0.5">Operator</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl overflow-hidden gradient-vibrant text-white font-black text-sm flex items-center justify-center border-2 border-white shadow-lg shadow-primary/20 flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->petugas->nama_lengkap ?? auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </header>

                <!-- Tombol Tambah (muncul di mobile) -->
                <a href="{{ route('operator.nasabah.create') }}" class="lg:hidden w-full bg-primary hover:bg-primaryDark text-white text-sm font-black py-3 px-4 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-md shadow-primary/30">
                    <i class="fas fa-plus text-xs"></i> Tambah Nasabah Baru
                </a>

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-5">

                    <div class="bg-white rounded-2xl p-5 border border-blue-100 shadow-lg shadow-blue-500/5 hover-lift relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-wider mb-1">Nasabah Aktif</p>
                            <p class="text-1xl lg:text-2xl font-black text-slate-900">{{ $totalNasabah ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-amber-100 shadow-lg shadow-amber-500/5 hover-lift relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-amber-500/30">
                                <i class="fas fa-user-plus text-white text-xl"></i>
                            </div>
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-wider mb-1">Baru (Bln Ini)</p>
                            <p class="text-1xl lg:text-2xl font-black text-slate-900">{{ $nasabahBaru ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="col-span-2 lg:col-span-1 gradient-soft rounded-2xl p-5 shadow-xl shadow-primary/20 relative overflow-hidden hover-lift group">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mb-4 border border-white/30">
                                <i class="fas fa-wallet text-white text-xl"></i>
                            </div>
                            <p class="text-[10px] text-emerald-100 font-black uppercase tracking-wider mb-1">Total Saldo Kas</p>
                            <p class="text-1xl lg:text-2xl font-black text-white break-all leading-tight">Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 overflow-hidden">

                    <!-- Header + Search -->
                    <div class="p-5 lg:p-6 border-b border-slate-100">
                        <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-1 h-5 bg-gradient-to-b from-primary to-primaryDark rounded-full"></div>
                                <h3 class="text-sm lg:text-base font-black text-slate-900">Daftar Nasabah</h3>
                            </div>
                            <a href="{{ route('operator.nasabah.create') }}" class="hidden lg:inline-flex bg-primary hover:bg-primaryDark text-white text-xs font-black py-2.5 px-4 rounded-xl transition-colors items-center gap-2 shadow-md shadow-primary/30">
                                <i class="fas fa-plus text-[10px]"></i> Tambah Nasabah
                            </a>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 mt-4">
                            <div class="flex-1 relative">
                                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="text" id="searchNasabah" placeholder="Cari nama atau no. rekening..."
                                    class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all"
                                    autocomplete="off">
                            </div>
                            <select id="statusNasabah"
                                class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all cursor-pointer sm:min-w-[150px]">
                                <option value="">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50/80">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">No. Rekening</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">NIS / NIP</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Nama Nasabah</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Saldo</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-center text-[10px] font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($nasabahs as $n)
                                <tr class="hover:bg-mintLight/20 transition-colors">
                                    <td class="px-6 py-4 text-xs font-mono font-black text-slate-600">{{ $n->rekening->no_rek ?? '-' }}</td>
                                    <td class="px-6 py-4 text-xs text-slate-600 font-medium">{{ $n->user->username ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-mintLight to-emerald-100 flex items-center justify-center flex-shrink-0">
                                                <span class="text-[10px] font-black text-primary">{{ substr($n->nama, 0, 2) }}</span>
                                            </div>
                                            <span class="text-sm font-bold text-slate-900">{{ $n->nama }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-black text-slate-900">Rp {{ number_format($n->rekening->saldo ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        @if($n->status == 'aktif')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-mintLight text-primary rounded-xl text-[10px] font-black border border-primary/20">
                                                <span class="w-1.5 h-1.5 bg-primary rounded-full"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-700 rounded-xl text-[10px] font-black border border-rose-200">
                                                <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-1.5">
                                            <a href="{{ route('operator.nasabah.edit', $n->id_nasabah) }}" class="w-8 h-8 bg-emerald-50 hover:bg-primary hover:text-white text-primary rounded-lg flex items-center justify-center transition-colors" title="Edit">
                                                <i class="fas fa-edit text-xs"></i>
                                            </a>
                                            <form action="{{ route('operator.nasabah.destroy', $n->id_nasabah) }}" method="POST"
                                                onsubmit="return confirm('⚠️ PERINGATAN!\n\nApakah Anda yakin ingin menghapus nasabah ini?\n\nNama: {{ $n->nama }}\nNo. Rek: {{ $n->rekening->no_rek ?? '-' }}\n\nData yang dihapus tidak dapat dikembalikan!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 bg-red-50 hover:bg-red-500 hover:text-white rounded-lg flex items-center justify-center text-red-600 transition-colors" title="Hapus">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                                        </div>
                                        <p class="text-sm font-bold text-slate-900">Tidak ada data nasabah</p>
                                        <p class="text-xs text-slate-500 mt-1">Data nasabah akan muncul di sini</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="md:hidden divide-y divide-slate-100">
                        @forelse($nasabahs as $n)
                            <div class="p-4 active:bg-slate-50 transition-colors nasabah-card">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div class="flex items-center gap-3 min-w-0 flex-1">
                                        <div class="w-11 h-11 bg-gradient-to-br from-mintLight to-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                            <span class="text-sm font-black text-primary">{{ substr($n->nama, 0, 2) }}</span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-bold text-slate-900 truncate">{{ $n->nama }}</p>
                                            <p class="text-[10px] text-slate-500 font-mono truncate font-medium">{{ $n->rekening->no_rek ?? '-' }}</p>
                                        </div>
                                    </div>
                                    @if($n->status == 'aktif')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-mintLight text-primary rounded-lg text-[9px] font-black border border-primary/20 flex-shrink-0">
                                            <span class="w-1.5 h-1.5 bg-primary rounded-full"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-rose-50 text-rose-700 rounded-lg text-[9px] font-black border border-rose-200 flex-shrink-0">
                                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> Nonaktif
                                        </span>
                                    @endif
                                </div>

                                <div class="grid grid-cols-2 gap-2 mb-3">
                                    <div class="bg-slate-50 rounded-xl px-3 py-2">
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">NIS/NIP</p>
                                        <p class="text-xs font-bold text-slate-700 truncate">{{ $n->user->username ?? '-' }}</p>
                                    </div>
                                    <div class="bg-mintLight rounded-xl px-3 py-2">
                                        <p class="text-[9px] font-bold text-primary uppercase tracking-wider mb-0.5">Saldo</p>
                                        <p class="text-xs font-black text-primary truncate">Rp {{ number_format($n->rekening->saldo ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('operator.nasabah.edit', $n->id_nasabah) }}" class="flex-1 py-2 bg-emerald-50 hover:bg-primary hover:text-white text-primary rounded-xl flex items-center justify-center gap-1.5 text-xs font-bold transition-colors">
                                        <i class="fas fa-edit text-[10px]"></i> Edit
                                    </a>
                                    <form action="{{ route('operator.nasabah.destroy', $n->id_nasabah) }}" method="POST" class="flex-1"
                                        onsubmit="return confirm('⚠️ PERINGATAN!\n\nApakah Anda yakin ingin menghapus nasabah ini?\n\nNama: {{ $n->nama }}\nNo. Rek: {{ $n->rekening->no_rek ?? '-' }}\n\nData yang dihapus tidak dapat dikembalikan!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full py-2 bg-red-50 hover:bg-red-500 hover:text-white rounded-xl flex items-center justify-center gap-1.5 text-xs font-bold text-red-600 transition-colors">
                                            <i class="fas fa-trash text-[10px]"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-900">Tidak ada data nasabah</p>
                                <p class="text-xs text-slate-500 mt-1">Data nasabah akan muncul di sini</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="p-4 lg:p-5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                        <p class="text-[11px] text-slate-500 font-semibold">
                            Menampilkan {{ $nasabahs->firstItem() ?? 0 }}–{{ $nasabahs->lastItem() ?? 0 }} dari {{ $nasabahs->total() ?? 0 }} data
                        </p>
                        <div class="flex gap-1">
                            {{ $nasabahs->links() }}
                        </div>
                    </div>
                </div>
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

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchNasabah');
            const statusSelect = document.getElementById('statusNasabah');
            const rows = document.querySelectorAll('table tbody tr');
            const cards = document.querySelectorAll('.nasabah-card');

            function filterNasabah() {
                const keyword = searchInput.value.toLowerCase().trim();
                const status = statusSelect.value.toLowerCase();

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    const cocokSearch = text.includes(keyword);
                    const cocokStatus = !status || text.includes(status);
                    row.style.display = cocokSearch && cocokStatus ? '' : 'none';
                });

                cards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    const cocokSearch = text.includes(keyword);
                    const cocokStatus = !status || text.includes(status);
                    card.style.display = cocokSearch && cocokStatus ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterNasabah);
            statusSelect.addEventListener('change', filterNasabah);
        });
    </script>
</body>
</html>