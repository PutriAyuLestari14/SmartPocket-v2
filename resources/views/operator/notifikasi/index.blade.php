<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Operator Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAFAFA; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #FAFAFA; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }

        .gradient-primary { background: linear-gradient(135deg, #15803d 0%, #166534 100%); }
        .gradient-forest { background: linear-gradient(135deg, #1A4D2E 0%, #123720 100%); }

        @keyframes softPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .pulse-dot { animation: softPulse 1.8s ease-in-out infinite; }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased min-h-screen selection:bg-mintLight selection:text-primary">

    <!-- HEADER / NAVBAR ATAS -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center text-white shadow-md shadow-primary/20">
                    <i class="fas fa-bell text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-black text-primary leading-tight">Pusat Notifikasi</h1>
                    <p class="text-xs text-slate-400 font-bold">Informasi & Aktivitas Operator</p>
                </div>
            </div>

            <a href="{{ route('operator.dashboard') }}" class="px-4 py-2 bg-mintLight hover:bg-primary/10 text-primary border border-primary/20 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shadow-sm">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-8">

        <!-- SUB HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Notifikasi Kamu</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar pengajuan dari nasabah yang menunggu verifikasi Anda.</p>
            </div>

            @if($totalPending > 0)
                <div class="shrink-0 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-amber-600">{{ $totalPending }}</span>
                    <span class="text-xs font-semibold text-slate-500">menunggu tindakan</span>
                </div>
            @endif
        </div>

        <!-- LIST NOTIFIKASI -->
        <div class="space-y-3.5">

            <!-- ============================= -->
            <!-- PENARIKAN -->
            <!-- ============================= -->
            @if($penarikanPending->count() > 0)
                <div class="mb-3">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-arrow-up text-amber-600 text-xs"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Penarikan</h3>
                            <p class="text-[11px] text-slate-400">Menunggu verifikasi</p>
                        </div>
                    </div>

                    <div class="space-y-3.5">
                        @foreach($penarikanPending as $trx)
                            <div class="bg-white rounded-2xl border border-primary/30 ring-1 ring-primary/10 transition-all duration-200 p-5 shadow-sm hover:shadow-md relative overflow-hidden flex items-start justify-between gap-4">
                                <!-- GARIS HIJAU DISAMPING -->
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary"></div>

                                <div class="flex items-start gap-4 flex-1">
                                    <!-- ICON -->
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5 bg-mintLight text-primary">
                                        <i class="fas fa-arrow-up text-base"></i>
                                    </div>

                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <h3 class="text-sm font-black text-primaryDark">
                                                {{ $trx->rekening->nasabah->nama }}
                                            </h3>
                                            <span class="px-2 py-0.5 bg-primary text-white text-[10px] font-black uppercase tracking-wider rounded-full">
                                                Baru
                                            </span>
                                        </div>

                                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                            Mengajukan penarikan saldo sebesar <strong class="text-slate-900">Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</strong>
                                        </p>

                                        <div class="flex items-center gap-2 text-[11px] font-bold text-slate-400">
                                            <i class="far fa-clock"></i>
                                            <span>{{ $trx->tanggal_transaksi->timezone('Asia/Jakarta')->format('d M Y • H:i') }} WIB</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- TOMBOL AKSI -->
                                <a href="{{ route('operator.verifikasi.index') }}" class="shrink-0 inline-flex items-center gap-2 px-3 py-2 bg-primary hover:bg-primaryDark text-white text-xs font-bold rounded-xl shadow-md shadow-primary/20 transition-all" title="Proses Verifikasi">
                                    <i class="fas fa-check text-xs"></i>
                                    <span class="hidden sm:inline">Proses</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- ============================= -->
            <!-- PEMINJAMAN -->
            <!-- ============================= -->
            @if($peminjamanPending->count() > 0)
                <div class="mb-3">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-hand-holding-dollar text-emerald-600 text-xs"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Pengajuan Pinjaman</h3>
                            <p class="text-[11px] text-slate-400">Menunggu verifikasi</p>
                        </div>
                    </div>

                    <div class="space-y-3.5">
                        @foreach($peminjamanPending as $pinjaman)
                            <div class="bg-white rounded-2xl border border-primary/30 ring-1 ring-primary/10 transition-all duration-200 p-5 shadow-sm hover:shadow-md relative overflow-hidden flex items-start justify-between gap-4">
                                <!-- GARIS HIJAU DISAMPING -->
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary"></div>

                                <div class="flex items-start gap-4 flex-1">
                                    <!-- ICON -->
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5 bg-mintLight text-primary">
                                        <i class="fas fa-hand-holding-dollar text-base"></i>
                                    </div>

                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <h3 class="text-sm font-black text-primaryDark">
                                                {{ $pinjaman->nasabah->nama }}
                                            </h3>
                                            <span class="px-2 py-0.5 bg-primary text-white text-[10px] font-black uppercase tracking-wider rounded-full">
                                                Baru
                                            </span>
                                        </div>

                                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-2">
                                            Mengajukan pinjaman baru sebesar <strong class="text-slate-900">Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</strong>
                                        </p>

                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold">
                                                Tenor {{ $pinjaman->tenor }} bulan
                                            </span>
                                            <span class="px-2.5 py-1 bg-mintLight text-primaryDark rounded-lg text-[10px] font-bold">
                                                Pending
                                            </span>
                                        </div>

                                        <div class="flex items-center gap-2 text-[11px] font-bold text-slate-400">
                                            <i class="far fa-clock"></i>
                                            <span>{{ \Carbon\Carbon::parse($pinjaman->tanggal_ajuan)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- TOMBOL AKSI -->
                                <a href="{{ route('operator.peminjaman.index') }}" class="shrink-0 inline-flex items-center gap-2 px-3 py-2 bg-primary hover:bg-primaryDark text-white text-xs font-bold rounded-xl shadow-md shadow-primary/20 transition-all" title="Proses Pengajuan">
                                    <i class="fas fa-check text-xs"></i>
                                    <span class="hidden sm:inline">Proses</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- ============================= -->
            <!-- EMPTY STATE -->
            <!-- ============================= -->
            @if($penarikanPending->count() === 0 && $peminjamanPending->count() === 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-mintLight text-primary rounded-2xl flex items-center justify-center mx-auto mb-4 border border-primary/20">
                        <i class="fas fa-bell-slash text-2xl"></i>
                    </div>
                    <h3 class="text-base font-black text-slate-900">Belum Ada Notifikasi</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Notifikasi baru terkait pengajuan penarikan dan peminjaman dari nasabah akan muncul di sini.</p>
                </div>
            @endif

        </div>

        <!-- Footer -->
        <p class="mt-10 text-center text-[10px] text-slate-400 font-semibold">
            Smart Pocket • BMT SMKN 11 Bandung
        </p>

    </main>

</body>
</html>