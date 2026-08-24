<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Master Nasabah (Admin View)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-700">Daftar Nasabah</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Username</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">No. Rekening</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Saldo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Alamat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tgl Daftar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($nasabahs as $index => $n)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $n->user->username ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-indigo-600">{{ $n->rekening->no_rek ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $n->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-green-600">
                                    Rp {{ number_format($n->rekening->saldo ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">{{ $n->alamat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $n->tanggal_daftar }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-bold rounded {{ $n->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($n->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>