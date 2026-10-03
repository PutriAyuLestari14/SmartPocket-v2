<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Keuangan - SmartPocket</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

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
        .table-scroll { -webkit-overflow-scrolling: touch; scrollbar-width: thin; }
    </style>
</head>

<body class="bg-bgMain text-slate-800 antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-forestDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-sm">

            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center shadow-md shadow-forest/20">
                            <i class="fas fa-wallet text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-base font-extrabold text-forest tracking-tight">SmartPocket</h1>
                            <p class="text-[10px] text-mint font-bold tracking-wider">ADMIN PANEL</p>
                        </div>
                    </div>
                    <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-forest p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-chart-line w-5 text-center text-slate-400"></i> Dashboard
                </a>

                <a href="{{ route('admin.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Data Nasabah
                </a>

                <a href="{{ route('admin.saldo.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-wallet w-5 text-center text-slate-400"></i> Update Saldo
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">
                    <i class="fas fa-money-bill-transfer w-5 text-center text-mint"></i> Laporan
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

        {{-- CONTENT --}}
        <main class="flex-1 lg:ml-64 min-w-0">

            {{-- Mobile Top Bar --}}
            <header class="lg:hidden bg-white border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center text-white shadow-md shadow-forest/20 flex-shrink-0">
                        <i class="fas fa-wallet text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-forest tracking-tight leading-none">Smart Pocket</h1>
                        <p class="text-[10px] text-mint font-bold tracking-wider mt-1">Admin Panel</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform">
                    <i class="fas fa-bars text-base"></i>
                </button>
            </header>

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                {{-- HEADER --}}
                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">

                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1 flex-wrap">
                            <span>Admin</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-forest font-bold">Laporan Keuangan</span>
                        </div>

                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            Laporan Keuangan
                        </h2>

                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Rekap neraca berdasarkan periode transaksi.
                        </p>
                    </div>

                    {{-- PILIH BULAN --}}
                    <form
                        action="{{ route('admin.laporan.index') }}"
                        method="GET"
                        class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl p-1.5 shadow-sm flex-shrink-0"
                    >
                        <label
                            for="periode"
                            class="text-xs font-bold text-slate-500 px-2 uppercase tracking-wider"
                        >
                            <i class="fas fa-calendar text-forest"></i> Periode
                        </label>

                        <input
                            type="month"
                            name="periode"
                            id="periode"
                            value="{{ $periode }}"
                            class="border-0 rounded-lg px-3 py-2 bg-slate-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-mint/30 focus:bg-white transition-all"
                            onchange="this.form.submit()"
                        >
                    </form>

                </header>

                {{-- PERIODE INFO --}}
                <div class="gradient-forest rounded-2xl p-5 text-white shadow-lg shadow-forest/20 relative overflow-hidden">
                    <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10 flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar-check text-white"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-emerald-100 uppercase tracking-widest font-bold">Periode Laporan</p>
                            <h3 class="text-lg lg:text-xl font-black mt-0.5">
                                {{ $tanggalMulai->translatedFormat('F Y') }}
                            </h3>
                        </div>
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

                    <div class="p-4 lg:p-5 border-b border-slate-100 flex items-center gap-2">
                        <div class="w-1 h-5 bg-gradient-to-b from-mint to-forest rounded-full"></div>
                        <h3 class="text-sm font-extrabold text-slate-900">Neraca Saldo</h3>
                    </div>

                    <div class="overflow-x-auto table-scroll">
                        <table class="w-full border-collapse min-w-[1000px]">

                            <thead>

                                {{-- HEADER UTAMA --}}
                                <tr class="bg-slate-800 text-white">

                                    <th rowspan="2" class="px-3 lg:px-4 py-3 lg:py-4 text-left text-[10px] lg:text-xs font-extrabold uppercase tracking-wider border-r border-slate-600 w-20">
                                        Kode
                                    </th>

                                    <th rowspan="2" class="px-3 lg:px-4 py-3 lg:py-4 text-left text-[10px] lg:text-xs font-extrabold uppercase tracking-wider border-r border-slate-600 min-w-[180px]">
                                        Nama Akun
                                    </th>

                                    <th colspan="2" class="px-3 lg:px-4 py-3 text-center text-[10px] lg:text-xs font-extrabold uppercase tracking-wider border-r border-slate-600">
                                        Neraca Awal
                                    </th>

                                    <th colspan="2" class="px-3 lg:px-4 py-3 text-center text-[10px] lg:text-xs font-extrabold uppercase tracking-wider border-r border-slate-600">
                                        Mutasi {{ $tanggalMulai->translatedFormat('F') }}
                                    </th>

                                    <th colspan="2" class="px-3 lg:px-4 py-3 text-center text-[10px] lg:text-xs font-extrabold uppercase tracking-wider">
                                        Saldo Akhir
                                    </th>

                                </tr>

                                {{-- SUB HEADER --}}
                                <tr class="bg-slate-100 text-slate-600">

                                    <th class="px-3 lg:px-4 py-2.5 text-center text-[10px] font-extrabold uppercase tracking-wider border-r w-32">
                                        Debit
                                    </th>

                                    <th class="px-3 lg:px-4 py-2.5 text-center text-[10px] font-extrabold uppercase tracking-wider border-r w-32">
                                        Kredit
                                    </th>

                                    <th class="px-3 lg:px-4 py-2.5 text-center text-[10px] font-extrabold uppercase tracking-wider border-r w-32">
                                        Debit
                                    </th>

                                    <th class="px-3 lg:px-4 py-2.5 text-center text-[10px] font-extrabold uppercase tracking-wider border-r w-32">
                                        Kredit
                                    </th>

                                    <th class="px-3 lg:px-4 py-2.5 text-center text-[10px] font-extrabold uppercase tracking-wider border-r w-32">
                                        Debit
                                    </th>

                                    <th class="px-3 lg:px-4 py-2.5 text-center text-[10px] font-extrabold uppercase tracking-wider w-32">
                                        Kredit
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($akun as $item)

                                    <tr class="border-t border-slate-200 hover:bg-mintLight/20 transition-colors">

                                        {{-- KODE --}}
                                        <td class="px-3 lg:px-4 py-4 text-xs lg:text-sm font-extrabold text-forest">
                                            {{ $item['kode'] }}
                                        </td>

                                        {{-- NAMA --}}
                                        <td class="px-3 lg:px-4 py-4 text-xs lg:text-sm font-bold text-slate-800">
                                            {{ $item['nama'] }}
                                        </td>

                                        {{-- NERACA AWAL DEBIT --}}
                                        <td class="px-3 lg:px-4 py-4 text-center border-l border-slate-100">

                                            @if ($item['awal_debit'] > 0)

                                                <div class="text-xs lg:text-sm font-extrabold text-slate-800 whitespace-nowrap">
                                                    Rp {{ number_format($item['awal_debit'], 0, ',', '.') }}
                                                </div>

                                                <div class="text-[9px] lg:text-[10px] text-slate-400 mt-1 font-semibold">
                                                    saldo awal
                                                </div>

                                            @else

                                                <span class="text-slate-300 text-sm">
                                                    —
                                                </span>

                                            @endif

                                        </td>

                                        {{-- NERACA AWAL KREDIT --}}
                                        <td class="px-3 lg:px-4 py-4 text-center border-r border-slate-100">

                                            @if ($item['awal_kredit'] > 0)

                                                <div class="text-xs lg:text-sm font-extrabold text-slate-800 whitespace-nowrap">
                                                    Rp {{ number_format($item['awal_kredit'], 0, ',', '.') }}
                                                </div>

                                                <div class="text-[9px] lg:text-[10px] text-slate-400 mt-1 font-semibold">
                                                    saldo awal
                                                </div>

                                            @else

                                                <span class="text-slate-300 text-sm">
                                                    —
                                                </span>

                                            @endif

                                        </td>

                                        {{-- MUTASI DEBIT --}}
                                        <td class="px-3 lg:px-4 py-4 text-center">

                                            @if ($item['mutasi_debit'] > 0)

                                                <div class="text-xs lg:text-sm font-extrabold text-slate-800 whitespace-nowrap">
                                                    Rp {{ number_format($item['mutasi_debit'], 0, ',', '.') }}
                                                </div>

                                                <div class="text-[9px] lg:text-[10px] text-slate-400 mt-1 font-semibold">
                                                    mutasi bulan
                                                </div>

                                            @else

                                                <span class="text-slate-300 text-sm">
                                                    —
                                                </span>

                                            @endif

                                        </td>

                                        {{-- MUTASI KREDIT --}}
                                        <td class="px-3 lg:px-4 py-4 text-center border-r border-slate-100">

                                            @if ($item['mutasi_kredit'] > 0)

                                                <div class="text-xs lg:text-sm font-extrabold text-slate-800 whitespace-nowrap">
                                                    Rp {{ number_format($item['mutasi_kredit'], 0, ',', '.') }}
                                                </div>

                                                <div class="text-[9px] lg:text-[10px] text-slate-400 mt-1 font-semibold">
                                                    mutasi bulan
                                                </div>

                                            @else

                                                <span class="text-slate-300 text-sm">
                                                    —
                                                </span>

                                            @endif

                                        </td>

                                        {{-- SALDO AKHIR DEBIT --}}
                                        <td class="px-3 lg:px-4 py-4 text-center">

                                            @if ($item['akhir_debit'] > 0)

                                                <div class="text-xs lg:text-sm font-extrabold text-forest whitespace-nowrap">
                                                    Rp {{ number_format($item['akhir_debit'], 0, ',', '.') }}
                                                </div>

                                                <div class="text-[9px] lg:text-[10px] text-slate-400 mt-1 font-semibold">
                                                    saldo akhir
                                                </div>

                                            @else

                                                <span class="text-slate-300 text-sm">
                                                    —
                                                </span>

                                            @endif

                                        </td>

                                        {{-- SALDO AKHIR KREDIT --}}
                                        <td class="px-3 lg:px-4 py-4 text-center">

                                            @if ($item['akhir_kredit'] > 0)

                                                <div class="text-xs lg:text-sm font-extrabold text-forest whitespace-nowrap">
                                                    Rp {{ number_format($item['akhir_kredit'], 0, ',', '.') }}
                                                </div>

                                                <div class="text-[9px] lg:text-[10px] text-slate-400 mt-1 font-semibold">
                                                    saldo akhir
                                                </div>

                                            @else

                                                <span class="text-slate-300 text-sm">
                                                    —
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                                {{-- TOTAL --}}
                                <tr class="gradient-forest text-white">

                                    <td colspan="2" class="px-3 lg:px-4 py-4 font-black text-xs lg:text-sm uppercase tracking-wider">
                                        Total
                                    </td>

                                    <td class="px-3 lg:px-4 py-4 text-center text-xs lg:text-sm font-black whitespace-nowrap">
                                        Rp {{ number_format($totalAwalDebit, 0, ',', '.') }}
                                    </td>

                                    <td class="px-3 lg:px-4 py-4 text-center text-xs lg:text-sm font-black border-r border-white/20 whitespace-nowrap">
                                        Rp {{ number_format($totalAwalKredit, 0, ',', '.') }}
                                    </td>

                                    <td class="px-3 lg:px-4 py-4 text-center text-xs lg:text-sm font-black whitespace-nowrap">
                                        Rp {{ number_format($totalMutasiDebit, 0, ',', '.') }}
                                    </td>

                                    <td class="px-3 lg:px-4 py-4 text-center text-xs lg:text-sm font-black border-r border-white/20 whitespace-nowrap">
                                        Rp {{ number_format($totalMutasiKredit, 0, ',', '.') }}
                                    </td>

                                    <td class="px-3 lg:px-4 py-4 text-center text-xs lg:text-sm font-black whitespace-nowrap">
                                        Rp {{ number_format($totalAkhirDebit, 0, ',', '.') }}
                                    </td>

                                    <td class="px-3 lg:px-4 py-4 text-center text-xs lg:text-sm font-black whitespace-nowrap">
                                        Rp {{ number_format($totalAkhirKredit, 0, ',', '.') }}
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- KETERANGAN --}}
                <div class="bg-mintLight/50 border border-mint/20 rounded-2xl p-4 lg:p-5 flex items-start gap-3">
                    <div class="w-8 h-8 bg-mint rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info text-white text-xs"></i>
                    </div>
                    <p class="text-[11px] lg:text-xs text-forest/80 leading-relaxed font-semibold">
                        <strong>Catatan:</strong>
                        Neraca awal merupakan posisi akun sebelum periode yang dipilih.
                        Mutasi merupakan transaksi yang terjadi selama periode tersebut.
                        Saldo akhir merupakan hasil posisi akun setelah memperhitungkan mutasi periode.
                    </p>
                </div>

            </div>

        </main>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>

</body>
</html>