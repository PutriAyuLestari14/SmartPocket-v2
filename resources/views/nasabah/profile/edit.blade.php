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

        .gradient-primary { background: linear-gradient(135deg, #15803d 0%, #166534 100%); }
        .gradient-soft { background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%); }
        .gradient-vibrant { background: linear-gradient(135deg, #15803d 0%, #16a34a 50%, #22c55e 100%); }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        @keyframes backdropIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-in { animation: modalIn 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .backdrop-in { animation: backdropIn 0.2s ease-out; }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased selection:bg-mintLight selection:text-primary">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-primaryDark/50 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity"></div>

    <div class="flex flex-col lg:flex-row min-h-screen">

        <!-- SIDEBAR -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl shadow-slate-200/50">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 gradient-vibrant rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30">
                        <i class="fas fa-wallet text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-black text-primary tracking-tight leading-none">SmartPocket</h1>
                        <p class="text-[10px] font-bold text-primaryDark tracking-wider mt-1">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-primary p-1">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-1.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>

                <a href="{{ route('nasabah.penarikan.create') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-money-bill-wave w-5 text-center text-slate-400"></i> Penarikan
                </a>

                @if(auth()->user()->nasabah->kategori == 'guru')
                    <a href="{{ route('nasabah.peminjaman.create') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                        <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman
                    </a>
                @endif

                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-history w-5 text-center text-slate-400"></i> Riwayat Transaksi
                </a>

                <p class="px-3 pt-6 pb-1.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Sistem</p>

                <a href="{{ route('nasabah.profile.edit')}}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-primary rounded-xl text-sm font-bold transition-all shadow-sm border border-primary/20">
                    <i class="fas fa-cog w-5 text-center text-primary"></i> Pengaturan Profile
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

        <!-- TOP NAVBAR MOBILE -->
        <div class="lg:hidden bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 py-3 flex items-center justify-between sticky top-0 z-20 shadow-sm w-full">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 gradient-soft rounded-xl flex items-center justify-center text-white shadow-sm shadow-primary/30">
                    <i class="fas fa-wallet text-sm"></i>
                </div>
                <div>
                    <h1 class="text-sm font-black text-primary leading-none">Smart Pocket</h1>
                    <p class="text-[9px] font-bold text-primaryDark tracking-wider mt-0.5">BMT SMKN 11</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('nasabah.notifikasi.index') }}" class="w-9 h-9 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative">
                    @php
                        $nasabah = auth()->user()->nasabah;
                        $unreadCount = $nasabah ? ($nasabah->unreadNotifications ? $nasabah->unreadNotifications->count() : 0) : 0;
                    @endphp
                    @if($unreadCount > 0)
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                    @endif
                    <i class="far fa-bell text-sm"></i>
                </a>
                <button onclick="toggleSidebar()" class="w-9 h-9 bg-slate-50 border border-slate-200 text-slate-700 rounded-xl flex items-center justify-center hover:bg-slate-100 transition-colors">
                    <i class="fas fa-bars text-sm"></i>
                </button>
            </div>
        </div>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 lg:ml-64 p-4 sm:p-6 lg:p-8 min-w-0">

            <!-- HEADER -->
            <header class="mb-6 lg:mb-8 flex items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-1">
                        <a href="{{ route('nasabah.dashboard') }}" class="hover:text-primary transition-colors">Utama</a>
                        <i class="fas fa-chevron-right text-[9px]"></i>
                        <span class="text-primary font-bold">Pengaturan Profile</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Profile & Pengaturan
                        </h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 flex items-center gap-2 font-medium">
                        <i class="fas fa-user-cog text-primary"></i>
                        Kelola data diri, keamanan akun, dan informasi tabungan Anda secara real-time.
                    </p>
                </div>

                <!-- Profil Desktop -->
                <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                    <a href="{{ route('nasabah.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 hover:text-primary hover:border-primary transition-all relative shadow-sm">
                        <i class="far fa-bell text-base"></i>
                        @php $pendingNotif = \App\Models\DetailTabungan::where('status', 'pending')->count(); @endphp
                        @if($pendingNotif > 0)
                            <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                        @endif
                    </a>
                    <div class="w-px h-8 bg-slate-200"></div>
                    <div class="text-right">
                        <p class="text-xs font-black text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-bold text-slate-400 capitalize mt-0.5">
                            {{ auth()->user()->nasabah->kategori ?? 'Siswa' }}
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl overflow-hidden gradient-vibrant text-white font-black text-sm flex items-center justify-center border-2 border-white shadow-lg shadow-primary/20 flex-shrink-0">
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

                <!-- KOLOM KIRI -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-6 md:p-8">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-black text-slate-900">Identitas & Data Pribadi</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Pastikan data yang dimasukkan sesuai dokumen resmi.</p>
                            </div>
                            <span class="px-3 py-1 bg-mintLight border border-primary/20 text-primary rounded-full text-[11px] font-bold flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span> Nasabah Aktif
                            </span>
                        </div>

                        <form id="formProfile" action="{{ route('nasabah.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

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
                                    <label class="block text-xs font-black text-slate-900 mb-1.5">Foto Profile</label>
                                    <input type="file" name="photo" id="inputPhoto" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-primaryDark cursor-pointer transition-all">
                                    <p class="text-[11px] text-slate-400 mt-1.5">Format: JPG, PNG, JPEG. Maksimal ukuran 2MB.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-2">Username / NIS</label>
                                    <div class="relative">
                                        <input type="text" value="{{ auth()->user()->username }}" readonly class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-xs font-medium text-slate-500 cursor-not-allowed pl-10">
                                        <i class="fas fa-lock absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-2">Nama Lengkap</label>
                                    <div class="relative">
                                        <input type="text" value="{{ auth()->user()->nasabah->nama ?? '' }}" readonly class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold text-slate-500 cursor-not-allowed pl-10">
                                        <i class="fas fa-lock absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-xs font-black text-slate-700 mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" id="inputAlamat" rows="3" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">{{ old('alamat', auth()->user()->nasabah->alamat ?? '') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-2">Tanggal Terdaftar</label>
                                    <div class="relative">
                                        <input type="text" value="{{ auth()->user()->nasabah ? \Carbon\Carbon::parse(auth()->user()->nasabah->tanggal_daftar)->format('d M Y') : '-' }}" readonly class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-xs font-medium text-slate-500 cursor-not-allowed pl-10">
                                        <i class="fas fa-calendar-alt absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-2">Status Akun</label>
                                    <div class="px-4 py-2.5 bg-mintLight border border-primary/20 rounded-xl text-xs font-bold text-primary flex items-center justify-between">
                                        <span class="flex items-center gap-2">
                                            <i class="fas fa-shield-alt text-primary"></i> Terverifikasi Total
                                        </span>
                                        <i class="fas fa-check-circle text-primary"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4 border-t border-slate-100">
                                <button type="button" onclick="openProfileModal()" class="px-6 py-3 bg-primary hover:bg-primaryDark text-white text-xs font-black rounded-xl shadow-md shadow-primary/30 transition-all flex items-center gap-2">
                                    <i class="fas fa-save text-xs"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- KOLOM KANAN -->
                <div class="space-y-6">

                    <div class="gradient-primary rounded-2xl shadow-xl shadow-primary/20 p-6 text-white relative overflow-hidden group">
                        <div class="absolute -top-12 -right-12 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/5 rounded-full blur-xl pointer-events-none"></div>

                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-8">
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-accent">Kartu Tabungan</span>
                                    <h4 class="text-sm font-bold text-white leading-tight">Smart Pocket Member</h4>
                                </div>
                                <div class="w-10 h-10 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md border border-white/20">
                                    <i class="fas fa-wallet text-accent text-base"></i>
                                </div>
                            </div>

                            <div class="mb-6">
                                <p class="text-[10px] text-emerald-100 font-medium uppercase tracking-wider mb-1">Nomor Rekening</p>
                                <p class="text-lg font-mono font-bold tracking-widest text-white">
                                    {{ auth()->user()->nasabah->rekening->no_rek ?? 'BELUM ADA' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] text-emerald-100 font-medium uppercase tracking-wider mb-1">Saldo Aktif</p>
                                <p class="text-2xl font-black text-white tracking-tight">
                                    Rp {{ auth()->user()->nasabah->rekening ? number_format(auth()->user()->nasabah->rekening->saldo, 0, ',', '.') : '0' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/50 p-6">
                        <div class="mb-5 pb-3 border-b border-slate-100">
                            <h3 class="text-base font-black text-slate-900">Keamanan Akun</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Perbarui kata sandi secara berkala.</p>
                        </div>

                        <form id="formPassword" action="{{ route('nasabah.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5">Sandi Saat Ini</label>
                                    <div class="relative">
                                        <input type="password" name="current_password" id="inputCurrentPass" required class="w-full px-4 py-2.5 pr-10 bg-white border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                                        <button type="button" onclick="togglePass('inputCurrentPass', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition-colors">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5">Sandi Baru</label>
                                    <div class="relative">
                                        <input type="password" name="password" id="inputNewPass" required class="w-full px-4 py-2.5 pr-10 bg-white border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                                        <button type="button" onclick="togglePass('inputNewPass', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition-colors">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-700 mb-1.5">Konfirmasi Sandi Baru</label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation" id="inputConfirmPass" required class="w-full px-4 py-2.5 pr-10 bg-white border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                                        <button type="button" onclick="togglePass('inputConfirmPass', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition-colors">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" onclick="openPasswordModal()" class="w-full mt-6 py-3 bg-primary hover:bg-primaryDark text-white text-xs font-black rounded-xl shadow-md shadow-primary/30 transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-key text-xs text-white/80"></i> Perbarui Kata Sandi
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </main>
    </div>

    <!-- ═══ MODAL KONFIRMASI PROFILE ═══ -->
    <div id="profileModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-primaryDark/60 backdrop-blur-sm backdrop-in" onclick="closeProfileModal()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden modal-in">
            <div class="gradient-vibrant px-6 py-6 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-edit text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold">Konfirmasi Update Profile</h3>
                        <p class="text-xs text-emerald-100 mt-0.5">Pastikan data sudah benar sebelum disimpan</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-3">
                <div class="flex justify-between items-start py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">Alamat Baru</span>
                    <span id="modalAlamat" class="text-xs font-semibold text-slate-700 text-right max-w-[200px] line-clamp-2">-</span>
                </div>

                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">Foto Profile</span>
                    <span id="modalPhoto" class="text-xs font-bold text-primary">-</span>
                </div>

                <div class="bg-mintLight border border-primary/20 rounded-xl px-4 py-3 flex gap-2">
                    <i class="fas fa-info-circle text-primary text-xs mt-0.5"></i>
                    <p class="text-[11px] text-primary leading-relaxed font-semibold">
                        Username dan nama lengkap tidak dapat diubah. Hubungi admin jika ada kesalahan.
                    </p>
                </div>
            </div>

            <div class="p-6 pt-0 flex gap-3">
                <button type="button" onclick="closeProfileModal()" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </button>
                <button type="button" onclick="submitProfile()" class="flex-1 py-3 bg-primary hover:bg-primaryDark text-white rounded-xl font-extrabold text-sm transition-colors flex items-center justify-center gap-2 shadow-md shadow-primary/20">
                    <i class="fas fa-check text-xs"></i> Ya, Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- ═══ MODAL KONFIRMASI PASSWORD ═══ -->
    <div id="passwordModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-primaryDark/60 backdrop-blur-sm backdrop-in" onclick="closePasswordModal()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden modal-in">
            <div class="gradient-primary px-6 py-6 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-key text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold">Konfirmasi Ubah Sandi</h3>
                        <p class="text-xs text-emerald-100 mt-0.5">Pastikan sandi baru sudah benar</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 flex gap-2 mb-2">
                    <i class="fas fa-exclamation-triangle text-amber-600 text-xs mt-0.5"></i>
                    <p class="text-[11px] text-amber-800 leading-relaxed font-semibold">
                        Setelah diubah, kamu akan diminta login ulang dengan sandi baru.
                    </p>
                </div>
            </div>

            <div class="p-6 pt-0 flex gap-3">
                <button type="button" onclick="closePasswordModal()" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </button>
                <button type="button" onclick="submitPassword()" class="flex-1 py-3 bg-primary hover:bg-primaryDark text-white rounded-xl font-extrabold text-sm transition-colors flex items-center justify-center gap-2 shadow-md shadow-primary/20">
                    <i class="fas fa-check text-xs"></i> Ya, Ubah
                </button>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        /* TOGGLE PASSWORD VISIBILITY */
        function togglePass(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        /* PROFILE MODAL */
        function openProfileModal() {
            const alamat = document.getElementById('inputAlamat').value.trim();
            const photoInput = document.getElementById('inputPhoto');

            if (!alamat) {
                alert('Alamat wajib diisi!');
                return;
            }

            document.getElementById('modalAlamat').textContent = alamat;
            document.getElementById('modalPhoto').textContent = photoInput.files.length > 0
                ? photoInput.files[0].name
                : 'Tidak diubah';

            const modal = document.getElementById('profileModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeProfileModal() {
            const modal = document.getElementById('profileModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function submitProfile() {
            document.getElementById('formProfile').submit();
        }

        /* PASSWORD MODAL */
        function openPasswordModal() {
            const current = document.getElementById('inputCurrentPass').value;
            const newPass = document.getElementById('inputNewPass').value;
            const confirm = document.getElementById('inputConfirmPass').value;

            if (!current || !newPass || !confirm) {
                alert('Semua kolom sandi wajib diisi!');
                return;
            }

            if (newPass !== confirm) {
                alert('Konfirmasi sandi baru tidak sama!');
                return;
            }

            if (newPass.length < 6) {
                alert('Sandi baru minimal 6 karakter!');
                return;
            }

            const modal = document.getElementById('passwordModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePasswordModal() {
            const modal = document.getElementById('passwordModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function submitPassword() {
            document.getElementById('formPassword').submit();
        }
    </script>
</body>
</html>