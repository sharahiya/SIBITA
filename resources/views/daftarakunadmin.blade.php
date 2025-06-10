@extends('layouts.layoutadmin')

@section('content')

<div class="container mx-auto px-4 pt-4 max-w-5xl">
    <!-- Header -->
    <div class="bg-white p-6 shadow-md rounded-lg w-full mx-auto">
        <h1 class="text-base font-semibold text-gray-800">Daftar Mahasiswa & Dosen</h1>
        <p class="text-gray-600 text-sm">Lihat daftar mahasiswa dan dosen yang terdaftar di sistem</p>
    </div>

    <!-- Mahasiswa Section -->
    <div class="mt-4">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-sm font-semibold text-gray-800 mb-3">Daftar Mahasiswa ({{ $mahasiswas->count() }})</h2>
            <input type="text" id="searchMahasiswa" placeholder="Cari mahasiswa..." class="w-full md:w-64 p-2 text-xs border rounded-lg mb-3">
            <div class="overflow-x-auto max-h-56 overflow-y-scroll">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead class="text-gray-700 uppercase bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NPM</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Angkatan</th>
                            <th class="px-4 py-2">Dosen Wali</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswaTableBody">
                        @forelse ($mahasiswas as $index => $mahasiswa)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $mahasiswa->nama }}</td>
                            <td class="px-4 py-2">{{ $mahasiswa->npm }}</td>
                            <td class="px-4 py-2">{{ $mahasiswa->email }}</td>
                            <td class="px-4 py-2">{{ $mahasiswa->angkatan }}</td>
                            <td class="px-4 py-2">{{ $mahasiswa->dosenWali->nama ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data mahasiswa
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Dosen Section -->
    <div class="mt-4">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-sm font-semibold text-gray-800 mb-3">Daftar Dosen ({{ $dosens->count() }})</h2>
            <input type="text" id="searchDosen" placeholder="Cari dosen..." class="w-full md:w-64 p-2 text-xs border rounded-lg mb-3">
            <div class="overflow-x-auto max-h-56 overflow-y-scroll">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead class="text-gray-700 uppercase bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NIP</th>
                            <th class="px-4 py-2">Bidang</th>
                            <th class="px-4 py-2">Kuota Bimbingan</th>
                            <th class="px-4 py-2">Mahasiswa Wali</th>
                        </tr>
                    </thead>
                    <tbody id="dosenTableBody">
                        @forelse ($dosens as $index => $dosen)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $dosen->nama }}</td>
                            <td class="px-4 py-2">{{ $dosen->nip }}</td>
                            <td class="px-4 py-2">{{ $dosen->bidang ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $dosen->kuota_bimbingan ?? 0 }}</td>
                            <td class="px-4 py-2">{{ $dosen->jumlahMahasiswaPerwalian() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data dosen
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pencarian Mahasiswa
    const searchMahasiswa = document.getElementById('searchMahasiswa');
    const mahasiswaTableBody = document.getElementById('mahasiswaTableBody');

    searchMahasiswa.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = mahasiswaTableBody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            // Skip jika baris kosong atau empty state
            if (rows[i].cells.length < 6) continue;

            const nama = rows[i].cells[1].textContent.toLowerCase();
            const npm = rows[i].cells[2].textContent.toLowerCase();
            const email = rows[i].cells[3].textContent.toLowerCase();

            if (nama.includes(filter) || npm.includes(filter) || email.includes(filter)) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    });

    // Pencarian Dosen
    const searchDosen = document.getElementById('searchDosen');
    const dosenTableBody = document.getElementById('dosenTableBody');

    searchDosen.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = dosenTableBody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            // Skip jika baris kosong atau empty state
            if (rows[i].cells.length < 6) continue;

            const nama = rows[i].cells[1].textContent.toLowerCase();
            const nip = rows[i].cells[2].textContent.toLowerCase();
            const bidang = rows[i].cells[3].textContent.toLowerCase();

            if (nama.includes(filter) || nip.includes(filter) || bidang.includes(filter)) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    });
});
</script>

@endsection
