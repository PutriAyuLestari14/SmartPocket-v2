<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Nasabah Baru - SMKN 11 Banking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-screen">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-university text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900">SMKN 11 Banking</h1>
                        <p class="text-xs text-slate-500">Operator Dashboard</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-4 space-y-1 flex-1 overflow-y-auto">
                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-home w-5 text-center"></i> Dashboard
                </a>
                
                <div class="pt-2">
                    <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 bg-yellow-400 text-slate-900 rounded-lg text-sm font-semibold transition-colors">
                        <i class="fas fa-users w-5 text-center"></i> Data Nasabah
                    </a>
                </div>

                <div class="pt-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-exchange-alt w-5 text-center"></i> Transaksi
                    </a>
                </div>

                <div class="pt-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-hand-holding-usd w-5 text-center"></i> Peminjaman
                    </a>
                </div>

                <div class="pt-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-check-circle w-5 text-center"></i> Verifikasi
                    </a>
                </div>

                <div class="pt-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-chart-bar w-5 text-center"></i> Laporan
                    </a>
                </div>

                <div class="pt-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-cog w-5 text-center"></i> Pengaturan
                    </a>
                </div>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
                <a href="{{ route('operator.nasabah.index') }}" class="hover:text-emerald-600">Data Nasabah</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-slate-900 font-medium">Tambah Nasabah</span>
            </nav>

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Tambah Nasabah Baru</h1>
                <p class="text-sm text-slate-500">Masukkan data detail untuk mendaftarkan nasabah baru ke dalam sistem Mini Bank SMKN 11.</p>
            </div>

            <!-- Error Message -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <strong>Terjadi Kesalahan:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('operator.nasabah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Informasi Dasar -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Informasi Dasar</h3>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <!-- NIS/NIP -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">NIS / NIP <span class="text-red-500">*</span></label>
                            <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan Nomor Induk" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                            <p class="text-xs text-slate-500 mt-1">Digunakan sebagai username login</p>
                        </div>

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama sesuai KTP/Kartu Pelajar" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                        </div>

                        <!-- Jenis Nasabah -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Nasabah <span class="text-red-500">*</span></label>
                            <select name="kategori" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                                <option value="">Pilih Jenis Nasabah</option>
                                <option value="siswa" {{ old('kategori') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="guru" {{ old('kategori') == 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="staf" {{ old('kategori') == 'staf' ? 'selected' : '' }}>Staf</option>
                            </select>
                        </div>

                        <!-- Kelas/Jurusan -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kelas / Jurusan</label>
                            <select name="kelas" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <option value="">Pilih Kelas & Jurusan</option>
                                <option value="X RPL 1">X RPL 1</option>
                                <option value="X RPL 2">X RPL 2</option>
                                <option value="X TKJ 1">X TKJ 1</option>
                                <option value="X TKJ 2">X TKJ 2</option>
                                <option value="XI RPL 1">XI RPL 1</option>
                                <option value="XI RPL 2">XI RPL 2</option>
                                <option value="XI TKJ 1">XI TKJ 1</option>
                                <option value="XI TKJ 2">XI TKJ 2</option>
                                <option value="XII RPL 1">XII RPL 1</option>
                                <option value="XII RPL 2">XII RPL 2</option>
                                <option value="XII TKJ 1">XII TKJ 1</option>
                                <option value="XII TKJ 2">XII TKJ 2</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Kontak & Rekening -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Kontak & Rekening</h3>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Alamat -->
                        <div class="col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>{{ old('alamat') }}</textarea>
                        </div>

                        <!-- Saldo Awal -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Saldo Awal (Rp)</label>
                            <input type="number" name="saldo" value="{{ old('saldo', 0) }}" placeholder="Rp 0" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <p class="text-xs text-slate-500 mt-1">Minimal setoran awal Rp 10.000</p>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Password Akun (Awal) <span class="text-red-500">*</span></label>
                            <input type="password" name="password" placeholder="Buat password sementara" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                            <p class="text-xs text-slate-500 mt-1">Password untuk login nasabah</p>
                        </div>

                        <!-- Tanggal Daftar -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Daftar <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_daftar" value="{{ old('tanggal_daftar', date('Y-m-d')) }}" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                            <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('operator.nasabah.index') }}" class="px-6 py-2.5 border border-gray-300 text-slate-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold flex items-center gap-2 transition-colors">
                        <i class="fas fa-save"></i> Simpan Data Nasabah
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>