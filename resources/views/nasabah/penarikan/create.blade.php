<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Penarikan - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        /* Animasi halus untuk focus */
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
                <a href="{}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-wallet w-5 text-center"></i> Saldo
                </a>
                <a href="{{ route('nasabah.penarikan.create') }}" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-semibold transition-colors">
                    <i class="fas fa-money-bill-wave w-5 text-center"></i> Tarik
                </a>
                <a href="{{ route('nasabah.peminjaman.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium transition-colors">
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
                    <span class="text-slate-800 font-semibold">Ajukan Penarikan</span>
                </nav>
                <h1 class="text-2xl lg:text-3xl font-bold text-slate-900 tracking-tight">Ajukan Penarikan Saldo</h1>
                <p class="text-sm text-slate-500 mt-1.5">Isi formulir di bawah ini. Permintaan akan diverifikasi oleh operator dalam 1x24 jam.</p>
            </div>

            <!-- Layout 2 Kolom: Kiri (Info) & Kanan (Form) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                
                <!-- KOLOM KIRI: Ringkasan & Aturan (1/3 Lebar) -->
                <div class="space-y-6">
                    <!-- Kartu Saldo -->
                    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl p-6 text-white shadow-lg shadow-emerald-500/20 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-5 rounded-full -mr-10 -mt-10 blur-xl"></div>
                        <div class="relative z-10">
                            <p class="text-xs font-medium text-emerald-100 uppercase tracking-wider mb-1">Sisa Saldo Anda</p>
                            <p class="text-3xl font-bold tracking-tight">Rp 1.250.000</p>
                            <div class="mt-4 pt-4 border-t border-white/20 flex items-center gap-2 text-xs text-emerald-100">
                                <i class="fas fa-shield-alt"></i>
                                <span>Saldo aman & terenkripsi</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Aturan -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-emerald-500"></i> Aturan Penarikan
                        </h3>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3 text-xs text-slate-600">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                <span>Minimal penarikan adalah <strong class="text-slate-900">Rp 10.000</strong>.</span>
                            </li>
                            <li class="flex items-start gap-3 text-xs text-slate-600">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                <span>Penarikan hanya bisa dilakukan dalam kelipatan <strong class="text-slate-900">Rp 1.000</strong>.</span>
                            </li>
                            <li class="flex items-start gap-3 text-xs text-slate-600">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                <span>Dana akan diproses oleh operator dan masuk ke saldo setelah disetujui.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- KOLOM KANAN: Formulir (2/3 Lebar) -->
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

                        <form action="{{ route('nasabah.penarikan.store') }}" method="POST">
                            @csrf

                            <!-- Input Jumlah -->
                            <div class="mb-6">
                                <label for="jumlah" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jumlah Penarikan <span class="text-red-500">*</span>
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
                                        min="10000" 
                                        step="1000"
                                        placeholder="0"
                                        class="input-premium w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-base font-bold text-slate-900 placeholder-slate-400" 
                                        required
                                        oninput="validasiAngka(this)"
                                    >
                                </div>
                                <p class="text-xs text-slate-500 mt-2 flex items-center gap-1.5">
                                    <i class="fas fa-lightbulb text-amber-500"></i>
                                    Masukkan angka saja, contoh: 50000
                                </p>
                            </div>

                            <!-- Input Keterangan -->
                            <div class="mb-8">
                                <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Keterangan / Tujuan <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    name="keterangan" 
                                    id="keterangan" 
                                    rows="4" 
                                    placeholder="Contoh: Untuk uang saku minggu ini, pembelian buku pelajaran, dll."
                                    class="input-premium w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm text-slate-900 placeholder-slate-400 resize-none" 
                                    required
                                >{{ old('keterangan') }}</textarea>
                                <div class="flex justify-between mt-2">
                                    <p class="text-xs text-slate-500">Jelaskan secara singkat tujuan penarikan.</p>
                                    <p class="text-xs text-slate-400"><span id="charCount">0</span>/255</p>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t border-slate-100">
                                <a href="{{ route('nasabah.dashboard') }}" class="w-full sm:w-auto px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-semibold hover:bg-slate-50 hover:text-slate-800 transition-all text-sm text-center">
                                    Batal
                                </a>
                                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-all shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 text-sm">
                                    <i class="fas fa-paper-plane text-xs"></i> 
                                    Ajukan Penarikan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Script Kecil untuk Detail UX -->
    <script>
        // 1. Hitung karakter textarea
        const textarea = document.getElementById('keterangan');
        const charCount = document.getElementById('charCount');
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
            if(this.value.length > 255) {
                this.value = this.value.substring(0, 255);
                charCount.textContent = 255;
            }
        });

        // 2. Validasi angka minimal
        function validasiAngka(input) {
            if (input.value < 0) input.value = 0;
        }
    </script>
</body>
</html>