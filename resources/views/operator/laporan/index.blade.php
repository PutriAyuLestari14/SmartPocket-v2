<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Umum - Smart Pocket</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-slate-50">

<div class="flex min-h-screen">

    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-screen z-40">

        {{-- Logo --}}
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">

                <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-sm">
                    <i class="fas fa-wallet text-white text-lg"></i>
                </div>

                <div>
                    <h1 class="text-lg font-bold text-slate-900">
                        Smart Pocket
                    </h1>

                    <p class="text-[10px] text-slate-500 font-medium">
                        BMT SMKN 11 BANDUNG
                    </p>
                </div>

            </div>
        </div>

        {{-- Navigation --}}
        <nav class="p-4 space-y-1 flex-1 overflow-y-auto scrollbar">

            <a href="{{ route('operator.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition">
                <i class="fas fa-home w-5 text-center"></i>
                Dashboard
            </a>

            <a href="{{ route('operator.nasabah.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition">
                <i class="fas fa-users w-5 text-center"></i>
                Data Nasabah
            </a>

            <a href="{{ route('operator.transaksi.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition">
                <i class="fas fa-exchange-alt w-5 text-center"></i>
                Transaksi
            </a>

            <a href="{{ route('operator.peminjaman.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition">
                <i class="fas fa-hand-holding-usd w-5 text-center"></i>
                Peminjaman
            </a>

            <a href="{{ route('operator.verifikasi.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition">
                <i class="fas fa-check-circle w-5 text-center"></i>
                Verifikasi
            </a>

            {{-- ACTIVE --}}
            <a href="{{ route('operator.laporan.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-semibold">
                <i class="fas fa-chart-bar w-5 text-center"></i>
                Laporan
            </a>

        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-gray-100">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="w-full bg-white border border-gray-200 hover:bg-red-50 hover:border-red-200 hover:text-red-600 text-slate-600 text-sm font-medium py-2.5 px-4 rounded-lg transition">

                    <i class="fas fa-sign-out-alt text-xs mr-2"></i>
                    Logout

                </button>
            </form>

        </div>

    </aside>


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}
    <main class="flex-1 ml-64 p-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

            <div>
                <div class="flex items-center gap-2 text-sm text-slate-400 mb-2">
                    <i class="fas fa-home text-xs"></i>
                    <span>/</span>
                    <span>Laporan</span>
                </div>

                <h1 class="text-2xl font-bold text-slate-900">
                    Jurnal Umum
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Catatan transaksi pinjaman dan pembayaran angsuran BMT.
                </p>
            </div>

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-slate-500"></i>
                </div>

                <div class="hidden sm:block">
                    <p class="text-sm font-semibold text-slate-800">
                        Operator
                    </p>
                    <p class="text-xs text-slate-400">
                        BMT Smart Pocket
                    </p>
                </div>

            </div>

        </div>


        {{-- =====================================================
             SUMMARY CARDS
        ====================================================== --}}
        @php
            $totalJurnal = $jurnal->count();
            $totalNominal = $jurnal->sum('nominal');
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            {{-- Card 1 --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                            Total Jurnal
                        </p>

                        <h3 class="text-2xl font-bold text-slate-900 mt-2">
                            {{ $totalJurnal }}
                        </h3>

                        <p class="text-xs text-slate-400 mt-1">
                            Data transaksi
                        </p>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <i class="fas fa-book text-emerald-600"></i>
                    </div>

                </div>

            </div>


            {{-- Card 2 --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                            Total Transaksi
                        </p>

                        <h3 class="text-xl font-bold text-slate-900 mt-2">
                            Rp {{ number_format($totalNominal, 0, ',', '.') }}
                        </h3>

                        <p class="text-xs text-slate-400 mt-1">
                            Nilai transaksi jurnal
                        </p>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-blue-600"></i>
                    </div>

                </div>

            </div>


            {{-- Card 3 --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                            Periode
                        </p>

                        <h3 class="text-base font-bold text-slate-900 mt-2">
                            @if($tanggalMulai && $tanggalSelesai)
                                {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }}
                                -
                                {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}
                            @else
                                Semua Data
                            @endif
                        </h3>

                        <p class="text-xs text-slate-400 mt-1">
                            Periode laporan
                        </p>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-purple-600"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             FILTER
        ====================================================== --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 mb-6">

            <div class="flex items-center gap-3 mb-5">

                <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                    <i class="fas fa-filter text-slate-600 text-sm"></i>
                </div>

                <div>
                    <h2 class="text-sm font-bold text-slate-800">
                        Filter Laporan
                    </h2>

                    <p class="text-xs text-slate-400">
                        Pilih periode transaksi yang ingin ditampilkan
                    </p>
                </div>

            </div>


            <form method="GET"
                  action="{{ route('operator.laporan.index') }}">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="tanggal_mulai"
                            value="{{ $tanggalMulai }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400"
                        >
                    </div>


                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2">
                            Tanggal Selesai
                        </label>

                        <input
                            type="date"
                            name="tanggal_selesai"
                            value="{{ $tanggalSelesai }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400"
                        >
                    </div>


                    <div class="flex items-end gap-2">

                        <button
                            type="submit"
                            class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl px-4 py-2.5 text-sm font-semibold transition">

                            <i class="fas fa-search mr-2"></i>
                            Tampilkan

                        </button>

                        <a
                            href="{{ route('operator.laporan.index') }}"
                            class="px-4 py-2.5 border border-gray-200 hover:bg-gray-50 text-slate-600 rounded-xl text-sm font-medium transition">

                            <i class="fas fa-undo"></i>

                        </a>

                    </div>

                </div>

            </form>

        </div>


        {{-- =====================================================
             JURNAL TABLE
        ====================================================== --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

            {{-- Table Header --}}
            <div class="px-6 py-5 border-b border-gray-100">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                    <div>
                        <h2 class="text-base font-bold text-slate-900">
                            Daftar Jurnal Umum
                        </h2>

                        <p class="text-xs text-slate-400 mt-1">
                            Riwayat pencatatan transaksi keuangan
                        </p>
                    </div>

                    <div class="flex items-center gap-2">

                        <span class="px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-semibold">
                            <i class="fas fa-circle text-[7px] mr-1"></i>
                            {{ $totalJurnal }} transaksi
                        </span>

                    </div>

                </div>

            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>
                        <tr class="bg-slate-50 border-b border-gray-100">

                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                Keterangan
                            </th>

                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                Debit
                            </th>

                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                Kredit
                            </th>

                            <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                Nominal
                            </th>

                        </tr>
                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @forelse($jurnal as $item)

                            <tr class="hover:bg-slate-50/70 transition">

                                {{-- Tanggal --}}
                                <td class="px-6 py-4 whitespace-nowrap">

                                    <div class="flex items-center gap-3">

                                        <div class="w-9 h-9 bg-slate-100 rounded-lg flex items-center justify-center">
                                            <i class="far fa-calendar text-slate-500 text-sm"></i>
                                        </div>

                                        <div>
                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}
                                            </p>

                                            <p class="text-[11px] text-slate-400">
                                                Transaksi
                                            </p>
                                        </div>

                                    </div>

                                </td>


                                {{-- Keterangan --}}
                                <td class="px-6 py-4">

                                    <p class="text-sm font-semibold text-slate-700">
                                        {{ $item['keterangan'] }}
                                    </p>

                                </td>


                                {{-- Debit --}}
                                <td class="px-6 py-4">

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-semibold">

                                        <i class="fas fa-arrow-down text-[10px]"></i>

                                        {{ $item['debit'] }}

                                    </span>

                                </td>


                                {{-- Kredit --}}
                                <td class="px-6 py-4">

                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold">

                                        <i class="fas fa-arrow-up text-[10px]"></i>

                                        {{ $item['kredit'] }}

                                    </span>

                                </td>


                                {{-- Nominal --}}
                                <td class="px-6 py-4 text-right whitespace-nowrap">

                                    <p class="text-sm font-bold text-slate-800">
                                        Rp {{ number_format($item['nominal'], 0, ',', '.') }}
                                    </p>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-16 text-center">

                                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-4">

                                        <i class="fas fa-book-open text-slate-300 text-2xl"></i>

                                    </div>

                                    <h3 class="text-sm font-bold text-slate-700">
                                        Belum Ada Jurnal
                                    </h3>

                                    <p class="text-xs text-slate-400 mt-1">
                                        Belum ada transaksi yang dapat ditampilkan pada periode ini.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Footer --}}
        <div class="mt-5 text-center">

            <p class="text-[11px] text-slate-400">
                Smart Pocket • BMT SMKN 11 Bandung
            </p>

        </div>

    </main>

</div>

</body>
</html>