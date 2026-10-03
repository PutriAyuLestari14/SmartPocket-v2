<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Nasabah Baru - Smart Pocket</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

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
        .gradient-mint-soft { background: linear-gradient(135deg, #E8F5E9 0%, #ffffff 100%); }

        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        @keyframes backdropIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-in { animation: modalIn 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .backdrop-in { animation: backdropIn 0.2s ease-out; }

        .book-option {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .book-option.selected {
            border-color: #4E9F3D;
            background: linear-gradient(135deg, #E8F5E9 0%, #ffffff 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -10px rgba(78, 159, 61, 0.35);
        }
        .book-option.selected .book-radio {
            border-color: #4E9F3D;
            background: #4E9F3D;
        }
        .book-option.selected .book-radio::after {
            content: '';
            display: block;
            width: 7px;
            height: 7px;
            background: white;
            border-radius: 50%;
            margin: 3px auto;
        }
        .book-option.selected .book-icon {
            background: #4E9F3D;
            color: white;
            transform: scale(1.1);
        }
    </style>
</head>

<body class="bg-bgMain text-slate-800 antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop"
         class="fixed inset-0 bg-forestDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity"
         onclick="toggleSidebar()">
    </div>

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar"
               class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-sm">

            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center shadow-md shadow-forest/20">
                            <i class="fas fa-wallet text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-base font-extrabold text-forest tracking-tight">Smart Pocket</h1>
                            <p class="text-[10px] text-mint font-bold tracking-wider">BMT SMKN 11 BANDUNG</p>
                        </div>
                    </div>
                    <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-forest p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-2 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Menu Utama</p>

                <a href="{{ route('operator.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>

                <a href="{{ route('operator.nasabah.index') }}"
                   class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-users w-5 text-center text-mint"></i> Data Nasabah
                </a>

                <a href="{{ route('operator.transaksi.index') }}"
                   class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-exchange-alt w-5 text-center text-slate-400"></i> Transaksi
                </a>

                <a href="{{ route('operator.peminjaman.index') }}"
                   class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman
                </a>

                <a href="{{ route('operator.verifikasi.index') }}"
                   class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-check-circle w-5 text-center text-slate-400"></i> Verifikasi
                </a>

                <a href="{{ route('operator.laporan.index') }}"
                   class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-chart-bar w-5 text-center text-slate-400"></i> Laporan
                </a>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-600 text-sm font-bold py-2.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
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
                    <a href="{{ route('operator.notifikasi.index') }}"
                       class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 relative active:scale-95 transition-transform">
                        <i class="far fa-bell text-base"></i>
                        <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-mint rounded-full ring-2 ring-white"></span>
                    </a>

                    <button onclick="toggleSidebar()"
                            class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform">
                        <i class="fas fa-bars text-base"></i>
                    </button>
                </div>
            </header>

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- Header -->
                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1 flex-wrap">
                            <a href="{{ route('operator.nasabah.index') }}" class="hover:text-forest transition-colors">Data Nasabah</a>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-forest font-bold">Tambah Nasabah</span>
                        </div>

                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Tambah Nasabah Baru
                        </h2>

                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Masukkan data detail untuk mendaftarkan nasabah baru ke dalam sistem Mini Bank SMKN 11.
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

                        <a href="{{ route('operator.notifikasi.index') }}"
                           class="w-10 h-10 bg-white border border-slate-200/80 rounded-xl flex items-center justify-center text-slate-600 hover:text-forest hover:border-mint transition-all relative shadow-sm ml-1">
                            <i class="far fa-bell text-base"></i>
                            @php
                                $pendingNotif = \App\Models\DetailTabungan::where('status', 'pending')->count();
                            @endphp
                            @if($pendingNotif > 0)
                                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-mint rounded-full ring-2 ring-white"></span>
                            @endif
                        </a>
                    </div>
                </header>

                <!-- Error Message -->
                @if ($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl">
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

                <form id="formNasabah"
                      action="{{ route('operator.nasabah.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <!-- Informasi Dasar -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-5">
                        <div class="gradient-mint-soft px-5 lg:px-6 py-4 border-b border-mint/20">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 gradient-mint rounded-xl flex items-center justify-center shadow-md shadow-mint/30">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-extrabold text-slate-900">Informasi Dasar</h3>
                                    <p class="text-[11px] text-slate-500">Data identitas nasabah</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 lg:p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-5">

                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">
                                        NISN / NIP <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="username" id="inputUsername" value="{{ old('username') }}"
                                           placeholder="Masukkan Nomor Induk"
                                           class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all"
                                           required>
                                    <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-info-circle text-mint"></i>
                                        Digunakan sebagai username login
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nama" id="inputNama" value="{{ old('nama') }}"
                                           placeholder="Nama sesuai KTP/Kartu Pelajar"
                                           class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">
                                        No. Rekening <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="prefix" id="inputPrefix" value="{{ old('prefix') }}"
                                           placeholder="Sesuai angkatan siswa"
                                           maxlength="4"
                                           class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all"
                                           required>
                                    <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-info-circle text-mint"></i>
                                        Siswa: 2 digit angkatan. Guru: GT.
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">
                                        Jenis Nasabah <span class="text-red-500">*</span>
                                    </label>
                                    <select name="kategori" id="inputKategori"
                                            class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all cursor-pointer"
                                            required>
                                        <option value="">Pilih Jenis Nasabah</option>
                                        <option value="siswa" {{ old('kategori') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                        <option value="guru" {{ old('kategori') == 'guru' ? 'selected' : '' }}>Guru</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Kontak & Rekening -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-5">
                        <div class="gradient-mint-soft px-5 lg:px-6 py-4 border-b border-mint/20">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 gradient-mint rounded-xl flex items-center justify-center shadow-md shadow-mint/30">
                                    <i class="fas fa-address-book text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-extrabold text-slate-900">Kontak & Rekening</h3>
                                    <p class="text-[11px] text-slate-500">Alamat dan detail akun</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 lg:p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-5">

                                <div class="lg:col-span-2">
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">
                                        Alamat <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="alamat" id="inputAlamat" rows="3" placeholder="Masukkan alamat lengkap"
                                              class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all resize-none"
                                              required>{{ old('alamat') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">
                                        Saldo Awal (Rp)
                                    </label>
                                    <input type="number" name="saldo" id="inputSaldo" value="{{ old('saldo', 0) }}"
                                           placeholder="Rp 0" min="0" oninput="updatePembayaran()"
                                           class="w-full px-4 py-3 bg-gradient-to-br from-mintLight to-white border-2 border-mint/30 rounded-xl text-base font-black text-forest focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint transition-all text-right">
                                    <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                        <i class="fas fa-info-circle text-mint"></i>
                                        Masukan setoran awal
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">
                                        Password Akun
                                    </label>
                                    <div class="gradient-mint-soft border-2 border-mint/20 rounded-xl p-4">
                                        <p class="text-xs text-forest font-bold flex items-center gap-2 flex-wrap">
                                            <i class="fas fa-key"></i>
                                            Password default:
                                            <span class="font-mono bg-white px-2 py-0.5 rounded border border-mint/30">nasabah123</span>
                                        </p>
                                        <p class="text-[10px] text-forest/70 mt-1.5">
                                            Nasabah dapat mengubah password setelah login pertama.
                                        </p>
                                    </div>
                                </div>

                                <!-- BUKU TABUNGAN -->
                                <div class="lg:col-span-2">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest">
                                                Buku Tabungan
                                            </label>
                                            <p class="text-[11px] text-slate-500 mt-1">Pilih cara pembayaran buku tabungan</p>
                                        </div>
                                        <div class="w-10 h-10 rounded-xl bg-mintLight flex items-center justify-center">
                                            <i class="fas fa-book-open text-mint"></i>
                                        </div>
                                    </div>

                                    <input type="hidden" name="buku_tabungan" id="inputBuku" value="tidak">

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                                        <button type="button" onclick="selectBuku('tidak', this)"
                                                class="book-option selected text-left border-2 border-mint rounded-xl p-3"
                                                data-value="tidak">
                                            <div class="flex items-center gap-2.5">
                                                <div class="book-radio w-4 h-4 rounded-full border-2 border-mint bg-mint flex-shrink-0"></div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-extrabold text-slate-800">Tidak</p>
                                                    <p class="text-[10px] text-slate-500 mt-0.5 leading-snug">Hanya saldo awal.</p>
                                                </div>
                                            </div>
                                        </button>
                                        <button type="button" onclick="selectBuku('terpisah', this)"
                                                class="book-option text-left border-2 border-slate-200 rounded-xl p-3 bg-white"
                                                data-value="terpisah">
                                            <div class="flex items-center gap-2.5">
                                                <div class="book-radio w-4 h-4 rounded-full border-2 border-slate-300 bg-white flex-shrink-0"></div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-extrabold text-slate-800">Terpisah</p>
                                                    <p class="text-[10px] text-slate-500 mt-0.5 leading-snug">+Rp5.000 di luar saldo.</p>
                                                </div>
                                            </div>
                                        </button>

                                        <button type="button" onclick="selectBuku('potong', this)"
                                                class="book-option text-left border-2 border-slate-200 rounded-xl p-3 bg-white"
                                                data-value="potong">
                                            <div class="flex items-center gap-2.5">
                                                <div class="book-radio w-4 h-4 rounded-full border-2 border-slate-300 bg-white flex-shrink-0"></div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-extrabold text-slate-800">Potong Saldo</p>
                                                    <p class="text-[10px] text-slate-500 mt-0.5 leading-snug">-Rp5.000 dari saldo.</p>
                                                </div>
                                            </div>
                                        </button>
                                    </div>

                                    <!-- RINGKASAN PEMBAYARAN -->
                                    <div class="mt-5 rounded-2xl border border-slate-200 overflow-hidden">
                                        <div class="bg-gradient-to-r from-slate-50 to-white px-4 py-3 border-b border-slate-200 flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center">
                                                <i class="fas fa-receipt text-mint text-xs"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-extrabold text-slate-800">Ringkasan Pembayaran</p>
                                                <p class="text-[10px] text-slate-400">Perhitungan sementara</p>
                                            </div>
                                        </div>

                                        <div class="p-4 space-y-3 bg-white">
                                            <div class="flex justify-between items-center">
                                                <span class="text-xs text-slate-500 font-semibold">Saldo awal</span>
                                                <span id="summarySaldo" class="text-sm font-bold text-slate-800">Rp 0</span>
                                            </div>

                                            <div class="flex justify-between items-center">
                                                <span class="text-xs text-slate-500 font-semibold">Buku tabungan</span>
                                                <span id="summaryBuku" class="text-sm font-bold text-slate-800">Tidak</span>
                                            </div>

                                            <div class="border-t border-dashed border-slate-200 pt-3 mt-1 flex justify-between items-center">
                                                <div>
                                                    <p class="text-xs font-extrabold text-slate-800">Total dibayar nasabah</p>
                                                    <p id="summaryKeterangan" class="text-[10px] text-slate-400 mt-0.5">Hanya saldo awal</p>
                                                </div>
                                                <span id="summaryTotal" class="text-xl font-black text-mint">Rp 0</span>
                                            </div>

                                            <div class="gradient-mint-soft rounded-xl border-2 border-mint/20 px-3 py-2.5 flex justify-between items-center">
                                                <span class="text-[11px] font-extrabold text-forest">Saldo masuk rekening</span>
                                                <span id="summaryMasuk" class="text-sm font-extrabold text-forest">Rp 0</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">
                                        Tanggal Daftar <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tanggal_daftar" id="inputTanggal" value="{{ old('tanggal_daftar', date('Y-m-d')) }}"
                                           class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status" id="inputStatus"
                                            class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all cursor-pointer"
                                            required>
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('operator.nasabah.index') }}"
                           class="px-6 py-3 border-2 border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors text-sm text-center">
                            Batal
                        </a>

                        <button type="button" onclick="openModal()"
                                class="px-6 py-3 gradient-mint hover:opacity-90 text-white rounded-xl font-black flex items-center justify-center gap-2 transition-all shadow-lg shadow-mint/30 text-sm">
                            <i class="fas fa-save text-xs"></i> Simpan Data Nasabah
                        </button>
                    </div>

                </form>

            </div>

        </main>

    </div>

    <!-- MODAL KONFIRMASI -->
    <div id="confirmModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-forestDark/60 backdrop-blur-sm backdrop-in" onclick="closeModal()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden modal-in">
            <div class="gradient-mint px-6 py-6 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-plus text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold">Konfirmasi Data Nasabah</h3>
                        <p class="text-xs text-emerald-100 mt-0.5">Pastikan data dan pembayaran sudah benar</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-3 max-h-[65vh] overflow-y-auto">
                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold">NISN / NIP</span>
                    <span id="modalUsername" class="text-sm font-extrabold text-slate-900 font-mono text-right truncate">-</span>
                </div>

                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold">Nama Lengkap</span>
                    <span id="modalNama" class="text-sm font-extrabold text-slate-900 text-right truncate">-</span>
                </div>

                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold">No. Rekening</span>
                    <span id="modalPrefix" class="text-sm font-extrabold text-forest font-mono text-right">-</span>
                </div>

                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold">Jenis Nasabah</span>
                    <span id="modalKategori" class="text-[10px] font-extrabold text-forest px-2.5 py-1 bg-mintLight rounded-lg uppercase">-</span>
                </div>

                <div class="flex justify-between items-start py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold">Alamat</span>
                    <span id="modalAlamat" class="text-xs font-semibold text-slate-700 text-right max-w-[200px] line-clamp-2">-</span>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 mt-2">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg bg-mintLight flex items-center justify-center">
                            <i class="fas fa-wallet text-mint text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-slate-800">Pembayaran Awal</p>
                            <p class="text-[10px] text-slate-400">Ringkasan saat pendaftaran</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] text-slate-500">Saldo Awal</span>
                            <span id="modalSaldo" class="text-xs font-bold text-slate-800">Rp 0</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-[11px] text-slate-500">Buku Tabungan</span>
                            <span id="modalBuku" class="text-xs font-bold text-slate-800">Tidak</span>
                        </div>

                        <div class="border-t border-slate-200 pt-2 mt-2 flex justify-between items-center">
                            <span class="text-xs font-extrabold text-slate-800">Total Dibayar</span>
                            <span id="modalTotal" class="text-base font-black text-mint">Rp 0</span>
                        </div>

                        <div class="gradient-mint-soft rounded-lg border-2 border-mint/20 px-3 py-2 flex justify-between items-center">
                            <span class="text-[10px] font-semibold text-forest">Masuk ke saldo rekening</span>
                            <span id="modalMasuk" class="text-xs font-extrabold text-forest">Rp 0</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center py-2.5 border-b border-slate-100 gap-3">
                    <span class="text-xs text-slate-500 font-semibold">Tanggal Daftar</span>
                    <span id="modalTanggal" class="text-sm font-extrabold text-slate-900 text-right">-</span>
                </div>

                <div class="flex justify-between items-center pt-3 bg-mintLight rounded-xl px-4 py-3 border border-mint/20">
                    <span class="text-xs text-forest font-extrabold">Status Akun</span>
                    <span id="modalStatus" class="text-[10px] font-extrabold px-2.5 py-1 rounded-lg uppercase bg-white text-forest border border-mint/30">-</span>
                </div>
            </div>

            <div class="p-6 pt-0 flex gap-3">
                <button type="button" onclick="closeModal()"
                        class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </button>

                <button type="button" onclick="submitForm()"
                        class="flex-1 py-3 gradient-mint hover:opacity-90 text-white rounded-xl font-extrabold text-sm transition-all flex items-center justify-center gap-2 shadow-lg shadow-mint/30">
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

        const BIAYA_BUKU = 5000;

        function selectBuku(value, element) {
            document.getElementById('inputBuku').value = value;

            document.querySelectorAll('.book-option').forEach(option => {
                option.classList.remove('selected');
                option.classList.remove('border-mint');
                option.classList.add('border-slate-200');
                option.classList.remove('bg-mintLight');
                option.classList.add('bg-slate-50');

                const radio = option.querySelector('.book-radio');
                radio.classList.remove('border-mint');
                radio.classList.remove('bg-mint');
                radio.classList.add('border-slate-300');
                radio.classList.add('bg-white');
                radio.innerHTML = '';
            });

            element.classList.add('selected');

            const radio = element.querySelector('.book-radio');
            radio.classList.remove('border-slate-300');
            radio.classList.remove('bg-white');
            radio.classList.add('border-mint');
            radio.classList.add('bg-mint');

            updatePembayaran();
        }

        function formatRupiah(value) {
            return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
        }

        function updatePembayaran() {
            const saldo = Math.max(
                0,
                parseInt(document.getElementById('inputSaldo').value) || 0
            );

            const buku = document.getElementById('inputBuku').value;

            let totalBayar = saldo;
            let saldoMasuk = saldo;
            let bukuText = 'Tidak';
            let keterangan = 'Hanya saldo awal';

            if (buku === 'terpisah') {
                totalBayar = saldo + BIAYA_BUKU;
                saldoMasuk = saldo;
                bukuText = 'Bayar terpisah (+Rp5.000)';
                keterangan = 'Buku dibayar di luar saldo awal';
            }

            if (buku === 'potong') {
                totalBayar = saldo;
                saldoMasuk = Math.max(0, saldo - BIAYA_BUKU);
                bukuText = 'Potong dari saldo (-Rp5.000)';
                keterangan = 'Buku dipotong dari saldo awal';
            }

            document.getElementById('summarySaldo').textContent = formatRupiah(saldo);
            document.getElementById('summaryBuku').textContent = bukuText;
            document.getElementById('summaryTotal').textContent = formatRupiah(totalBayar);
            document.getElementById('summaryMasuk').textContent = formatRupiah(saldoMasuk);
            document.getElementById('summaryKeterangan').textContent = keterangan;
        }

        function openModal() {
            const username = document.getElementById('inputUsername').value.trim();
            const nama = document.getElementById('inputNama').value.trim();
            const prefix = document.getElementById('inputPrefix').value.trim();
            const kategori = document.getElementById('inputKategori').value;
            const alamat = document.getElementById('inputAlamat').value.trim();
            const saldo = parseInt(document.getElementById('inputSaldo').value) || 0;
            const tanggal = document.getElementById('inputTanggal').value;
            const status = document.getElementById('inputStatus').value;
            const buku = document.getElementById('inputBuku').value;

            if (!username) { alert('NISN / NIP wajib diisi!'); return; }
            if (!nama) { alert('Nama lengkap wajib diisi!'); return; }
            if (!prefix) { alert('No. Rekening wajib diisi!'); return; }
            if (!kategori) { alert('Jenis nasabah wajib dipilih!'); return; }
            if (!alamat) { alert('Alamat wajib diisi!'); return; }
            if (!tanggal) { alert('Tanggal daftar wajib diisi!'); return; }

            document.getElementById('modalUsername').textContent = username;
            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalPrefix').textContent = prefix;
            document.getElementById('modalKategori').textContent = kategori;
            document.getElementById('modalAlamat').textContent = alamat;

            let totalBayar = saldo;
            let saldoMasuk = saldo;
            let bukuText = 'Tidak';

            if (buku === 'terpisah') {
                totalBayar = saldo + BIAYA_BUKU;
                saldoMasuk = saldo;
                bukuText = 'Bayar terpisah (+Rp5.000)';
            }

            if (buku === 'potong') {
                totalBayar = saldo;
                saldoMasuk = Math.max(0, saldo - BIAYA_BUKU);
                bukuText = 'Potong dari saldo (-Rp5.000)';
            }

            document.getElementById('modalSaldo').textContent = formatRupiah(saldo);
            document.getElementById('modalBuku').textContent = bukuText;
            document.getElementById('modalTotal').textContent = formatRupiah(totalBayar);
            document.getElementById('modalMasuk').textContent = formatRupiah(saldoMasuk);

            document.getElementById('modalTanggal').textContent =
                new Date(tanggal).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

            document.getElementById('modalStatus').textContent = status;

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
            document.getElementById('formNasabah').submit();
        }

        updatePembayaran();
    </script>

</body>
</html>