<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl font-bold">Halo, {{ $nasabah->nama ?? 'Nasabah' }} 👋</h2>

        <div class="mt-4 rounded-lg bg-white p-6 shadow">
            <p class="text-sm text-gray-500">No. Rekening</p>
            <p class="font-semibold">{{ $nasabah->rekening->no_rek ?? 'belum ada rekening' }}</p>

            <p class="mt-4 text-sm text-gray-500">Saldo Tabungan</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </div>
    </div>
</x-app-layout>