<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Nasabah - SMKN 11 Banking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50">
    <div class="flex min-h-screen">
        
        <!-- Sidebar (TIDAK DIUBAH SAMA SEKALI) -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-screen">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-wallet text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900">Smart Pocket</h1>
                        <p class="text-[10px] text-slate-500 font-medium">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-4 space-y-1 flex-1 overflow-y-auto">
                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-home w-5 text-center"></i> Dashboard
                </a>
                
                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-users w-5 text-center"></i> Data Nasabah
                </a>

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-exchange-alt w-5 text-center"></i> Transaksi
                </a>

                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-hand-holding-usd w-5 text-center"></i> Peminjaman
                </a>

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-check-circle w-5 text-center"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-chart-bar w-5 text-center"></i> Laporan
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-cog w-5 text-center"></i> Pengaturan
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100 space-y-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-white border border-gray-200 hover:bg-red-50 hover:text-red-600 text-slate-600 text-sm font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

<!-- Main Content -->
        <main class="flex-1 ml-64 p-6 lg:p-8">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">Edit Data Nasabah</h1>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi detail untuk nasabah terdaftar.</p>
            </div>

            <!-- Main Card Container -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6 lg:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                    <!-- Left Column: Saldo Card & Info -->
                    <div class="space-y-4">
                        <!-- Saldo Card -->
                        <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-6 shadow-sm">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xs">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Saldo Saat Ini</span>
                            </div>
                            <p class="text-3xl font-extrabold text-slate-900 mb-2">
                                Rp {{ number_format($nasabah->rekening->saldo ?? 0, 0, ',', '.') }}
                            </p>
                            <div class="pt-2 border-t border-blue-100/60 flex items-center justify-between text-xs text-slate-500">
                                <span>Status Rekening</span>
                                <span class="font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/50">
                                    {{ ucfirst($nasabah->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Last Updated Info -->
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-xs text-slate-500 flex items-center gap-2">
                            <i class="far fa-clock text-slate-400"></i>
                            <span>Terakhir diubah: <strong>{{ $nasabah->updated_at ? $nasabah->updated_at->format('d M Y') : '-' }}</strong></span>
                        </div>
                    </div>

                    <!-- Right Column: Form Edit -->
                    <div class="lg:col-span-2">
                        <form action="{{ route('operator.nasabah.update', $nasabah->id_nasabah) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                                    <strong class="font-semibold">Terjadi Kesalahan:</strong>
                                    <ul class="mt-2 list-disc list-inside text-sm space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Section: Informasi Identitas -->
                            <div class="mb-8">
                                <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2 pb-2 border-b border-gray-100">
                                    <i class="fas fa-id-card text-slate-500"></i> Informasi Identitas
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- NIS/NIP -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIS / NIP</label>
                                        <input type="text" value="{{ $nasabah->user->username ?? '' }}" readonly
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-slate-50 text-slate-500 text-sm cursor-not-allowed">
                                        <p class="text-[11px] text-slate-400 mt-1">NIS tidak dapat diubah</p>
                                    </div>

                                    <!-- Nama Lengkap -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
                                        <input type="text" name="nama" value="{{ old('nama', $nasabah->nama) }}" required
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                    </div>

                                    <form action="{{ route('operator.nasabah.update', $nasabah->id_nasabah) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <input type="hidden" name="username" value="{{ $nasabah->user->username ?? '' }}">
                                        <input type="hidden" name="tanggal_daftar" value="{{ $nasabah->tanggal_daftar ?? date('Y-m-d') }}">
                                    </form>
                                    <!-- Alamat -->
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat</label>
                                        <textarea name="alamat" rows="3" required
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all resize-y">{{ old('alamat', $nasabah->alamat) }}</textarea>
                                    </div>                                
                                </div>
                            </div>

                            <!-- Section: Pengaturan Akun -->
                            <div class="mb-8">
                                <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2 pb-2 border-b border-gray-100">
                                    <i class="fas fa-shield-alt text-slate-500"></i> Pengaturan Akun
                                </h3>
                                
                                <div class="space-y-4">
                                    <!-- Reset Password -->
                                    <div class="flex items-start gap-3 p-4 bg-amber-50/60 border border-amber-200/70 rounded-xl">
                                        <input type="checkbox" name="reset_password" value="1" id="resetPass"
                                            class="mt-0.5 rounded border-amber-300 text-amber-600 focus:ring-amber-500">
                                        <div class="flex-1">
                                            <label for="resetPass" class="text-sm font-semibold text-slate-900 cursor-pointer">Reset Password ke Default</label>
                                            <p class="text-xs text-slate-600 mt-0.5">Password akan diubah menjadi <span class="font-mono bg-amber-100 px-1.5 py-0.5 rounded text-amber-900 font-semibold">nasabah123</span></p>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Akun</label>
                                        <select name="status" required
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-slate-800 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                            <option value="aktif" {{ $nasabah->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="nonaktif" {{ $nasabah->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                                <a href="{{ route('operator.nasabah.index') }}" class="px-5 py-2.5 border border-gray-200 text-slate-600 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold shadow-sm transition-colors flex items-center gap-2">
                                    <i class="fas fa-save text-xs"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>
</html>