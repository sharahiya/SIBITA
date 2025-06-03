@extends('layouts.layoutmhs')
@section('content')
<div class="flex-grow max-w-4xl mx-auto bg-white p-6 rounded-2xl shadow-md text-sm">
    <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Form Pengajuan Pembimbing & Tugas Akhir</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error:</strong>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengajuan.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Informasi Tugas Akhir --}}
        <div>
            <p class="text-xs uppercase text-gray-500 mb-1">Informasi Tugas Akhir</p>
            <label class="block font-medium mb-1">Judul Tugas Akhir</label>
            <input type="text" name="judul" class="w-full p-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('judul', $pengajuan1->topik_ta ?? $pengajuan2->topik_ta ?? '') }}" required>

            <label class="block font-medium mt-4 mb-1">Deskripsi Project</label>
            <textarea name="deskripsi" class="w-full p-2 border rounded-md text-sm h-24 resize-none focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ old('deskripsi', $pengajuan1->deskripsi_ta ?? $pengajuan2->deskripsi_ta ?? '') }}</textarea>
        </div>

        {{-- Bidang Minat --}}
        <div>
            <p class="text-xs uppercase text-gray-500 mb-1">Bidang Minat Penelitian Mahasiswa</p>
            <div class="flex flex-wrap gap-4">
                @php
                    // dd($pengajuan1->bidang);
                    $selectedBidang = old('bidang') !== null ? old('bidang') : ($pengajuan1->bidang ?? '');
                @endphp

                @foreach(['Rekayasa Perangkat Lunak', 'Data Mining', 'Jaringan', 'GIS'] as $minat)
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="bidang" value="{{ $minat }}"
                            {{ $selectedBidang === $minat ? 'checked' : '' }}
                            onclick="tampilkanDosen()">
                        <span>{{ $minat }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Dosen Pembimbing 1 --}}
        <div>
            <p class="text-xs uppercase text-gray-500 mb-1">Dosen Pembimbing 1</p>
            @if(isset($pengajuan1))
                <div class="mb-3">
                    <label class="block font-medium mb-1">Nama Dosen</label>
                    <div class="flex items-center gap-2">
                        <input type="text" class="w-full p-2 border rounded bg-gray-100 text-sm" value="{{ $pengajuan1->dosen->nama }}" disabled>
                        <input type="hidden" class="w-full p-2 border rounded bg-gray-100 text-sm" name="dosenPembimbing" value="{{ $pengajuan1->dosen->nama }}">
                        <a href="{{ route('pengajuan.store', ['id' => $pengajuan1->dosen->id_dosen]) }}" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">Profil</a>
                    </div>
                    <p class="mt-1 text-sm {{ $pengajuan1->status === 'diterima' ? 'text-green-600' : ($pengajuan1->status === 'pending' ? 'text-yellow-600' : 'text-red-600') }}">
                        Status: {{ ucfirst($pengajuan1->status) }}
                    </p>
                </div>
            @else
                <div id="dosenSelection" class="hidden mt-3">
                    <h3 class="font-medium mb-2">Rekomendasi Dosen Pembimbing 1</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border text-xs text-left">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-2 py-1">Pilih</th>
                                    <th class="border px-2 py-1">Nama</th>
                                    <th class="border px-2 py-1">NIP</th>
                                    <th class="border px-2 py-1">Jabatan</th>
                                    <th class="border px-2 py-1">Kuota</th>
                                </tr>
                            </thead>
                            <tbody id="dosenContainer"></tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        {{-- Dosen Pembimbing 2 --}}
        <div>
            <p class="text-xs uppercase text-gray-500 mb-1">Dosen Pembimbing 2</p>
            @if(isset($pengajuan2))
            <div class="mb-3">
                <label class="block font-medium mb-1">Nama Dosen</label>
                <div class="flex items-center gap-2">
                    <input type="text" class="w-full p-2 border rounded bg-gray-100 text-sm" value="{{ $pengajuan2->dosen->nama }}" disabled>
                    <input type="hidden" class="w-full p-2 border rounded bg-gray-100 text-sm" name="dosenPembimbing2" value="{{ $pengajuan2->dosen->nama }}">
                    <a href="{{ route('pengajuan.store', ['id' => $pengajuan2->dosen->id_dosen]) }}" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">Profil</a>
                </div>
                <p class="mt-1 text-sm {{ $pengajuan2->status === 'diterima' ? 'text-green-600' : ($pengajuan2->status === 'pending' ? 'text-yellow-600' : 'text-red-600') }}">
                    Status: {{ ucfirst($pengajuan2->status) }}
                </p>
            </div>
            @else
                <div class="mt-3">
                    <label class="block font-medium mb-1">Bidang Minat Dosen Pembimbing 2</label>
                    <div class="flex flex-wrap gap-4 mb-3">
                        @foreach(['Rekayasa Perangkat Lunak', 'Data Mining', 'Jaringan', 'GIS', 'Lainnya'] as $minat)
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="bidangDospem2" value="{{ $minat }}" onclick="tampilkanDosen2()">
                                <span>{{ $minat }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div id="dosen2Selection" class="hidden">
                        <label class="block font-medium mb-2">Cari Dosen Pembimbing 2 (opsional)</label>
                        <div class="relative mb-2">
                            <input type="text" id="searchDospem2" class="w-full p-2 border rounded pl-8 text-sm" placeholder="Cari Dosen...">
                            <i class="fa fa-search absolute left-2 top-2 text-gray-500 text-xs"></i>
                            <p id="instruksi" class="italic text-red-500 mt-1 hidden">*Jika dosen di luar informatika, lakukan pencarian manual.</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full border text-xs text-left" id="dosen2Table">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-2 py-1">Pilih</th>
                                        <th class="border px-2 py-1">Nama</th>
                                        <th class="border px-2 py-1">NIP</th>
                                        <th class="border px-2 py-1">Jabatan</th>
                                        <th class="border px-2 py-1">Kuota</th>
                                    </tr>
                                </thead>
                                <tbody id="dosen2Container"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Tombol Submit --}}
        @if((!isset($pengajuan1) || !isset($pengajuan2))  && ($pengajuan2?->status !== 'diterima' || $pengajuan1?->status !== 'diterima'))
        <div class="text-center pt-2">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fa-solid fa-paper-plane mr-2"></i> Ajukan Dosen Pembimbing
            </button>
        </div>
        @endif
    </form>
</div>

<script>
    function tampilkanDosen() {
        const bidang = document.querySelector('input[name="bidang"]:checked')?.value;
        const container = document.getElementById("dosenContainer");
        const div = document.getElementById("dosenSelection");

        if (!bidang) {
            div.classList.add("hidden");
            return;
        }

        fetch(`/dosen/bidang/${bidang}`)
            .then(res => res.json())
            .then(data => {
                container.innerHTML = '';
                data.forEach(dosen => buatBarisDosen(dosen, container, 'dosenPembimbing', 'dosenAktif'));
                div.classList.remove("hidden");
            });
    }

    function tampilkanDosen2() {
        const bidang = document.querySelector('input[name="bidangDospem2"]:checked')?.value;
        const container = document.getElementById("dosen2Container");
        const div = document.getElementById("dosen2Selection");
        const instruksi = document.getElementById("instruksi");
        const dosen2Table = document.getElementById("dosen2Table");
        const searchInput = document.getElementById("searchDospem2");

        container.innerHTML = "";
        searchInput.value = "";

        if (!bidang) {
            div.classList.add("hidden");
            return;
        }

        div.classList.remove("hidden");

        if (bidang === "Lainnya") {
            dosen2Table.classList.add("hidden");
            instruksi.classList.remove("hidden");
            return;
        }

        fetch(`/dosen/bidang/${bidang}`)
            .then(res => res.json())
            .then(data => {
                container.innerHTML = '';
                data.forEach(dosen => buatBarisDosen(dosen, container, 'dosenPembimbing2', 'dosenAktif'));
                dosen2Table.classList.remove("hidden");
                instruksi.classList.add("hidden");
            })
            .catch(error => {
                console.error('Gagal memuat dosen pembimbing 2:', error);
                div.classList.add("hidden");
            });
    }

    function buatBarisDosen(dosen, container, nameInput, dosenAktifKey) {
        const isDisabled = dosen.jumlahMahasiswaBimbingan >= dosen.kuota_bimbingan || dosen[dosenAktifKey];

        const tr = document.createElement("tr");

        const tdCheckbox = document.createElement("td");
        const input = document.createElement("input");
        input.type = "radio";
        input.name = nameInput;
        input.value = dosen.nama;
        input.classList.add("ml-2");
        if (isDisabled) input.disabled = true;
        tdCheckbox.classList.add("text-center");
        tdCheckbox.appendChild(input);

        const tdNama = document.createElement("td");
        tdNama.textContent = dosen.nama;

        const tdNip = document.createElement("td");
        tdNip.textContent = dosen.nip;

        const tdJabatan = document.createElement("td");
        tdJabatan.textContent = dosen.jabatan;

        const tdKuota = document.createElement("td");
        tdKuota.textContent = `${dosen.jumlah_pengajuan}/${dosen.kuota_bimbingan}`;
        if (isDisabled) tdKuota.classList.add("text-gray-500");

        tr.appendChild(tdCheckbox);
        tr.appendChild(tdNama);
        tr.appendChild(tdNip);
        tr.appendChild(tdJabatan);
        tr.appendChild(tdKuota);

        container.appendChild(tr);
    }

    document.getElementById("searchDospem2").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const container = document.getElementById("dosen2Container");
        const div = document.getElementById("dosen2Selection");
        const table = document.getElementById("dosen2Table");
        const instruksi = document.getElementById("instruksi");

        if (!filter) {
            container.innerHTML = '';
            return;
        }

        div.classList.remove("hidden");
        table.classList.remove("hidden");
        instruksi.classList.add("hidden");

        fetch(`/search-dosen?q=${filter}`)
            .then(res => res.json())
            .then(data => {
                container.innerHTML = '';
                data.forEach(dosen => buatBarisDosen(dosen, container, "dosenPembimbing2", 'dosenAktif'));
            })
            .catch(err => {
                console.error("Gagal mencari dosen:", err);
            });
    });
</script>
@endsection
