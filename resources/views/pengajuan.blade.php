@extends('layouts.layoutmhs')
@section('content')
<div class="flex-grow max-w-4xl mx-auto bg-white p-4 rounded-lg shadow-md text-sm">
    <h2 class="text-lg font-bold mb-2 text-center">Form Pengajuan Tugas Akhir</h2>

    <form>
        <label class="block font-medium">Judul Tugas Akhir</label>
        <input type="text" class="w-full p-1 border rounded mb-2 h-8 text-sm" required>

        <label class="block font-medium">Deskripsi Project</label>
        <textarea class="w-full p-1 border rounded mb-2 h-20 text-sm" required></textarea>

        <label class="block font-medium mb-1">Bidang Minat Penelitian Mahasiswa</label>
        <div class="mb-3">
            <label class="mr-3"><input type="radio" name="bidang" value="RPL" onclick="tampilkanDosen()"> Rekayasa Perangkat Lunak</label>
            <label class="mr-3"><input type="radio" name="bidang" value="Data Mining" onclick="tampilkanDosen()"> Data Mining</label>
            <label class="mr-3"><input type="radio" name="bidang" value="Jaringan" onclick="tampilkanDosen()"> Jaringan</label>
            <label><input type="radio" name="bidang" value="GIS" onclick="tampilkanDosen()"> GIS</label>
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
                <label class="mr-3"><input type="radio" name="bidangDospem2" value="RPL" onclick="tampilkanDosen2()"> Rekayasa Perangkat Lunak</label>
                <label class="mr-3"><input type="radio" name="bidangDospem2" value="Data Mining" onclick="tampilkanDosen2()"> Data Mining</label>
                <label class="mr-3"><input type="radio" name="bidangDospem2" value="Jaringan" onclick="tampilkanDosen2()"> Jaringan</label>
                <label class="mr-3"><input type="radio" name="bidangDospem2" value="GIS" onclick="tampilkanDosen2()"> GIS</label>
                <label><input type="radio" name="bidangDospem2" value="Lainnya" onclick="tampilkanDosen2()"> Lainnya</label>
            </div>

            <div id="dosen2Selection" class="hidden mt-3">
                <label class="block font-medium mb-1">Cari Dosen Pembimbing 2 (opsional)</label>
                <div class="relative mb-3">
                    <input type="text" id="searchDospem2" class="w-full p-1 border rounded pl-8 h-8 text-sm" placeholder="Cari Dosen...">
                    <p id="instruksi" class="italic text-red-500 hidden">*Apabila dosen berada diluar informatika maka search diluar tabel</p>
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
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('waitingpage') }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition text-sm inline-block">
                <i class="fa-solid fa-paper-plane mr-1"></i> Ajukan Dosen Pembimbing
            </a>
        </div>
    </form>
</div>

<script>
    const dataDosen = {
        "RPL": [
            { nama: "Dr. Muzailin S.Si, M.Sc.", nip: "197010191995121001", jabatan: "Lektor", kuota: 21, maxKuota: 25 },
            { nama: "Dr. Rahmat Hidayat, S.T., M.T.", nip: "198509231997021002", jabatan: "Lektor", kuota: 25, maxKuota: 25 }
        ],
        "Data Mining": [
            { nama: "Dr. Siti Aminah, S.Kom, M.Kom", nip: "198211101999032003", jabatan: "Lektor Kepala", kuota: 18, maxKuota: 25 },
            { nama: "Dr. Arif Ramadhan, S.T., M.Kom", nip: "197812221996031005", jabatan: "Lektor", kuota: 25, maxKuota: 25 }
        ],
        "Jaringan": [
            { nama: "Dr. Andi Wijaya, S.T., M.T.", nip: "197504101998021004", jabatan: "Lektor", kuota: 22, maxKuota: 25 },
            { nama: "Dr. Bambang Susilo, S.T., M.T.", nip: "198112051999032001", jabatan: "Lektor", kuota: 25, maxKuota: 25 }
        ],
        "GIS": [
            { nama: "Prof. Budi Santoso, M.T.", nip: "196504121993011002", jabatan: "Guru Besar", kuota: 15, maxKuota: 20 },
            { nama: "Dr. Ahmad Fauzan, S.Kom, M.Kom", nip: "197908151998021007", jabatan: "Lektor Kepala", kuota: 20, maxKuota: 20 }
        ]
    };

    function tampilkanDosen() {
        const bidang = document.querySelector('input[name="bidang"]:checked')?.value;
        const container = document.getElementById("dosenContainer");
        const div = document.getElementById("dosenSelection");

        container.innerHTML = "";

        if (!bidang || !dataDosen[bidang]) {
            div.classList.add("hidden");
            return;
        }

        dataDosen[bidang].forEach(dosen => buatBarisDosen(dosen, container, "dosenPembimbing"));
        div.classList.remove("hidden");
    }

    function tampilkanDosen2() {
        const bidang = document.querySelector('input[name="bidangDospem2"]:checked')?.value;
        const container = document.getElementById("dosen2Container");
        const div = document.getElementById("dosen2Selection");
        const instruksi = document.getElementById("instruksi");
        const dosen2Table = document.getElementById("dosen2Table");

        container.innerHTML = "";

        if (bidang === "Lainnya") {
            // Jika memilih "Lainnya", hanya tampilkan search dan instruksi
            dosen2Table.classList.add("hidden");
            instruksi.classList.remove("hidden");
            div.classList.remove("hidden");
        } else {
            dosen2Table.classList.remove("hidden");
            instruksi.classList.add("hidden");

            if (!bidang || !dataDosen[bidang]) {
                div.classList.add("hidden");
                return;
            }

            dataDosen[bidang].forEach(dosen => buatBarisDosen(dosen, container, "dosenPembimbing2"));
            div.classList.remove("hidden");
        }
    }

    function buatBarisDosen(dosen, container, nameInput) {
        const isDisabled = dosen.kuota >= dosen.maxKuota;

        const tr = document.createElement("tr");

        const tdCheckbox = document.createElement("td");
        const input = document.createElement("input");
        input.type = "checkbox";
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
        tdKuota.textContent = `${dosen.kuota}/${dosen.maxKuota}`;
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
        container.innerHTML = "";

        Object.values(dataDosen).flat().forEach(dosen => {
            const cocok = dosen.nama.toLowerCase().includes(filter) || dosen.nip.includes(filter);
            if (cocok) buatBarisDosen(dosen, container, "dosenPembimbing2");
        });
    });
</script>
@endsection
