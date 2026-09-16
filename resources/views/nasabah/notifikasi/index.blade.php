<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Smart Pocket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-bell text-emerald-500 mr-2"></i>
                        Notifikasi
                    </h1>
                    
                    @if($belumDibaca > 0)
                    <form action="{{ route('nasabah.notifikasi.read-all') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-emerald-600 hover:text-emerald-700 font-semibold">
                            <i class="fas fa-check-double mr-1"></i>
                            Tandai semua sudah dibaca
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                    <p class="text-sm text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            @forelse($notifikasis as $notif)
                <div class="bg-white rounded-lg shadow-sm border {{ $notif->status == 'belum dibaca' ? 'border-emerald-300 border-l-4 border-l-emerald-500' : 'border-gray-200' }} mb-4 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900 {{ $notif->status == 'belum dibaca' ? 'font-bold' : '' }}">
                                    {{ $notif->judul }}
                                </h3>
                                @if($notif->status == 'belum dibaca')
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">
                                        Baru
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-gray-600 mb-3">{{ $notif->pesan }}</p>
                            
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="far fa-clock mr-2"></i>
                                {{ $notif->tanggal_kirim->format('d M Y, H:i') }} WIB
                            </div>
                        </div>

                        @if($notif->status == 'belum dibaca')
                        <form action="{{ route('nasabah.notifikasi.read', $notif->id_notifikasi) }}" method="POST" class="ml-4">
                            @csrf
                            <button type="submit" class="text-emerald-600 hover:text-emerald-700" title="Tandai sudah dibaca">
                                <i class="fas fa-check-circle text-xl"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

            @empty
                <div class="text-center py-12">
                    <i class="fas fa-bell-slash text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada notifikasi</p>
                    <p class="text-gray-400 text-sm mt-2">Notifikasi akan muncul ketika ada aktivitas di akun Anda</p>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($notifikasis->hasPages())
                <div class="mt-8">
                    {{ $notifikasis->links() }}
                </div>
            @endif
        </div>
    </div>

</body>
</html>