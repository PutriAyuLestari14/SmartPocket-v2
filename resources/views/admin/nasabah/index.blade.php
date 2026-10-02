<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Nasabah - Admin Smart Pocket</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
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
            height: 6px;
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

        .gradient-mint {
            background: linear-gradient(135deg, #4E9F3D 0%, #1A4D2E 100%);
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-2px);
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        @keyframes backdropIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-in {
            animation: modalIn 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .backdrop-in {
            animation: backdropIn 0.2s ease-out;
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

        <!-- ================= SIDEBAR ================= -->

        <aside id="sidebar"
            class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-sm">

            <div class="p-6 border-b border-slate-100">

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div
                            class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center shadow-md shadow-forest/20">

                            <i class="fas fa-wallet text-white text-lg"></i>

                        </div>

                        <div>

                            <h1 class="text-base font-extrabold text-forest tracking-tight">
                                Smart Pocket
                            </h1>

                            <p class="text-[10px] text-mint font-bold tracking-wider">
                                ADMIN PANEL
                            </p>

                        </div>

                    </div>


                    <button onclick="toggleSidebar()"
                        class="lg:hidden text-slate-400 hover:text-forest p-1">

                        <i class="fas fa-times text-lg"></i>

                    </button>

                </div>

            </div>


            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">

                    <i class="fas fa-chart-line w-5 text-center text-slate-400"></i>

                    Dashboard

                </a>


                <a href="{{ route('admin.nasabah.index') }}"
                    class="flex items-center gap-3 px-4 py-3 bg-mintLight text-forest rounded-xl text-sm font-bold transition-all shadow-sm border border-mint/20">

                    <i class="fas fa-users w-5 text-center text-mint"></i>

                    Data Nasabah

                </a>


                <a href="{{ route('admin.saldo.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">

                    <i class="fas fa-wallet w-5 text-center text-slate-400"></i>

                    Update Saldo

                </a>


                <a href="{{ route('admin.laporan.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">

                    <i class="fas fa-money-bill-transfer w-5 text-center text-slate-400"></i>

                    Laporan

                </a>


                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-forest rounded-xl text-sm font-semibold transition-all">

                    <i class="fas fa-cog w-5 text-center text-slate-400"></i>

                    Pengaturan

                </a>

            </nav>


            <div class="p-4 border-t border-slate-100">

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                        class="w-full bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-600 text-sm font-bold py-2.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2">

                        <i class="fas fa-sign-out-alt text-xs"></i>

                        Logout

                    </button>

                </form>

            </div>

        </aside>


        <!-- ================= MAIN ================= -->

        <main class="flex-1 lg:ml-64 min-w-0">

            <!-- Mobile Top Bar -->

            <header
                class="lg:hidden bg-white border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <div
                        class="w-10 h-10 bg-forest rounded-xl flex items-center justify-center shadow-md shadow-forest/20 flex-shrink-0">

                        <i class="fas fa-wallet text-white text-lg"></i>

                    </div>

                    <div>

                        <h1 class="text-base font-extrabold text-forest tracking-tight leading-none">
                            Smart Pocket
                        </h1>

                        <p class="text-[10px] text-mint font-bold tracking-wider mt-1">
                            Admin Panel
                        </p>

                    </div>

                </div>


                <div class="flex items-center gap-2">

                    <button onclick="toggleSidebar()"
                        class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform">

                        <i class="fas fa-bars text-base"></i>

                    </button>

                </div>

            </header>


            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- ================= HEADER ================= -->

                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">

                    <div class="min-w-0">

                        <div
                            class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1 flex-wrap">

                            <span>Manajemen</span>

                            <i class="fas fa-chevron-right text-[9px]"></i>

                            <span class="text-forest font-bold">
                                Data Nasabah
                            </span>

                        </div>


                        <h2
                            class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">

                            Data Master Nasabah

                        </h2>


                        <p class="text-xs sm:text-sm text-slate-500 mt-1">

                            Kelola dan pantau data seluruh nasabah BMT.

                        </p>

                    </div>

                </header>


                <!-- ================= TABLE CARD ================= -->

                <div
                    class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

                    <!-- CARD HEADER -->

                    <div
                        class="p-4 lg:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                        <div class="flex items-center gap-2">

                            <div
                                class="w-1 h-5 bg-gradient-to-b from-mint to-forest rounded-full">
                            </div>

                            <h3 class="text-sm font-extrabold text-slate-900">

                                Daftar Nasabah

                            </h3>

                        </div>


                        <div class="relative sm:w-72">

                            <i
                                class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">
                            </i>

                            <input type="text"
                                id="searchNasabah"
                                placeholder="Cari nama, username, atau no. rek..."
                                class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint focus:bg-white transition-all"
                                autocomplete="off">

                        </div>

                    </div>


                    <!-- ================= DESKTOP TABLE ================= -->

                    <div class="hidden md:block overflow-x-auto">

                        <table class="w-full">

                            <thead class="bg-slate-50/80">

                                <tr>

                                    <th
                                        class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                                        No
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                                        Username
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                                        No. Rekening
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                                        Nama
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-right text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                                        Saldo
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                                        Alamat
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                                        Tgl Daftar
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-left text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                                        Status
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-center text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-slate-100">

                                @forelse($nasabahs as $index => $n)

                                    <tr
                                        class="hover:bg-mintLight/30 transition-colors nasabah-row">

                                        <td
                                            class="px-5 py-3.5 text-xs font-bold text-slate-500">

                                            {{ $loop->iteration }}

                                        </td>


                                        <td
                                            class="px-5 py-3.5 text-xs font-bold text-slate-700">

                                            {{ $n->user->username ?? '-' }}

                                        </td>


                                        <td
                                            class="px-5 py-3.5 text-xs font-bold text-forest font-mono">

                                            {{ $n->rekening->no_rek ?? '-' }}

                                        </td>


                                        <td class="px-5 py-3.5">

                                            <div class="flex items-center gap-2.5">

                                                <div
                                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-mintLight to-emerald-200 flex items-center justify-center flex-shrink-0">

                                                    <span
                                                        class="text-[10px] font-extrabold text-forest">

                                                        {{ strtoupper(substr($n->nama ?? 'N', 0, 2)) }}

                                                    </span>

                                                </div>


                                                <span
                                                    class="text-sm font-bold text-slate-900">

                                                    {{ $n->nama }}

                                                </span>

                                            </div>

                                        </td>


                                        <td
                                            class="px-5 py-3.5 text-sm font-extrabold text-slate-900 text-right whitespace-nowrap">

                                            Rp {{ number_format($n->rekening->saldo ?? 0, 0, ',', '.') }}

                                        </td>


                                        <td
                                            class="px-5 py-3.5 text-xs text-slate-600 max-w-[180px] truncate"
                                            title="{{ $n->alamat }}">

                                            {{ $n->alamat }}

                                        </td>


                                        <td
                                            class="px-5 py-3.5 text-xs font-semibold text-slate-600 whitespace-nowrap">

                                            {{ \Carbon\Carbon::parse($n->tanggal_daftar)->format('d M Y') }}

                                        </td>


                                        <td class="px-5 py-3.5">

                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1
                                                {{ $n->status === 'aktif'
                                                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                                    : 'bg-red-50 text-red-700 border-red-200' }}
                                                rounded-lg text-[10px] font-bold border">

                                                <span
                                                    class="w-1.5 h-1.5
                                                    {{ $n->status === 'aktif'
                                                        ? 'bg-emerald-500'
                                                        : 'bg-red-500' }}
                                                    rounded-full">
                                                </span>

                                                {{ ucfirst($n->status) }}

                                            </span>

                                        </td>


                                        <!-- AKSI -->

                                        <td class="px-5 py-3.5">

                                            <div class="flex justify-center">

                                                <button
                                                    onclick="openMutasiNasabah(
                                                        {{ $n->id_nasabah }},
                                                        '{{ addslashes($n->nama ?? '-') }}',
                                                        '{{ addslashes($n->rekening->no_rek ?? '-') }}'
                                                    )"
                                                    class="w-8 h-8 bg-emerald-50 hover:bg-forest hover:text-white text-forest rounded-lg flex items-center justify-center transition-colors"
                                                    title="Lihat Mutasi Nasabah">

                                                    <i class="fas fa-eye text-xs"></i>

                                                </button>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="9"
                                            class="px-5 py-16 text-center">

                                            <div
                                                class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">

                                                <i
                                                    class="fas fa-inbox text-slate-400 text-2xl">
                                                </i>

                                            </div>

                                            <p
                                                class="text-sm font-bold text-slate-900">

                                                Belum ada data nasabah

                                            </p>

                                            <p
                                                class="text-xs text-slate-500 mt-1">

                                                Data nasabah akan muncul di sini.

                                            </p>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    <!-- ================= MOBILE ================= -->

                    <div class="md:hidden divide-y divide-slate-100">

                        @forelse($nasabahs as $index => $n)

                            <div
                                class="p-4 active:bg-slate-50 transition-colors nasabah-card">

                                <div
                                    class="flex justify-between items-start gap-3 mb-3">

                                    <div
                                        class="flex items-center gap-3 min-w-0 flex-1">

                                        <div
                                            class="w-11 h-11 rounded-2xl bg-gradient-to-br from-mintLight to-emerald-200 flex items-center justify-center flex-shrink-0">

                                            <span
                                                class="text-sm font-extrabold text-forest">

                                                {{ strtoupper(substr($n->nama ?? 'N', 0, 2)) }}

                                            </span>

                                        </div>


                                        <div class="min-w-0 flex-1">

                                            <p
                                                class="text-sm font-extrabold text-slate-900 truncate">

                                                {{ $n->nama }}

                                            </p>

                                            <p
                                                class="text-[10px] text-slate-500 font-mono truncate">

                                                {{ $n->rekening->no_rek ?? '-' }}
                                                ·
                                                {{ $n->user->username ?? '-' }}

                                            </p>

                                        </div>

                                    </div>


                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1
                                        {{ $n->status === 'aktif'
                                            ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                            : 'bg-red-50 text-red-700 border-red-200' }}
                                        rounded-lg text-[9px] font-bold border flex-shrink-0">

                                        {{ ucfirst($n->status) }}

                                    </span>

                                </div>


                                <div class="grid grid-cols-2 gap-2 mb-3">

                                    <div
                                        class="bg-mintLight rounded-xl px-3 py-2">

                                        <p
                                            class="text-[9px] font-bold text-forest uppercase tracking-wider mb-0.5">

                                            Saldo

                                        </p>

                                        <p
                                            class="text-xs font-extrabold text-forest truncate">

                                            Rp {{ number_format($n->rekening->saldo ?? 0, 0, ',', '.') }}

                                        </p>

                                    </div>


                                    <div
                                        class="bg-slate-50 rounded-xl px-3 py-2">

                                        <p
                                            class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">

                                            Tgl Daftar

                                        </p>

                                        <p
                                            class="text-xs font-bold text-slate-700">

                                            {{ \Carbon\Carbon::parse($n->tanggal_daftar)->format('d M Y') }}

                                        </p>

                                    </div>

                                </div>


                                @if($n->alamat)

                                    <div
                                        class="bg-slate-50 rounded-xl px-3 py-2 mb-3">

                                        <p
                                            class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">

                                            Alamat

                                        </p>

                                        <p
                                            class="text-xs font-semibold text-slate-600 line-clamp-2">

                                            {{ $n->alamat }}

                                        </p>

                                    </div>

                                @endif


                                <!-- MOBILE ACTION -->

                                <button
                                    onclick="openMutasiNasabah(
                                        {{ $n->id_nasabah }},
                                        '{{ addslashes($n->nama ?? '-') }}',
                                        '{{ addslashes($n->rekening->no_rek ?? '-') }}'
                                    )"
                                    class="w-full py-2.5 bg-emerald-50 hover:bg-forest hover:text-white text-forest rounded-xl flex items-center justify-center gap-2 text-xs font-bold transition-colors">

                                    <i class="fas fa-eye text-[10px]"></i>

                                    Lihat Mutasi

                                </button>

                            </div>

                        @empty

                            <div class="px-4 py-16 text-center">

                                <div
                                    class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">

                                    <i
                                        class="fas fa-inbox text-slate-400 text-2xl">
                                    </i>

                                </div>

                                <p
                                    class="text-sm font-bold text-slate-900">

                                    Belum ada data nasabah

                                </p>

                                <p
                                    class="text-xs text-slate-500 mt-1">

                                    Data nasabah akan muncul di sini.

                                </p>

                            </div>

                        @endforelse

                    </div>


                    <!-- PAGINATION -->

                    @if($nasabahs->hasPages())

                        <div
                            class="p-4 lg:p-5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3">

                            <p
                                class="text-[11px] text-slate-500 font-semibold">

                                Menampilkan
                                {{ $nasabahs->firstItem() ?? 0 }}
                                –
                                {{ $nasabahs->lastItem() ?? 0 }}
                                dari
                                {{ $nasabahs->total() }}
                                data

                            </p>

                            <div>

                                {{ $nasabahs->links() }}

                            </div>

                        </div>

                    @endif

                </div>


                <!-- FOOTER -->

                <p
                    class="text-center text-[10px] text-slate-400 font-semibold pt-2">

                    Smart Pocket • Admin Panel • BMT SMKN 11 Bandung

                </p>

            </div>

        </main>

    </div>


    <!-- ===================================================== -->
    <!-- MODAL MUTASI NASABAH -->
    <!-- ===================================================== -->

    <div id="mutasiNasabahModal"
        class="fixed inset-0 z-[60] hidden">

        <!-- BACKDROP -->

        <div
            class="absolute inset-0 bg-forestDark/60 backdrop-blur-sm backdrop-in"
            onclick="closeMutasiNasabah()">
        </div>


        <!-- MODAL -->

        <div
            class="absolute top-1/2 left-1/2
            -translate-x-1/2 -translate-y-1/2
            w-[95%] max-w-6xl
            max-h-[92vh]
            overflow-y-auto
            bg-white
            rounded-3xl
            shadow-2xl
            modal-in">

            <!-- HEADER -->

            <div
                class="sticky top-0 gradient-forest text-white
                px-5 lg:px-6 py-5
                flex items-center justify-between
                rounded-t-3xl
                z-20
                relative overflow-hidden">

                <div
                    class="absolute -top-10 -right-10
                    w-32 h-32 bg-white/10
                    rounded-full blur-2xl">
                </div>


                <div
                    class="relative z-10 flex items-center gap-4 min-w-0">

                    <div
                        class="w-11 h-11 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">

                        <i class="fas fa-receipt text-white"></i>

                    </div>


                    <div class="min-w-0">

                        <h3
                            class="text-base lg:text-lg font-black">

                            Mutasi Nasabah

                        </h3>


                        <p
                            class="text-xs text-emerald-100 mt-0.5 truncate"
                            id="modalNamaNasabah">

                            -

                        </p>

                    </div>

                </div>


                <button
                    onclick="closeMutasiNasabah()"
                    class="relative z-10 w-9 h-9 rounded-xl bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors flex-shrink-0">

                    <i class="fas fa-times text-sm"></i>

                </button>

            </div>


            <!-- ============================================== -->
            <!-- FILTER BULAN -->
            <!-- ============================================== -->

            <div
                class="px-5 lg:px-6 pt-5">

                <div
                    class="bg-slate-50 border border-slate-200 rounded-2xl p-4">

                    <div
                        class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

                        <div>

                            <p
                                class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">

                                Periode Mutasi

                            </p>

                            <h4
                                class="text-sm font-black text-slate-900">

                                Saldo Harian & Rata-rata Saldo

                            </h4>

                            <p
                                class="text-[10px] text-slate-500 mt-1">

                                Setiap tanggal tetap ditampilkan meskipun tidak ada transaksi.

                            </p>

                        </div>


                        <div class="w-full sm:w-52">

                            <label
                                class="block text-[10px] font-bold text-slate-500 mb-1.5">

                                Pilih Bulan

                            </label>

                            <input
                                type="month"
                                id="periodeMutasi"
                                value="{{ now()->format('Y-m') }}"
                                class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-mint/30 focus:border-mint">

                        </div>

                    </div>

                </div>

            </div>


            <!-- ============================================== -->
            <!-- LOADING -->
            <!-- ============================================== -->

            <div
                id="mutasiNasabahLoading"
                class="p-12 text-center">

                <div
                    class="w-12 h-12 border-4 border-mintLight border-t-forest rounded-full animate-spin mx-auto mb-3">
                </div>

                <p
                    class="text-sm text-slate-500 font-semibold">

                    Memuat mutasi nasabah...

                </p>

            </div>


            <!-- ============================================== -->
            <!-- CONTENT -->
            <!-- ============================================== -->

            <div
                id="mutasiNasabahContent"
                class="hidden">

                <div class="p-5 lg:p-6 space-y-5">

                    <!-- ====================================== -->
                    <!-- SUMMARY -->
                    <!-- ====================================== -->

                    <div
                        class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                        <!-- SALDO AWAL -->

                        <div
                            class="bg-slate-50 border border-slate-200 rounded-2xl p-4">

                            <div
                                class="flex items-center justify-between mb-2">

                                <p
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-wider">

                                    Saldo Awal Bulan

                                </p>

                                <div
                                    class="w-8 h-8 bg-white rounded-xl flex items-center justify-center">

                                    <i
                                        class="fas fa-wallet text-slate-500 text-xs">
                                    </i>

                                </div>

                            </div>

                            <p
                                id="saldoAwalBulan"
                                class="text-lg font-black text-slate-900">

                                Rp 0

                            </p>

                        </div>


                        <!-- SALDO AKHIR -->

                        <div
                            class="bg-mintLight border border-emerald-200 rounded-2xl p-4">

                            <div
                                class="flex items-center justify-between mb-2">

                                <p
                                    class="text-[10px] font-black text-forest uppercase tracking-wider">

                                    Saldo Akhir Bulan

                                </p>

                                <div
                                    class="w-8 h-8 bg-white/70 rounded-xl flex items-center justify-center">

                                    <i
                                        class="fas fa-chart-line text-forest text-xs">
                                    </i>

                                </div>

                            </div>

                            <p
                                id="saldoAkhirBulan"
                                class="text-lg font-black text-forest">

                                Rp 0

                            </p>

                        </div>


                        <!-- RATA-RATA -->

                        <div
                            class="gradient-mint rounded-2xl p-4 shadow-lg shadow-forest/10">

                            <div
                                class="flex items-center justify-between mb-2">

                                <p
                                    class="text-[10px] font-black text-emerald-100 uppercase tracking-wider">

                                    Rata-rata Saldo

                                </p>

                                <div
                                    class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">

                                    <i
                                        class="fas fa-calculator text-white text-xs">
                                    </i>

                                </div>

                            </div>

                            <p
                                id="rataRataSaldo"
                                class="text-lg font-black text-white">

                                Rp 0

                            </p>

                            <p
                                class="text-[9px] text-emerald-100 mt-1">

                                Dasar perhitungan bagi hasil

                            </p>

                        </div>

                    </div>


                    <!-- ====================================== -->
                    <!-- TABLE -->
                    <!-- ====================================== -->

                    <div
                        class="bg-white rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-200/40 overflow-hidden">

                        <div class="overflow-x-auto">

                            <table class="w-full text-xs">

                                <thead class="bg-slate-50/80">

                                    <tr>

                                        <th
                                            class="px-4 py-3 text-left font-black text-slate-500 uppercase text-[10px] tracking-wider">

                                            No. Rek

                                        </th>

                                        <th
                                            class="px-4 py-3 text-left font-black text-slate-500 uppercase text-[10px] tracking-wider">

                                            Nama

                                        </th>

                                        <th
                                            class="px-4 py-3 text-center font-black text-slate-500 uppercase text-[10px] tracking-wider">

                                            Tanggal

                                        </th>

                                        <th
                                            class="px-4 py-3 text-center font-black text-slate-500 uppercase text-[10px] tracking-wider">

                                            Jenis

                                        </th>

                                        <th
                                            class="px-4 py-3 text-right font-black text-slate-500 uppercase text-[10px] tracking-wider">

                                            Debet

                                        </th>

                                        <th
                                            class="px-4 py-3 text-right font-black text-slate-500 uppercase text-[10px] tracking-wider">

                                            Kredit

                                        </th>

                                        <th
                                            class="px-4 py-3 text-right font-black text-slate-500 uppercase text-[10px] tracking-wider">

                                            Saldo

                                        </th>

                                    </tr>

                                </thead>


                                <tbody
                                    id="modalNasabahTableBody"
                                    class="divide-y divide-slate-100">
                                </tbody>


                                <tfoot
                                    class="bg-mintLight border-t-2 border-forest">

                                    <tr>

                                        <th
                                            colspan="4"
                                            class="px-4 py-3 text-left font-black text-forest uppercase text-[10px] tracking-wider">

                                            TOTAL

                                        </th>


                                        <th
                                            id="modalNasabahTotalDebet"
                                            class="px-4 py-3 text-right font-black text-forest text-[10px]">

                                            0

                                        </th>


                                        <th
                                            id="modalNasabahTotalKredit"
                                            class="px-4 py-3 text-right font-black text-forest text-[10px]">

                                            0

                                        </th>


                                        <th
                                            id="modalNasabahSaldoAkhir"
                                            class="px-4 py-3 text-right font-black text-forest text-[10px]">

                                            0

                                        </th>

                                    </tr>

                                </tfoot>

                            </table>

                        </div>


                        <!-- EMPTY -->

                        <div
                            id="modalNasabahEmpty"
                            class="hidden p-10 text-center">

                            <div
                                class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3">

                                <i
                                    class="fas fa-calendar-xmark text-slate-400 text-lg">
                                </i>

                            </div>

                            <p
                                class="text-sm font-bold text-slate-700">

                                Belum ada transaksi pada periode ini

                            </p>

                            <p
                                class="text-xs text-slate-500 mt-1">

                                Saldo harian tetap akan dihitung dari saldo sebelumnya.

                            </p>

                        </div>

                    </div>


                    <!-- ====================================== -->
                    <!-- INFO AVERAGE -->
                    <!-- ====================================== -->

                    <div
                        class="bg-blue-50 border border-blue-100 rounded-2xl p-4">

                        <div class="flex gap-3">

                            <div
                                class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">

                                <i
                                    class="fas fa-circle-info text-blue-600 text-sm">
                                </i>

                            </div>


                            <div>

                                <p
                                    class="text-xs font-black text-blue-800">

                                    Perhitungan Rata-rata Saldo

                                </p>

                                <p
                                    class="text-[10px] text-blue-700 leading-relaxed mt-1">

                                    Rata-rata saldo dihitung dari seluruh saldo harian
                                    tanggal 1 sampai akhir bulan, termasuk tanggal yang
                                    tidak memiliki transaksi.

                                </p>

                                <p
                                    class="text-[10px] font-bold text-blue-800 mt-1">

                                    Total saldo harian ÷ jumlah hari dalam bulan

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ===================================================== -->
    <!-- SCRIPT -->
    <!-- ===================================================== -->

    <script>

        // =====================================================
        // SIDEBAR
        // =====================================================

        function toggleSidebar() {

            const sidebar =
                document.getElementById('sidebar');

            const backdrop =
                document.getElementById('sidebarBackdrop');

            sidebar.classList.toggle('-translate-x-full');

            backdrop.classList.toggle('hidden');

        }


        // =====================================================
        // FORMAT RUPIAH
        // =====================================================

        const formatRupiah = (angka) => {

            return new Intl.NumberFormat('id-ID')
                .format(Number(angka) || 0);

        };


        // =====================================================
        // MODAL NASABAH
        // =====================================================

        let selectedNasabahId = null;


        function openMutasiNasabah(
            idNasabah,
            namaNasabah,
            noRek
        ) {

            selectedNasabahId = idNasabah;


            const modal =
                document.getElementById('mutasiNasabahModal');

            const loading =
                document.getElementById('mutasiNasabahLoading');

            const content =
                document.getElementById('mutasiNasabahContent');

            const tableBody =
                document.getElementById('modalNasabahTableBody');

            const empty =
                document.getElementById('modalNasabahEmpty');


            modal.classList.remove('hidden');

            loading.classList.remove('hidden');

            content.classList.add('hidden');

            empty.classList.add('hidden');

            tableBody.innerHTML = '';


            document.getElementById(
                'modalNamaNasabah'
            ).textContent =
                namaNasabah +
                (noRek ? ' - ' + noRek : '');


            loadMutasiNasabah();

        }


        // =====================================================
        // LOAD MUTASI
        // =====================================================

        function loadMutasiNasabah() {

            if (!selectedNasabahId) {
                return;
            }


            const periode =
                document.getElementById('periodeMutasi').value;


            const loading =
                document.getElementById('mutasiNasabahLoading');

            const content =
                document.getElementById('mutasiNasabahContent');

            const tableBody =
                document.getElementById('modalNasabahTableBody');

            const empty =
                document.getElementById('modalNasabahEmpty');


            loading.classList.remove('hidden');

            content.classList.add('hidden');

            empty.classList.add('hidden');

            tableBody.innerHTML = '';


            const url =
                `/admin/nasabah/mutasi/${selectedNasabahId}?periode=${periode}`;


            fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            })

            .then(response => {

                if (!response.ok) {
                    throw new Error(
                        'HTTP ' + response.status
                    );
                }

                return response.json();

            })

            .then(data => {

                loading.classList.add('hidden');


                if (!data.success) {

                    content.classList.remove('hidden');

                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="7"
                                class="px-4 py-8 text-center text-sm text-red-600">
                                ${data.message || 'Data tidak ditemukan'}
                            </td>
                        </tr>
                    `;

                    return;
                }


                // =============================================
                // SUMMARY
                // =============================================

                document.getElementById(
                    'saldoAwalBulan'
                ).textContent =
                    'Rp ' +
                    formatRupiah(data.saldo_awal_bulan);


                document.getElementById(
                    'saldoAkhirBulan'
                ).textContent =
                    'Rp ' +
                    formatRupiah(data.saldo_akhir_bulan);


                document.getElementById(
                    'rataRataSaldo'
                ).textContent =
                    'Rp ' +
                    formatRupiah(data.rata_rata_saldo);


                document.getElementById(
                    'modalNasabahTotalDebet'
                ).textContent =
                    formatRupiah(data.total_debet)
                        .replace(/\./g, ' ');


                document.getElementById(
                    'modalNasabahTotalKredit'
                ).textContent =
                    formatRupiah(data.total_kredit)
                        .replace(/\./g, ' ');


                document.getElementById(
                    'modalNasabahSaldoAkhir'
                ).textContent =
                    formatRupiah(data.saldo_akhir_bulan)
                        .replace(/\./g, ' ');


                // =============================================
                // TABLE
                // =============================================

                if (
                    !data.mutasi ||
                    data.mutasi.length === 0
                ) {

                    empty.classList.remove('hidden');

                } else {

                    data.mutasi.forEach(t => {

                        const row =
                            document.createElement('tr');


                        row.className =
                            'hover:bg-mintLight/20 transition-colors';


                        let badgeJenis = '';


                        // CREDIT = SETORAN
                        if (t.jenis === 'setoran') {

                            badgeJenis = `
                                <span
                                    class="inline-block px-2 py-1
                                    bg-emerald-50 text-emerald-700
                                    rounded-lg text-[9px] font-black
                                    border border-emerald-200">

                                    SETORAN

                                </span>
                            `;

                        }

                        // DEBIT = PENARIKAN
                        else if (t.jenis === 'penarikan') {

                            badgeJenis = `
                                <span
                                    class="inline-block px-2 py-1
                                    bg-purple-50 text-purple-700
                                    rounded-lg text-[9px] font-black
                                    border border-purple-200">

                                    PENARIKAN

                                </span>
                            `;

                        }

                        // TIDAK ADA TRANSAKSI
                        else {

                            badgeJenis = `
                                <span
                                    class="inline-block px-2 py-1
                                    bg-slate-50 text-slate-500
                                    rounded-lg text-[9px] font-black
                                    border border-slate-200">

                                    -

                                </span>
                            `;

                        }


                        row.innerHTML = `

                            <td
                                class="px-4 py-3
                                text-[10px] font-mono
                                text-slate-600">

                                ${t.no_rek || '-'}

                            </td>


                            <td
                                class="px-4 py-3
                                text-[10px] font-semibold
                                text-slate-900">

                                ${t.nama || '-'}

                            </td>


                            <td
                                class="px-4 py-3
                                text-[10px]
                                text-center
                                text-slate-600
                                whitespace-nowrap">

                                ${t.tanggal || '-'}

                            </td>


                            <td
                                class="px-4 py-3
                                text-center">

                                ${badgeJenis}

                            </td>


                            <td
                                class="px-4 py-3
                                text-[10px]
                                font-semibold
                                text-right
                                ${Number(t.debit) > 0
                                    ? 'text-purple-600'
                                    : 'text-slate-400'}">

                                ${
                                    Number(t.debit) > 0
                                    ? formatRupiah(t.debit)
                                        .replace(/\./g, ' ')
                                    : '0'
                                }

                            </td>


                            <td
                                class="px-4 py-3
                                text-[10px]
                                font-semibold
                                text-right
                                ${Number(t.kredit) > 0
                                    ? 'text-emerald-600'
                                    : 'text-slate-400'}">

                                ${
                                    Number(t.kredit) > 0
                                    ? formatRupiah(t.kredit)
                                        .replace(/\./g, ' ')
                                    : '0'
                                }

                            </td>


                            <td
                                class="px-4 py-3
                                text-[10px]
                                font-black
                                text-right
                                text-slate-900
                                bg-slate-50">

                                ${formatRupiah(t.saldo)
                                    .replace(/\./g, ' ')}

                            </td>

                        `;


                        tableBody.appendChild(row);

                    });

                }


                content.classList.remove('hidden');

            })

            .catch(error => {

                console.error(
                    'Error mengambil mutasi nasabah:',
                    error
                );


                loading.classList.add('hidden');

                content.classList.remove('hidden');


                tableBody.innerHTML = `

                    <tr>

                        <td
                            colspan="7"
                            class="px-4 py-8 text-center">

                            <div
                                class="text-red-600 text-sm font-bold">

                                Gagal memuat data mutasi.

                            </div>

                            <p
                                class="text-xs text-slate-400 mt-1">

                                ${error.message}

                            </p>

                        </td>

                    </tr>

                `;

            });

        }


        // =====================================================
        // CLOSE MODAL
        // =====================================================

        function closeMutasiNasabah() {

            document
                .getElementById('mutasiNasabahModal')
                .classList.add('hidden');

            selectedNasabahId = null;

        }


        // =====================================================
        // GANTI BULAN
        // =====================================================

        document
            .getElementById('periodeMutasi')
            .addEventListener('change', function () {

                if (selectedNasabahId) {

                    loadMutasiNasabah();

                }

            });


        // =====================================================
        // ESC
        // =====================================================

        document.addEventListener(
            'keydown',
            function (e) {

                if (e.key === 'Escape') {

                    closeMutasiNasabah();

                }

            }
        );


        // =====================================================
        // SEARCH
        // =====================================================

        document
            .getElementById('searchNasabah')
            .addEventListener(
                'input',
                function () {

                    const keyword =
                        this.value
                            .toLowerCase()
                            .trim();


                    const rows =
                        document.querySelectorAll(
                            '.nasabah-row'
                        );


                    const cards =
                        document.querySelectorAll(
                            '.nasabah-card'
                        );


                    rows.forEach(row => {

                        const text =
                            row.textContent
                                .toLowerCase();

                        row.style.display =
                            text.includes(keyword)
                                ? ''
                                : 'none';

                    });


                    cards.forEach(card => {

                        const text =
                            card.textContent
                                .toLowerCase();

                        card.style.display =
                            text.includes(keyword)
                                ? ''
                                : 'none';

                    });

                }
            );

    </script>

</body>

</html>