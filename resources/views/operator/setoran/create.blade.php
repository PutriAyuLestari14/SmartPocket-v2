<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Setoran Dana - Smart Pocket</title>
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

                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Data Nasabah
                </a>

                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-exchange-alt w-5 text-center text-mint"></i> Transaksi
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

            <!-- Mobile Top Bar (samain kayak dashboard) -->
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
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1">
                            <span>Dashboard</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span>Transaksi</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-forest font-bold">Input Setoran</span>
                        </div>

                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Input Setoran Dana
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Proses penyetoran dana tunai nasabah ke rekening mereka.
                        </p>
                    </div>

                    <!-- Profil + notif desktop -->
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

                <!-- Notifikasi Session -->
                @if(session('success'))
                    <div class="p-4 bg-mintLight border border-mint/30 rounded-2xl flex items-start gap-3">
                        <div class="w-8 h-8 bg-mint rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <p class="text-sm font-bold text-forest pt-1">{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('error'))
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3">
                        <div class="w-8 h-8 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation text-white text-xs"></i>
                        </div>
                        <p class="text-sm font-bold text-red-700 pt-1">{{ session('error') }}</p>
                    </div>
                @endif

                <form id="formSetoran" action="{{ route('operator.setoran.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-6">

                        <!-- Left Column -->
                        <div class="lg:col-span-2 space-y-5 lg:space-y-6">

                            <!-- Identitas Nasabah -->
                            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 lg:p-6">
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                                        <i class="fas fa-user-circle text-forest"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-extrabold text-slate-900">Identitas Nasabah</h3>
                                        <p class="text-[11px] text-slate-500">Cari berdasarkan nomor rekening atau nama</p>
                                    </div>
                                </div>

                                <!-- Search -->
                                <div class="mb-4 relative">
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Cari Nasabah</label>
                                    <div class="flex gap-2">
                                        <div class="flex-1 relative">
                                            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                            <input type="text" id="searchNama" placeholder="Ketik No. Rekening atau Nama..."
                                                class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all"
                                                onkeyup="filterNasabah()" autocomplete="off">
                                        </div>
                                        <button type="button" onclick="cariNasabah()" class="px-4 py-2.5 bg-mint hover:bg-forest text-white rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-md shadow-mint/20">
                                            <i class="fas fa-search text-xs"></i>
                                        </button>
                                    </div>

                                    <!-- Dropdown -->
                                    <div id="dropdownNasabah" class="hidden absolute mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-xl max-h-56 overflow-y-auto z-20">
                                        @foreach($nasabah as $n)
                                            <div onclick="pilihNasabah('{{ $n->id_nasabah }}', '{{ $n->nama }}', '{{ $n->rekening->no_rek ?? '-' }}', {{ $n->rekening->saldo ?? 0 }})"
                                                class="px-4 py-3 hover:bg-mintLight cursor-pointer border-b border-slate-100 last:border-0 transition-colors">
                                                <p class="text-sm font-bold text-slate-900 font-mono">No. Rek: {{ $n->rekening->no_rek ?? '-' }}</p>
                                                <p class="text-xs text-slate-500 mt-0.5">Nama: {{ $n->nama }} · NISN: {{ $n->user->username ?? '-' }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('id_nasabah') <p class="text-xs text-red-600 mt-1.5 font-semibold">{{ $message }}</p> @enderror
                                </div>

                                <!-- Nasabah Info -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                                        <input type="hidden" name="id_nasabah" id="id_nasabah">
                                        <div class="px-4 py-3 bg-mintLight border border-mint/20 rounded-xl min-h-[46px] flex items-center">
                                            <p id="displayNama" class="text-sm font-bold text-forest">-</p>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">No. Rekening</label>
                                        <div class="px-4 py-3 bg-mintLight border border-mint/20 rounded-xl min-h-[46px] flex items-center">
                                            <p id="displayNoRek" class="text-sm font-bold text-forest font-mono">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Setoran -->
                            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 lg:p-6">
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-10 h-10 bg-mintLight rounded-xl flex items-center justify-center">
                                        <i class="fas fa-coins text-forest"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-extrabold text-slate-900">Detail Setoran</h3>
                                        <p class="text-[11px] text-slate-500">Masukkan nominal dan keterangan setoran</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Jumlah Setoran <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-forest text-sm font-extrabold">Rp</span>
                                        <input type="number" name="jumlah" id="nominalSetoran" value="{{ old('jumlah') }}" min="1000" step="1000"
                                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base font-extrabold text-slate-900 focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all text-right"
                                            placeholder="0" required>
                                    </div>
                                    @error('jumlah') <p class="text-xs text-red-600 mt-1.5 font-semibold">{{ $message }}</p> @enderror

                                    <div class="grid grid-cols-4 gap-2 mt-3">
                                        <button type="button" onclick="setNominal(50000)" class="py-2 bg-slate-50 border border-slate-200 rounded-lg text-[11px] font-bold text-slate-600 hover:bg-mintLight hover:border-mint/30 hover:text-forest transition-colors">50K</button>
                                        <button type="button" onclick="setNominal(100000)" class="py-2 bg-slate-50 border border-slate-200 rounded-lg text-[11px] font-bold text-slate-600 hover:bg-mintLight hover:border-mint/30 hover:text-forest transition-colors">100K</button>
                                        <button type="button" onclick="setNominal(200000)" class="py-2 bg-slate-50 border border-slate-200 rounded-lg text-[11px] font-bold text-slate-600 hover:bg-mintLight hover:border-mint/30 hover:text-forest transition-colors">200K</button>
                                        <button type="button" onclick="setNominal(500000)" class="py-2 bg-slate-50 border border-slate-200 rounded-lg text-[11px] font-bold text-slate-600 hover:bg-mintLight hover:border-mint/30 hover:text-forest transition-colors">500K</button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Keterangan <span class="text-red-500">*</span></label>
                                    <textarea name="keterangan" rows="2" placeholder="Contoh: Setoran tunai dari tabungan mingguan"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all resize-none" required>{{ old('keterangan') }}</textarea>
                                    @error('keterangan') <p class="text-xs text-red-600 mt-1.5 font-semibold">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Ringkasan -->
                        <div class="lg:col-span-1">
                            <div class="gradient-forest rounded-2xl p-5 lg:p-6 shadow-xl shadow-forest/20 text-white lg:sticky lg:top-6 relative overflow-hidden">
                                <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                                <div class="relative z-10">
                                    <h3 class="text-sm font-extrabold mb-5 flex items-center gap-2">
                                        <i class="fas fa-receipt text-mint"></i> Ringkasan Transaksi
                                    </h3>

                                    <div class="space-y-3 mb-5 text-sm">
                                        <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                            <span class="text-xs text-emerald-100 font-medium">Jenis Transaksi</span>
                                            <span class="text-xs font-extrabold text-white">Setoran</span>
                                        </div>
                                        <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                            <span class="text-xs text-emerald-100 font-medium">Saldo Saat Ini</span>
                                            <span class="text-sm font-extrabold text-white" id="summarySaldo">Rp 0</span>
                                        </div>
                                        <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                            <span class="text-xs text-emerald-100 font-medium">Nominal Setor</span>
                                            <span class="text-sm font-extrabold text-emerald-300" id="summaryNominal">Rp 0</span>
                                        </div>
                                        <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                            <span class="text-xs text-emerald-100 font-medium">Biaya Admin</span>
                                            <span class="text-xs font-extrabold text-white">Rp 0</span>
                                        </div>
                                        <div class="flex justify-between items-center pt-2 bg-white/5 rounded-xl px-3 py-2 -mx-1">
                                            <span class="text-xs text-emerald-100 font-bold">Estimasi Saldo Baru</span>
                                            <span class="text-base font-black text-emerald-300" id="summaryTotal">Rp 0</span>
                                        </div>
                                    </div>

                                    <button type="button" onclick="openModal()" class="w-full py-3 bg-mint hover:bg-emerald-500 text-white rounded-xl font-extrabold transition-colors flex items-center justify-center gap-2 text-sm shadow-lg shadow-mint/30 mb-2">
                                        <i class="fas fa-check-circle text-xs"></i> Proses Setoran
                                    </button>

                                    <a href="{{ route('operator.transaksi.index') }}" class="w-full py-2.5 border border-white/20 text-white/90 rounded-xl font-bold hover:bg-white/10 transition-colors text-sm text-center block">
                                        Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- ═══ MODAL KONFIRMASI (elegan, gak jamet) ═══ -->
    <div id="confirmModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-forestDark/60 backdrop-blur-sm backdrop-in" onclick="closeModal()"></div>

        <!-- Modal Card -->
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden modal-in">
            <!-- Top gradient strip -->
            <div class="gradient-forest px-6 py-6 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shield-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold">Konfirmasi Setoran</h3>
                        <p class="text-xs text-emerald-100 mt-0.5">Pastikan data sudah benar sebelum diproses</p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-3">
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                    <span class="text-xs text-slate-500 font-semibold">Nama Nasabah</span>
                    <span id="modalNama" class="text-sm font-extrabold text-slate-900 text-right">-</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                    <span class="text-xs text-slate-500 font-semibold">No. Rekening</span>
                    <span id="modalNoRek" class="text-sm font-extrabold text-slate-900 font-mono">-</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                    <span class="text-xs text-slate-500 font-semibold">Nominal Setor</span>
                    <span id="modalNominal" class="text-sm font-extrabold text-mint">Rp 0</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100">
                    <span class="text-xs text-slate-500 font-semibold">Keterangan</span>
                    <span id="modalKeterangan" class="text-xs font-semibold text-slate-700 text-right max-w-[180px] truncate">-</span>
                </div>
                <div class="flex justify-between items-center pt-3 bg-mintLight rounded-xl px-4 py-3 border border-mint/20">
                    <span class="text-xs text-forest font-extrabold">Estimasi Saldo Baru</span>
                    <span id="modalTotal" class="text-base font-black text-forest">Rp 0</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="p-6 pt-0 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </button>
                <button type="button" onclick="submitForm()" class="flex-1 py-3 bg-mint hover:bg-forest text-white rounded-xl font-extrabold text-sm transition-colors flex items-center justify-center gap-2 shadow-md shadow-mint/20">
                    <i class="fas fa-check text-xs"></i> Ya, Proses
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentSaldo = 0;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        function filterNasabah() {
            const searchValue = document.getElementById('searchNama').value.toLowerCase();
            const dropdown = document.getElementById('dropdownNasabah');
            const items = dropdown.getElementsByClassName('cursor-pointer');

            let hasVisible = false;
            for (let item of items) {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                    item.style.display = 'block';
                    hasVisible = true;
                } else {
                    item.style.display = 'none';
                }
            }

            if (searchValue.length > 0 && hasVisible) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }

        function cariNasabah() {
            filterNasabah();
        }

        function pilihNasabah(id, nama, norek, saldo) {
            document.getElementById('id_nasabah').value = id;
            document.getElementById('displayNama').textContent = nama;
            document.getElementById('displayNoRek').textContent = norek;
            document.getElementById('searchNama').value = nama;
            document.getElementById('dropdownNasabah').classList.add('hidden');

            currentSaldo = saldo;
            updateSummary();
        }

        function setNominal(amount) {
            document.getElementById('nominalSetoran').value = amount;
            updateSummary();
        }

        function updateSummary() {
            const nominal = parseInt(document.getElementById('nominalSetoran').value) || 0;
            const saldoBaru = currentSaldo + nominal;

            document.getElementById('summarySaldo').textContent = 'Rp ' + currentSaldo.toLocaleString('id-ID');
            document.getElementById('summaryNominal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
            document.getElementById('summaryTotal').textContent = 'Rp ' + saldoBaru.toLocaleString('id-ID');
        }

        document.addEventListener('click', function (event) {
            const searchBox = document.getElementById('searchNama');
            const dropdown = document.getElementById('dropdownNasabah');

            if (searchBox && dropdown && !searchBox.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // ═══ MODAL HANDLER ═══
        function openModal() {
            const idNasabah = document.getElementById('id_nasabah').value;
            const nama = document.getElementById('displayNama').textContent;
            const norek = document.getElementById('displayNoRek').textContent;
            const nominal = parseInt(document.getElementById('nominalSetoran').value) || 0;
            const keterangan = document.querySelector('textarea[name="keterangan"]').value;

            // Validasi
            if (!idNasabah) {
                alert('Silakan pilih nasabah terlebih dahulu!');
                return;
            }
            if (nominal < 1000) {
                alert('Jumlah setoran minimal Rp 1.000!');
                return;
            }
            if (!keterangan.trim()) {
                alert('Keterangan wajib diisi!');
                return;
            }

            // Isi modal
            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalNoRek').textContent = norek;
            document.getElementById('modalNominal').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
            document.getElementById('modalKeterangan').textContent = keterangan;
            document.getElementById('modalTotal').textContent = 'Rp ' + (currentSaldo + nominal).toLocaleString('id-ID');

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
            document.getElementById('formSetoran').submit();
        }

        // Init
        updateSummary();
        document.getElementById('nominalSetoran').addEventListener('input', updateSummary);
    </script>
</body>
</html>