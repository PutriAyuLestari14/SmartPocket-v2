<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        bgMain: '#FAFAFA',
                        primary: '#15803d',
                        primaryDark: '#166534',
                        primaryLight: '#16a34a',
                        secondary: '#22c55e',
                        accent: '#4ade80',
                        mint: '#15803d',
                        mintLight: '#dcfce7',
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
                    <p class="text-xs text-slate-400 font-bold">Informasi & Aktivitas Akun</p>
                </div>
            </div>

            <!-- TOMBOL KEMBALI KE DASHBOARD -->
            <a href="{{ route('nasabah.dashboard') }}" class="px-4 py-2 bg-mintLight hover:bg-primary/10 text-primary border border-primary/20 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shadow-sm">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-8">

        <!-- SUB HEADER & TOMBOL BACA SEMUA -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Notifikasi Kamu</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar semua pemberitahuan transaksi dan pembaruan sistem.</p>
            </div>

            @if(isset($belumDibaca) && $belumDibaca > 0)
                <form action="{{ route('nasabah.notifikasi.read-all') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-primary hover:bg-primaryDark text-white text-xs font-bold rounded-xl shadow-md shadow-primary/20 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-check-double text-xs"></i>
                        <span>Tandai Semua Sudah Dibaca</span>
                    </button>
                </form>
            @endif
        </div>

        <!-- ALERT SUKSES -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-mintLight border border-primary/30 rounded-2xl flex items-center gap-3 text-primaryDark text-xs sm:text-sm font-bold shadow-sm">
                <div class="w-6 h-6 rounded-lg bg-primary text-white flex items-center justify-center shrink-0">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- LIST NOTIFIKASI -->
        <div class="space-y-3.5">
            @forelse($notifikasis as $notif)
                <div class="bg-white rounded-2xl border transition-all duration-200 p-5 shadow-sm hover:shadow-md relative overflow-hidden flex items-start justify-between gap-4 {{ $notif->status == 'belum dibaca' ? 'border-primary/30 ring-1 ring-primary/10' : 'border-slate-200/80' }}">
                    
                    <!-- GARIS HIJAU DISAMPING UNTUK NOTIF BARU -->
                    @if($notif->status == 'belum dibaca')
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary"></div>
                    @endif

                    <div class="flex items-start gap-4 flex-1">
                        <!-- ICON -->
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5 {{ $notif->status == 'belum dibaca' ? 'bg-mintLight text-primary' : 'bg-slate-100 text-slate-400' }}">
                            <i class="fas {{ $notif->status == 'belum dibaca' ? 'fa-envelope' : 'fa-envelope-open' }} text-base"></i>
                        </div>

                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h3 class="text-sm font-bold text-slate-900 {{ $notif->status == 'belum dibaca' ? 'text-primaryDark font-black' : '' }}">
                                    {{ $notif->judul }}
                                </h3>

                                @if($notif->status == 'belum dibaca')
                                    <span class="px-2 py-0.5 bg-primary text-white text-[10px] font-black uppercase tracking-wider rounded-full">
                                        Baru
                                    </span>
                                @endif
                            </div>

                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                {{ $notif->pesan }}
                            </p>

                            <div class="flex items-center gap-2 text-[11px] font-bold text-slate-400">
                                <i class="far fa-clock"></i>
                                <span>{{ $notif->tanggal_kirim->format('d M Y, H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>

                    <!-- TOMBOL CHECKMARK INDIVIDUAL -->
                    @if($notif->status == 'belum dibaca')
                        <form action="{{ route('nasabah.notifikasi.read', $notif->id_notifikasi) }}" method="POST" class="shrink-0">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-primary hover:bg-mintLight rounded-xl transition-all" title="Tandai Sudah Dibaca">
                                <i class="fas fa-check-circle text-xl"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <!-- STATE KOSONG -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-mintLight text-primary rounded-2xl flex items-center justify-center mx-auto mb-4 border border-primary/20">
                        <i class="fas fa-bell-slash text-2xl"></i>
                    </div>
                    <h3 class="text-base font-black text-slate-900">Belum Ada Notifikasi</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Notifikasi baru terkait riwayat penarikan, peminjaman, dan sistem akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        @if(method_exists($notifikasis, 'hasPages') && $notifikasis->hasPages())
            <div class="mt-8">
                {{ $notifikasis->links() }}
            </div>
        @endif

    </main>

</body>
</html>