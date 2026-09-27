<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Peminjaman Baru - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bgMain: '#FAFAFA',
                        forest: '#1A4D2E',
                        forestDark: '#123720',
                        mint: '#4E9F3D',
                        mintLight: '#E8F5E9',
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
        .gradient-forest { background: linear-gradient(135deg, #1A4D2E 0%, #123720 100%); }
        .gradient-mint { background: linear-gradient(135deg, #4E9F3D 0%, #1A4D2E 100%); }
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        @keyframes backdropIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-in { animation: modalIn 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .backdrop-in { animation: backdropIn 0.2s ease-out; }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-forestDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center shadow-md shadow-forest/20">
                        <i class="fas fa-wallet text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-forest tracking-tight">Smart Pocket</h1>
                        <p class="text-[10px] text-mint font-bold tracking-wider">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-2 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>

                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Data Nasabah
                </a>

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-exchange-alt w-5 text-center text-slate-400"></i> Transaksi
                </a>

                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-hand-holding-usd w-5 text-center text-mint"></i> Peminjaman
                </a>

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-check-circle w-5 text-center text-slate-400"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-chart-bar w-5 text-center text-slate-400"></i> Laporan
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
            <header class="lg:hidden bg-white border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center text-white shadow-md shadow-forest/20">
                        <i class="fas fa-wallet text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-forest tracking-tight leading-none">Smart Pocket</h1>
                        <p class="text-[10px] text-mint font-bold tracking-wider mt-1">BMT SMKN 11</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('operator.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative active:scale-95 transition-transform">
                        <i class="far fa-bell text-base"></i>
                        <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-mint rounded-full ring-2 ring-white"></span>
                    </a>
                    <button onclick="toggleSidebar()" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform">
                        <i class="fas fa-bars text-base"></i>
                    </button>
                </div>
            </header>

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- Header -->
                <header class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1 flex-wrap">
                            <span>Peminjaman</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-forest font-bold">Input Peminjaman</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Input Peminjaman Baru
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Proses peminjaman langsung melalui teller BMT.
                        </p>
                    </div>
                </header>
                
                <!-- Error -->
                @if ($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-exclamation text-white text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-extrabold text-red-700 mb-2">Data belum lengkap</p>
                                <ul class="list-disc list-inside text-xs text-red-700 space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="p-4 bg-mintLight border border-mint/30 rounded-2xl flex items-start gap-3">
                        <div class="w-8 h-8 bg-mint rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <p class="text-sm font-bold text-forest pt-1">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3">
                        <div class="w-8 h-8 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation text-white text-xs"></i>
                        </div>
                        <p class="text-sm font-bold text-red-700 pt-1">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Form -->
                <form id="formPeminjaman" action="{{ route('operator.peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-6">

                        <!-- Left Column -->
                        <div class="lg:col-span-2 space-y-5 lg:space-y-6">

                            <!-- Identitas Peminjam -->
                            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 lg:p-6">
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                                        <i class="fas fa-user-circle text-forest"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-extrabold text-slate-900">Identitas Peminjam</h3>
                                        <p class="text-[11px] text-slate-500">Cari dan pilih nasabah peminjam</p>
                                    </div>
                                </div>

                                <!-- Search -->
                                <div class="mb-4 relative">
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Cari Nasabah</label>
                                    <div class="flex gap-2">
                                        <div class="flex-1 relative">
                                            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                            <input type="text" id="searchNasabah" placeholder="Ketik nama atau no. rekening..."
                                                class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all"
                                                onkeyup="filterNasabah()" autocomplete="off">
                                        </div>
                                        <button type="button" onclick="filterNasabah()" class="px-4 py-2.5 bg-mint hover:bg-forest text-white rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-md shadow-mint/20">
                                            <i class="fas fa-search text-xs"></i>
                                        </button>
                                    </div>

                                    <!-- Dropdown -->
                                    <div id="dropdownNasabah" class="hidden absolute mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-xl max-h-56 overflow-y-auto z-30">
                                        @foreach($nasabahs as $n)
                                            <div onclick="pilihNasabah('{{ $n->id_nasabah }}', '{{ addslashes($n->nama) }}', '{{ $n->rekening->no_rek ?? '-' }}', '{{ $n->kategori }}', '{{ $n->rekening->saldo ?? 0 }}')"
                                                class="nasabah-item px-4 py-3 hover:bg-mintLight cursor-pointer border-b border-slate-100 last:border-0 transition-colors">
                                                <p class="text-sm font-bold text-slate-900">{{ $n->nama }}</p>
                                                <p class="text-[11px] text-slate-500 mt-0.5">
                                                    No. Rek: <span class="font-mono font-bold">{{ $n->rekening->no_rek ?? '-' }}</span> · {{ ucfirst($n->kategori) }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('id_nasabah')
                                        <p class="text-xs text-red-600 mt-1.5 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Data Terpilih -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                                        <input type="hidden" name="id_nasabah" id="id_nasabah">
                                        <div class="px-4 py-3 bg-mintLight border border-mint/20 rounded-xl min-h-[46px] flex items-center">
                                            <p id="displayNama" class="text-sm font-bold text-forest">-</p>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">No. Rekening</label>
                                        <div class="px-4 py-3 bg-mintLight border border-mint/20 rounded-xl min-h-[46px] flex items-center">
                                            <p id="displayNoRek" class="text-sm font-bold text-forest font-mono">-</p>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Saldo Saat Ini</label>
                                        <div class="px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl min-h-[46px] flex items-center">
                                            <p id="displaySaldo" class="text-sm font-bold text-blue-700">Rp 0</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Peminjaman -->
                            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 lg:p-6">
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                                        <i class="fas fa-hand-holding-usd text-forest"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-extrabold text-slate-900">Detail Peminjaman</h3>
                                        <p class="text-[11px] text-slate-500">Nominal, tenor, dan tanggal</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <!-- Nominal -->
                                    <div>
                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Nominal Pinjaman <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-forest text-sm font-extrabold">Rp</span>
                                            <input type="number" name="jumlah_pinjaman" id="nominal" value="{{ old('jumlah_pinjaman') }}" min="50000" step="10000" required
                                                class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-extrabold text-slate-900 focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all text-right">
                                        </div>
                                        <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                            <i class="fas fa-info-circle text-mint"></i> Minimal Rp 50.000
                                        </p>
                                        @error('jumlah_pinjaman')
                                            <p class="text-xs text-red-600 mt-1.5 font-semibold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Tenor -->
                                    <div>
                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Tenor <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="number" name="tenor" id="tenor" value="{{ old('tenor') }}" min="1" max="24" required placeholder="Contoh: 10"
                                                class="w-full pr-20 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all">
                                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-500 font-bold">Bulan</span>
                                        </div>
                                        <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                            <i class="fas fa-info-circle text-mint"></i> Maksimal 24 bulan
                                        </p>
                                        @error('tenor')
                                            <p class="text-xs text-red-600 mt-1.5 font-semibold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <!-- Tanggal Pinjam -->
                                    <div>
                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Tanggal Pinjam <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_ajuan" id="tanggalPinjam" value="{{ old('tanggal_ajuan', date('Y-m-d')) }}" required
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all">
                                        @error('tanggal_ajuan')
                                            <p class="text-xs text-red-600 mt-1.5 font-semibold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Jatuh Tempo -->
                                    <div>
                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Tanggal Jatuh Tempo <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_jatuh_tempo" id="tanggalJatuhTempo" value="{{ old('tanggal_jatuh_tempo') }}" required
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all">
                                        @error('tanggal_jatuh_tempo')
                                            <p class="text-xs text-red-600 mt-1.5 font-semibold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Keterangan <span class="text-slate-400 font-semibold normal-case tracking-normal">(Opsional)</span></label>
                                    <textarea name="keterangan" rows="3" placeholder="Contoh: Peminjaman untuk kebutuhan rumah tangga..."
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all resize-none">{{ old('keterangan') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="lg:col-span-1">
                            <div class="gradient-forest rounded-2xl p-5 lg:p-6 text-white shadow-xl shadow-forest/20 relative overflow-hidden lg:sticky lg:top-6">
                                <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                                <div class="relative z-10">
                                    <h3 class="text-sm font-extrabold mb-5 flex items-center gap-2">
                                        <i class="fas fa-receipt text-mint"></i> Ringkasan Peminjaman
                                    </h3>

                                    <div class="space-y-3 mb-5 text-sm">
                                        <div class="flex justify-between items-center pb-3 border-b border-white/10 gap-3">
                                            <span class="text-xs text-emerald-100 font-medium flex-shrink-0">Peminjam</span>
                                            <span id="summaryNama" class="text-xs font-extrabold text-white text-right max-w-[150px] truncate">-</span>
                                        </div>
                                        <div class="flex justify-between items-center pb-3 border-b border-white/10 gap-3">
                                            <span class="text-xs text-emerald-100 font-medium flex-shrink-0">No. Rekening</span>
                                            <span id="summaryRek" class="text-xs font-extrabold text-white font-mono">-</span>
                                        </div>
                                        <div class="flex justify-between items-center pb-3 border-b border-white/10 gap-3">
                                            <span class="text-xs text-emerald-100 font-medium flex-shrink-0">Nominal</span>
                                            <span id="summaryNominal" class="text-sm font-extrabold text-blue-300">Rp 0</span>
                                        </div>
                                        <div class="flex justify-between items-center pb-3 border-b border-white/10 gap-3">
                                            <span class="text-xs text-emerald-100 font-medium flex-shrink-0">Tenor</span>
                                            <span id="summaryTenor" class="text-xs font-extrabold text-white">0 Bulan</span>
                                        </div>
                                        <div class="flex justify-between items-center pt-2 bg-white/5 rounded-xl px-3 py-2 -mx-1 gap-3">
                                            <span class="text-xs text-emerald-100 font-bold flex-shrink-0">Angsuran / Bulan</span>
                                            <span id="summaryAngsuran" class="text-sm font-black text-mint">Rp 0</span>
                                        </div>
                                    </div>

                                    <div class="p-3 bg-white/10 backdrop-blur rounded-xl mb-4 flex gap-2">
                                        <i class="fas fa-info-circle text-mint text-xs mt-0.5"></i>
                                        <p class="text-[10px] text-emerald-50 leading-relaxed">
                                            Peminjaman yang diproses melalui teller langsung tercatat sebagai peminjaman yang disetujui.
                                        </p>
                                    </div>

                                    <button type="button" onclick="openModal()" class="w-full py-3 bg-mint hover:bg-emerald-500 text-white rounded-xl font-extrabold transition-colors flex items-center justify-center gap-2 text-sm shadow-lg shadow-mint/30 mb-2">
                                        <i class="fas fa-save text-xs"></i> Simpan Peminjaman
                                    </button>
                                    <a href="{{ route('operator.peminjaman.index') }}" class="w-full py-2.5 border border-white/20 text-white/90 rounded-xl font-bold hover:bg-white/10 transition-colors text-sm text-center block">
                                        Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- ═══ MODAL KONFIRMASI PEMINJAMAN ═══ -->
    <div id="confirmModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-forestDark/60 backdrop-blur-sm backdrop-in" onclick="closeModal()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden modal-in">
            <div class="gradient-forest px-6 py-6 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-hand-holding-usd text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold">Konfirmasi Peminjaman</h3>
                        <p class="text-xs text-emerald-100 mt-0.5">Pastikan data sudah benar sebelum disimpan</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-3 max-h-[60vh] overflow-y-auto">
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">Peminjam</span>
                    <span id="modalNama" class="text-sm font-extrabold text-slate-900 text-right truncate">-</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">No. Rekening</span>
                    <span id="modalRek" class="text-sm font-extrabold text-forest font-mono text-right">-</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">Nominal Pinjaman</span>
                    <span id="modalNominal" class="text-base font-black text-forest">Rp 0</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">Tenor</span>
                    <span id="modalTenor" class="text-sm font-extrabold text-slate-900">-</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">Tanggal Pinjam</span>
                    <span id="modalTanggal" class="text-sm font-extrabold text-slate-900 text-right">-</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">Jatuh Tempo</span>
                    <span id="modalJatuhTempo" class="text-sm font-extrabold text-slate-900 text-right">-</span>
                </div>
                <div class="flex justify-between items-center pt-3 bg-mintLight rounded-xl px-4 py-3 border border-mint/20 gap-3">
                    <span class="text-xs text-forest font-extrabold flex-shrink-0">Angsuran / Bulan</span>
                    <span id="modalAngsuran" class="text-base font-black text-forest">Rp 0</span>
                </div>
            </div>

            <div class="p-6 pt-0 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </button>
                <button type="button" onclick="submitForm()" class="flex-1 py-3 bg-mint hover:bg-forest text-white rounded-xl font-extrabold text-sm transition-colors flex items-center justify-center gap-2 shadow-md shadow-mint/20">
                    <i class="fas fa-check text-xs"></i> Ya, Simpan
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentSaldo = 0;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        /* SEARCH NASABAH */
        function filterNasabah() {
            const searchValue = document.getElementById('searchNasabah').value.toLowerCase().trim();
            const dropdown = document.getElementById('dropdownNasabah');
            const items = dropdown.querySelectorAll('.nasabah-item');
            let adaHasil = false;

            items.forEach(function (item) {
                const text = item.textContent.toLowerCase();
                if (searchValue === '' || text.includes(searchValue)) {
                    item.style.display = 'block';
                    if (searchValue !== '') adaHasil = true;
                } else {
                    item.style.display = 'none';
                }
            });

            if (searchValue !== '' && adaHasil) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }

        /* PILIH NASABAH */
        function pilihNasabah(id, nama, norek, kategori, saldo) {
            document.getElementById('id_nasabah').value = id;
            document.getElementById('displayNama').textContent = nama;
            document.getElementById('displayNoRek').textContent = norek;
            document.getElementById('displaySaldo').textContent = 'Rp ' + Number(saldo).toLocaleString('id-ID');
            document.getElementById('searchNasabah').value = nama;
            document.getElementById('dropdownNasabah').classList.add('hidden');

            currentSaldo = Number(saldo) || 0;

            document.getElementById('summaryNama').textContent = nama;
            document.getElementById('summaryRek').textContent = norek;

            updateSummary();
        }

        /* HITUNG SIMULASI */
        function updateSummary() {
            const nominal = Number(document.getElementById('nominal').value) || 0;
            const tenor = Number(document.getElementById('tenor').value) || 0;
            const angsuran = tenor > 0 ? nominal / tenor : 0;

            document.getElementById('summaryNominal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
            document.getElementById('summaryTenor').textContent = tenor + ' Bulan';
            document.getElementById('summaryAngsuran').textContent = 'Rp ' + Math.round(angsuran).toLocaleString('id-ID');
        }

        /* HITUNG JATUH TEMPO */
        function calculateJatuhTempo() {
            const tanggalPinjam = document.getElementById('tanggalPinjam').value;
            const tenor = Number(document.getElementById('tenor').value) || 0;

            if (!tanggalPinjam || tenor <= 0) return;

            const tanggal = new Date(tanggalPinjam);
            tanggal.setMonth(tanggal.getMonth() + tenor);

            const year = tanggal.getFullYear();
            const month = String(tanggal.getMonth() + 1).padStart(2, '0');
            const day = String(tanggal.getDate()).padStart(2, '0');

            document.getElementById('tanggalJatuhTempo').value = `${year}-${month}-${day}`;
        }

        /* EVENT */
        document.getElementById('nominal').addEventListener('input', updateSummary);
        document.getElementById('tenor').addEventListener('change', function () {
            updateSummary();
            calculateJatuhTempo();
        });
        document.getElementById('tanggalPinjam').addEventListener('change', calculateJatuhTempo);

        /* TUTUP DROPDOWN */
        document.addEventListener('click', function (event) {
            const searchBox = document.getElementById('searchNasabah');
            const dropdown = document.getElementById('dropdownNasabah');
            if (searchBox && dropdown && !searchBox.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        /* ═══ MODAL HANDLER ═══ */
        function openModal() {
            const idNasabah = document.getElementById('id_nasabah').value;
            const nama = document.getElementById('displayNama').textContent;
            const norek = document.getElementById('displayNoRek').textContent;
            const nominal = Number(document.getElementById('nominal').value) || 0;
            const tenor = Number(document.getElementById('tenor').value) || 0;
            const tglPinjam = document.getElementById('tanggalPinjam').value;
            const tglJatuhTempo = document.getElementById('tanggalJatuhTempo').value;

            if (!idNasabah) { alert('Silakan pilih nasabah terlebih dahulu!'); return; }
            if (nominal < 50000) { alert('Nominal pinjaman minimal Rp 50.000!'); return; }
            if (tenor < 1 || tenor > 24) { alert('Tenor harus antara 1-24 bulan!'); return; }
            if (!tglPinjam) { alert('Tanggal pinjam wajib diisi!'); return; }
            if (!tglJatuhTempo) { alert('Tanggal jatuh tempo wajib diisi!'); return; }

            const formatTanggal = (tgl) => {
                if (!tgl) return '-';
                return new Date(tgl).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            };

            const angsuran = tenor > 0 ? Math.round(nominal / tenor) : 0;

            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalRek').textContent = norek;
            document.getElementById('modalNominal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
            document.getElementById('modalTenor').textContent = tenor + ' Bulan';
            document.getElementById('modalTanggal').textContent = formatTanggal(tglPinjam);
            document.getElementById('modalJatuhTempo').textContent = formatTanggal(tglJatuhTempo);
            document.getElementById('modalAngsuran').textContent = 'Rp ' + angsuran.toLocaleString('id-ID');

            const modal = document.getElementById('confirmModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function submitForm() {
            document.getElementById('formPeminjaman').submit();
        }

        /* INIT */
        updateSummary();
        calculateJatuhTempo();
    </script>
</body>
</html>