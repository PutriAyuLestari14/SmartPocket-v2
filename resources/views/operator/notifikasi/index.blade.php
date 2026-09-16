<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi - Operator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="min-h-screen p-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">
                <i class="fas fa-bell text-emerald-500 mr-2"></i>
                Notifikasi Pengajuan
            </h1>

            @forelse($penarikanPending as $trx)
                <div class="bg-white rounded-lg shadow-sm border-l-4 border-amber-500 p-4 mb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-gray-900">Pengajuan Penarikan Baru</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                <strong>{{ $trx->rekening->nasabah->nama }}</strong> 
                                mengajukan penarikan sebesar 
                                <span class="text-emerald-600 font-bold">Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</span>
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ $trx->tanggal_transaksi->timezone('Asia/Jakarta')->format('d F Y • H:i') }} WIB
                            </p>
                        </div>
                        <a href="{{ route('operator.verifikasi.index') }}" 
                           class="bg-emerald-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-emerald-600">
                            Verifikasi
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-lg">
                    <i class="fas fa-check-circle text-6xl text-emerald-300 mb-4"></i>
                    <p class="text-gray-500">Tidak ada notifikasi baru</p>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>