<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Master Nasabah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-700">Daftar Nasabah</h3>
                    <a href="{{ route('operator.nasabah.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-black font-semibold rounded-lg shadow-md transition">
                        + Tambah Nasabah
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="p-3 border">No. Rekening</th>
                                <th class="p-3 border">Username</th>
                                <th class="p-3 border">Nama</th>
                                <th class="p-3 border">Saldo</th>  
                                <th class="p-3 border">Alamat</th>
                                <th class="p-3 border">Tgl Daftar</th>
                                <th class="p-3 border">Status</th>
                                <th class="p-3 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nasabahs as $nasabah)
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="p-3 border font-semibold">{{ $nasabah->rekening->no_rek ?? '-' }}</td>
                                    <td>{{ $nasabah->user->username ?? '-' }}</td>
                                    <td class="p-3 border">{{ $nasabah->nama }}</td>
                                    <td class="p-3 border text-right font-bold text-green-600">
                                        Rp {{ number_format($nasabah->rekening->saldo ?? 0, 0, ',', '.') }}
                                    </td>  <!-- TAMBAHIN SALDO -->
                                    <td class="p-3 border">{{ $nasabah->alamat }}</td>
                                    <td class="p-3 border">{{ $nasabah->tanggal_daftar }}</td>
                                    <td class="p-3 border">
                                        <span class="px-2 py-1 text-xs font-bold rounded {{ $nasabah->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($nasabah->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3 border text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('operator.nasabah.edit', $nasabah->id_nasabah) }}" 
                                            class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-black rounded font-medium text-xs">
                                            Edit
                                            </a>
                                            
                                            <form action="{{ route('operator.nasabah.destroy', $nasabah->id_nasabah) }}" 
                                                method="POST" 
                                                onsubmit="return confirm('Yakin mau hapus data ini?')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded font-medium text-xs">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-gray-500">Belum ada data nasabah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $nasabahs->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>