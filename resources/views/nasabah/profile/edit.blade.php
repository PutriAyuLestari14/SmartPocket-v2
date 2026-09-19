<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile & Pengaturan - Smart Pocket</title>
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
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #FAFAFA; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased selection:bg-mintLight selection:text-forest">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-forestDark/50 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity"></div>

    <div class="flex flex-col lg:flex-row min-h-screen">
        
        <!-- SIDEBAR -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-sm">
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
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-forest p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-1.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>
                
                <a href="{{ route('nasabah.penarikan.create') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-money-bill-wave w-5 text-center text-slate-400"></i> Penarikan
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
                
                <!-- Menu Aktif: Profile -->
                <a href="{{ route('nasabah.profile.edit')}}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-cog w-5 text-center text-mint"></i> Pengaturan Profile
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

        <!-- TOP NAVBAR MOBILE (PERSIS KAYAK RIWAYAT) -->
        <div class="lg:hidden bg-white border-b border-slate-200/80 px-4 py-3 flex items-center justify-between sticky top-0 z-20 shadow-sm w-full">
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
        </div>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 lg:ml-64 p-4 sm:p-6 lg:p-8 min-w-0">
            
            <!-- HEADER PRESISI DESAIN (PERSIS KAYAK RIWAYAT, TINGGAL GANTI TEKS) -->
            <header class="mb-6 lg:mb-8 flex items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1">
                        <a href="{{ route('nasabah.dashboard') }}" class="hover:text-forest">Utama</a>
                        <i class="fas fa-chevron-right text-[9px]"></i>
                        <span class="text-forest font-bold">Pengaturan Profile</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Profile & Pengaturan
                        </h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Kelola data diri, keamanan akun, dan informasi tabungan Anda secara real-time.
                    </p>
                </div>

                <!-- Profile Desktop Header (PERSIS KAYAK RIWAYAT) -->
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

            <!-- GRID LAYOUT -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- KOLOM KIRI: DATA PRIBADI (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Identitas & Data Pribadi</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Pastikan data yang dimasukkan sesuai dokumen resmi.</p>
                            </div>
                            <span class="px-3 py-1 bg-mintLight border border-mint/20 text-forest rounded-full text-[11px] font-bold flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-mint rounded-full animate-pulse"></span> Nasabah Aktif
                            </span>
                        </div>

                        <!-- FORM UPDATE PROFILE -->
                        <form action="{{ route('nasabah.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <!-- Upload Foto -->
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 mb-8 p-4 bg-slate-50/50 rounded-2xl border border-slate-100">
                                <div class="relative group">
                                    @if(auth()->user()->nasabah && auth()->user()->nasabah->photo)
                                        <img src="{{ asset('storage/' . auth()->user()->nasabah->photo) }}" alt="Foto Profile" class="w-20 h-20 rounded-2xl object-cover border-2 border-white shadow-md">
                                    @else
                                        <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center border-2 border-white shadow-md text-slate-400">
                                            <i class="fas fa-user text-2xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <label class="block text-xs font-bold text-slate-900 mb-1.5">Foto Profile</label>
                                    <input type="file" name="photo" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-forest file:text-white hover:file:bg-forestDark cursor-pointer transition-all">
                                    <p class="text-[11px] text-slate-400 mt-1.5">Format: JPG, PNG, JPEG. Maksimal ukuran 2MB.</p>
                                </div>
                            </div>

                            <!-- Grid Input Data -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2">Username / NIS</label>
                                    <div class="relative">
                                        <input type="text" value="{{ auth()->user()->username }}" readonly class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-xs font-medium text-slate-500 cursor-not-allowed pl-10">
                                        <i class="fas fa-lock absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2">Nama Lengkap</label>
                                    <div class="relative">
                                        <input type="text" name="nama" value="{{ old('nama', auth()->user()->nasabah->nama ?? '') }}" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-mint/20 focus:border-mint transition-all pl-10">
                                        <i class="fas fa-user absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-xs font-bold text-slate-700 mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-mint/20 focus:border-mint transition-all">{{ old('alamat', auth()->user()->nasabah->alamat ?? '') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2">Tanggal Terdaftar</label>
                                    <div class="relative">
                                        <input type="text" value="{{ auth()->user()->nasabah ? \Carbon\Carbon::parse(auth()->user()->nasabah->tanggal_daftar)->format('d M Y') : '-' }}" readonly class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-xs font-medium text-slate-500 cursor-not-allowed pl-10">
                                        <i class="fas fa-calendar-alt absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2">Status Akun</label>
                                    <div class="px-4 py-2.5 bg-mintLight border border-mint/20 rounded-xl text-xs font-bold text-forest flex items-center justify-between">
                                        <span class="flex items-center gap-2">
                                            <i class="fas fa-shield-alt text-mint"></i> Terverifikasi Total
                                        </span>
                                        <i class="fas fa-check-circle text-mint"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4 border-t border-slate-100">
                                <button type="submit" class="px-6 py-3 bg-forest hover:bg-forestDark text-white text-xs font-bold rounded-xl shadow-md shadow-forest/20 transition-all flex items-center gap-2">
                                    <i class="fas fa-save text-xs"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- KOLOM KANAN: TABUNGAN & PASSWORD (1/3) -->
                <div class="space-y-6">

                    <!-- Card Rekening -->
                    <div class="bg-gradient-to-br from-forest via-forestDark to-forest rounded-2xl shadow-xl shadow-forest/10 p-6 text-white relative overflow-hidden">
                        <div class="absolute -top-12 -right-12 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-mint/20 rounded-full blur-xl pointer-events-none"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-8">
                                <div>
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-mint">Kartu Tabungan</span>
                                    <h4 class="text-sm font-bold text-white leading-tight">Smart Pocket Member</h4>
                                </div>
                                <div class="w-10 h-10 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md border border-white/20">
                                    <i class="fas fa-wallet text-mint text-base"></i>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <p class="text-[10px] text-mint font-medium uppercase tracking-wider mb-1">Nomor Rekening</p>
                                <p class="text-lg font-mono font-bold tracking-widest text-white">
                                    {{ auth()->user()->nasabah->rekening->no_rek ?? 'BELUM ADA' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] text-mint font-medium uppercase tracking-wider mb-1">Saldo Aktif</p>
                                <p class="text-2xl font-black text-white tracking-tight">
                                    Rp {{ auth()->user()->nasabah->rekening ? number_format(auth()->user()->nasabah->rekening->saldo, 0, ',', '.') : '0' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Ubah Password -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
                        <div class="mb-5 pb-3 border-b border-slate-100">
                            <h3 class="text-base font-bold text-slate-900">Keamanan Akun</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Perbarui kata sandi secara berkala.</p>
                        </div>
                        
                        <form action="{{ route('nasabah.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Sandi Saat Ini</label>
                                    <input type="password" name="current_password" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-mint/20 focus:border-mint transition-all">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Sandi Baru</label>
                                    <input type="password" name="password" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-mint/20 focus:border-mint transition-all">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Sandi Baru</label>
                                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-mint/20 focus:border-mint transition-all">
                                </div>
                            </div>

                            <button type="submit" class="w-full mt-6 py-3 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-key text-xs text-slate-400"></i> Perbarui Kata Sandi
                            </button>
                        </form>
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
    </script>
</body>
</html>