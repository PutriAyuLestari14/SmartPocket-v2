<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .input-premium {
            transition: all 0.2s ease-in-out;
        }
        .input-premium:focus {
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="flex min-h-screen">
        
        <!-- Sidebar Nasabah (Konsisten) -->
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
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-wallet w-5 text-center"></i> Saldo
                </a>
                <a href="{{ route('nasabah.penarikan.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-money-bill-wave w-5 text-center"></i> Tarik
                </a>
                <!-- Menu Aktif: Pinjam -->
                <a href="{{ route('nasabah.peminjaman.create') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-semibold transition-colors">
                    <i class="fas fa-hand-holding-usd w-5 text-center"></i> Pinjam
                </a>
                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-history w-5 text-center"></i> Riwayat
                </a>
                
                <p class="px-4 py-2 mt-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lainnya</p>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-cog w-5 text-center"></i> Pengaturan
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

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-6 lg:p-10">
            
            <!-- Header Halaman -->
            <div class="mb-8">
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-3">
                    <a href="{{ route('nasabah.dashboard') }}" class="hover:text-emerald-600 transition-colors">Dashboard</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-slate-800 font-semibold">Ajukan Peminjaman</span>
                </nav>
                <h1 class="text-2xl lg:text-3xl font-bold text-slate-900 tracking-tight">Ajukan Peminjaman Dana</h1>
                <p class="text-sm text-slate-500 mt-1.5">Ajukan pinjaman dengan bunga rendah. Permintaan akan diverifikasi oleh operator.</p>
            </div>

            <!-- Layout 2 Kolom: Kiri (Info) & Kanan (Form) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                
                <!-- KOLOM KIRI: Ringkasan & Aturan -->
                <div class="space-y-6">
                    <!-- Kartu Limit Pinjaman -->
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 text-white shadow-lg shadow-blue-500/20 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mr-10 -mt-10 blur-xl"></div>
                        <div class="relative z-10">
                            <p class="text-xs font-medium text-blue-100 uppercase tracking-wider mb-1">Limit Pinjaman Tersisa</p>
                            <p class="text-3xl font-bold tracking-tight">Rp 5.000.000</p>
                            <div class="mt-4 pt-4 border-t border-white/20 flex items-center gap-2 text-xs text-blue-100">
                                <i class="fas fa-chart-line"></i>
                                <span>Berdasarkan status keaktifan Anda</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Ketentuan -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-blue-500"></i> Ketentuan Peminjaman
                        </h3>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3 text-xs text-slate-600">
                                <i class="fas fa-check-circle text-blue-500 mt-0.5 flex-shrink-0"></i>
                                <span>Minimal pinjaman adalah <strong class="text-slate-900">Rp 50.000</strong>.</span>
                            </li>
                            <li class="flex items-start gap-3 text-xs text-slate-600">
                                <i class="fas fa-check-circle text-blue-500 mt-0.5 flex-shrink-0"></i>
                                <span>Pilih metode pembayaran yang sesuai (Tunai atau Potong Gaji).</span>
                            </li>
                            <li class="flex items-start gap-3 text-xs text-slate-600">
                                <i class="fas fa-check-circle text-blue-500 mt-0.5 flex-shrink-0"></i>
                                <span>Pastikan tanggal pengembalian realistis sesuai kemampuan.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- KOLOM KANAN: Formulir -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 lg:p-8">
                        
                        <!-- Notifikasi Error -->
                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3">
                                <i class="fas fa-exclamation-circle text-red-500 text-lg mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-semibold text-red-800">Mohon periksa kembali data Anda</p>
                                    <ul class="mt-1.5 list-disc list-inside text-xs text-red-700 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <!-- Notifikasi Sukses -->
                        @if (session('success'))
                            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3">
                                <i class="fas fa-check-circle text-emerald-500 text-lg mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-semibold text-emerald-800">Pengajuan Berhasil!</p>
                                    <p class="text-xs text-emerald-700 mt-1">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('nasabah.peminjaman.store') }}" method="POST">
                            @csrf

                            <!-- 1. Jumlah Pinjaman -->
                            <div class="mb-6">
                                <label for="jumlah" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jumlah Pinjaman (Rp) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-slate-500 font-bold text-sm">Rp</span>
                                    </div>
                                    <input 
                                        type="number" 
                                        name="jumlah" 
                                        id="jumlah" 
                                        value="{{ old('jumlah') }}" 
                                        min="50000" 
                                        step="10000"
                                        placeholder="0"
                                        class="input-premium w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-base font-bold text-slate-900 placeholder-slate-400" 
                                        required
                                    >
                                </div>
                                <p class="text-xs text-slate-500 mt-2 flex items-center gap-1.5">
                                    <i class="fas fa-lightbulb text-amber-500"></i>
                                    Minimal Rp 50.000, kelipatan Rp 10.000.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- 2. Jangka Waktu (Tanggal) -->
                                <div>
                                    <label for="tanggal_pengembalian" class="block text-sm font-semibold text-slate-700 mb-2">
                                        Target Lunas (Sampai Kapan) <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="date" 
                                        name="tanggal_pengembalian" 
                                        id="tanggal_pengembalian" 
                                        value="{{ old('tanggal_pengembalian') }}" 
                                        min="{{ date('Y-m-d', strtotime('+1 month')) }}"
                                        class="input-premium w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm text-slate-900" 
                                        required
                                    >
                                    <p class="text-xs text-slate-500 mt-2">Pilih tanggal rencana pelunasan.</p>
                                </div>

                                <!-- 3. Metode Pembayaran (Dropdown) -->
                                <div>
                                    <label for="metode_pembayaran" class="block text-sm font-semibold text-slate-700 mb-2">
                                        Metode Pembayaran <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select 
                                            name="metode_pembayaran" 
                                            id="metode_pembayaran" 
                                            class="input-premium w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm text-slate-900 appearance-none cursor-pointer" 
                                            required
                                        >
                                            <option value="" disabled selected>Pilih metode pembayaran</option>
                                            <option value="tunai" {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai di Kantor BMT</option>
                                            <option value="potong_gaji" {{ old('metode_pembayaran') == 'potong_gaji' ? 'selected' : '' }}>Potong Gaji (Khusus Guru/Staf)</option>
                                            <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                        </select>
                                        <!-- Custom Dropdown Arrow -->
                                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                            <i class="fas fa-chevron-down text-slate-400 text-xs"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-2">Pilih cara Anda akan mencicil/melunasi.</p>
                                </div>
                            </div>

                            <!-- 4. Keterangan / Tujuan (Opsional tapi disarankan) -->
                            <div class="mb-8">
                                <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tujuan Peminjaman <span class="text-slate-400 font-normal">(Opsional)</span>
                                </label>
                                <textarea 
                                    name="keterangan" 
                                    id="keterangan" 
                                    rows="3" 
                                    placeholder="Contoh: Untuk modal usaha kecil-kecilan, biaya kesehatan, dll."
                                    class="input-premium w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm text-slate-900 placeholder-slate-400 resize-none" 
                                >{{ old('keterangan') }}</textarea>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t border-slate-100">
                                <a href="{{ route('nasabah.dashboard') }}" class="w-full sm:w-auto px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-semibold hover:bg-slate-50 hover:text-slate-800 transition-all text-sm text-center">
                                    Batal
                                </a>
                                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-all shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 text-sm">
                                    <i class="fas fa-paper-plane text-xs"></i> 
                                    Ajukan Peminjaman
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