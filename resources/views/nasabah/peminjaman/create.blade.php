<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
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
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FAFAFA; font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #FAFAFA; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        
        .input-premium { transition: all 0.2s ease-in-out; }
        .input-premium:focus-within { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(26, 77, 46, 0.1); }
        .modal-backdrop { transition: opacity 0.3s ease-out; }
        .modal-box { transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased selection:bg-mintLight selection:text-forest min-h-screen flex flex-col">

    <!-- Topbar Khusus Mobile -->
    <header class="lg:hidden bg-white border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-forest rounded-xl flex items-center justify-center text-white shadow-sm">
                <i class="fas fa-wallet text-sm"></i>
            </div>
            <div>
                <h1 class="text-sm font-extrabold text-forest leading-none">Smart Pocket</h1>
                <p class="text-[9px] font-bold text-mint tracking-wider mt-0.5">BMT SMKN 11</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('nasabah.notifikasi.index') }}" class="w-9 h-9 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative">
                <i class="far fa-bell text-sm"></i>
                @php
                    $nasabah = auth()->user()->nasabah;
                    $unreadCount = $nasabah ? ($nasabah->unreadNotifications ? $nasabah->unreadNotifications->count() : 0) : 0;
                @endphp
                @if($unreadCount > 0)
                    <span class="absolute top-2 right-2 w-2 h-2 bg-mint rounded-full ring-2 ring-white"></span>
                @endif
            </a>
            <button id="toggleSidebar" class="p-2 text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </div>
    </header>

    <div class="flex flex-1 relative">
        <!-- Sidebar Backdrop untuk Mobile -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-forestDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity"></div>

        <!-- Sidebar Nasabah -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-sm">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center text-white shadow-md shadow-forest/20">
                        <i class="fas fa-wallet text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-forest tracking-tight leading-none">SmartPocket</h1>
                        <p class="text-[10px] font-bold text-mint tracking-wider mt-1">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
                <button id="closeSidebar" class="lg:hidden text-slate-400 hover:text-forest">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-2 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Menu Utama</p>
                <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>
                <a href="{{ route('nasabah.penarikan.create') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-money-bill-wave w-5 text-center text-slate-400"></i> Penarikan
                </a>
                @if(auth()->user()->nasabah->kategori == 'guru')
                    <a href="{{ route('nasabah.peminjaman.create') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                        <i class="fas fa-hand-holding-usd w-5 text-center text-mint"></i> Peminjaman
                    </a>
                @endif
                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-history w-5 text-center text-slate-400"></i> Riwayat Transaksi
                </a>
                
                <p class="px-3 pt-6 pb-1.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Sistem</p>
                <a href="{{ route('nasabah.profile.edit')}}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-cog w-5 text-center text-slate-400"></i> Pengaturan Profile
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 text-sm font-bold py-2.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 p-4 sm:p-6 lg:p-10 w-full max-w-7xl mx-auto">
            
            <!-- Header Halaman -->
            <div class="mb-6 lg:mb-8 flex items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1">
                        <span>Utama</span>
                        <i class="fas fa-chevron-right text-[9px]"></i>
                        <span class="text-forest font-bold">Ajukan Peminjaman</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">Pengajuan Pinjaman Dana</h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Dapatkan fasilitas peminjaman dana khusus anggota dengan proses kilat.</p>
                </div>

                <!-- Profile Desktop Header -->
                <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                    <button class="px-4 py-2.5 bg-white border border-slate-200/80 hover:border-mint text-slate-700 hover:text-forest text-xs font-bold rounded-xl transition-all shadow-sm flex items-center gap-2">
                        <i class="fas fa-download text-mint text-xs"></i> Export
                    </button>
                    <div class="w-px h-8 bg-slate-200 my-auto mx-1"></div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-semibold text-slate-400 capitalize mt-0.5">
                            {{ auth()->user()->nasabah->kategori ?? 'Siswa' }}
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-forest text-white font-bold text-sm flex items-center justify-center border border-slate-200 shadow-sm flex-shrink-0">
                        @if(auth()->user()->nasabah && auth()->user()->nasabah->photo)
                            <img src="{{ asset('storage/' . auth()->user()->nasabah->photo) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                </div>
            </div>

            <!-- Grid Responsive -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
                
                <!-- KOLOM RINGKASAN INFO -->
                <div class="lg:col-span-4 space-y-4 sm:space-y-6">
                    <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-gradient-to-br from-forest via-forestDark to-forest p-5 sm:p-6 text-white shadow-xl shadow-forest/20">
                        <div class="absolute -right-10 -bottom-10 w-32 sm:w-40 h-32 sm:h-40 bg-mint/20 rounded-full blur-3xl"></div>
                        <div class="relative z-10 flex flex-col justify-between h-full">
                            <div>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-mint/20 border border-mint/30 text-[9px] sm:text-[10px] font-bold text-mint tracking-wide uppercase mb-3 sm:mb-4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-mint animate-pulse"></span> Maksimal Fasilitas
                                </span>
                                <p class="text-xs text-emerald-100 font-medium">Limit Pinjaman Tersisa</p>
                                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-1">Rp 5.000.000</h2>
                            </div>
                            <div class="mt-6 sm:mt-8 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-emerald-100">
                                <span class="flex items-center gap-1.5"><i class="fas fa-check-circle text-mint"></i> Akun Verifikasi</span>
                                <span class="font-semibold text-white">Guru / Staf</span>
                            </div>
                        </div>
                    </div>

                    <!-- RINGKASAN SIMULASI (SUDAH DIUPDATE - GABUNG RINCIAN PENCAIRAN) -->
                    <div class="bg-mintLight/60 border border-mint/20 rounded-2xl p-4 sm:p-5 space-y-3">
                        <h4 class="text-xs font-bold text-forest uppercase tracking-wider flex items-center gap-2">
                            <i class="fas fa-calculator text-mint"></i> Ringkasan Simulasi
                        </h4>
                        
                        <!-- Info Cicilan -->
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between items-center text-slate-600">
                                <span>Estimasi Cicilan/Bulan</span>
                                <span id="simulasiCicilan" class="font-bold text-slate-900 text-xs sm:text-sm">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-600">
                                <span>Total Jatuh Tempo</span>
                                <span id="simulasiBulan" class="font-semibold text-slate-800">-</span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="h-px bg-mint/30 my-2"></div>

                        <!-- Rincian Pencairan (BARU - DIGABUNG DI SINI) -->
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between items-center text-slate-600">
                                <span>Nominal Pinjaman</span>
                                <span id="rincianNominal" class="font-semibold text-slate-900">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center text-rose-600">
                                <span>Potongan Provisi (1%)</span>
                                <span id="rincianProvisi" class="font-semibold">- Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center pt-1 border-t border-mint/30">
                                <span class="font-bold text-forest">Dana Diterima</span>
                                <span id="rincianDiterima" class="font-black text-sm text-forest">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-forest uppercase tracking-wider flex items-center gap-2">
                            <i class="fas fa-info-circle text-mint"></i> Syarat & Ketentuan
                        </h3>
                        <ul class="space-y-2 text-xs text-slate-600">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-mint mt-0.5 text-[10px]"></i>
                                <span>Nominal pengajuan minimal <strong class="text-forest">Rp 50.000</strong>.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-mint mt-0.5 text-[10px]"></i>
                                <span>Memiliki rekening tabungan aktif.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-mint mt-0.5 text-[10px]"></i>
                                <span>Riwayat angsuran lancar.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-mint mt-0.5 text-[10px]"></i>
                                <span>Dana diambil tunai di kantor BMT setelah disetujui.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- KOLOM FORMULIR -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-sm p-4 sm:p-6 lg:p-8">
                        
                        @if ($errors->any())
                            <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200/80 rounded-2xl flex items-start gap-3">
                                <i class="fas fa-exclamation-triangle text-rose-500 text-sm mt-0.5"></i>
                                <div>
                                    <h4 class="text-xs font-bold text-rose-900">Periksa Kembali Data Anda</h4>
                                    <ul class="mt-1 list-disc list-inside text-[11px] text-rose-700 space-y-0.5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200/80 rounded-2xl flex items-start gap-3">
                                <i class="fas fa-check-circle text-emerald-500 text-sm mt-0.5"></i>
                                <div>
                                    <h4 class="text-xs font-bold text-emerald-900">Pengajuan Berhasil!</h4>
                                    <p class="text-[11px] text-emerald-700 mt-0.5">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        <form id="formPeminjaman" action="{{ route('nasabah.peminjaman.store') }}" method="POST" class="space-y-4 sm:space-y-6">
                            @csrf

                            <div>
                                <label for="jumlah" class="block text-xs font-bold text-forest uppercase tracking-wider mb-2">
                                    Nominal Pinjaman <span class="text-rose-500">*</span>
                                </label>
                                <div class="input-premium relative rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200/80 focus-within:border-mint focus-within:bg-white transition-all">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 sm:pl-4 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-extrabold text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" min="50000" step="10000" placeholder="0" class="w-full pl-10 sm:pl-12 pr-4 py-3 sm:py-4 bg-transparent text-base sm:text-lg font-black text-slate-900 placeholder-slate-300 focus:outline-none" required oninput="updateSimulasi()">
                                </div>
                                <div class="flex items-center justify-between mt-1.5 text-[10px] sm:text-[11px] text-slate-400">
                                    <span>Min. Rp 50.000</span>
                                    <span>Kelipatan Rp 10.000</span>
                                </div>
                            </div>

                            <div>
                                <label for="tenor" class="block text-xs font-bold text-forest uppercase tracking-wider mb-2">
                                    Tenor / Jangka Waktu <span class="text-rose-500">*</span>
                                </label>
                                <div class="input-premium relative rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200/80 focus-within:border-mint focus-within:bg-white transition-all">
                                    <input type="number" name="tenor" id="tenor" value="{{ old('tenor', 12) }}" min="1" max="24" placeholder="12" class="w-full pl-4 pr-16 py-3 sm:py-3.5 bg-transparent text-xs sm:text-sm font-bold text-slate-900 focus:outline-none" required oninput="updateSimulasi()">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-bold text-xs uppercase tracking-wider">Bulan</span>
                                    </div>
                                </div>
                                <p class="text-[10px] sm:text-[11px] text-slate-400 mt-1">Durasi pengembalian maksimal 24 Bulan (2 Tahun).</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <div>
                                    <label for="tanggal_pinjam" class="block text-xs font-bold text-forest uppercase tracking-wider mb-2">
                                        Tanggal Pinjam <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="input-premium rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200/80 focus-within:border-mint focus-within:bg-white transition-all">
                                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" class="w-full px-3.5 py-3 sm:py-3.5 bg-transparent text-xs font-bold text-slate-800 focus:outline-none" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="tanggal_jatuh_tempo" class="block text-xs font-bold text-forest uppercase tracking-wider mb-2">
                                        Tanggal Jatuh Tempo <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="input-premium rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200/80 focus-within:border-mint focus-within:bg-white transition-all">
                                        <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo') }}" min="{{ date('Y-m-d', strtotime('+1 month')) }}" class="w-full px-3.5 py-3 sm:py-3.5 bg-transparent text-xs font-bold text-slate-800 focus:outline-none" required onchange="updateSimulasi()">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="keterangan" class="block text-xs font-bold text-forest uppercase tracking-wider mb-2">
                                    Keperluan / Catatan <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                                </label>
                                <div class="input-premium rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200/80 focus-within:border-mint focus-within:bg-white transition-all">
                                    <textarea name="keterangan" id="keterangan" rows="3" placeholder="Tuliskan alasan peminjaman..." class="w-full p-3.5 bg-transparent text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none resize-none">{{ old('keterangan') }}</textarea>
                                </div>
                            </div>

                            <div class="pt-3 sm:pt-4 flex flex-col-reverse sm:flex-row items-center justify-end gap-2.5 sm:gap-3 border-t border-slate-100">
                                <a href="{{ route('nasabah.dashboard') }}" class="w-full sm:w-auto px-5 py-3 text-center text-xs font-bold text-slate-500 hover:text-forest rounded-xl hover:bg-slate-100 transition-all">
                                    Batal
                                </a>
                                <button type="button" onclick="bukaModalKonfirmasi()" class="w-full sm:w-auto px-7 py-3.5 bg-mint hover:bg-forest text-white rounded-xl font-bold shadow-md shadow-mint/20 transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-paper-plane text-xs"></i> Lanjutkan Pengajuan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL POP-UP KONFIRMASI -->
    <div id="modalKonfirmasi" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4">
        <div id="modalBackdrop" class="modal-backdrop fixed inset-0 bg-forestDark/60 backdrop-blur-sm opacity-0" onclick="tutupModal()"></div>
        <div id="modalContent" class="modal-box bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-100 max-w-xs sm:max-w-sm w-full p-5 sm:p-6 relative z-10 opacity-0 scale-95 transform">
            <div class="text-center">
                <div class="w-12 h-12 bg-mintLight text-mint rounded-2xl border border-mint/20 flex items-center justify-center mx-auto mb-3 text-lg">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Konfirmasi Pinjaman</h3>
                <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Periksa rincian sebelum dikirim ke sistem.</p>
            </div>
            <div class="my-4 p-3.5 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-100 space-y-2.5 text-xs" id="modalDetails">
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Nominal Pinjaman</span>
                    <span id="previewNominal" class="font-black text-slate-900">Rp 0</span>
                </div>
                <div class="flex justify-between items-center text-rose-600">
                    <span class="font-medium">Potongan Provisi (1%)</span>
                    <span id="previewProvisi" class="font-bold">- Rp 0</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-slate-200">
                    <span class="text-forest font-bold">Dana Diterima</span>
                    <span id="previewDiterima" class="font-black text-mint">Rp 0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Tenor</span>
                    <span id="previewTenor" class="font-bold text-slate-800">0 Bulan</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Jatuh Tempo</span>
                    <span id="previewJatuhTempo" class="font-bold text-mint">-</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2.5">
                <button type="button" onclick="tutupModal()" class="py-2.5 px-3 border border-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50 transition-all text-xs">Cek Lagi</button>
                <button type="button" onclick="kirimFormulir()" class="py-2.5 px-3 bg-mint hover:bg-forest text-white rounded-xl font-bold shadow-md shadow-mint/20 transition-all text-xs flex items-center justify-center gap-1.5">
                    <i class="fas fa-check"></i> Ya, Kirim
                </button>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        function openMobileSidebar() { sidebar.classList.remove('-translate-x-full'); sidebarBackdrop.classList.remove('hidden'); }
        function closeMobileSidebar() { sidebar.classList.add('-translate-x-full'); sidebarBackdrop.classList.add('hidden'); }
        toggleSidebar?.addEventListener('click', openMobileSidebar);
        closeSidebar?.addEventListener('click', closeMobileSidebar);
        sidebarBackdrop?.addEventListener('click', closeMobileSidebar);

        const modal = document.getElementById('modalKonfirmasi');
        const backdrop = document.getElementById('modalBackdrop');
        const content = document.getElementById('modalContent');
        const form = document.getElementById('formPeminjaman');

        function updateSimulasi() {
            const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
            const tenor = parseInt(document.getElementById('tenor').value) || 0;
            const jatuhTempo = document.getElementById('tanggal_jatuh_tempo').value;
            
            // HITUNG PROVISI 1%
            const provisi = Math.round(jumlah * 0.01);
            const diterima = jumlah - provisi;

            // Update simulasi cicilan
            if (jumlah > 0 && tenor > 0) {
                const cicilan = Math.round(jumlah / tenor);
                document.getElementById('simulasiCicilan').textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(cicilan);
            } else { 
                document.getElementById('simulasiCicilan').textContent = 'Rp 0'; 
            }
            
            // Update tanggal jatuh tempo
            if(jatuhTempo) {
                const dateObj = new Date(jatuhTempo);
                document.getElementById('simulasiBulan').textContent = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
            } else { 
                document.getElementById('simulasiBulan').textContent = '-'; 
            }

            // UPDATE RINCIAN PENCAIRAN DI RINGKASAN SIMULASI
            const fmt = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
            document.getElementById('rincianNominal').textContent = fmt.format(jumlah);
            document.getElementById('rincianProvisi').textContent = '- ' + fmt.format(provisi);
            document.getElementById('rincianDiterima').textContent = fmt.format(diterima);
        }

        function bukaModalKonfirmasi() {
            if (!form.checkValidity()) { form.reportValidity(); return; }
            
            const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
            const tenor = document.getElementById('tenor').value;
            const jatuhTempo = document.getElementById('tanggal_jatuh_tempo').value;
            
            const provisi = Math.round(jumlah * 0.01);
            const diterima = jumlah - provisi;
            const fmt = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });

            let tglFormatted = '-';
            if(jatuhTempo) { 
                const dateObj = new Date(jatuhTempo); 
                tglFormatted = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }); 
            }

            document.getElementById('previewNominal').textContent = fmt.format(jumlah);
            document.getElementById('previewProvisi').textContent = '- ' + fmt.format(provisi);
            document.getElementById('previewDiterima').textContent = fmt.format(diterima);
            document.getElementById('previewTenor').textContent = tenor + " Bulan";
            document.getElementById('previewJatuhTempo').textContent = tglFormatted;

            modal.classList.remove('hidden');
            setTimeout(() => { backdrop.classList.remove('opacity-0'); content.classList.remove('opacity-0', 'scale-95'); content.classList.add('opacity-100', 'scale-100'); }, 10);
        }

        function tutupModal() {
            backdrop.classList.add('opacity-0');
            content.classList.remove('opacity-100', 'scale-100');
            content.classList.add('opacity-0', 'scale-95');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }

        function kirimFormulir() { form.submit(); }
        
        // Jalankan sekali saat load
        updateSimulasi();
    </script>
</body>
</html>