<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Notifikasi - Operator Smart Pocket</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAFAFA;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }

        .gradient-forest {
            background: linear-gradient(135deg, #1A4D2E 0%, #123720 100%);
        }

        @keyframes softPulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .pulse-dot {
            animation: softPulse 1.8s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-bgMain text-slate-800 antialiased">

    <!-- Top Bar -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200/70 sticky top-0 z-30">

        <div class="max-w-2xl mx-auto px-4 lg:px-6 py-3.5 flex items-center justify-between">

            <a href="{{ route('operator.dashboard') }}"
                class="flex items-center gap-3 group">

                <div
                    class="w-9 h-9 bg-forest rounded-xl flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform">

                    <i class="fas fa-wallet text-sm"></i>

                </div>

                <div>
                    <h1 class="text-sm font-extrabold text-forest leading-none">
                        Smart Pocket
                    </h1>

                    <p class="text-[9px] text-mint font-bold tracking-wider mt-0.5">
                        BMT SMKN 11
                    </p>
                </div>

            </a>

            <a href="{{ route('operator.notifikasi.index') }}"
                class="relative w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600">

                <i class="far fa-bell text-sm"></i>

                @if($totalPending > 0)
                    <span
                        class="absolute top-1 right-1 min-w-[17px] h-[17px] px-1 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center ring-2 ring-white">
                        {{ $totalPending }}
                    </span>
                @endif

            </a>

        </div>

    </header>


    <!-- Main -->
    <main class="max-w-2xl mx-auto px-4 lg:px-6 py-8 lg:py-12">

        <!-- Title -->
        <div class="mb-8">

            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">
                Notifikasi
            </p>

            <h2 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                Pengajuan Baru
            </h2>

            <p class="text-sm text-slate-500 mt-2">
                Pengajuan dari nasabah yang menunggu verifikasi Anda.
            </p>

        </div>


        <!-- Counter -->
        @if($totalPending > 0)

            <div class="flex items-baseline gap-2 mb-6">

                <span class="text-3xl font-black text-amber-600">
                    {{ $totalPending }}
                </span>

                <span class="text-sm font-semibold text-slate-500">
                    pengajuan menunggu tindakan
                </span>

            </div>

        @endif


        <!-- ============================= -->
        <!-- PENARIKAN -->
        <!-- ============================= -->

        @if($penarikanPending->count() > 0)

            <div class="mb-8">

                <div class="flex items-center gap-2 mb-4">

                    <div
                        class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">

                        <i class="fas fa-arrow-up text-amber-600 text-xs"></i>

                    </div>

                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900">
                            Penarikan
                        </h3>

                        <p class="text-[11px] text-slate-400">
                            Menunggu verifikasi
                        </p>
                    </div>

                </div>


                <div class="space-y-3">

                    @foreach($penarikanPending as $trx)

                        <div
                            class="bg-white rounded-2xl border border-slate-200/80 p-5 hover:border-mint/40 transition-colors">

                            <div class="flex items-start gap-4">

                                <!-- Icon -->
                                <div
                                    class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">

                                    <i class="fas fa-arrow-up text-amber-600 text-sm"></i>

                                </div>


                                <!-- Content -->
                                <div class="flex-1 min-w-0">

                                    <p class="text-sm font-bold text-slate-900 mb-1">
                                        {{ $trx->rekening->nasabah->nama }}
                                    </p>

                                    <p class="text-xs text-slate-500 mb-3">
                                        Mengajukan penarikan saldo
                                    </p>

                                    <div
                                        class="flex items-baseline justify-between gap-3 flex-wrap">

                                        <p class="text-lg font-black text-slate-900">
                                            Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                                        </p>

                                        <p class="text-[11px] text-slate-400 font-medium">

                                            {{ $trx->tanggal_transaksi
                                                ->timezone('Asia/Jakarta')
                                                ->format('d M Y • H:i') }}
                                            WIB

                                        </p>

                                    </div>


                                    <a href="{{ route('operator.verifikasi.index') }}"
                                        class="mt-4 inline-flex items-center gap-2 text-xs font-bold text-forest hover:text-mint transition-colors">

                                        Proses verifikasi

                                        <i class="fas fa-arrow-right text-[10px]"></i>

                                    </a>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @endif



        <!-- ============================= -->
        <!-- PEMINJAMAN -->
        <!-- ============================= -->

        @if($peminjamanPending->count() > 0)

            <div class="mb-8">

                <div class="flex items-center gap-2 mb-4">

                    <div
                        class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">

                        <i class="fas fa-hand-holding-dollar text-emerald-600 text-xs"></i>

                    </div>

                    <div>

                        <h3 class="text-sm font-extrabold text-slate-900">
                            Pengajuan Pinjaman
                        </h3>

                        <p class="text-[11px] text-slate-400">
                            Menunggu verifikasi
                        </p>

                    </div>

                </div>


                <div class="space-y-3">

                    @foreach($peminjamanPending as $pinjaman)

                        <div
                            class="bg-white rounded-2xl border border-slate-200/80 p-5 hover:border-mint/40 transition-colors">

                            <div class="flex items-start gap-4">

                                <!-- Icon -->
                                <div
                                    class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">

                                    <i
                                        class="fas fa-hand-holding-dollar text-emerald-600 text-sm">
                                    </i>

                                </div>


                                <!-- Content -->
                                <div class="flex-1 min-w-0">

                                    <p class="text-sm font-bold text-slate-900 mb-1">

                                        {{ $pinjaman->nasabah->nama }}

                                    </p>


                                    <p class="text-xs text-slate-500 mb-3">

                                        Mengajukan pinjaman baru

                                    </p>


                                    <div
                                        class="flex items-baseline justify-between gap-3 flex-wrap">

                                        <p class="text-lg font-black text-slate-900">

                                            Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}

                                        </p>


                                        <p class="text-[11px] text-slate-400 font-medium">

                                            {{ \Carbon\Carbon::parse($pinjaman->tanggal_ajuan)->format('d M Y') }}

                                        </p>

                                    </div>


                                    <div class="flex flex-wrap gap-2 mt-3">

                                        <span
                                            class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold">

                                            Tenor {{ $pinjaman->tenor }} bulan

                                        </span>


                                        <span
                                            class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[10px] font-bold">

                                            Pending

                                        </span>

                                    </div>


                                    <a href="{{ route('operator.peminjaman.index') }}"
                                        class="mt-4 inline-flex items-center gap-2 text-xs font-bold text-forest hover:text-mint transition-colors">

                                        Proses pengajuan

                                        <i class="fas fa-arrow-right text-[10px]"></i>

                                    </a>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @endif



        <!-- ============================= -->
        <!-- EMPTY STATE -->
        <!-- ============================= -->

        @if($penarikanPending->count() === 0 && $peminjamanPending->count() === 0)

            <div
                class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center">

                <div
                    class="w-14 h-14 bg-mintLight rounded-2xl flex items-center justify-center mx-auto mb-4">

                    <i class="fas fa-check text-mint text-xl"></i>

                </div>

                <p class="text-sm font-bold text-slate-900 mb-1">
                    Semua beres
                </p>

                <p class="text-xs text-slate-500">
                    Belum ada pengajuan baru saat ini.
                </p>

            </div>

        @endif


        <!-- Footer -->
        <p class="mt-10 text-center text-[10px] text-slate-400 font-semibold">
            Smart Pocket • BMT SMKN 11 Bandung
        </p>

    </main>

</body>

</html>