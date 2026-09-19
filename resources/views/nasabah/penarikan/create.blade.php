<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Penarikan - Smart Pocket</title>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bgMain: '#FAFAFA',      /* Latar Utama */
                        forest: '#1A4D2E',      /* Sekunder Forest Green */
                        forestDark: '#123720',  /* Deep Forest */
                        mint: '#4E9F3D',        /* Aksen Mint Green */
                        mintLight: '#E8F5E9',   /* Soft Tint Mint */
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
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #FAFAFA; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }

        /* Card Gradasi Forest Green */
        .card-forest {
            background: linear-gradient(135deg, #1A4D2E 0%, #123720 100%);
            box-shadow: 0 12px 28px -6px rgba(26, 77, 46, 0.35);
        }

        .input-premium { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
        .input-premium:focus { transform: translateY(-1px); }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-forestDark/50 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity"></div>

    <!-- MOBILE TOPBAR HEADER (DITAMBAHKAN NOTIFIKASI) -->
    <header class="lg:hidden bg-white border-b border-slate-100 px-4 py-3 flex items-center justify-between sticky top-0 z-20">
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
            <button onclick="toggleSidebar()" class="w-9 h-9 bg-slate-50 border border-slate-200 text-slate-700 rounded-xl flex items-center justify-center hover:bg-slate-100 transition-colors">
                <i class="fas fa-bars text-sm"></i>
            </button>
        </div>
    </header>

    <div class="flex flex-col lg:flex-row min-h-screen">
        
        <!-- SIDEBAR DESKTOP & MOBILE -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-sm">
            
            <!-- Brand Header Sidebar -->
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
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-forest">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-1.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>
                
                <a href="{{ route('nasabah.penarikan.create') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-money-bill-wave w-5 text-center text-mint"></i> Penarikan 
                </a>

                @if(auth()->user()->nasabah->kategori == 'guru')
                    <a href="{{ route('nasabah.peminjaman.create') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                        <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman 
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

            <!-- Logout Button -->
            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 text-sm font-bold py-2.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 lg:ml-64 p-4 sm:p-6 lg:p-8 min-w-0">
            
            <!-- HEADER PRESISI DESAIN (DITAMBAHKAN PROFILE DESKTOP) -->
            <header class="mb-6 lg:mb-8 flex items-start justify-between gap-4">
                <div>
                    <nav class="flex items-center gap-1.5 text-xs sm:text-sm text-slate-400 font-medium mb-2">
                        <a href="{{ route('nasabah.dashboard') }}" class="hover:text-forest transition-colors">Dashboard</a>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                        <span class="text-slate-700 font-bold">Ajukan Penarikan</span>
                    </nav>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                        Pengajuan Penarikan Saldo
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Tarik saldo tabungan Anda dengan mudah dan cepat melalui konfirmasi BMT.
                    </p>
                </div>

                <!-- Profile Desktop Header -->
                <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
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
            </header>

            <!-- LAYOUT 2 KOLOM -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                
                <!-- KOLOM KIRI: Informasi & Saldo -->
                <div class="space-y-6">
                    <!-- Kartu Saldo Tabungan -->
                    <div class="card-forest rounded-2xl p-6 text-white relative overflow-hidden flex flex-col justify-between min-h-[190px]">
                        <div class="flex justify-between items-start relative z-10">
                            <div>
                                <p class="text-[10px] font-bold text-emerald-200 uppercase tracking-widest">Saldo Tersedia</p>
                                <h3 class="text-2xl sm:text-3xl font-black tracking-tight text-white mt-1 break-all">
                                    Rp {{ number_format($rekening->saldo ?? 0, 0, ',', '.') }}
                                </h3>
                            </div>
                            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-mint border border-white/20 flex-shrink-0">
                                <i class="fas fa-wallet text-lg"></i>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-white/15 flex items-center gap-2 text-xs text-emerald-100/90 relative z-10">
                            <i class="fas fa-shield-alt text-mint"></i>
                            <span class="font-medium">Saldo terverifikasi aman di BMT</span>
                        </div>
                    </div>

                    <!-- Kartu Aturan Penarikan -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                        <h3 class="text-xs font-extrabold text-forest uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-mint text-sm"></i> Ketentuan Penarikan
                        </h3>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3 text-xs text-slate-600">
                                <i class="fas fa-check-circle text-mint mt-0.5 flex-shrink-0"></i>
                                <span>Minimal penarikan sebesar <strong class="text-forest">Rp 10.000</strong>.</span>
                            </li>
                            <li class="flex items-start gap-3 text-xs text-slate-600">
                                <i class="fas fa-check-circle text-mint mt-0.5 flex-shrink-0"></i>
                                <span>Kelipatan nominal penarikan adalah <strong class="text-forest">Rp 1.000</strong>.</span>
                            </li>
                            <li class="flex items-start gap-3 text-xs text-slate-600">
                                <i class="fas fa-check-circle text-mint mt-0.5 flex-shrink-0"></i>
                                <span>Dana diproses sesuai antrean konfirmasi petugas BMT.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- KOLOM KANAN: Form Pengajuan -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 lg:p-8">
                        
                        <form action="{{ route('nasabah.penarikan.store') }}" method="POST" id="formPenarikan">
                            @csrf

                            <!-- Input Jumlah -->
                            <div class="mb-6">
                                <label for="jumlah" class="block text-xs font-bold uppercase tracking-wider text-forest mb-2">
                                    Jumlah Penarikan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-bold text-sm">Rp</span>
                                    </div>
                                    <input 
                                        type="number" 
                                        name="jumlah" 
                                        id="jumlah" 
                                        value="{{ old('jumlah') }}" 
                                        min="10000" 
                                        step="1000"
                                        placeholder="0"
                                        class="input-premium w-full pl-12 pr-4 py-3.5 bg-bgMain border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-mint/20 focus:border-mint text-base font-bold text-slate-900 placeholder-slate-400" 
                                        required
                                        oninput="validasiAngka(this)"
                                    >
                                </div>
                                <p class="text-xs text-slate-400 mt-2 flex items-center gap-1.5">
                                    <i class="fas fa-lightbulb text-amber-500"></i>
                                    Masukkan nominal tanpa titik/koma, contoh: 50000
                                </p>
                            </div>

                            <!-- Input Tanggal Penarikan -->
                            <div class="mb-6">
                                <label for="tanggal_transaksi" class="block text-xs font-bold uppercase tracking-wider text-forest mb-2">
                                    Tanggal Penarikan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-slate-400"></i>
                                    </div>
                                    <input 
                                        type="date" 
                                        name="tanggal_transaksi" 
                                        id="tanggal_transaksi" 
                                        value="{{ old('tanggal_transaksi', date('Y-m-d')) }}" 
                                        class="input-premium w-full pl-12 pr-4 py-3.5 bg-bgMain border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-mint/20 focus:border-mint text-sm font-semibold text-slate-800" 
                                        required
                                    >
                                </div>
                                <p class="text-xs text-slate-400 mt-2 flex items-center gap-1.5">
                                    <i class="fas fa-info-circle text-mint"></i>
                                    Tentukan tanggal rencana pencairan saldo.
                                </p>
                            </div>

                            <!-- Input Keterangan -->
                            <div class="mb-8">
                                <label for="keterangan" class="block text-xs font-bold uppercase tracking-wider text-forest mb-2">
                                    Keterangan / Keperluan <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    name="keterangan" 
                                    id="keterangan" 
                                    rows="4" 
                                    placeholder="Contoh: Untuk keperluan pembelian peralatan sekolah / uang saku..."
                                    class="input-premium w-full px-4 py-3.5 bg-bgMain border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-mint/20 focus:border-mint text-sm text-slate-800 placeholder-slate-400 resize-none" 
                                    required
                                >{{ old('keterangan') }}</textarea>
                                <div class="flex justify-between mt-2">
                                    <p class="text-xs text-slate-400">Berikan penjelasan singkat mengenai penarikan ini.</p>
                                    <p class="text-xs text-slate-400 font-mono"><span id="charCount">0</span>/255</p>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-6 border-t border-slate-100">
                                <a href="{{ route('nasabah.dashboard') }}" class="w-full sm:w-auto px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50 transition-all text-xs text-center">
                                    Batal
                                </a>
                                <button type="submit" id="btnSubmit" class="w-full sm:w-auto px-8 py-3 bg-mint hover:bg-forest text-white rounded-xl font-bold flex items-center justify-center gap-2 transition-all shadow-md shadow-mint/20 text-xs">
                                    <i class="fas fa-paper-plane text-xs" id="btnIcon"></i> 
                                    <span id="btnText">Ajukan Penarikan</span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Script UX & Logic Interaktif -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        // Pop-up Notifikasi Sukses
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Pengajuan Berhasil! 🎉',
                text: '{{ session('success') }}',
                confirmButtonColor: '#1A4D2E',
                confirmButtonText: 'Ke Riwayat Transaksi',
                customClass: {
                    popup: 'rounded-2xl p-4 sm:p-6',
                    confirmButton: 'rounded-xl px-5 py-2.5 font-bold text-xs'
                },
                timer: 4000,
                timerProgressBar: true
            }).then((result) => {
                if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                    window.location.href = "{{ route('nasabah.riwayat') }}";
                }
            });
        @endif

        // Pop-up Notifikasi Gagal
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal Mengajukan',
                text: '{{ session('error') }}',
                confirmButtonColor: '#DC2626',
                confirmButtonText: 'Coba Lagi',
                customClass: {
                    popup: 'rounded-2xl p-4 sm:p-6',
                    confirmButton: 'rounded-xl px-5 py-2.5 font-bold text-xs'
                }
            });
        @endif

        // Loading State Tombol Submit
        const form = document.getElementById('formPenarikan');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnText = document.getElementById('btnText');
        const btnIcon = document.getElementById('btnIcon');

        if (form && btnSubmit) {
            form.addEventListener('submit', function() {
                btnSubmit.disabled = true;
                btnSubmit.classList.add('opacity-75', 'cursor-not-allowed');
                btnText.textContent = 'Memproses Pengajuan...';
                btnIcon.className = 'fas fa-spinner fa-spin text-xs';
            });
        }

        // Counter Karakter Textarea
        const textarea = document.getElementById('keterangan');
        const charCount = document.getElementById('charCount');
        if (textarea && charCount) {
            charCount.textContent = textarea.value.length;
            
            textarea.addEventListener('input', function() {
                charCount.textContent = this.value.length;
                if(this.value.length > 255) {
                    this.value = this.value.substring(0, 255);
                    charCount.textContent = 255;
                }
            });
        }

        // Validasi Input Angka
        function validasiAngka(input) {
            if (input.value < 0) input.value = 0;
        }
    </script>
</body>
</html>