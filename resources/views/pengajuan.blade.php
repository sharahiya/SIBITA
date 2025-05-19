@extends('layouts.layoutmhs')
@section('content')
<div class="flex-grow max-w-4xl mx-auto bg-white p-4 rounded-lg shadow-md text-sm">
    <h2 class="text-lg font-bold mb-2 text-center">Form Pengajuan Tugas Akhir</h2>

    <form action="{{ route('pengajuan.store') }}" method="POST">
        @csrf
        <label class="block font-medium">Judul Tugas Akhir</label>
        <input type="text" name="judul" class="w-full p-1 border rounded mb-2 h-8 text-sm" required>

        <label class="block font-medium">Deskripsi Project</label>
        <textarea name="deskripsi" class="w-full p-1 border rounded mb-2 h-20 text-sm" required></textarea>

        <label class="block font-medium mb-1">Bidang Minat Penelitian Mahasiswa</label>
        <div class="mb-3">
            @foreach(['Rekayasa Perangkat Lunak', 'Data Mining', 'Jaringan', 'GIS'] as $minat)
                <label class="mr-3">
                    <input type="radio" name="bidang" value="{{ $minat }}" onclick="tampilkanDosen()"> {{ $minat }}
                </label>
            @endforeach
        </div>

        <div id="dosenSelection" class="hidden">
            <h3 class="font-medium mb-1">Rekomendasi Dosen Pembimbing 1</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-2 text-xs">Pilih</th>
                        <th class="border border-gray-300 p-2 text-xs">Nama Dosen</th>
                        <th class="border border-gray-300 p-2 text-xs">NIP</th>
                        <th class="border border-gray-300 p-2 text-xs">Jabatan</th>
                        <th class="border border-gray-300 p-2 text-xs">Kuota</th>
                    </tr>
                </thead>
                <tbody id="dosenContainer"></tbody>
            </table>
        </div>

        <div class="mt-6">
            <label class="block font-medium mb-1">Bidang Minat Dosen Pembimbing 2</label>
            <div class="mb-2">
                @foreach(['Rekayasa Perangkat Lunak', 'Data Mining', 'Jaringan', 'GIS', 'Lainnya'] as $minat)
                    <label class="mr-3">
                        <input type="radio" name="bidangDospem2" value="{{ $minat }}" onclick="tampilkanDosen2()"> {{ $minat }}
                    </label>
                @endforeach
            </div>

            <div id="dosen2Selection" class="hidden mt-3">
                <label class="block font-medium mb-1">Cari Dosen Pembimbing 2 (opsional)</label>
                <div class="relative mb-3">
                    <input type="text" id="searchDospem2" class="w-full p-1 border rounded pl-8 h-8 text-sm" placeholder="Cari Dosen...">
                    <p id="instruksi" class="italic text-red-500 hidden">*Apabila dosen berada di luar Informatika maka search di luar tabel</p>
                    <i class="fa fa-search absolute left-2 top-2 text-gray-500 text-xs"></i>
                </div>

                <table class="w-full border-collapse border border-gray-300" id="dosen2Table">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 p-2 text-xs">Pilih</th>
                            <th class="border border-gray-300 p-2 text-xs">Nama Dosen</th>
                            <th class="border border-gray-300 p-2 text-xs">NIP</th>
                            <th class="border border-gray-300 p-2 text-xs">Jabatan</th>
                            <th class="border border-gray-300 p-2 text-xs">Kuota</th>
                        </tr>
                    </thead>
                    <tbody id="dosen2Container"></tbody>
                </table>

                <div class="mt-2 text-sm">
                    <label>Atau masukkan nama dosen pembimbing 2 secara manual:</label>
                    <input type="text" name="manual_dosen_2" class="w-full p-1 border rounded h-8 mt-1" placeholder="Contoh: Dr. Fulan dari FTI">
                </div>
            </div>
        </div>

        <div class="mt-4 text-center">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition text-sm inline-block">
                <i class="fa-solid fa-paper-plane mr-1"></i> Ajukan Dosen Pembimbing
            </button>
        </div>
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
                data.forEach(dosen => buatBarisDosen(dosen, container, 'dosenPembimbing'));
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

    // AJAX untuk ambil dosen berdasarkan bidang
    fetch(`/dosen/bidang/${bidang}`)
        .then(res => res.json())
        .then(data => {
            container.innerHTML = '';
            data.forEach(dosen => buatBarisDosen(dosen, container, 'dosenPembimbing2'));

            dosen2Table.classList.remove("hidden");
            instruksi.classList.add("hidden");
        })
        .catch(error => {
            console.error('Gagal memuat dosen pembimbing 2:', error);
            div.classList.add("hidden");
        });
}

    function buatBarisDosen(dosen, container, nameInput) {
        const isDisabled = dosen.kuota >= dosen.kuota_bimbingan;

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
        tdKuota.textContent = `${dosen.kuota}/${dosen.kuota_bimbingan}`;
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

    // PENTING: tampilkan div dan tabel agar hasil terlihat
    div.classList.remove("hidden");
    table.classList.remove("hidden");
    instruksi.classList.add("hidden");

    fetch(`/search-dosen?q=${filter}`)
        .then(res => res.json())
        .then(data => {
            container.innerHTML = '';
            data.forEach(dosen => buatBarisDosen(dosen, container, "dosenPembimbing2"));
        })
        .catch(err => {
            console.error("Gagal mencari dosen:", err);
        });
});
</script>
@endsection
