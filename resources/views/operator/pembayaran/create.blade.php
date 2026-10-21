<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pembayaran Cicilan - Smart Pocket</title>
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

        .gradient-primary { background: linear-gradient(135deg, #15803d 0%, #166534 100%); }
        .gradient-mint { background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); }
        .gradient-soft { background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%); }
        .gradient-fresh { background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); }
        .gradient-vibrant { background: linear-gradient(135deg, #15803d 0%, #16a34a 50%, #22c55e 100%); }

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
                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Data Nasabah
                </a>
                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-mintLight to-white text-primary rounded-xl text-sm font-bold transition-all shadow-sm border border-primary/30">
                    <i class="fas fa-exchange-alt w-5 text-center text-primary"></i> Transaksi
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
                    <button onclick="toggleSidebar()" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform shadow-sm">
                        <i class="fas fa-bars text-base"></i>
                    </button>
                </div>
            </header>

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- Header -->
                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-1 flex-wrap">
                            <span>Dashboard</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span>Transaksi</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-primary font-bold">Input Pembayaran</span>
                        </div>
                        <h2 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Input Pembayaran Cicilan
                        </h2>
                        <p class="text-sm text-slate-500 mt-2 flex items-center gap-2 font-medium">
                            <i class="fas fa-file-invoice-dollar text-primary"></i>
                            Proses pembayaran angsuran pinjaman untuk guru dan staf.
                        </p>
                    </div>
                </header>

                <!-- Alert Success/Error -->
                @if(session('success'))
                    <div class="p-4 bg-mintLight border border-primary/30 rounded-2xl flex items-start gap-3">
                        <div class="w-8 h-8 bg-primary rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <p class="text-sm font-bold text-primary pt-1">{{ session('success') }}</p>
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

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-6">

                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-5 lg:space-y-6">

                        <!-- 1. Data Peminjam -->
                        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-5 lg:p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                                    <i class="fas fa-user-tie text-primary text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black text-slate-900">Data Peminjam</h3>
                                    <p class="text-[11px] text-slate-500">Cari guru/staf yang akan melakukan pembayaran</p>
                                </div>
                            </div>

                            <!-- Search Form (Real-time) -->
                            <div class="mb-4 relative">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Cari Nasabah</label>
                                <div class="flex gap-2">
                                    <div class="flex-1 relative">
                                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                        <input type="text" id="searchNama" placeholder="Ketik Nama atau No. Rekening..."
                                            class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all"
                                            autocomplete="off">
                                    </div>
                                    <button type="button" onclick="cariNasabah()" class="px-4 py-2.5 bg-primary hover:bg-primaryDark text-white rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-md shadow-primary/30">
                                        <i class="fas fa-search text-xs"></i>
                                    </button>
                                </div>

                                <!-- Dropdown Real-time -->
                                <div id="dropdownNasabah" class="hidden absolute mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-xl max-h-56 overflow-y-auto z-20">
                                    @foreach($nasabahs as $n)
                                        <div onclick="pilihNasabah('{{ $n->id_nasabah }}', '{{ addslashes($n->nama) }}', '{{ $n->no_rek ?? '-' }}', '{{ $n->kategori ?? '-' }}', '{{ $n->status ?? '-' }}', {{ $n->id_nasabah }})"
                                            class="nasabah-item px-4 py-3 hover:bg-mintLight cursor-pointer border-b border-slate-100 last:border-0 transition-colors">
                                            <p class="text-sm font-bold text-slate-900 font-mono">No. Rek: {{ $n->no_rek ?? '-' }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">Nama: {{ $n->nama }} · NISN: {{ $n->user->username ?? '-' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                @error('id_nasabah') <p class="text-xs text-red-600 mt-1.5 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <!-- Selected Nasabah Card -->
                            @if($nasabah)
                                <div class="bg-mintLight/60 border border-primary/20 rounded-2xl p-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center flex-shrink-0 shadow-md shadow-primary/20">
                                            <span class="text-white font-black text-base">{{ substr($nasabah->nama, 0, 2) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-base font-black text-slate-900 truncate">{{ $nasabah->nama }}</p>
                                            <p class="text-[10px] text-slate-500 mt-0.5">No. Rek: {{ $nasabah->no_rek }} • {{ ucfirst($nasabah->kategori) }}</p>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-[9px] text-slate-500 uppercase font-black tracking-wider">Status</p>
                                            <span class="inline-block mt-0.5 px-2.5 py-1 bg-primary text-white rounded-full text-[10px] font-black">{{ ucfirst($nasabah->status) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @elseif(request('cari'))
                                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-amber-800 text-sm flex items-center gap-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span class="font-semibold">Data nasabah tidak ditemukan.</span>
                                </div>
                            @endif
                        </div>

                        <!-- 2. Detail Pembayaran -->
                        @if($nasabah && $peminjamanAktif->isNotEmpty())
                            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-5 lg:p-6">
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                                        <i class="fas fa-file-invoice-dollar text-primary text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-black text-slate-900">Detail Pembayaran Angsuran</h3>
                                        <p class="text-[11px] text-slate-500">Isi data pembayaran dengan benar</p>
                                    </div>
                                </div>

                                <form action="{{ route('operator.pembayaran.store') }}" method="POST" id="formPembayaran">
                                    @csrf

                                    <!-- Pilih Pinjaman Aktif -->
                                    <div class="mb-4">
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Pinjaman Aktif</label>
                                        <select name="id_pinjaman" id="selectPinjaman" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all cursor-pointer" required>
                                            <option value="">-- Pilih Pinjaman --</option>
                                            @foreach($peminjamanAktif as $p)
                                                <option value="{{ $p->id_pinjaman }}"
                                                    data-jumlah="{{ $p->jumlah_pinjaman }}"
                                                    data-sisa="{{ $p->sisa_pinjaman }}"
                                                    data-sisa-jasa="{{ $p->sisa_jasa }}"
                                                    data-jasa-perbulan="{{ $p->jasa_per_bulan }}"
                                                    data-tenor="{{ $p->tenor }}"
                                                    data-next-cicilan="{{ $p->next_cicilan_ke }}"
                                                    data-jasa-bulan='@json($p->jasa_bulan ?? [])'
                                                    {{ $pinjamanTerpilih && $pinjamanTerpilih->id_pinjaman == $p->id_pinjaman ? 'selected' : '' }}>
                                                    Pinjaman Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }} (Sisa Pokok: Rp {{ number_format($p->sisa_pinjaman, 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Info Tagihan Bulan Ini -->
                                    <div id="infoTagihan" class="mb-4 p-4 bg-mintLight/60 rounded-2xl border border-primary/20 hidden">
                                        <p class="text-[10px] font-black text-primary uppercase tracking-widest mb-3 flex items-center gap-2">
                                            <i class="fas fa-info-circle"></i> Info Tagihan Bulan Ini
                                        </p>
                                        <div class="grid grid-cols-2 gap-3 text-xs">
                                            <div class="bg-white/60 rounded-xl p-3">
                                                <span class="text-slate-500 text-[10px] font-semibold block mb-0.5">Pokok/bulan</span>
                                                <span class="font-black text-slate-900 text-sm" id="infoPokokPerBulan">Rp 0</span>
                                            </div>
                                            <div class="bg-white/60 rounded-xl p-3">
                                                <span class="text-slate-500 text-[10px] font-semibold block mb-0.5">Jasa/bulan (1%)</span>
                                                <span class="font-black text-slate-900 text-sm" id="infoJasaPerBulan">Rp 0</span>
                                            </div>
                                            <div class="col-span-2 bg-white rounded-xl p-3 border border-primary/20 flex justify-between items-center">
                                                <span class="text-slate-600 font-bold text-xs">Total (Pokok + Jasa)</span>
                                                <span class="font-black text-primary text-sm" id="infoTotalBulanIni">Rp 0</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cicilan Ke & Tanggal -->
                                    <div class="grid grid-cols-2 gap-3 mb-4">
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Cicilan Ke-</label>
                                            <input type="number" name="cicilan_ke" id="inputCicilanKe" min="1" value="1"
                                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all" required>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tanggal Bayar</label>
                                            <input type="date" name="tanggal_pembayaran" id="tanggalPembayaran" value="{{ date('Y-m-d') }}"
                                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all" required>
                                        </div>
                                    </div>

                                    <!-- Jenis Pembayaran -->
                                    <div class="mb-4">
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Jenis Pembayaran</label>
                                        <select name="jenis_pembayaran" id="selectJenis" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all cursor-pointer" required>
                                            <option value="pokok">Bayar Pokok Saja</option>
                                            <option value="jasa">Bayar Jasa (1%) Saja</option>
                                            <option value="keduanya">Bayar Pokok & Jasa</option>
                                        </select>
                                        <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                            <i class="fas fa-magic text-primary"></i> Nominal akan otomatis terisi sesuai pilihan
                                        </p>
                                    </div>

                                    <!-- Nominal Bayar -->
                                    <div class="mb-4">
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nominal Pembayaran</label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-primary text-sm font-black">Rp</span>
                                            <input type="number" name="jumlah" id="nominalBayar" value="0"
                                                class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base font-black text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all text-right" required>
                                        </div>
                                        <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                            <i class="fas fa-pen text-primary"></i> Bisa diubah manual jika ada uang lebih/kurang
                                        </p>
                                    </div>

                                    <!-- Keterangan -->
                                    <div class="mb-5">
                                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Keterangan <span class="text-slate-400 font-semibold normal-case tracking-normal">(Opsional)</span></label>
                                        <input type="text" name="keterangan" placeholder="Contoh: Pembayaran via transfer..."
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary focus:bg-white transition-all">
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-3">
                                        <a href="{{ route('operator.peminjaman.index') }}" class="flex-1 px-4 py-3 border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors text-sm text-center">
                                            Batal
                                        </a>
                                        <button type="button" onclick="openModal()" class="flex-1 px-4 py-3 bg-primary hover:bg-primaryDark text-white rounded-xl font-black transition-colors flex items-center justify-center gap-2 text-sm shadow-md shadow-primary/30">
                                            <i class="fas fa-check-circle text-xs"></i> Proses Pembayaran
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @elseif($nasabah)
                            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-8 text-center">
                                <div class="w-16 h-16 bg-mintLight rounded-2xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-check-circle text-3xl text-primary"></i>
                                </div>
                                <p class="text-slate-900 font-black">Nasabah ini tidak memiliki pinjaman aktif.</p>
                                <p class="text-xs text-slate-400 mt-1">Semua pinjaman sudah lunas atau belum ada pengajuan.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column -->
                    <div class="lg:col-span-1 space-y-5 lg:space-y-6">

                        <!-- Info Pinjaman -->
                        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-5 lg:p-6">
                            <h3 class="text-sm font-black text-slate-900 mb-5 flex items-center gap-2">
                                <div class="w-8 h-8 bg-mintLight rounded-lg flex items-center justify-center">
                                    <i class="fas fa-info-circle text-primary text-xs"></i>
                                </div>
                                Info Pinjaman Terpilih
                            </h3>

                            <div class="space-y-3" id="infoPinjaman">
                                <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                                    <span class="text-xs text-slate-500 font-semibold">Total Pinjaman</span>
                                    <span class="text-sm font-black text-slate-900" id="infoTotal">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                                    <span class="text-xs text-slate-500 font-semibold">Sisa Pokok</span>
                                    <span class="text-sm font-black text-slate-900" id="infoSisaPokok">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-slate-500 font-semibold">Sisa Jasa</span>
                                    <span class="text-sm font-black text-amber-600" id="infoSisaJasa">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Estimasi Total Sisa -->
                        <div class="gradient-mint rounded-2xl p-5 lg:p-6 text-white shadow-xl shadow-primary/20 relative overflow-hidden lg:sticky lg:top-6">
                            <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                            <div class="relative z-10">
                                <p class="text-[10px] text-emerald-100 uppercase font-black tracking-widest mb-2">Estimasi Total Sisa</p>
                                <p class="text-3xl font-black text-white mb-2 break-all" id="estimasiSisa">Rp 0</p>
                                <p class="text-[10px] text-emerald-100 flex items-center gap-1.5">
                                    <i class="fas fa-sync-alt text-[8px]"></i> Akan terupdate saat nominal diisi
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ═══ MODAL KONFIRMASI PEMBAYARAN ═══ -->
    <div id="confirmModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-primaryDark/60 backdrop-blur-sm backdrop-in" onclick="closeModal()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden modal-in">
            <div class="gradient-primary px-6 py-6 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-receipt text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black">Konfirmasi Pembayaran</h3>
                        <p class="text-xs text-emerald-100 mt-0.5">Pastikan data sudah benar sebelum diproses</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-3 max-h-[60vh] overflow-y-auto">
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                    <span class="text-xs text-slate-500 font-semibold">Nama Peminjam</span>
                    <span id="modalNama" class="text-sm font-black text-slate-900 text-right max-w-[180px] truncate">-</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                    <span class="text-xs text-slate-500 font-semibold">Cicilan Ke-</span>
                    <span id="modalCicilan" class="text-sm font-black text-slate-900">-</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                    <span class="text-xs text-slate-500 font-semibold">Tanggal Bayar</span>
                    <span id="modalTanggal" class="text-sm font-black text-slate-900">-</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                    <span class="text-xs text-slate-500 font-semibold">Jenis Pembayaran</span>
                    <span id="modalJenis" class="text-xs font-black text-primary px-2.5 py-1 bg-mintLight rounded-lg">-</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                    <span class="text-xs text-slate-500 font-semibold">Nominal Bayar</span>
                    <span id="modalNominal" class="text-base font-black text-primary">Rp 0</span>
                </div>
                <div class="flex justify-between items-center pt-3 bg-mintLight rounded-xl px-4 py-3 border border-primary/20">
                    <span class="text-xs text-primary font-black">Estimasi Sisa Pinjaman</span>
                    <span id="modalSisa" class="text-base font-black text-primary">Rp 0</span>
                </div>
            </div>

            <div class="p-6 pt-0 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </button>
                <button type="button" onclick="submitForm()" class="flex-1 py-3 bg-primary hover:bg-primaryDark text-white rounded-xl font-black text-sm transition-colors flex items-center justify-center gap-2 shadow-md shadow-primary/30">
                    <i class="fas fa-check text-xs"></i> Ya, Proses
                </button>
            </div>
        </div>
    </div>

    <!-- ═══ SCRIPT UTAMA (TIDAK DIUBAH) ═══ -->
    <script>
        const selectPinjaman = document.getElementById('selectPinjaman');
        const selectJenis = document.getElementById('selectJenis');
        const nominalBayar = document.getElementById('nominalBayar');

        const infoTotal = document.getElementById('infoTotal');
        const infoSisaPokok = document.getElementById('infoSisaPokok');
        const infoSisaJasa = document.getElementById('infoSisaJasa');
        const estimasiSisa = document.getElementById('estimasiSisa');

        const infoTagihan = document.getElementById('infoTagihan');
        const infoPokokPerBulan = document.getElementById('infoPokokPerBulan');
        const infoJasaPerBulan = document.getElementById('infoJasaPerBulan');
        const infoTotalBulanIni = document.getElementById('infoTotalBulanIni');

        let currentSisaPokok = 0;
        let currentSisaJasa = 0;
        let currentPokokPerBulan = 0;
        let currentJasaPerBulan = 0;

        const formatRupiah = (angka) => {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka || 0);
        };

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        if (selectPinjaman) {
            selectPinjaman.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                if (this.value) {
                    const total = parseInt(selectedOption.dataset.jumlah) || 0;
                    currentSisaPokok = parseInt(selectedOption.dataset.sisa) || 0;
                    currentSisaJasa = parseInt(selectedOption.dataset.sisaJasa) || 0;
                    const tenor = parseInt(selectedOption.dataset.tenor) || 1;

                    const nextCicilan = parseInt(selectedOption.dataset.nextCicilan) || 1;
                    document.getElementById('inputCicilanKe').value = nextCicilan;

                    currentJasaPerBulan = parseInt(selectedOption.dataset.jasaPerbulan) || (total * 0.01);
                    currentPokokPerBulan = Math.ceil(total / tenor);

                    infoTotal.textContent = formatRupiah(total);
                    infoSisaPokok.textContent = formatRupiah(currentSisaPokok);
                    infoSisaJasa.textContent = formatRupiah(currentSisaJasa);

                    infoPokokPerBulan.textContent = formatRupiah(currentPokokPerBulan);
                    infoJasaPerBulan.textContent = formatRupiah(currentJasaPerBulan);
                    infoTotalBulanIni.textContent = formatRupiah(currentPokokPerBulan + currentJasaPerBulan);
                    infoTagihan.classList.remove('hidden');

                    updateNominalOtomatis();
                    updateEstimasi();
                } else {
                    infoTotal.textContent = 'Rp 0';
                    infoSisaPokok.textContent = 'Rp 0';
                    infoSisaJasa.textContent = 'Rp 0';
                    estimasiSisa.textContent = 'Rp 0';
                    infoTagihan.classList.add('hidden');
                    nominalBayar.value = '';
                    currentSisaPokok = 0;
                    currentSisaJasa = 0;
                    currentJasaPerBulan = 0;
                    currentPokokPerBulan = 0;
                }
            });
        }

        if (selectJenis) {
            selectJenis.addEventListener('change', function () {
                updateNominalOtomatis();
                updateEstimasi();
            });
        }

        function updateNominalOtomatis() {
            if (!selectPinjaman || !selectPinjaman.value) return;

            const jenis = selectJenis.value;
            let nominal = 0;

            if (jenis === 'jasa') {
                nominal = currentJasaPerBulan;
            } else if (jenis === 'pokok') {
                nominal = currentPokokPerBulan;
            } else if (jenis === 'keduanya') {
                const selectedOption = selectPinjaman.options[selectPinjaman.selectedIndex];
                const tanggal = document.getElementById('tanggalPembayaran').value;
                let jasaSudahDibayar = false;

                if (tanggal && selectedOption.dataset.jasaBulan) {
                    const jasaBulan = JSON.parse(selectedOption.dataset.jasaBulan);
                    const bulanPembayaran = tanggal.substring(0, 7);
                    jasaSudahDibayar = jasaBulan.includes(bulanPembayaran);
                }

                if (jasaSudahDibayar) {
                    nominal = currentPokokPerBulan;
                } else {
                    nominal = currentPokokPerBulan + currentJasaPerBulan;
                }
            }
            nominalBayar.value = nominal;
        }

        if (nominalBayar) {
            nominalBayar.addEventListener('input', updateEstimasi);
        }

        function updateEstimasi() {
            if (currentSisaPokok > 0 || currentSisaJasa > 0) {
                const bayar = parseInt(nominalBayar.value) || 0;
                const jenis = selectJenis.value;

                let sisaSetelahBayarPokok = currentSisaPokok;
                let sisaSetelahBayarJasa = currentSisaJasa;

                if (jenis === 'jasa') {
                    sisaSetelahBayarJasa = Math.max(0, currentSisaJasa - bayar);
                } else if (jenis === 'pokok') {
                    sisaSetelahBayarPokok = Math.max(0, currentSisaPokok - bayar);
                } else if (jenis === 'keduanya') {
                    if (bayar <= currentSisaJasa) {
                        sisaSetelahBayarJasa = currentSisaJasa - bayar;
                    } else {
                        sisaSetelahBayarJasa = 0;
                        sisaSetelahBayarPokok = Math.max(0, currentSisaPokok - (bayar - currentSisaJasa));
                    }
                }

                const totalSisa = sisaSetelahBayarPokok + sisaSetelahBayarJasa;
                estimasiSisa.textContent = formatRupiah(totalSisa);

                if (bayar > (currentSisaPokok + currentSisaJasa)) {
                    estimasiSisa.classList.add('text-red-200');
                } else {
                    estimasiSisa.classList.remove('text-red-200');
                }
            }
        }

        if (selectPinjaman && selectPinjaman.value) {
            selectPinjaman.dispatchEvent(new Event('change'));
        }

        const tanggalPembayaran = document.getElementById('tanggalPembayaran');
        if (tanggalPembayaran) {
            tanggalPembayaran.addEventListener('change', function () {
                updateNominalOtomatis();
                updateEstimasi();
            });
        }

        // ═══ MODAL ═══
        function openModal() {
            if (!selectPinjaman || !selectPinjaman.value) {
                alert('Silakan pilih pinjaman terlebih dahulu!');
                return;
            }
            const nominal = parseInt(nominalBayar.value) || 0;
            if (nominal <= 0) {
                alert('Nominal pembayaran harus lebih dari 0!');
                return;
            }

            const nama = '{{ $nasabah->nama ?? "-" }}';
            const cicilan = document.getElementById('inputCicilanKe').value;
            const tanggal = document.getElementById('tanggalPembayaran').value;
            const jenisText = selectJenis.options[selectJenis.selectedIndex].text;
            const sisaText = estimasiSisa.textContent;

            const tglFormat = new Date(tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalCicilan').textContent = 'Ke-' + cicilan;
            document.getElementById('modalTanggal').textContent = tglFormat;
            document.getElementById('modalJenis').textContent = jenisText;
            document.getElementById('modalNominal').textContent = formatRupiah(nominal);
            document.getElementById('modalSisa').textContent = sisaText;

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
            document.getElementById('formPembayaran').submit();
        }
    </script>

    <!-- ═══ AUTO SEARCH NASABAH (REAL-TIME) ═══ -->
    <script>
        // Karena pakai data dari $nasabahs, kita bikin search real-time via JS aja
        const searchNama = document.getElementById('searchNama');
        const dropdownNasabah = document.getElementById('dropdownNasabah');

        // Fungsi untuk nampilin semua nasabah saat pertama kali ngetik
        function filterNasabah() {
            const searchValue = searchNama.value.toLowerCase().trim();
            const items = dropdownNasabah.getElementsByClassName('nasabah-item');

            let hasVisible = false;
            for (let item of items) {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                    item.style.display = 'block';
                    hasVisible = true;
                } else {
                    item.style.display = 'none';
                }
            }

            if (searchValue.length > 0 && hasVisible) {
                dropdownNasabah.classList.remove('hidden');
            } else {
                dropdownNasabah.classList.add('hidden');
            }
        }

        function cariNasabah() {
            filterNasabah();
        }

        // Event listener pas ngetik
        searchNama.addEventListener('keyup', filterNasabah);

        // Tutup dropdown kalau klik di luar
        document.addEventListener('click', function (event) {
            if (searchNama && dropdownNasabah && !searchNama.contains(event.target) && !dropdownNasabah.contains(event.target)) {
                dropdownNasabah.classList.add('hidden');
            }
        });

        // Fungsi pilih nasabah
        function pilihNasabah(id, nama, noRek, kategori, status, nasabahId) {
            // Redirect ke halaman dengan parameter cari
            window.location.href = "{{ route('operator.pembayaran.create') }}?cari=" + encodeURIComponent(nama);
        }
    </script>

</body>
</html>