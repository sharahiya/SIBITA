@extends('layouts.layoutadmin')

@section('content')
<div class="container mx-auto px-4 pt-4 max-w-5xl">
    <!-- Header -->
    <div class="bg-white p-6 shadow-md rounded-lg w-full mx-auto">
        <h1 class="text-base font-semibold text-gray-800">Request Mahasiswa</h1>
        <p class="text-sm text-gray-600">Kelola permintaan penetapan penguji dan ruangan dari mahasiswa</p>
    </div>

    <!-- Daftar Request -->
    <div class="bg-white p-6 shadow-md rounded-lg mt-4 mx-auto">
        <h2 class="text-sm font-semibold text-gray-800 mb-3">Daftar Mahasiswa</h2>

        <!-- Fitur Pencarian -->
        <div class="mb-4 flex items-center">
            <input type="text" id="searchInput" class="w-1/2 p-2 border rounded-md text-sm" placeholder="Cari mahasiswa berdasarkan Nama, NPM, atau Bidang Minat...">
        </div>

        <!-- Kontainer Tabel -->
        <div class="overflow-y-auto max-h-[336px]">
            <table class="min-w-full text-xs text-left text-gray-500" id="mahasiswaTable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">NPM</th>
                        <th class="px-4 py-2">Bidang Minat</th>
                        <th class="px-4 py-2">Judul TA</th>
                        <th class="px-4 py-2">Dospem 1</th>
                        <th class="px-4 py-2">Dospem 2</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr class="bg-white border-b hover:bg-gray-50 transition duration-300">
                        <td class="px-4 py-2">{{ $student['nama'] }}</td>
                        <td class="px-4 py-2">{{ $student['npm'] }}</td>
                        <td class="px-4 py-2">{{ $student['bidang'] }}</td>
                        <td class="px-4 py-2">{{ $student['judul'] }}</td>
                        <td class="px-4 py-2">{{ $student['dosen_1'] }}</td>
                        <td class="px-4 py-2">{{ $student['dosen_2'] }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('pengujiadmin', ['id' => $student['id_mahasiswa']]) }}">
                                <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition text-xs">
                                    Tetapkan
                                </button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll('#mahasiswaTable tbody tr');

        rows.forEach(function(row) {
            let cells = row.getElementsByTagName('td');
            let nama = cells[0].textContent.toLowerCase();
            let npm = cells[1].textContent.toLowerCase();
            let bidangMinat = cells[2].textContent.toLowerCase();
            let judulTA = cells[3].textContent.toLowerCase();

            if (nama.includes(input) || npm.includes(input) || bidangMinat.includes(input) || judulTA.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
