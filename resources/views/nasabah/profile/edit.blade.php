<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile & Pengaturan - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0',
                            300: '#6ee7b7', 400: '#34d399', 500: '#10b981',
                            600: '#059669', 700: '#047857', 800: '#065f46', 900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .card-grad-1 { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <div class="flex min-h-screen">
        
        <!-- SIDEBAR (Sesuaikan dengan sidebar nasabah kamu) -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col fixed h-screen z-20">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-md shadow-emerald-500/20">
                        <i class="fas fa-wallet text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900 tracking-tight">Smart Pocket</h1>
                        <p class="text-[10px] text-slate-500 font-medium tracking-wide">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-4 space-y-1 flex-1">
                <p class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menu Utama</p>
                <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-home w-5 text-center"></i> Dashboard
                </a>
                <a href="{{ route('nasabah.penarikan.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                    <i class="fas fa-money-bill-wave w-5 text-center"></i> Penarikan
                </a>
                @if(auth()->user()->nasabah->kategori == 'guru')
                    <a href="{{ route('nasabah.peminjaman.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">
                        <i class="fas fa-hand-holding-usd w-5 text-center"></i> Peminjaman
                    </a>
                @endif
                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-history w-5 text-center"></i> Riwayat Transaksi
                </a>
                
                <p class="px-4 py-2 mt-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lainnya</p>
                <a href="{{ route('nasabah.profile.edit')}}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-semibold transition-colors">
                    <i class="fas fa-cog w-5 text-center"></i> Profile
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-white border border-slate-200 hover:bg-red-50 hover:text-red-600 hover:border-red-200 text-slate-600 text-sm font-medium py-2.5 px-4 rounded-lg transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>


        <!-- MAIN CONTENT -->
        <main class="flex-1 md:ml-64 p-4 lg:p-8">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-slate-900">Pengaturan & Profil User</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data diri, keamanan akun, dan informasi tabungan Anda.</p>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-600"></i>
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Grid Layout: 2 Kolom -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- KOLOM KIRI: DATA PRIBADI (Lebar 2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Card Identitas & Foto -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-slate-900">Identitas & Data Pribadi</h3>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">Nasabah Aktif</span>
                        </div>

                        <!-- Form Update Profile -->
                        <form action="{{ route('nasabah.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <!-- Upload Foto -->
                            <div class="flex items-center gap-6 mb-8 pb-6 border-b border-gray-100">
                                <div class="relative">
                                    @if($nasabah && $nasabah->photo)
                                        <img src="{{ asset('storage/' . $nasabah->photo) }}" alt="Foto Profile" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                                    @else
                                        <div class="w-24 h-24 rounded-full bg-slate-200 flex items-center justify-center border-4 border-white shadow-md">
                                            <i class="fas fa-user text-3xl text-slate-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-900 mb-2">Foto Profile</label>
                                    <input type="file" name="photo" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                                    <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                                </div>
                            </div>

                            <!-- Grid Input Data -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Username / NIS</label>
                                    <input type="text" value="{{ $user->username }}" readonly class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-500 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ old('nama', $nasabah->nama ?? '') }}" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">{{ old('alamat', $nasabah->alamat ?? '') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal Daftar</label>
                                    <input type="text" value="{{ $nasabah ? \Carbon\Carbon::parse($nasabah->tanggal_daftar)->format('d M Y') : '-' }}" readonly class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-500 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status Akun</label>
                                    <div class="px-4 py-2.5 bg-emerald-50 border border-emerald-200 rounded-lg text-sm font-bold text-emerald-700 flex items-center gap-2">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Aktif
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4 border-t border-gray-100">
                                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-md transition-all flex items-center gap-2">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- KOLOM KANAN: PASSWORD & SALDO (Lebar 1/3) -->
                <div class="space-y-6">

                    <!-- Card Informasi Tabungan (Saldo & No Rek) -->
                    <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                        <!-- Decorative Circle -->
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-sm font-semibold text-emerald-100">Informasi Tabungan</h3>
                                <i class="fas fa-wallet text-emerald-200"></i>
                            </div>
                            
                            <p class="text-xs text-emerald-200 mb-1">Nomor Rekening</p>
                            <p class="text-xl font-bold tracking-wider mb-6 font-mono">
                                {{ $rekening ? $rekening->no_rek : 'Belum Ada' }}
                            </p>
                            
                            <p class="text-xs text-emerald-200 mb-1">Saldo Saat Ini</p>
                            <p class="text-3xl font-black">
                                Rp {{ $rekening ? number_format($rekening->saldo, 0, ',', '.') : '0' }}
                            </p>
                        </div>
                    </div>

                                        <!-- Card Ubah Password -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Kata Sandi & Akses</h3>
                        
                        <form action="{{ route('nasabah.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kata Sandi Saat Ini</label>
                                    <input type="password" name="current_password" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kata Sandi Baru</label>
                                    <input type="password" name="password" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                </div>
                            </div>

                            <button type="submit" class="w-full mt-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-lg shadow-md transition-all">
                                Perbarui Kata Sandi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>