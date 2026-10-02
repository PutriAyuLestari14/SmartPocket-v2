<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Umum - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
                        infoYellow: '#eab308',
                        infoYellowLight: '#fef9c3',
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
        
        .gradient-primary { background: linear-gradient(135deg, #15803d 0%, #166534 100%); }
        .gradient-mint { background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); }
        .gradient-soft { background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%); }
        .gradient-fresh { background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); }
        .gradient-vibrant { background: linear-gradient(135deg, #15803d 0%, #16a34a 50%, #22c55e 100%); }
        
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 12px 20px -8px rgba(21, 128, 61, 0.15); }
        
        /* Indentasi standar akuntansi untuk akun Kredit */
        .account-credit { padding-left: 2rem; font-style: italic; }
    </style>
</head>
<body class="bg-bgMain text-slate-800 antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-primaryDark/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl shadow-slate-200/50">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 gradient-vibrant rounded-xl flex items-center justify-center shadow-lg shadow-primary/30">
                        <i class="fas fa-wallet text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-black text-primary tracking-tight">Smart Pocket</h1>
                        <p class="text-[10px] text-primaryDark font-bold tracking-wider">BMT SMKN 11 BANDUNG</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
                <p class="px-3 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu Utama</p>
                <a href="{{ route('operator.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-home w-5 text-center text-slate-400"></i> Dashboard
                </a>
                <a href="{{ route('operator.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-users w-5 text-center text-slate-400"></i> Data Nasabah
                </a>
                <a href="{{ route('operator.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-exchange-alt w-5 text-center text-slate-400"></i> Transaksi
                </a>
                <a href="{{ route('operator.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-hand-holding-usd w-5 text-center text-slate-400"></i> Peminjaman
                </a>
                <a href="{{ route('operator.verifikasi.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl text-sm font-semibold transition-all">
                    <i class="fas fa-check-circle w-5 text-center text-slate-400"></i> Verifikasi
                </a>
                <a href="{{ route('operator.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-mintLight to-white text-primary rounded-xl text-sm font-bold transition-all shadow-sm border border-primary/30">
                    <i class="fas fa-chart-pie w-5 text-center text-primary"></i> Laporan
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
            <header class="lg:hidden bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 gradient-soft rounded-xl flex items-center justify-center text-white shadow-md shadow-primary/30">
                        <i class="fas fa-wallet text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-base font-black text-primary tracking-tight leading-none">Smart Pocket</h1>
                        <p class="text-[10px] text-primaryDark font-bold tracking-wider mt-1">BMT SMKN 11</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="toggleSidebar()" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-700 active:scale-95 transition-transform shadow-sm">
                        <i class="fas fa-bars text-base"></i>
                    </button>
                </div>
            </header>

            <div class="p-4 lg:p-8 space-y-5 lg:space-y-6">

                <!-- Header -->
                <header class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-1 flex-wrap">
                            <span>Laporan</span>
                            <i class="fas fa-chevron-right text-[9px]"></i>
                            <span class="text-primary font-bold">Jurnal Umum</span>
                        </div>
                        <h2 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight leading-tight">Jurnal Umum</h2>
                        <p class="text-sm text-slate-500 mt-2 flex items-center gap-2 font-medium">
                            <i class="fas fa-book text-infoYellow"></i>
                            Catatan transaksi berpasangan (Double-Entry System) BMT.
                        </p>
                    </div>

                    <!-- Profil + notif desktop -->
                    <div class="hidden lg:flex items-center gap-3 pt-1 flex-shrink-0">
                        <a href="{{ route('operator.notifikasi.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 hover:text-primary hover:border-primary transition-all relative shadow-sm">
                            <i class="far fa-bell text-base"></i>
                            @php $pendingNotif = \App\Models\DetailTabungan::where('status', 'pending')->count(); @endphp
                            @if($pendingNotif > 0)
                                <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                            @endif
                        </a>
                        <div class="w-px h-8 bg-slate-200"></div>
                        <div class="text-right">
                            <p class="text-xs font-black text-slate-800 leading-tight">
                                {{ auth()->user()->petugas->nama_lengkap ?? auth()->user()->name }}
                            </p>
                            <p class="text-[10px] font-bold text-slate-400 mt-0.5">Operator</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl overflow-hidden gradient-vibrant text-white font-black text-sm flex items-center justify-center border-2 border-white shadow-lg shadow-primary/20 flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->petugas->nama_lengkap ?? auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </header>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/60 shadow-lg hover-lift">
                        <p class="text-xs text-slate-500 font-black uppercase tracking-wider mb-1">Total Transaksi</p>
                        <p class="text-2xl font-black text-slate-900">{{ $jurnalData->count() }} <span class="text-sm font-bold text-slate-400">Bukti</span></p>
                    </div>
                    <div class="bg-gradient-to-br from-primary to-primaryDark rounded-2xl p-5 shadow-lg shadow-primary/20 hover-lift text-white">
                        <p class="text-xs text-emerald-100 font-black uppercase tracking-wider mb-1">Total Debit</p>
                        <p class="text-2xl font-black">Rp {{ number_format($totalDebit, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 border border-yellow-200 shadow-lg hover-lift relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-infoYellowLight rounded-bl-full -mr-4 -mt-4"></div>
                        <p class="text-xs text-slate-500 font-black uppercase tracking-wider mb-1 relative z-10">Total Kredit</p>
                        <p class="text-2xl font-black text-slate-900 relative z-10">Rp {{ number_format($totalKredit, 0, ',', '.') }}</p>
                        @if($totalDebit == $totalKredit)
                            <span class="inline-flex items-center gap-1 mt-2 px-2 py-1 rounded-lg bg-infoYellowLight text-infoYellow text-[10px] font-black">
                                <i class="fas fa-check-circle"></i> SEIMBANG (BALANCE)
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Filter Card (SUDAH DITAMBAHKAN TOMBOL EXPORT EXCEL) -->
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-lg p-5">
                    <form action="{{ route('operator.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-slate-50 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-slate-50 font-semibold">
                        </div>
                        <div class="md:col-span-2 flex gap-2">
                            <button type="submit" class="flex-1 px-5 py-2.5 rounded-xl bg-primary hover:bg-primaryDark text-white text-sm font-black transition-colors shadow-md shadow-primary/30 flex items-center justify-center gap-2">
                                <i class="fas fa-filter text-xs"></i> Terapkan Filter
                            </button>
                            
                            <!-- TOMBOL EXPORT EXCEL -->
                            <a href="{{ route('operator.laporan.export', request()->query()) }}" 
                                class="px-5 py-2.5 rounded-xl bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white text-sm font-black transition-all duration-300 flex items-center justify-center gap-2 group shadow-sm hover:shadow-md">
                                <i class="fas fa-file-excel text-lg group-hover:scale-110 transition-transform"></i> 
                                <span>Export Excel</span>
                            </a>

                            <a href="{{ route('operator.laporan.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-sm font-bold hover:bg-slate-200 transition-colors flex items-center justify-center">
                                <i class="fas fa-rotate-left"></i>
                            </a>
                        </div>
                    </form>
                </div>

                <!-- TABEL JURNAL UMUM (4 KOLOM - LEBIH BERSIH) -->
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-lg overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 bg-infoYellowLight rounded-xl flex items-center justify-center">
                            <i class="fas fa-book-open text-infoYellow text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900">Buku Jurnal Umum</h3>
                            <p class="text-[11px] text-slate-500">Format standar akuntansi berpasangan</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50/80 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider w-32">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">Nama Akun (CoA) & Keterangan</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-wider w-40">Debit (Rp)</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-wider w-40">Kredit (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($jurnalData as $noBukti => $entries)
                                    @php
                                        $firstEntry = $entries->first();
                                        $totalDebitTransaksi = $entries->sum('debit');
                                        $totalKreditTransaksi = $entries->sum('kredit');
                                    @endphp

                                    @foreach ($entries as $index => $entry)
                                        <tr class="hover:bg-mintLight/10 transition-colors group">
                                            
                                            <!-- Tanggal (Hanya muncul di baris pertama per grup) -->
                                            <td class="px-6 py-3 align-top whitespace-nowrap font-bold text-slate-700">
                                                @if($index === 0)
                                                    {{ \Carbon\Carbon::parse($firstEntry['tanggal'])->format('d/m/Y') }}
                                                @endif
                                            </td>

                                            <!-- Nama Akun & Keterangan -->
                                            <td class="px-6 py-3 align-top">
                                                @if($entry['kredit'] > 0)
                                                    <!-- Akun Kredit: Indentasi & Italic -->
                                                    <div class="account-credit text-slate-600 font-semibold">
                                                        {{ $entry['akun'] }}
                                                    </div>
                                                @else
                                                    <!-- Akun Debit: Bold & Rata Kiri -->
                                                    <div class="text-slate-900 font-bold">
                                                        {{ $entry['akun'] }}
                                                    </div>
                                                @endif
                                                
                                                <!-- Keterangan Transaksi (Hanya muncul di baris pertama) -->
                                                @if($index === 0 && isset($firstEntry['keterangan']) && $firstEntry['keterangan'])
                                                    <p class="text-[10px] text-slate-400 mt-1 italic max-w-[250px] leading-tight">
                                                        "{{ Str::limit($firstEntry['keterangan'], 50) }}"
                                                    </p>
                                                @endif
                                            </td>

                                            <!-- Kolom Debit -->
                                            <td class="px-6 py-3 text-right align-top font-mono font-semibold text-slate-700">
                                                @if($entry['debit'] > 0)
                                                    {{ number_format($entry['debit'], 0, ',', '.') }}
                                                @endif
                                            </td>

                                            <!-- Kolom Kredit -->
                                            <td class="px-6 py-3 text-right align-top font-mono font-semibold text-slate-700">
                                                @if($entry['kredit'] > 0)
                                                    {{ number_format($entry['kredit'], 0, ',', '.') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- Garis Pemisah & Subtotal per Transaksi -->
                                    <tr class="bg-slate-50/50">
                                        <td colspan="4" class="px-6 py-1 border-b border-slate-200">
                                            <div class="flex justify-end gap-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">
                                                <span>Subtotal: Dr {{ number_format($totalDebitTransaksi, 0, ',', '.') }} = Cr {{ number_format($totalKreditTransaksi, 0, ',', '.') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center">
                                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-book-open text-slate-300 text-2xl"></i>
                                            </div>
                                            <p class="text-sm font-bold text-slate-900">Belum ada data jurnal</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <!-- Footer Total Keseluruhan -->
                            <tfoot class="bg-primary text-white border-t-2 border-primaryDark">
                                <tr>
                                    <td colspan="2" class="px-6 py-4 font-black text-sm tracking-wide text-right">
                                        TOTAL KESELURUHAN
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-accent font-mono text-base">
                                        Rp {{ number_format($totalDebit, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-yellow-300 font-mono text-base">
                                        Rp {{ number_format($totalKredit, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400 gap-2 pt-2">
                    <p class="font-bold">Smart Pocket • BMT SMKN 11 Bandung</p>
                    <p class="font-bold">Jurnal Umum</p>
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