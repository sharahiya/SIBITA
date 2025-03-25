<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Tugas Akhir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ["Poppins", "sans-serif"],
                    },
                },
            },
        };
    </script>
</head>
<body class="font-poppins bg-blue-100">

@include('components/navbar')

<div class="flex-grow max-w-4xl mt-20 mx-auto bg-white p-4 rounded-lg shadow-md text-sm">
    <h2 class="text-lg font-bold mb-2 text-center">Form Pengajuan Tugas Akhir</h2>
    
    <form>
        <label class="block font-medium">Judul Tugas Akhir</label>
        <input type="text" class="w-full p-1 border rounded mb-2 h-8 text-sm" required>
        
        <label class="block font-medium">Deskripsi Project</label>
        <textarea class="w-full p-1 border rounded mb-2 h-20 text-sm" required></textarea>
        
        <label class="block font-medium mb-1">Bidang Minat Penelitian</label>
        <div class="mb-3">
            <label class="mr-3"><input type="radio" name="bidang" value="RPL" onclick="tampilkanDosen()"> Rekayasa Perangkat Lunak</label>
            <label class="mr-3"><input type="radio" name="bidang" value="Data Mining" onclick="tampilkanDosen()"> Data Mining</label>
            <label class="mr-3"><input type="radio" name="bidang" value="Jaringan" onclick="tampilkanDosen()"> Jaringan</label>
            <label><input type="radio" name="bidang" value="GIS" onclick="tampilkanDosen()"> GIS</label>
        </div>

        <div id="dosenSelection" class="hidden">
            <h3 class="text-base font-semibold mb-2">Pilih Dosen Pembimbing</h3>
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

        <div class="mt-3">
            <label class="block font-medium mb-1">Cari Dosen Pembimbing 2</label>
            <div class="relative">
                <input type="text" id="searchDospem2" class="w-full p-1 border rounded pl-8 h-8 text-sm" placeholder="Cari Dosen...">
                <i class="fa fa-search absolute left-2 top-2 text-gray-500 text-xs"></i>
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
        let bidang = document.querySelector('input[name="bidang"]:checked').value;
        let dosenContainer = document.getElementById("dosenContainer");
        let dosenDiv = document.getElementById("dosenSelection");

        dosenContainer.innerHTML = "";

        if (bidang && dataDosen[bidang]) {
            dataDosen[bidang].forEach(dosen => {
                let isDisabled = dosen.kuota >= dosen.maxKuota;
                
                let tr = document.createElement("tr");
                tr.classList.add("border");

                let tdCheckbox = document.createElement("td");
                let input = document.createElement("input");
                input.type = "checkbox";
                input.name = "dosenPembimbing";
                input.value = dosen.nama;
                input.classList.add("ml-2");
                if (isDisabled) {
                    input.disabled = true;
                }
                tdCheckbox.classList.add("text-center");
                tdCheckbox.appendChild(input);

                let tdNama = document.createElement("td");
                tdNama.textContent = dosen.nama;

                let tdNip = document.createElement("td");
                tdNip.textContent = dosen.nip;

                let tdJabatan = document.createElement("td");
                tdJabatan.textContent = dosen.jabatan;

                let tdKuota = document.createElement("td");
                tdKuota.textContent = `${dosen.kuota}/${dosen.maxKuota}`;
                if (isDisabled) {
                    tdKuota.classList.add("text-gray-500");
                }

                tr.appendChild(tdCheckbox);
                tr.appendChild(tdNama);
                tr.appendChild(tdNip);
                tr.appendChild(tdJabatan);
                tr.appendChild(tdKuota);

                dosenContainer.appendChild(tr);
            });

            dosenDiv.classList.remove("hidden");
        } else {
            dosenDiv.classList.add("hidden");
        }
    }
</script>

</body>
</html>
