<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Input Peminjaman Baru - Smart Pocket</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-screen z-20">

        <div class="p-6 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-wallet text-white text-lg"></i>
                </div>

                <div>
                    <h1 class="text-lg font-bold text-slate-900">
                        Smart Pocket
                    </h1>

                    <p class="text-[10px] text-slate-500 font-medium">
                        BMT SMKN 11 BANDUNG
                    </p>
                </div>

            </div>

        </div>

        <nav class="p-4 space-y-1 flex-1 overflow-y-auto">

            <a href="{{ route('operator.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">

                <i class="fas fa-home w-5 text-center"></i>
                Dashboard

            </a>

            <a href="{{ route('operator.nasabah.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">

                <i class="fas fa-users w-5 text-center"></i>
                Data Nasabah

            </a>

            <a href="{{ route('operator.transaksi.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">

                <i class="fas fa-exchange-alt w-5 text-center"></i>
                Transaksi

            </a>

            <a href="{{ route('operator.peminjaman.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium">

                <i class="fas fa-hand-holding-usd w-5 text-center"></i>
                Peminjaman

            </a>

            <a href="{{ route('operator.verifikasi.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">

                <i class="fas fa-check-circle w-5 text-center"></i>
                Verifikasi

            </a>

            <a href="{{ route('operator.laporan.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-gray-50 rounded-lg text-sm font-medium">

                <i class="fas fa-chart-bar w-5 text-center"></i>
                Laporan

            </a>

        </nav>

        <div class="p-4 border-t border-gray-100">

            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                        class="w-full bg-white border border-gray-200 hover:bg-red-50 hover:text-red-600 text-slate-600 text-sm font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">

                    <i class="fas fa-sign-out-alt text-xs"></i>
                    Logout

                </button>

            </form>

        </div>

    </aside>


    <!-- MAIN -->
    <main class="flex-1 ml-64 p-6">

        <!-- HEADER -->
        <div class="mb-5">

            <div class="flex justify-between items-start">

                <div>

                    <h1 class="text-xl lg:text-2xl font-bold text-slate-900">
                        Input Peminjaman Baru
                    </h1>

                    <p class="text-sm text-slate-500 mt-1">
                        Proses peminjaman langsung melalui teller BMT.
                    </p>

                </div>

                <a href="{{ route('operator.peminjaman.index') }}"
                   class="px-4 py-2 border border-gray-200 text-slate-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">

                    <i class="fas fa-arrow-left text-xs"></i>
                    Kembali

                </a>

            </div>

        </div>


        <!-- ERROR -->
        @if ($errors->any())

            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">

                <div class="flex items-start gap-2">

                    <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>

                    <div>

                        <p class="text-sm font-semibold text-red-800">
                            Data belum lengkap
                        </p>

                        <ul class="mt-1 text-xs text-red-700 list-disc list-inside">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        @if(session('success'))

            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-lg">

                <div class="flex items-center gap-2">

                    <i class="fas fa-check-circle text-emerald-600"></i>

                    <p class="text-sm font-semibold text-emerald-800">
                        {{ session('success') }}
                    </p>

                </div>

            </div>

        @endif


        @if(session('error'))

            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">

                <div class="flex items-center gap-2">

                    <i class="fas fa-exclamation-circle text-red-600"></i>

                    <p class="text-sm font-semibold text-red-800">
                        {{ session('error') }}
                    </p>

                </div>

            </div>

        @endif


        <!-- FORM -->
        <form action="{{ route('operator.peminjaman.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">


                <!-- LEFT -->
                <div class="lg:col-span-2 space-y-4">


                    <!-- IDENTITAS PEMINJAM -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">

                        <div class="flex items-center gap-2 mb-3">

                            <i class="fas fa-user-circle text-emerald-600"></i>

                            <h3 class="text-sm font-bold text-slate-900">
                                Identitas Peminjam
                            </h3>

                        </div>


                        <!-- SEARCH -->
                        <div class="mb-4">

                            <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">

                                Cari Nasabah

                            </label>

                            <div class="flex gap-2">

                                <input
                                    type="text"
                                    id="searchNasabah"
                                    placeholder="Ketik nama atau no. rekening..."

                                    class="flex-1 px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"

                                    onkeyup="filterNasabah()"
                                >

                                <button
                                    type="button"
                                    onclick="filterNasabah()"

                                    class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold">

                                    <i class="fas fa-search text-xs"></i>

                                </button>

                            </div>


                            <!-- HASIL SEARCH -->
                            <div
                                id="dropdownNasabah"

                                class="hidden mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-52 overflow-y-auto z-30"
                            >

                                @foreach($nasabahs as $n)

                                    <div
                                        onclick="pilihNasabah(
                                            '{{ $n->id_nasabah }}',
                                            '{{ addslashes($n->nama) }}',
                                            '{{ $n->rekening->no_rek ?? '-' }}',
                                            '{{ $n->kategori }}',
                                            '{{ $n->rekening->saldo ?? 0 }}'
                                        )"

                                        class="nasabah-item px-3 py-2.5 hover:bg-emerald-50 cursor-pointer border-b border-gray-100 last:border-0"
                                    >

                                        <p class="text-sm font-bold text-slate-900">

                                            {{ $n->nama }}

                                        </p>

                                        <p class="text-xs text-slate-500">

                                            No. Rek:
                                            <span class="font-mono font-semibold">
                                                {{ $n->rekening->no_rek ?? '-' }}
                                            </span>

                                            |

                                            Kategori:
                                            {{ ucfirst($n->kategori) }}

                                        </p>

                                    </div>

                                @endforeach

                            </div>

                            @error('id_nasabah')

                                <p class="text-xs text-red-600 mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <!-- DATA TERPILIH -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">


                            <div>

                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">

                                    Nama Lengkap

                                </label>

                                <input
                                    type="hidden"
                                    name="id_nasabah"
                                    id="id_nasabah"
                                >

                                <div class="px-3 py-2 bg-blue-50 border border-blue-200 rounded-lg min-h-[40px] flex items-center">

                                    <p id="displayNama"
                                       class="text-sm font-semibold text-slate-900">

                                        -

                                    </p>

                                </div>

                            </div>


                            <div>

                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">

                                    No. Rekening

                                </label>

                                <div class="px-3 py-2 bg-blue-50 border border-blue-200 rounded-lg min-h-[40px] flex items-center">

                                    <p id="displayNoRek"
                                       class="text-sm font-semibold text-slate-900 font-mono">

                                        -

                                    </p>

                                </div>

                            </div>


                            <div>

                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">

                                    Saldo Saat Ini

                                </label>

                                <div class="px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-lg min-h-[40px] flex items-center">

                                    <p id="displaySaldo"
                                       class="text-sm font-bold text-emerald-700">

                                        Rp 0

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- DETAIL PEMINJAMAN -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">

                        <div class="flex items-center gap-2 mb-4">

                            <i class="fas fa-hand-holding-usd text-emerald-600"></i>

                            <h3 class="text-sm font-bold text-slate-900">

                                Detail Peminjaman

                            </h3>

                        </div>


                        <!-- NOMINAL + TENOR -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">


                            <!-- NOMINAL -->
                            <div>

                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">

                                    Nominal Pinjaman
                                    <span class="text-red-500">*</span>

                                </label>

                                <div class="relative">

                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm font-semibold">

                                        Rp

                                    </span>

                                    <input
                                        type="number"
                                        name="jumlah_pinjaman"
                                        id="nominal"
                                        value="{{ old('jumlah_pinjaman') }}"
                                        min="50000"
                                        step="10000"
                                        required

                                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-right"
                                    >

                                </div>

                                <p class="text-[10px] text-slate-400 mt-1">

                                    Minimal Rp 50.000.

                                </p>

                                @error('jumlah_pinjaman')

                                    <p class="text-xs text-red-600 mt-1">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- TENOR -->
                            <div>

                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">

                                    Tenor
                                    <span class="text-red-500">*</span>

                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        name="tenor"
                                        id="tenor"
                                        value="{{ old('tenor') }}"
                                        min="1"
                                        max="24"
                                        required
                                        placeholder="Contoh: 10"
                                        class="w-full pr-20 px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                                    >
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-500 font-medium">
                                        Bulan
                                    </span>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1">
                                    Masukkan tenor.
                                </p>

                                @error('tenor')

                                    <p class="text-xs text-red-600 mt-1">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>


                        <!-- TANGGAL -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">


                            <!-- TANGGAL PINJAM -->
                            <div>

                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">

                                    Tanggal Pinjam
                                    <span class="text-red-500">*</span>

                                </label>

                                <input
                                    type="date"
                                    name="tanggal_ajuan"
                                    id="tanggalPinjam"
                                    value="{{ old('tanggal_ajuan', date('Y-m-d')) }}"
                                    required

                                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                                >

                                @error('tanggal_ajuan')

                                    <p class="text-xs text-red-600 mt-1">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- JATUH TEMPO -->
                            <div>

                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">

                                    Tanggal Jatuh Tempo
                                    <span class="text-red-500">*</span>

                                </label>

                                <input
                                    type="date"
                                    name="tanggal_jatuh_tempo"
                                    id="tanggalJatuhTempo"
                                    value="{{ old('tanggal_jatuh_tempo') }}"
                                    required

                                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                                >

                                @error('tanggal_jatuh_tempo')

                                    <p class="text-xs text-red-600 mt-1">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>


                        <!-- KETERANGAN -->
                        <div class="mb-2">

                            <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1.5">

                                Keterangan
                                <span class="text-slate-400 font-normal">
                                    (Opsional)
                                </span>

                            </label>

                            <textarea
                                name="keterangan"
                                rows="3"
                                placeholder="Contoh: Peminjaman untuk kebutuhan rumah tangga..."

                                class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 resize-none"
                            >{{ old('keterangan') }}</textarea>

                        </div>

                    </div>

                </div>


                <!-- RIGHT COLUMN -->
                <div>

                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 sticky top-4">

                        <h3 class="text-sm font-bold text-slate-900 mb-4">

                            Ringkasan Peminjaman

                        </h3>


                        <div class="space-y-3 mb-5">


                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">

                                <span class="text-xs text-slate-600">
                                    Peminjam
                                </span>

                                <span
                                    id="summaryNama"
                                    class="text-xs font-bold text-slate-900 text-right max-w-[150px]"
                                >
                                    -
                                </span>

                            </div>


                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">

                                <span class="text-xs text-slate-600">
                                    No. Rekening
                                </span>

                                <span
                                    id="summaryRek"
                                    class="text-xs font-bold text-slate-900 font-mono"
                                >
                                    -
                                </span>

                            </div>


                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">

                                <span class="text-xs text-slate-600">
                                    Nominal
                                </span>

                                <span
                                    id="summaryNominal"
                                    class="text-sm font-bold text-blue-600"
                                >
                                    Rp 0
                                </span>

                            </div>


                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">

                                <span class="text-xs text-slate-600">
                                    Tenor
                                </span>

                                <span
                                    id="summaryTenor"
                                    class="text-xs font-bold text-slate-900"
                                >
                                    0 Bulan
                                </span>

                            </div>


                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">

                                <span class="text-xs text-slate-600">
                                    Angsuran / Bulan
                                </span>

                                <span
                                    id="summaryAngsuran"
                                    class="text-sm font-bold text-emerald-600"
                                >
                                    Rp 0
                                </span>

                            </div>

                        </div>


                        <!-- INFO -->
                        <div class="p-3 bg-blue-50 border border-blue-100 rounded-lg mb-4">

                            <div class="flex gap-2">

                                <i class="fas fa-info-circle text-blue-500 text-xs mt-0.5"></i>

                                <p class="text-[10px] text-blue-700 leading-relaxed">

                                    Peminjaman yang diproses melalui teller
                                    langsung tercatat sebagai peminjaman
                                    yang disetujui.

                                </p>

                            </div>

                        </div>


                        <!-- BUTTON -->
                        <button
                            type="submit"

                            class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2 text-sm shadow-sm mb-2"
                        >

                            <i class="fas fa-save text-xs"></i>

                            Simpan Peminjaman

                        </button>
                        <a
                            href="{{ route('operator.peminjaman.index') }}"

                            class="w-full py-2 border border-gray-200 text-slate-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors text-sm text-center block"
                        >
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

<script>

    let currentSaldo = 0;


    /*
    |--------------------------------------------------------------------------
    | SEARCH NASABAH
    |--------------------------------------------------------------------------
    */

    function filterNasabah() {

        const searchValue =
            document
                .getElementById('searchNasabah')
                .value
                .toLowerCase()
                .trim();

        const dropdown =
            document.getElementById('dropdownNasabah');

        const items =
            dropdown.querySelectorAll('.nasabah-item');

        let adaHasil = false;


        items.forEach(function(item) {

            const text =
                item.textContent.toLowerCase();

            if (
                searchValue === '' ||
                text.includes(searchValue)
            ) {

                item.style.display = 'block';

                if (searchValue !== '') {
                    adaHasil = true;
                }

            } else {

                item.style.display = 'none';

            }

        });


        if (searchValue !== '' && adaHasil) {

            dropdown.classList.remove('hidden');

        } else {

            dropdown.classList.add('hidden');

        }

    }


    /*
    |--------------------------------------------------------------------------
    | PILIH NASABAH
    |--------------------------------------------------------------------------
    */

    function pilihNasabah(
        id,
        nama,
        norek,
        kategori,
        saldo
    ) {

        document.getElementById('id_nasabah').value = id;

        document.getElementById('displayNama').textContent = nama;

        document.getElementById('displayNoRek').textContent = norek;

        document.getElementById('displaySaldo').textContent =
            'Rp ' + Number(saldo).toLocaleString('id-ID');


        document.getElementById('searchNasabah').value =
            nama;


        document
            .getElementById('dropdownNasabah')
            .classList.add('hidden');


        currentSaldo = Number(saldo) || 0;


        document.getElementById('summaryNama').textContent =
            nama;

        document.getElementById('summaryRek').textContent =
            norek;


        updateSummary();

    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG SIMULASI
    |--------------------------------------------------------------------------
    */

    function updateSummary() {

        const nominal =
            Number(
                document.getElementById('nominal').value
            ) || 0;

        const tenor =
            Number(
                document.getElementById('tenor').value
            ) || 0;


        const angsuran =
            tenor > 0
                ? nominal / tenor
                : 0;


        document.getElementById('summaryNominal').textContent =
            'Rp ' +
            nominal.toLocaleString('id-ID');


        document.getElementById('summaryTenor').textContent =
            tenor +
            ' Bulan';


        document.getElementById('summaryAngsuran').textContent =
            'Rp ' +
            Math.round(angsuran).toLocaleString('id-ID');

    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG JATUH TEMPO
    |--------------------------------------------------------------------------
    */

    function calculateJatuhTempo() {

        const tanggalPinjam =
            document.getElementById('tanggalPinjam').value;

        const tenor =
            Number(
                document.getElementById('tenor').value
            ) || 0;


        if (!tanggalPinjam || tenor <= 0) {
            return;
        }


        const tanggal =
            new Date(tanggalPinjam);


        tanggal.setMonth(
            tanggal.getMonth() + tenor
        );


        const year =
            tanggal.getFullYear();

        const month =
            String(
                tanggal.getMonth() + 1
            ).padStart(2, '0');

        const day =
            String(
                tanggal.getDate()
            ).padStart(2, '0');


        document.getElementById('tanggalJatuhTempo').value =
            `${year}-${month}-${day}`;

    }


    /*
    |--------------------------------------------------------------------------
    | EVENT
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('nominal')
        .addEventListener(
            'input',
            updateSummary
        );


    document
        .getElementById('tenor')
        .addEventListener(
            'change',
            function() {

                updateSummary();

                calculateJatuhTempo();

            }
        );


    document
        .getElementById('tanggalPinjam')
        .addEventListener(
            'change',
            calculateJatuhTempo
        );


    /*
    |--------------------------------------------------------------------------
    | TUTUP DROPDOWN KETIKA KLIK DI LUAR
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function(event) {

            const searchBox =
                document.getElementById('searchNasabah');

            const dropdown =
                document.getElementById('dropdownNasabah');


            if (
                !searchBox.contains(event.target) &&
                !dropdown.contains(event.target)
            ) {

                dropdown.classList.add('hidden');

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INIT
    |--------------------------------------------------------------------------
    */

    updateSummary();

    calculateJatuhTempo();

</script>

</body>
</html>