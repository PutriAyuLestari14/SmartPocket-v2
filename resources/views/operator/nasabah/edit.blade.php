<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Nasabah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('operator.nasabah.update', $nasabah->id_nasabah) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-gray-700">Username (untuk login)</label>
                        <input type="text" name="username" value="{{ old('username', $nasabah->user->username ?? '') }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Nama Lengkap Nasabah</label>
                        <input type="text" name="nama" value="{{ old('nama', $nasabah->nama) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Alamat</label>
                        <textarea name="alamat" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" rows="3" required>{{ old('alamat', $nasabah->alamat) }}</textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Tanggal Daftar</label>
                        <input type="date" name="tanggal_daftar" value="{{ old('tanggal_daftar', $nasabah->tanggal_daftar) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Status Akun</label>
                        <select name="status" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                            <option value="aktif" {{ $nasabah->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ $nasabah->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="reset_password" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-red-600 font-semibold">Reset Password ke Default (nasabah123)</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Centang jika nasabah lupa password dan ingin mengembalikan password ke bawaan.</p>
                    </div>

                    <div class="flex justify-end space-x-2 pt-4">
                        <a href="{{ route('operator.nasabah.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-black rounded-md shadow-md">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>