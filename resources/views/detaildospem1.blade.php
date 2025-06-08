@extends('layouts.layoutmhs')
@section('content')
<div class="container mx-auto px-4 pt-4">
    <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-6xl mx-auto">
    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="{{ route('pengajuan2') }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-full shadow hover:bg-gray-200 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>


        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-800">Detail Dosen Pembimbing 1</h1>
        </div>

        <h2 class="text-lg font-semibold text-gray-900 mb-2">
            {{ $dosen->nama }}
        </h2>
        <table class="text-sm text-gray-700">
            <tr>
            <td class="pr-4">Bidang</td>
            <td>: {{ $dosen->bidang }}</td>
            </tr>
            <tr>
            <td class="pr-4">Jurusan</td>
            <td>: {{ $dosen->jurusan->nama_jurusan }}</td>
            </tr>
            <tr>
            <td class="pr-4">Fakultas</td>
            <td>: {{ $dosen->fakultas->nama_fakultas }}</td>
            </tr>
            <tr>
            <td class="pr-4">Jumlah Mahasiswa Bimbingan</td>
            <td>: {{ $jumlahMahasiswa }}</td>
            </tr>
        </table>

        <!-- Link WhatsApp Read-Only -->
        <div class="mt-4">
            <label for="whatsappGroup" class="text-xs text-gray-600">Link WhatsApp Grup:</label>
            <div class="flex items-center space-x-3">
                <input type="text"
                    value="{{ $dosen->link_wa_group ?? 'https://chat.whatsapp.com/xxxxx' }}"
                    class="w-80 p-2 text-sm border border-gray-300 bg-gray-100 rounded-md text-gray-700"
                    disabled>
                <a href="{{ $dosen->link_wa_group ?? 'https://chat.whatsapp.com/xxxxx' }}" target="_blank"
                    class="inline-block px-4 py-2 bg-green-500 text-white text-sm rounded-md hover:bg-green-600 transition-all shadow-sm">
                    Buka WhatsApp
                </a>
            </div>
        </div>



        <!-- Daftar Mahasiswa -->
        <h2 class="text-lg font-semibold text-gray-800 mt-6">Daftar Mahasiswa Bimbingan</h2>

        <div class="mt-4">
            <label for="searchInput" class="text-xs text-gray-600">Cari Mahasiswa:</label>
            <input type="text" id="searchInput"
                class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-80 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Cari berdasarkan Nama atau NPM...">
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4" style="max-height: 300px; overflow-y: auto;">
            <table class="w-full text-xs text-left text-gray-500 border border-gray-300">
                <thead class="text-[10px] text-white uppercase bg-blue-900">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">No</th>
                        <th class="px-4 py-2 border border-gray-300">Nama</th>
                        <th class="px-4 py-2 border border-gray-300">NPM</th>
                        <th class="px-4 py-2 border border-gray-300">Bidang</th>
                        <th class="px-4 py-2 border border-gray-300">Judul Tugas Akhir</th>
                        <th class="px-4 py-2 border border-gray-300">Deskripsi</th>
                        <th class="px-4 py-2 border border-gray-300">Role</th>
                        <th class="px-4 py-2 border border-gray-300">Status</th>
                    </tr>
                </thead>
                <tbody id="tableMahasiswa">
                    <!-- Loop data mahasiswa -->
                    @foreach($ajuanBimbingan as $index => $ajuan)
                    <tr class="bg-white even:bg-gray-50 border-b hover:bg-blue-50">

                        <td class="px-4 py-2 border border-gray-300">{{ $index+1 }}</td>
                        <td class="px-4 py-2 border border-gray-300 font-medium">{{ $ajuan->mahasiswa->nama }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->mahasiswa->npm }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->bidang }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->topik_ta }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <a href="#" onclick="openModal('{{ $ajuan->deskripsi_ta }}')"
                               class="text-blue-600 hover:underline">Lihat</a>
                        </td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->id_dosen_1 == $dosen->id ? 'Dospem 1' : 'Dospem 2' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->mahasiswa->seminar_status ?? '-' }}</td>
                    </tr>
                    @endforeach
                    <!-- Tambahkan data lain seperti biasa -->
                </tbody>
            </table>
        </div>

    </div>
</div>


<!-- Modal Deskripsi -->
<div id="modalDeskripsi" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <p id="modalText" class="text-gray-800"></p>
        <div class="mt-4 flex justify-end">
            <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Remove -->
<div id="modalRemove" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
        <p class="text-gray-800">Apakah Anda yakin ingin menghapus mahasiswa ini?</p>
        <div class="mt-4 flex justify-center space-x-4">
            <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600" onclick="removeStudent()">Ya</button>
            <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 ml-2" onclick="closeRemoveModal()">Tidak</button>
        </div>
    </div>
</div>

<script>
let pengajuanToRemoveId = null;

function openModal(deskripsi) {
    document.getElementById('modalText').textContent = deskripsi;
    document.getElementById('modalDeskripsi').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modalDeskripsi').classList.add('hidden');
}

// Konfirmasi remove mahasiswa
function confirmRemove(button) {
    pengajuanToRemoveId = button.getAttribute('data-id');
    document.getElementById('modalRemove').classList.remove('hidden');
}

function closeRemoveModal() {
    document.getElementById('modalRemove').classList.add('hidden');
}

function removeStudent() {
    if (!pengajuanToRemoveId) return;

    fetch(`/bimbingan/remove/${pengajuanToRemoveId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Gagal menghapus');
        return response.json();
    })
    .then(data => {
        alert(data.message);
        location.reload(); // Atau hapus baris <tr> secara dinamis
    })
    .catch(error => {
        alert('Terjadi kesalahan saat menghapus.');
        console.error(error);
    });

    closeRemoveModal();
}

// event listerner pencarian
document.addEventListener('DOMContentLoaded', function (){
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', searchMahasiswa);
    searchInput.addEventListener('input', searchMahasiswa);
})

function searchMahasiswa() {
    const searchInput = document.getElementById('searchInput');
    const filter = searchInput.value.toLowerCase();
    const table = document.getElementById('tableMahasiswa')
    const rows = table.getElementsByTagName('tr');
    console.log('filter:', filter);

    for (let i = 0; i < rows.length; i++){
        const nameCell = rows[i].getElementsByTagName('td')[1];
        const npmCell = rows[i].getElementsByTagName('td')[2];

        if(nameCell && npmCell){
            const nameText = (nameCell.textContent || nameCell.innerText).toLowerCase();
            const npmText = (npmCell.textContent || npmCell.innerText).toLowerCase();

            if(nameText.indexOf(filter) > -1 || npmText.indexOf(filter) > -1){
                rows[i].style.display = '';
            }else{
                rows[i].style.display = 'none';
            }
        }
    }
}

</script>

@endsection

{{-- @extends('layouts.layoutmhs')

@section('content')
<div class="container mx-auto px-4 pt-6">
    <div class="bg-white p-8 shadow-xl rounded-2xl w-full max-w-6xl mx-auto border border-gray-100">
        <div class="mb-6">
            <a href="{{ route('pengajuan2') }}" class="inline-flex items-center px-4 py-2 bg-white text-gray-800 text-sm font-medium rounded-md border border-gray-300 hover:bg-gray-100 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
            Kembali
            </a>
        </div>
        <!-- Section Title -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Data Dosen Pembimbing</h1>
        </div>

        <!-- Informasi Dosen -->
        <section class="mb-10">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Dosen</h2>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-sm">
                <p class="text-base text-gray-700 mb-2">
                    <span class="font-medium text-gray-900">Nama:</span> {{ $dosen->nama }}
                </p>
                <p class="text-base text-gray-700 mb-2">
                    <span class="font-medium text-gray-900">Bidang</span> {{ $dosen->bidang }}
                </p>
                <p class="text-base text-gray-700 mb-2">
                    <span class="font-medium text-gray-900">Jurusan:</span> {{ $dosen->jurusan->nama_jurusan }}
                </p>
                <p class="text-base text-gray-700 mb-2">
                    <span class="font-medium text-gray-900">Fakultas:</span> {{ $dosen->fakultas->nama_fakultas }}
                </p>
                <p class="text-base text-gray-700 mb-2">
                    <span class="font-medium text-gray-900">Jumlah Bimbingan:</span>
                    <span class="text-blue-600 font-semibold">{{ $jumlahMahasiswa }}</span>
                </p>

                <div class="mt-4">
                    <label class="block text-sm text-gray-600 mb-1">Link WhatsApp Grup:</label>
                    <div class="flex items-center space-x-3">
                        <input type="text"
                            value="{{ $dosen->link_wa_group ?? 'https://chat.whatsapp.com/xxxxx' }}"
                            class="w-80 p-2 text-sm border border-gray-300 bg-gray-100 rounded-md text-gray-700"
                            disabled>
                        <a href="{{ $dosen->link_wa_group ?? 'https://chat.whatsapp.com/xxxxx' }}" target="_blank"
                            class="inline-block px-4 py-2 bg-green-500 text-white text-sm rounded-md hover:bg-green-600 transition-all shadow-sm">
                            Buka WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Garis Pembatas -->
        <hr class="my-10 border-t border-gray-300">

        <!-- Daftar Mahasiswa -->
        <section>
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Daftar Mahasiswa Bimbingan</h2>
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-md bg-white max-h-[340px] overflow-y-auto">
                <table class="min-w-full text-sm text-gray-800">
                    <thead class="bg-blue-900 text-white text-xs uppercase sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">NPM</th>
                            <th class="px-4 py-3 text-left">Bidang</th>
                            <th class="px-4 py-3 text-left">Judul</th>
                            <th class="px-4 py-3 text-left">Deskripsi</th>
                            <th class="px-4 py-3 text-left">Role</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ajuanBimbingan as $index => $ajuan)
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition-colors border-b border-gray-200">
                            <td class="px-4 py-2">{{ $index+1 }}</td>
                            <td class="px-4 py-2 font-medium">{{ $ajuan->mahasiswa->nama }}</td>
                            <td class="px-4 py-2">{{ $ajuan->mahasiswa->npm }}</td>
                            <td class="px-4 py-2">{{ $ajuan->bidang }}</td>
                            <td class="px-4 py-2">{{ $ajuan->topik_ta }}</td>
                            <td class="px-4 py-2">
                                <a href="#" onclick="openModal('{{ $ajuan->deskripsi_ta }}')"
                                   class="text-blue-600 hover:underline">Lihat</a>
                            </td>
                            <td class="px-4 py-2">{{ $ajuan->id_dosen_1 == $dosen->id ? 'Dospem 1' : 'Dospem 2' }}</td>
                            <td class="px-4 py-2">{{ $ajuan->mahasiswa->seminar_status ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<!-- Modal Deskripsi -->
<div id="modalDeskripsi" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <p id="modalText" class="text-gray-800"></p>
        <div class="mt-4 flex justify-end">
            <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Remove -->
<div id="modalRemove" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
        <p class="text-gray-800">Apakah Anda yakin ingin menghapus mahasiswa ini?</p>
        <div class="mt-4 flex justify-center space-x-4">
            <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600" onclick="removeStudent()">Ya</button>
            <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 ml-2" onclick="closeRemoveModal()">Tidak</button>
        </div>
    </div>
</div>

<script>
let pengajuanToRemoveId = null;

function openModal(deskripsi) {
    document.getElementById('modalText').textContent = deskripsi;
    document.getElementById('modalDeskripsi').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modalDeskripsi').classList.add('hidden');
}

// Konfirmasi remove mahasiswa
function confirmRemove(button) {
    pengajuanToRemoveId = button.getAttribute('data-id');
    document.getElementById('modalRemove').classList.remove('hidden');
}

function closeRemoveModal() {
    document.getElementById('modalRemove').classList.add('hidden');
}

function removeStudent() {
    if (!pengajuanToRemoveId) return;

    fetch(`/bimbingan/remove/${pengajuanToRemoveId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Gagal menghapus');
        return response.json();
    })
    .then(data => {
        alert(data.message);
        location.reload(); // Atau hapus baris <tr> secara dinamis
    })
    .catch(error => {
        alert('Terjadi kesalahan saat menghapus.');
        console.error(error);
    });

    closeRemoveModal();
}
</script>

@endsection

 --}}
