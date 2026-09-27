<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Nasabah - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
        .gradient-forest { background: linear-gradient(135deg, #1A4D2E 0%, #123720 100%); }
        .gradient-mint { background: linear-gradient(135deg, #4E9F3D 0%, #1A4D2E 100%); }
        .gradient-blue { background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); }
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
    <div id="sidebarBackdrop" class="fixed inset-0 bg-forestDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-sm">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center shadow-md shadow-forest/20">
                        <i class="fas fa-wallet text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-forest tracking-tight">Smart Pocket</h1>
                        <p class="text-[10px] text-mint font-bold tracking-wider">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-2 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>

                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-users w-5 text-center text-mint"></i> Data Nasabah
                </a>

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-exchange-alt w-5 text-center text-slate-400"></i> Transaksi
                </a>

                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman
                </a>

                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-check-circle w-5 text-center text-slate-400"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-chart-bar w-5 text-center text-slate-400"></i> Laporan
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
            <header class="lg:hidden bg-white border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center text-white shadow-md shadow-forest/20">
                        <i class="fas fa-wallet text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-forest tracking-tight leading-none">Smart Pocket</h1>
                        <p class="text-[10px] text-mint font-bold tracking-wider mt-1">BMT SMKN 11</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('operator.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative active:scale-95 transition-transform">
                        <i class="far fa-bell text-base"></i>
                        <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-mint rounded-full ring-2 ring-white"></span>
                    </a>
                    <button onclick="toggleSidebar()" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform">
                        <i class="fas fa-bars text-base"></i>
                    </button>
                </div>
            </header>

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- Header -->
                <header class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1 flex-wrap">
                            <a href="{{ route('operator.nasabah.index') }}" class="hover:text-forest transition-colors">Data Nasabah</a>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-forest font-bold">Edit Nasabah</span>
                        </div>

                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Edit Data Nasabah
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Perbarui informasi detail untuk nasabah terdaftar.
                        </p>
                    </div>

                    <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-800 leading-tight">
                                {{ auth()->user()->petugas->nama_lengkap ?? auth()->user()->name }}
                            </p>
                            <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Operator</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl overflow-hidden bg-forest text-white font-bold text-sm flex items-center justify-center border border-slate-200 shadow-sm flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->petugas->nama_lengkap ?? auth()->user()->name, 0, 1)) }}
                        </div>
                        <a href="{{ route('operator.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200/80 rounded-xl flex items-center justify-center text-slate-600 hover:text-forest hover:border-mint transition-all relative shadow-sm ml-1">
                            <i class="far fa-bell text-base"></i>
                            @php $pendingNotif = \App\Models\DetailTabungan::where('status', 'pending')->count(); @endphp
                            @if($pendingNotif > 0)
                                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-mint rounded-full ring-2 ring-white"></span>
                            @endif
                        </a>
                    </div>
                </header>

                <!-- Main Card Container -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-6 items-start">

                    <!-- Left Column -->
                    <div class="space-y-4">

                        <!-- Saldo Card -->
                        <div class="gradient-blue rounded-2xl p-5 lg:p-6 text-white shadow-xl shadow-blue-500/20 relative overflow-hidden">
                            <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-8 h-8 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center">
                                        <i class="fas fa-wallet text-xs"></i>
                                    </div>
                                    <span class="text-[10px] font-extrabold text-blue-100 uppercase tracking-widest">Saldo Saat Ini</span>
                                </div>
                                <p class="text-2xl lg:text-3xl font-black text-white mb-3 break-all">
                                    Rp {{ number_format($nasabah->rekening->saldo ?? 0, 0, ',', '.') }}
                                </p>
                                <div class="pt-3 border-t border-white/20 flex items-center justify-between text-xs">
                                    <span class="text-blue-100 font-medium">Status Rekening</span>
                                    <span class="font-extrabold px-2.5 py-1 rounded-full {{ $nasabah->status == 'aktif' ? 'bg-mint text-white' : 'bg-red-500 text-white' }}">
                                        {{ ucfirst($nasabah->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 flex items-start gap-3">
                            <div class="w-8 h-8 bg-mintLight rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-info-circle text-forest text-xs"></i>
                            </div>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                NISN dan No. Rekening tidak dapat diubah. Hubungi admin jika ada kesalahan input data identitas.
                            </p>
                        </div>
                    </div>

                    <!-- Right Column: Form Edit -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 lg:p-6">
                            <form id="formEditNasabah" action="{{ route('operator.nasabah.update', $nasabah->id_nasabah) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @if ($errors->any())
                                    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-2xl">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-exclamation text-white text-xs"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-extrabold text-red-700 mb-2">Terjadi Kesalahan:</p>
                                                <ul class="list-disc list-inside text-xs text-red-700 space-y-0.5">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Section: Informasi Identitas -->
                                <div class="mb-6">
                                    <div class="flex items-center gap-3 mb-5">
                                        <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                                            <i class="fas fa-id-card text-forest"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-extrabold text-slate-900">Informasi Identitas</h3>
                                            <p class="text-[11px] text-slate-500">Data diri nasabah</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- NIS/NIP (readonly) -->
                                        <div>
                                            <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">NISN / NIP</label>
                                            <div class="relative">
                                                <input type="text" value="{{ $nasabah->user->username ?? '' }}" readonly
                                                    class="w-full px-4 py-2.5 pr-10 border border-slate-200 rounded-xl bg-slate-100 text-slate-500 text-sm cursor-not-allowed font-mono">
                                                <i class="fas fa-lock absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                            </div>
                                            <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                                <i class="fas fa-info-circle text-mint"></i> NISN tidak dapat diubah
                                            </p>
                                        </div>

                                        <!-- No. Rekening (readonly) -->
                                        <div>
                                            <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">No. Rekening</label>
                                            <div class="relative">
                                                <input type="text" value="{{ $nasabah->rekening->no_rek ?? '-' }}" readonly
                                                    class="w-full px-4 py-2.5 pr-10 border border-slate-200 rounded-xl bg-slate-100 text-slate-500 text-sm cursor-not-allowed font-mono">
                                                <i class="fas fa-lock absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                            </div>
                                            <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                                <i class="fas fa-info-circle text-mint"></i> No. Rekening tidak dapat diubah
                                            </p>
                                        </div>

                                        <!-- Nama Lengkap -->
                                        <div class="md:col-span-2">
                                            <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                                            <input type="text" name="nama" id="inputNama" value="{{ old('nama', $nasabah->nama) }}" required
                                                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all">
                                        </div>

                                        <input type="hidden" name="username" value="{{ $nasabah->user->username ?? '' }}">
                                        <input type="hidden" name="tanggal_daftar" value="{{ $nasabah->tanggal_daftar ?? date('Y-m-d') }}">

                                        <!-- Alamat -->
                                        <div class="md:col-span-2">
                                            <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Alamat</label>
                                            <textarea name="alamat" id="inputAlamat" rows="3" required
                                                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all resize-y">{{ old('alamat', $nasabah->alamat) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Pengaturan Akun -->
                                <div class="mb-6">
                                    <div class="flex items-center gap-3 mb-5">
                                        <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                                            <i class="fas fa-shield-alt text-forest"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-extrabold text-slate-900">Pengaturan Akun</h3>
                                            <p class="text-[11px] text-slate-500">Keamanan dan status akun</p>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <!-- Reset Password -->
                                        <label for="resetPass" class="flex items-start gap-3 p-4 bg-amber-50 border border-amber-200 rounded-2xl cursor-pointer hover:bg-amber-100/50 transition-colors">
                                            <input type="checkbox" name="reset_password" value="1" id="resetPass"
                                                class="mt-0.5 w-4 h-4 rounded border-amber-300 text-amber-600 focus:ring-amber-500 cursor-pointer">
                                            <div class="flex-1">
                                                <p class="text-sm font-extrabold text-slate-900">Reset Password ke Default</p>
                                                <p class="text-xs text-slate-600 mt-0.5">Password akan diubah menjadi <span class="font-mono bg-white px-1.5 py-0.5 rounded border border-amber-200 text-amber-900 font-bold">nasabah123</span></p>
                                            </div>
                                        </label>

                                        <!-- Status -->
                                        <div>
                                            <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Status Akun</label>
                                            <select name="status" id="inputStatus" required
                                                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all cursor-pointer">
                                                <option value="aktif" {{ $nasabah->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="nonaktif" {{ $nasabah->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-5 border-t border-slate-100">
                                    <a href="{{ route('operator.nasabah.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors text-center">
                                        Batal
                                    </a>
                                    <button type="button" onclick="openModal()" class="px-6 py-2.5 bg-mint hover:bg-forest text-white rounded-xl text-sm font-extrabold shadow-md shadow-mint/20 transition-colors flex items-center justify-center gap-2">
                                        <i class="fas fa-save text-xs"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ═══ MODAL KONFIRMASI EDIT ═══ -->
    <div id="confirmModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-forestDark/60 backdrop-blur-sm backdrop-in" onclick="closeModal()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden modal-in">
            <div class="gradient-mint px-6 py-6 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-edit text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold">Konfirmasi Perubahan</h3>
                        <p class="text-xs text-emerald-100 mt-0.5">Pastikan data sudah benar sebelum disimpan</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-3 max-h-[60vh] overflow-y-auto">
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">NISN / NIP</span>
                    <span class="text-sm font-extrabold text-slate-900 font-mono text-right truncate">{{ $nasabah->user->username ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">No. Rekening</span>
                    <span class="text-sm font-extrabold text-forest font-mono text-right truncate">{{ $nasabah->rekening->no_rek ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">Nama Lengkap</span>
                    <span id="modalNama" class="text-sm font-extrabold text-slate-900 text-right truncate">-</span>
                </div>
                <div class="flex justify-between items-start py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">Alamat</span>
                    <span id="modalAlamat" class="text-xs font-semibold text-slate-700 text-right max-w-[200px] line-clamp-2">-</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold flex-shrink-0">Status Akun</span>
                    <span id="modalStatus" class="text-[10px] font-extrabold px-2.5 py-1 rounded-lg uppercase bg-mintLight text-forest border border-mint/30">-</span>
                </div>
                <div class="flex justify-between items-center pt-3 bg-amber-50 rounded-xl px-4 py-3 border border-amber-200">
                    <span class="text-xs text-amber-800 font-extrabold flex items-center gap-1.5">
                        <i class="fas fa-key text-[10px]"></i> Reset Password
                    </span>
                    <span id="modalReset" class="text-[10px] font-extrabold px-2.5 py-1 rounded-lg uppercase bg-white text-amber-700 border border-amber-300">-</span>
                </div>
            </div>

            <div class="p-6 pt-0 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </button>
                <button type="button" onclick="submitForm()" class="flex-1 py-3 bg-mint hover:bg-forest text-white rounded-xl font-extrabold text-sm transition-colors flex items-center justify-center gap-2 shadow-md shadow-mint/20">
                    <i class="fas fa-check text-xs"></i> Ya, Simpan
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

        function openModal() {
            const nama = document.getElementById('inputNama').value.trim();
            const alamat = document.getElementById('inputAlamat').value.trim();
            const status = document.getElementById('inputStatus').value;
            const resetPass = document.getElementById('resetPass').checked;

            if (!nama) { alert('Nama lengkap wajib diisi!'); return; }
            if (!alamat) { alert('Alamat wajib diisi!'); return; }

            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalAlamat').textContent = alamat;
            document.getElementById('modalStatus').textContent = status;
            document.getElementById('modalReset').textContent = resetPass ? 'Ya' : 'Tidak';

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
            document.getElementById('formEditNasabah').submit();
        }
    </script>
</body>
</html>