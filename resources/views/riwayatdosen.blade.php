@extends('layouts.layoutdosen')
@section('content')
    <style>
        .table-container {
            max-height: 500px;
            overflow-y: auto;
        }
        .judul-ta {
            white-space: normal;
            word-wrap: break-word;
            max-width: 300px;
        }
        .bidang-minat {
            width: 100px;
            text-align: center;
        }
        .role {
            width: 120px;
            text-align: center;
        }
        .search-wrapper {
            position: relative;
            width: 350px;
        }
        .search-wrapper input {
            width: 100%;
            padding: 8px 30px 8px 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        .search-wrapper .fa-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #888;
        }
    </style>

    <div class="container mx-auto px-4 pt-4">
        <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-6xl mx-auto">

            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold text-gray-800">Riwayat Mahasiswa Bimbingan</h1>
                <div class="search-wrapper">
                    <input type="text" id="searchInput" placeholder="Cari Nama...">
                    <i class="fa fa-search"></i>
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg table-container">
                <table class="w-full text-xs text-left text-gray-500 border border-gray-300">
                    <thead class="text-[10px] text-white uppercase bg-blue-900">
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">No</th>
                            <th class="px-4 py-2 border border-gray-300">Nama</th>
                            <th class="px-4 py-2 border border-gray-300">NPM</th>
                            <th class="px-4 py-2 border border-gray-300 bidang-minat">Bidang Minat</th>
                            <th class="px-4 py-2 border border-gray-300 judul-ta">Judul TA</th>
                            <th class="px-4 py-2 border border-gray-300 role">Role</th>
                            <th class="px-4 py-2 border border-gray-300">Tanggal Sidang</th>
                            <th class="px-4 py-2 border border-gray-300">File Final</th>
                            <th class="px-4 py-2 border border-gray-300">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse ($riwayat as $index => $item)
                            <tr class='bg-white even:bg-gray-50 border-b hover:bg-blue-50'>
                                <td class='px-4 py-2 border border-gray-300 font-medium text-gray-900'>{{ $index + 1 }}</td>
                                <td class='px-4 py-2 border border-gray-300'>{{ $item['mahasiswa']->nama }}</td>
                                <td class='px-4 py-2 border border-gray-300'>{{ $item['mahasiswa']->npm }}</td>
                                <td class='px-4 py-2 border border-gray-300 bidang-minat'>
                                    {{ $item['pengajuan_bimbingan']->bidang ?? '-' }}
                                </td>
                                <td class='px-4 py-2 border border-gray-300 judul-ta'>
                                    {{ $item['pengajuan_bimbingan']->topik_ta ?? '-' }}
                                </td>
                                <td class='px-4 py-2 border border-gray-300 role'>
                                    {{ $item['pengajuan_seminar']->dosen_ke == 1 ? 'Dospem 1' : 'Dospem 2' }}
                                </td>
                                <td class='px-4 py-2 border border-gray-300'>
                                    {{ $item['seminar']['tanggal'] ?? '-' }}
                                </td>
                                <td class='px-4 py-2 border border-gray-300 text-center'>
                                    @if ($item['seminar']['lampiran'])
                                        <div class="flex justify-center space-x-2">
                                            <button onclick="previewPDF('{{ asset('storage/' . $item['seminar']['lampiran']) }}')"
                                                    class="text-blue-600 hover:text-blue-800 transition-colors">
                                                <i class="fa fa-eye"></i> Preview
                                            </button>
                                            <a href="{{ asset('storage/' . $item['seminar']['lampiran']) }}"
                                               class="text-green-600 hover:text-green-800 transition-colors" download>
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class='px-4 py-2 border border-gray-300'>
                                    Selesai Sidang
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                    Belum ada riwayat mahasiswa yang sidang
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Preview PDF -->
    <div id="pdfModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-11/12 h-5/6 max-w-4xl">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Preview File PDF</h3>
                <button onclick="closePDFModal()" class="text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>
            </div>
            <div class="p-4 h-full">
                <iframe id="pdfViewer" src="" class="w-full h-full border-0 rounded"></iframe>
            </div>
            <div class="flex justify-end p-4 border-t space-x-2">
                <button onclick="closePDFModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                    Tutup
                </button>
                <a id="downloadLink" href="" download
                   class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition-colors">
                    <i class="fa fa-download mr-1"></i> Download
                </a>
            </div>
        </div>
    </div>

    <script>
        // Script untuk fitur pencarian
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#tableBody tr");

            rows.forEach(row => {
                // Skip baris kosong
                if (row.cells.length < 2) return;

                let nama = row.cells[1].textContent.toLowerCase();
                let npm = row.cells[2].textContent.toLowerCase();

                if (nama.includes(filter) || npm.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        // Fungsi untuk preview PDF
        function previewPDF(url) {
            const modal = document.getElementById('pdfModal');
            const viewer = document.getElementById('pdfViewer');
            const downloadLink = document.getElementById('downloadLink');

            // Set source untuk iframe
            viewer.src = url + '#toolbar=1&navpanes=1&scrollbar=1&view=FitH';
            downloadLink.href = url;

            // Tampilkan modal
            modal.classList.remove('hidden');

            // Tambahkan event listener untuk ESC key
            document.addEventListener('keydown', handleEscKey);
        }

        // Fungsi untuk menutup modal PDF
        function closePDFModal() {
            const modal = document.getElementById('pdfModal');
            const viewer = document.getElementById('pdfViewer');

            // Sembunyikan modal
            modal.classList.add('hidden');

            // Kosongkan src iframe untuk menghentikan loading
            viewer.src = '';

            // Hapus event listener ESC key
            document.removeEventListener('keydown', handleEscKey);
        }

        // Handle ESC key untuk menutup modal
        function handleEscKey(event) {
            if (event.key === 'Escape') {
                closePDFModal();
            }
        }

        // Tutup modal jika klik di luar area modal
        document.getElementById('pdfModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closePDFModal();
            }
        });
    </script>

@endsection
