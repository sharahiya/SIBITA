@extends('layouts.layoutadmin')
@section('content')

<div class="container mx-auto px-4 pt-4 max-w-5xl">
    <!-- Header -->
    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white p-6 shadow-md rounded-lg w-full mx-auto">
        <h1 class="text-base font-semibold text-gray-800">Tentukan Penguji dan Upload Nilai</h1>
        <p class="text-sm text-gray-600">Tentukan penguji 1, penguji 2, dan penguji 3 (opsional) untuk mahasiswa</p>
    </div>

    <!-- Form Penetapan Penguji dan Ruangan -->
    <div class="bg-white p-6 shadow-md rounded-lg mt-4 mx-auto">
        <h2 class="text-sm font-semibold text-gray-800 mb-3">Tentukan Penguji</h2>
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4" method="POST" action="{{ route('penetapan-penguji.store', $mahasiswa->id_mahasiswa) }}">
            @csrf
            <input type="hidden" name="penguji_1" id="hiddenPenguji1">
            <input type="hidden" name="penguji_2" id="hiddenPenguji2">
            <input type="hidden" name="penguji_3" id="hiddenPenguji3">

            <!-- Informasi Mahasiswa -->
            <div class="col-span-1 md:col-span-3">
                <p class="text-sm font-semibold text-gray-800">Nama Mahasiswa:</p>
                <input type="text" value="{{ $mahasiswa->nama }}" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled>

                <p class="text-sm font-semibold text-gray-800 mt-2">NPM Mahasiswa:</p>
                <input type="text" value="{{ $mahasiswa->npm }}" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled>
            </div>

            <!-- Bidang Minat dan Judul TA -->
            <div class="col-span-1 md:col-span-3">
                <p class="text-sm font-semibold text-gray-800">Bidang Minat:</p>
                <input type="text" value="{{ $pengajuan->bidang }}" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled>

                <p class="text-sm font-semibold text-gray-800 mt-2">Judul TA:</p>
                <div class="flex items-center space-x-2">
                    <input type="text" id="judulTAField" value="{{ $pengajuan->topik_ta }}" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled>
                </div>
            </div>

            <!-- Dospem -->
            <div class="col-span-1 md:col-span-3">
                <p class="text-sm font-semibold text-gray-800">Dosen Pembimbing 1:</p>
                <input type="text" value="{{ $mahasiswa->dosenPembimbing1->nama ?? '-' }}" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled>

                <p class="text-sm font-semibold text-gray-800 mt-2">Dosen Pembimbing 2:</p>
                <input type="text" value="{{ $mahasiswa->dosenPembimbing2->nama ?? '-' }}" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled>
            </div>

            <!-- Pilihan Penguji 1 -->
            <div class="col-span-1 md:col-span-3">
                <h3 class="text-sm font-semibold text-gray-800 mb-2 mt-4">Pilih Penguji 1 <span class="text-red-500">*</span></h3>
                <div class="relative">
                    <input id="searchPenguji1"
                           type="text"
                           placeholder="Cari Penguji 1..."
                           class="w-full p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 mb-2"
                           value="{{ $penguji1 ? $penguji1->dosen->nama : '' }}"
                           {{ $penguji1 ? 'disabled' : '' }}>
                    @if (!$penguji1)
                    <div id="penguji1List" class="overflow-y-auto max-h-48 bg-white border rounded-lg shadow-lg z-10">
                        <table class="w-full text-xs text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2">Nama Dosen</th>
                                    <th class="px-4 py-2">NIP</th>
                                    <th class="px-4 py-2">Jabatan</th>
                                    <th class="px-4 py-2">Jumlah Perwalian</th>
                                    <th class="px-4 py-2">Jumlah Bimbingan</th>
                                    <th class="px-4 py-2">Jumlah Penguji</th>
                                </tr>
                            </thead>
                            <tbody id="penguji1Table">
                                @foreach ($dosenList as $dosen)
                                <tr class="p-2 cursor-pointer hover:bg-gray-50" onclick="selectPenguji('searchPenguji1', '{{ $dosen->nama }}')">
                                    <td class="px-4 py-2">{{ $dosen->nama }}</td>
                                    <td class="px-4 py-2">{{ $dosen->nip }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jabatan }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jumlahMahasiswaPerwalian() ?? 0 }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jumlahMahasiswaBimbingan() ?? 0 }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jumlahMenjadiPenguji() ?? 0 }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pilihan Penguji 2 -->
            <div class="col-span-1 md:col-span-3">
                <h3 class="text-sm font-semibold text-gray-800 mb-2 mt-4">Pilih Penguji 2 <span class="text-red-500">*</span></h3>
                <div class="relative">
                    <input id="searchPenguji2"
                           type="text"
                           placeholder="Cari Penguji 2..."
                           class="w-full p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 mb-2"
                           value="{{ $penguji2 ? $penguji2->dosen->nama : '' }}"
                           {{ $penguji2 ? 'disabled' : '' }}>
                    @if (!$penguji2)
                    <div id="penguji2List" class="overflow-y-auto max-h-48 bg-white border rounded-lg shadow-lg z-10">
                        <table class="w-full text-xs text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2">Nama Dosen</th>
                                    <th class="px-4 py-2">NIP</th>
                                    <th class="px-4 py-2">Jabatan</th>
                                    <th class="px-4 py-2">Jumlah Perwalian</th>
                                    <th class="px-4 py-2">Jumlah Bimbingan</th>
                                    <th class="px-4 py-2">Jumlah Penguji</th>
                                </tr>
                            </thead>
                            <tbody id="penguji2Table">
                                @foreach ($dosenList as $dosen)
                                <tr class="p-2 cursor-pointer hover:bg-gray-50" onclick="selectPenguji('searchPenguji2', '{{ $dosen->nama }}')">
                                    <td class="px-4 py-2">{{ $dosen->nama }}</td>
                                    <td class="px-4 py-2">{{ $dosen->nip }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jabatan }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jumlahMahasiswaPerwalian() ?? 0 }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jumlahMahasiswaBimbingan() ?? 0 }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jumlahMenjadiPenguji() ?? 0 }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pilihan Penguji 3 (Opsional) -->
            <div class="col-span-1 md:col-span-3" id="penguji3Section" style="{{ $penguji3 || (!$penguji1 && !$penguji2) ? 'display: block;' : 'display: none;' }}">
                <h3 class="text-sm font-semibold text-gray-800 mb-2 mt-4">
                    Pilih Penguji 3
                    <span class="text-gray-500 text-xs">(Opsional)</span>
                    @if(!$penguji3 && ($penguji1 || $penguji2))
                    <button type="button" onclick="removePenguji3()" class="ml-2 text-xs bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                        Hapus
                    </button>
                    @endif
                </h3>
                <div class="relative">
                    <input id="searchPenguji3"
                           type="text"
                           placeholder="Cari Penguji 3..."
                           class="w-full p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 mb-2"
                           value="{{ $penguji3 ? $penguji3->dosen->nama : '' }}"
                           {{ $penguji3 ? 'disabled' : '' }}>
                    @if (!$penguji3)
                    <div id="penguji3List" class="overflow-y-auto max-h-48 bg-white border rounded-lg shadow-lg z-10">
                        <table class="w-full text-xs text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2">Nama Dosen</th>
                                    <th class="px-4 py-2">NIP</th>
                                    <th class="px-4 py-2">Jabatan</th>
                                    <th class="px-4 py-2">Jumlah Perwalian</th>
                                    <th class="px-4 py-2">Jumlah Bimbingan</th>
                                    <th class="px-4 py-2">Jumlah Penguji</th>
                                </tr>
                            </thead>
                            <tbody id="penguji3Table">
                                @foreach ($dosenList as $dosen)
                                <tr class="p-2 cursor-pointer hover:bg-gray-50" onclick="selectPenguji('searchPenguji3', '{{ $dosen->nama }}')">
                                    <td class="px-4 py-2">{{ $dosen->nama }}</td>
                                    <td class="px-4 py-2">{{ $dosen->nip }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jabatan }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jumlahMahasiswaPerwalian() ?? 0 }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jumlahMahasiswaBimbingan() ?? 0 }}</td>
                                    <td class="px-4 py-2">{{ $dosen->jumlahMenjadiPenguji() ?? 0 }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>

                <!-- Save Button for Penguji 3 -->
                @if(($penguji1 && $penguji2) && !$penguji3)
                <div id="savePenguji3Container" class="mt-3" style="display: none;">
                    <form method="POST" action="{{ route('penetapan-penguji.tambah-penguji3', $mahasiswa->id_mahasiswa) }}" id="formPenguji3">
                        @csrf
                        <input type="hidden" name="id_mahasiswa" value="{{ $mahasiswa->id_mahasiswa }}">
                        <input type="hidden" name="penguji_3" id="hiddenPenguji3Save">
                        <div class="flex items-center space-x-2">
                            <button type="submit" id="savePenguji3Btn" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 text-xs rounded-lg hover:shadow-lg hover:scale-105 transition-transform duration-300 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                💾 Simpan Penguji 3
                            </button>
                            <button type="button" onclick="cancelPenguji3()" class="bg-gray-500 text-white px-4 py-2 text-xs rounded-lg hover:bg-gray-600 transition-colors">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            </div>

            <!-- Tombol Tambah Penguji 3 -->
            @if(($penguji1 && $penguji2) && !$penguji3)
            <div class="col-span-1 md:col-span-3" id="addPenguji3Button">
                <button type="button" onclick="showPenguji3()" class="bg-green-500 text-white px-4 py-2 text-xs rounded-lg hover:bg-green-600 transition-colors">
                    + Tambah Penguji 3 (Opsional)
                </button>
            </div>
            @endif

            @if(!$penguji1 && !$penguji2 && !$penguji3)
            <!-- Button Submit -->
            <button type="submit" class="col-span-1 md:col-span-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white p-2 text-xs rounded-lg hover:shadow-lg hover:scale-105 transition-transform duration-300">Tetapkan Penguji</button>
            @endif
        </form>

        @if($penguji1 || $penguji2 || $penguji3)
        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
            <h4 class="text-sm font-semibold text-gray-800 mb-3">Penguji yang Sudah Ditetapkan:</h4>
            <div class="space-y-2">
                @if($penguji1)
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-700">Penguji 1: {{ $penguji1->dosen->nama }}</span>
                </div>
                @endif
                @if($penguji2)
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-700">Penguji 2: {{ $penguji2->dosen->nama }}</span>
                </div>
                @endif
                @if($penguji3)
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-700">Penguji 3: {{ $penguji3->dosen->nama }} <span class="text-gray-500">(Opsional)</span></span>
                </div>
                @endif
            </div>

            <form method="POST" action="{{ route('penguji.reset', $mahasiswa->id_mahasiswa) }}" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white p-2 text-xs rounded-lg hover:shadow-lg hover:scale-105 transition-transform duration-300">Ganti Penguji</button>
            </form>
        </div>
        @endif
    </div>

    <!-- Upload Nilai Section - Fixed Layout -->
    @if($penguji1 || $penguji2 || $penguji3)
    <div class="bg-white p-6 shadow-md rounded-lg mt-4 mx-auto">
        <h2 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-3">📊 Upload Nilai Seminar & Sidang</h2>

        <!-- Status Nilai yang Sudah Ada -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Seminar Proposal -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl border border-blue-200 shadow-sm">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-sm font-semibold text-blue-800 mb-1">📝 Seminar Proposal</h3>
                        <div class="w-8 h-1 bg-blue-400 rounded"></div>
                    </div>
                    @if($seminarProposal && $seminarProposal->nilai)
                        <div class="flex flex-col gap-1">
                            <button onclick="editNilai('proposal', {{ $seminarProposal->nilai }}, {{ $seminarProposal->lulus }})"
                                    class="text-xs bg-yellow-500 text-white px-3 py-1.5 rounded-full hover:bg-yellow-600 transition-colors">
                                ✏️ Edit
                            </button>
                            <button onclick="hapusNilai('proposal', {{ $seminarProposal->id_seminar }})"
                                    class="text-xs bg-red-500 text-white px-3 py-1.5 rounded-full hover:bg-red-600 transition-colors">
                                🗑️ Hapus
                            </button>
                        </div>
                    @endif
                </div>

                @if($seminarProposal && $seminarProposal->nilai)
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-blue-700">Nilai:</span>
                            <span class="text-lg font-bold text-blue-800">{{ $seminarProposal->nilai }}</span>
                        </div>
                        <div class="flex justify-center">
                            <span class="px-3 py-1 rounded-full text-xs font-medium text-white {{ $seminarProposal->lulus == 1 ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $seminarProposal->lulus == 1 ? '✅ Lulus' : '❌ Tidak Lulus' }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="w-12 h-12 mx-auto mb-2 bg-blue-200 rounded-full flex items-center justify-center">
                            <span class="text-blue-500 text-xl">📝</span>
                        </div>
                        <span class="text-sm text-blue-600">Belum ada nilai</span>
                    </div>
                @endif
            </div>

            <!-- Seminar Hasil -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-5 rounded-xl border border-orange-200 shadow-sm {{ $seminarProposal && $seminarProposal->status === 'diterima' ? '' : 'opacity-60' }}">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-sm font-semibold text-orange-800 mb-1">📊 Seminar Hasil</h3>
                        <div class="w-8 h-1 bg-orange-400 rounded"></div>
                    </div>
                    @if($seminarHasil && $seminarHasil->nilai)
                        <div class="flex flex-col gap-1">
                            <button onclick="editNilai('hasil', {{ $seminarHasil->nilai }}, {{ $seminarHasil->lulus }})"
                                    class="text-xs bg-yellow-500 text-white px-3 py-1.5 rounded-full hover:bg-yellow-600 transition-colors">
                                ✏️ Edit
                            </button>
                            <button onclick="hapusNilai('hasil', {{ $seminarHasil->id_seminar }})"
                                    class="text-xs bg-red-500 text-white px-3 py-1.5 rounded-full hover:bg-red-600 transition-colors">
                                🗑️ Hapus
                            </button>
                        </div>
                    @endif
                </div>

                @if($seminarHasil && $seminarHasil->nilai)
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-orange-700">Nilai:</span>
                            <span class="text-lg font-bold text-orange-800">{{ $seminarHasil->nilai }}</span>
                        </div>
                        <div class="flex justify-center">
                            <span class="px-3 py-1 rounded-full text-xs font-medium text-white {{ $seminarHasil->lulus == 1 ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $seminarHasil->lulus == 1 ? '✅ Lulus' : '❌ Tidak Lulus' }}
                            </span>
                        </div>
                    </div>
                @elseif(!$seminarProposal || $seminarProposal->status !== 'diterima')
                    <div class="text-center py-4">
                        <div class="w-12 h-12 mx-auto mb-2 bg-orange-200 rounded-full flex items-center justify-center">
                            <span class="text-orange-400 text-xl">🔒</span>
                        </div>
                        <span class="text-xs text-orange-600">Memerlukan Seminar Proposal lulus</span>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="w-12 h-12 mx-auto mb-2 bg-orange-200 rounded-full flex items-center justify-center">
                            <span class="text-orange-500 text-xl">📊</span>
                        </div>
                        <span class="text-sm text-orange-600">Belum ada nilai</span>
                    </div>
                @endif
            </div>

            <!-- Sidang -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-5 rounded-xl border border-green-200 shadow-sm {{ $seminarHasil && $seminarHasil->status === 'diterima' ? '' : 'opacity-60' }}">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-sm font-semibold text-green-800 mb-1">🎓 Sidang</h3>
                        <div class="w-8 h-1 bg-green-400 rounded"></div>
                    </div>
                    @if($seminarSidang && $seminarSidang->nilai)
                        <div class="flex flex-col gap-1">
                            <button onclick="editNilai('sidang', {{ $seminarSidang->nilai }}, {{ $seminarSidang->lulus }})"
                                    class="text-xs bg-yellow-500 text-white px-3 py-1.5 rounded-full hover:bg-yellow-600 transition-colors">
                                ✏️ Edit
                            </button>
                            <button onclick="hapusNilai('sidang', {{ $seminarSidang->id_seminar }})"
                                    class="text-xs bg-red-500 text-white px-3 py-1.5 rounded-full hover:bg-red-600 transition-colors">
                                🗑️ Hapus
                            </button>
                        </div>
                    @endif
                </div>

                @if($seminarSidang && $seminarSidang->nilai)
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-green-700">Nilai:</span>
                            <span class="text-lg font-bold text-green-800">{{ $seminarSidang->nilai }}</span>
                        </div>
                        <div class="flex justify-center">
                            <span class="px-3 py-1 rounded-full text-xs font-medium text-white {{ $seminarSidang->lulus == 1 ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $seminarSidang->lulus == 1 ? '✅ Lulus' : '❌ Tidak Lulus' }}
                            </span>
                        </div>
                    </div>
                @elseif(!$seminarHasil || $seminarHasil->status !== 'diterima')
                    <div class="text-center py-4">
                        <div class="w-12 h-12 mx-auto mb-2 bg-green-200 rounded-full flex items-center justify-center">
                            <span class="text-green-400 text-xl">🔒</span>
                        </div>
                        <span class="text-xs text-green-600">Memerlukan Seminar Hasil lulus</span>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="w-12 h-12 mx-auto mb-2 bg-green-200 rounded-full flex items-center justify-center">
                            <span class="text-green-500 text-xl">🎓</span>
                        </div>
                        <span class="text-sm text-green-600">Belum ada nilai</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Form Upload/Edit Nilai -->
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <h3 class="text-base font-semibold text-gray-800 mb-4">📝 Form Input Nilai</h3>

            <form method="POST" action="{{ route('upload.nilai', $mahasiswa->id_mahasiswa) }}" id="formNilai" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" value="POST" id="methodField">
                <input type="hidden" name="seminar_id" id="seminarId">
                <input type="hidden" name="jenis_seminar" id="hiddenJenisSeminar">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Seminar/Sidang</label>
                        <select name="jenis_seminar" id="jenisSeminar" class="w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Pilih Jenis</option>
                            <option value="proposal">📝 Seminar Proposal</option>
                            <option value="hasil" {{ !$seminarProposal || $seminarProposal->lulus != 1 ? 'disabled' : '' }}>
                                📊 Seminar Hasil
                                @if(!$seminarProposal || $seminarProposal->lulus != 1)
                                    (Memerlukan Sempro Lulus)
                                @endif
                            </option>
                            <option value="sidang" {{ !$seminarHasil || $seminarHasil->lulus != 1 ? 'disabled' : '' }}>
                                🎓 Sidang
                                @if(!$seminarHasil || $seminarHasil->lulus != 1)
                                    (Memerlukan Semhas Lulus)
                                @endif
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai</label>
                        <input type="number" name="nilai" id="inputNilai" min="0" max="100" step="0.1"
                               placeholder="Masukkan nilai 0-100"
                               class="w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status" id="inputStatus" class="w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Pilih Status</option>
                            <option value="lulus">✅ Lulus</option>
                            <option value="tidak_lulus">❌ Tidak Lulus</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="resetForm()" id="btnCancel" class="bg-gray-500 text-white px-6 py-3 text-sm rounded-lg hover:bg-gray-600 transition-colors" style="display: none;">
                        🔄 Batal
                    </button>
                    <button type="submit" id="btnSubmit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-3 text-sm rounded-lg hover:from-blue-600 hover:to-blue-700 transition-colors shadow-sm">
                        💾 Upload Nilai
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    <div id="modalHapusNilai" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white p-6 rounded-xl w-96 shadow-2xl">
            <div class="text-center mb-4">
                <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Hapus Nilai</h3>
                <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus nilai <span id="jenisNilaiHapus" class="font-semibold"></span>?</p>
                <p class="text-xs text-red-500 mt-1">Tindakan ini tidak dapat dibatalkan.</p>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModalHapus()" class="bg-gray-300 text-gray-700 px-4 py-2 text-sm rounded-lg hover:bg-gray-400 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="confirmHapusNilai()" class="bg-red-600 text-white px-4 py-2 text-sm rounded-lg hover:bg-red-700 transition-colors">
                    🗑️ Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Variables for managing delete operation
let currentDeleteData = null;

// Helper function to get jenis text - ADD THIS FUNCTION
function getJenisText(jenis) {
    switch(jenis) {
        case 'proposal': return 'Seminar Proposal';
        case 'hasil': return 'Seminar Hasil';
        case 'sidang': return 'Sidang';
        default: return jenis;
    }
}

// Function to edit nilai - Updated to properly set hidden field
function editNilai(jenis, nilai, lulus) {
    // Fill form with existing data
    document.getElementById('jenisSeminar').value = jenis;
    document.getElementById('inputNilai').value = nilai;
    document.getElementById('inputStatus').value = lulus == 1 ? 'lulus' : 'tidak_lulus';

    // Set the hidden field for jenis_seminar (important for PUT requests)
    document.getElementById('hiddenJenisSeminar').value = jenis;

    // Change form to edit mode
    document.getElementById('methodField').value = 'PUT';
    document.getElementById('btnSubmit').innerHTML = '🔄 Update Nilai';
    document.getElementById('btnCancel').style.display = 'inline-block';

    // Disable jenis selection when editing
    document.getElementById('jenisSeminar').disabled = true;

    // Scroll to form
    document.getElementById('formNilai').scrollIntoView({ behavior: 'smooth' });

    showSimpleNotification(`Mode edit untuk ${getJenisText(jenis)}`, 'info');
}

// Function to show delete confirmation
function hapusNilai(jenis, seminarId) {
    currentDeleteData = { jenis, seminarId };
    document.getElementById('jenisNilaiHapus').textContent = getJenisText(jenis);
    document.getElementById('modalHapusNilai').classList.remove('hidden');
}

// Function to close delete modal
function closeModalHapus() {
    document.getElementById('modalHapusNilai').classList.add('hidden');
    currentDeleteData = null;
}

// Function to confirm delete - Fixed route
function confirmHapusNilai() {
    if (!currentDeleteData) return;

    const { jenis, seminarId } = currentDeleteData;

    // Show loading
    showSimpleNotification('Menghapus nilai...', 'info');

    // Send delete request - Fixed route
    fetch(`{{ route('hapus.nilai', $mahasiswa->id_mahasiswa) }}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            jenis_seminar: jenis,
            seminar_id: seminarId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSimpleNotification(data.message, 'success');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showSimpleNotification(data.message || 'Gagal menghapus nilai', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showSimpleNotification('Terjadi kesalahan saat menghapus nilai', 'error');
    })
    .finally(() => {
        closeModalHapus();
    });
}

// Function to reset form to upload mode - Updated to clear hidden field
function resetForm() {
    document.getElementById('formNilai').reset();
    document.getElementById('methodField').value = 'POST';
    document.getElementById('btnSubmit').innerHTML = '💾 Upload Nilai';
    document.getElementById('btnCancel').style.display = 'none';
    document.getElementById('jenisSeminar').disabled = false;
    document.getElementById('seminarId').value = '';
    document.getElementById('hiddenJenisSeminar').value = ''; // Clear hidden field

    showSimpleNotification('Form direset ke mode upload', 'info');
}

// Add event listener to sync the visible select with hidden input
document.getElementById('jenisSeminar').addEventListener('change', function() {
    document.getElementById('hiddenJenisSeminar').value = this.value;
});

// Handle form submission with enhanced validation
document.getElementById('formNilai').addEventListener('submit', function(e) {
    const jenis = document.getElementById('jenisSeminar').value;
    const method = document.getElementById('methodField').value;

    // Sync the hidden field in case it's out of sync
    document.getElementById('hiddenJenisSeminar').value = jenis;

    // Additional validation for prerequisites
    if (jenis === 'hasil' && (!{{ $seminarProposal ? 'true' : 'false' }} || {{ $seminarProposal->lulus ?? 0 }} != 1)) {
        e.preventDefault();
        showAlert('Seminar Proposal harus lulus terlebih dahulu sebelum dapat mengupload nilai Seminar Hasil', 'warning', 'Prasyarat Tidak Terpenuhi');
        return;
    }

    if (jenis === 'sidang' && (!{{ $seminarHasil ? 'true' : 'false' }} || {{ $seminarHasil->lulus ?? 0 }} != 1)) {
        e.preventDefault();
        showAlert('Seminar Hasil harus lulus terlebih dahulu sebelum dapat mengupload nilai Sidang', 'warning', 'Prasyarat Tidak Terpenuhi');
        return;
    }

    // Show loading state
    const btnSubmit = document.getElementById('btnSubmit');
    const originalText = btnSubmit.innerHTML;
    btnSubmit.innerHTML = method === 'PUT' ? '🔄 Updating...' : '💾 Uploading...';
    btnSubmit.disabled = true;

    // Debug: Log form data before submission
    console.log('Form data being submitted:', {
        method: method,
        jenis_seminar: jenis,
        nilai: document.getElementById('inputNilai').value,
        status: document.getElementById('inputStatus').value
    });
});

// Enhanced notification function with more types
function showSimpleNotification(message, type = 'success') {
    // Remove any existing notifications
    const existingNotification = document.querySelector('.simple-notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = `simple-notification fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-sm font-medium text-white transform transition-all duration-300 translate-x-full ${getNotificationClass(type)}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Slide in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 10);

    // Slide out and remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

function getNotificationClass(type) {
    switch (type) {
        case 'success':
            return 'bg-green-600';
        case 'error':
            return 'bg-red-600';
        case 'warning':
            return 'bg-yellow-600';
        case 'info':
            return 'bg-blue-600';
        default:
            return 'bg-blue-600';
    }
}

// Custom Alert Modal Functions
function showAlert(message, type = 'warning', title = null) {
    return new Promise((resolve) => {
        // Create modal if it doesn't exist
        let modal = document.getElementById('alertModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'alertModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50';
            modal.innerHTML = `
                <div id="alertModalContent" class="bg-white p-6 rounded-xl w-96 shadow-2xl transform scale-95 transition-transform duration-300">
                    <div id="alertModalHeader" class="text-center mb-4">
                        <h3 id="alertModalTitle" class="text-lg font-semibold text-gray-800 mb-2"></h3>
                        <p id="alertModalMessage" class="text-sm text-gray-600"></p>
                    </div>
                    <div class="flex justify-center">
                        <button id="alertModalOkBtn" class="bg-blue-500 text-white px-6 py-2 text-sm rounded-lg hover:bg-blue-600 transition-colors">
                            OK
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        const modalContent = document.getElementById('alertModalContent');
        const modalHeader = document.getElementById('alertModalHeader');
        const modalTitle = document.getElementById('alertModalTitle');
        const modalMessage = document.getElementById('alertModalMessage');
        const okBtn = document.getElementById('alertModalOkBtn');

        // Set title
        modalTitle.textContent = title || getDefaultTitle(type);

        // Set message
        modalMessage.textContent = message;

        // Set icon and colors based on type
        const iconHTML = getIconHTML(type);
        const existingIcon = modalHeader.querySelector('div');
        if (existingIcon) {
            existingIcon.remove();
        }
        modalHeader.insertAdjacentHTML('afterbegin', iconHTML);

        // Show modal with animation
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);

        // Handle OK button
        const handleOk = () => {
            closeAlertModal(modal, modalContent);
            resolve(true);
            okBtn.removeEventListener('click', handleOk);
            document.removeEventListener('keydown', handleEscape);
        };

        // Handle Escape key
        const handleEscape = (e) => {
            if (e.key === 'Escape') {
                handleOk();
            }
        };

        okBtn.addEventListener('click', handleOk);
        document.addEventListener('keydown', handleEscape);

        // Close when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                handleOk();
            }
        });
    });
}

function closeAlertModal(modal, modalContent) {
    modalContent.classList.remove('scale-100');
    modalContent.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function getDefaultTitle(type) {
    switch (type) {
        case 'success': return 'Berhasil';
        case 'error': return 'Error';
        case 'warning': return 'Peringatan';
        default: return 'Informasi';
    }
}

function getIconHTML(type) {
    switch (type) {
        case 'success':
            return `<div class="bg-green-100 rounded-full p-2"><svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>`;
        case 'error':
            return `<div class="bg-red-100 rounded-full p-2"><svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></div>`;
        case 'warning':
            return `<div class="bg-yellow-100 rounded-full p-2"><svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg></div>`;
        default:
            return `<div class="bg-blue-100 rounded-full p-2"><svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>`;
    }
}

// All the existing penguji selection functions...
function selectPenguji(inputId, dosenName) {
    const input = document.getElementById(inputId);
    const otherInputs = ['searchPenguji1', 'searchPenguji2', 'searchPenguji3'].filter(id => id !== inputId);

    // Jangan lakukan apapun jika input disabled
    if (input.disabled) return;

    // Cek apakah dosen sudah dipilih di input lainnya
    for (let otherInputId of otherInputs) {
        const otherInput = document.getElementById(otherInputId);
        if (otherInput && otherInput.value === dosenName) {
            showAlert('Dosen ini sudah dipilih sebagai penguji lain', 'warning', 'Penguji Duplikat');
            return;
        }
    }

    input.value = dosenName;

    // Update hidden input
    if (inputId === 'searchPenguji1') {
        document.getElementById('hiddenPenguji1').value = dosenName;
    } else if (inputId === 'searchPenguji2') {
        document.getElementById('hiddenPenguji2').value = dosenName;
    } else if (inputId === 'searchPenguji3') {
        document.getElementById('hiddenPenguji3').value = dosenName;
        // Also update the save form hidden input
        const hiddenPenguji3Save = document.getElementById('hiddenPenguji3Save');
        if (hiddenPenguji3Save) {
            hiddenPenguji3Save.value = dosenName;
        }
        // Enable save button and show save container
        enablePenguji3Save();
    }

    // Refresh all tables to hide selected lecturers
    refreshAllTables();

    // Add visual feedback without modal
    showSimpleNotification(`${dosenName} berhasil dipilih sebagai penguji`, 'success');
}

function enablePenguji3Save() {
    const saveContainer = document.getElementById('savePenguji3Container');
    const saveBtn = document.getElementById('savePenguji3Btn');

    if (saveContainer && saveBtn) {
        saveContainer.style.display = 'block';
        saveBtn.disabled = false;
        saveBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

function showPenguji3() {
    document.getElementById('penguji3Section').style.display = 'block';
    document.getElementById('addPenguji3Button').style.display = 'none';

    // Refresh tables to ensure proper exclusions
    refreshAllTables();

    // Simple notification instead of modal
    showSimpleNotification('Penguji 3 telah ditambahkan (opsional)', 'success');
}

function removePenguji3() {
    document.getElementById('penguji3Section').style.display = 'none';
    document.getElementById('addPenguji3Button').style.display = 'block';
    document.getElementById('searchPenguji3').value = '';
    document.getElementById('hiddenPenguji3').value = '';

    // Hide save container and reset
    const saveContainer = document.getElementById('savePenguji3Container');
    const saveBtn = document.getElementById('savePenguji3Btn');
    const hiddenPenguji3Save = document.getElementById('hiddenPenguji3Save');

    if (saveContainer) saveContainer.style.display = 'none';
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
    if (hiddenPenguji3Save) hiddenPenguji3Save.value = '';

    // Refresh tables after removing penguji 3
    refreshAllTables();

    // Simple notification instead of modal
    showSimpleNotification('Penguji 3 telah dihapus', 'success');
}

function cancelPenguji3() {
    // Reset penguji 3 selection
    document.getElementById('searchPenguji3').value = '';
    document.getElementById('hiddenPenguji3').value = '';

    // Hide save container
    const saveContainer = document.getElementById('savePenguji3Container');
    const saveBtn = document.getElementById('savePenguji3Btn');
    const hiddenPenguji3Save = document.getElementById('hiddenPenguji3Save');

    if (saveContainer) saveContainer.style.display = 'none';
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
    if (hiddenPenguji3Save) hiddenPenguji3Save.value = '';

    // Refresh tables
    refreshAllTables();

    showSimpleNotification('Pemilihan penguji 3 dibatalkan', 'warning');
}

// Handle form submission for penguji 3
document.getElementById('formPenguji3')?.addEventListener('submit', function(e) {
    const penguji3Name = document.getElementById('hiddenPenguji3Save').value;

    if (!penguji3Name) {
        e.preventDefault();
        showAlert('Silakan pilih penguji 3 terlebih dahulu', 'warning', 'Penguji Belum Dipilih');
        return;
    }

    // Show loading state
    const saveBtn = document.getElementById('savePenguji3Btn');
    if (saveBtn) {
        saveBtn.innerHTML = '⏳ Menyimpan...';
        saveBtn.disabled = true;
    }
});

// New function to refresh all tables based on current selections
function refreshAllTables() {
    const selectedPenguji = [
        document.getElementById('searchPenguji1').value,
        document.getElementById('searchPenguji2').value,
        document.getElementById('searchPenguji3').value
    ].filter(value => value.trim() !== '');

    // Update Penguji 1 table
    updateTableExclusions('penguji1Table', selectedPenguji, document.getElementById('searchPenguji1').value);

    // Update Penguji 2 table
    updateTableExclusions('penguji2Table', selectedPenguji, document.getElementById('searchPenguji2').value);

    // Update Penguji 3 table
    updateTableExclusions('penguji3Table', selectedPenguji, document.getElementById('searchPenguji3').value);
}

// New function to update table with exclusions
function updateTableExclusions(tableId, selectedPenguji, currentValue) {
    const rows = document.querySelectorAll(`#${tableId} tr`);
    rows.forEach(row => {
        const namaDosen = row.querySelector('td')?.textContent;
        if (namaDosen && selectedPenguji.includes(namaDosen) && namaDosen !== currentValue) {
            row.style.display = 'none';
        } else {
            // Only show if it matches current search keyword
            const searchInput = document.getElementById(tableId.replace('Table', '').replace('penguji', 'searchPenguji'));
            const keyword = searchInput ? searchInput.value.toLowerCase() : '';

            if (keyword === '' || row.innerText.toLowerCase().includes(keyword)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

// Script Pencarian untuk Penguji - Updated to handle exclusions
document.getElementById('searchPenguji1').addEventListener('input', function() {
    const keyword = this.value.toLowerCase();
    const otherValues = [
        document.getElementById('searchPenguji2').value,
        document.getElementById('searchPenguji3').value
    ];
    const items = document.querySelectorAll('#penguji1Table tr');
    items.forEach(item => {
        const namaDosen = item.querySelector('td')?.textContent;
        if (otherValues.includes(namaDosen)) {
            item.style.display = 'none';
        } else {
            item.style.display = item.innerText.toLowerCase().includes(keyword) ? '' : 'none';
        }
    });
});

document.getElementById('searchPenguji2').addEventListener('input', function() {
    const keyword = this.value.toLowerCase();
    const otherValues = [
        document.getElementById('searchPenguji1').value,
        document.getElementById('searchPenguji3').value
    ];
    const items = document.querySelectorAll('#penguji2Table tr');
    items.forEach(item => {
        const namaDosen = item.querySelector('td')?.textContent;
        if (otherValues.includes(namaDosen)) {
            item.style.display = 'none';
        } else {
            item.style.display = item.innerText.toLowerCase().includes(keyword) ? '' : 'none';
        }
    });
});

document.getElementById('searchPenguji3').addEventListener('input', function() {
    const keyword = this.value.toLowerCase();
    const otherValues = [
        document.getElementById('searchPenguji1').value,
        document.getElementById('searchPenguji2').value
    ];
    const items = document.querySelectorAll('#penguji3Table tr');
    items.forEach(item => {
        const namaDosen = item.querySelector('td')?.textContent;
        if (otherValues.includes(namaDosen) && namaDosen) {
            item.style.display = 'none';
        } else {
            item.style.display = item.innerText.toLowerCase().includes(keyword) ? '' : 'none';
        }
    });
});

// Modal open & close
function openModal() {
    document.getElementById('editModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function saveJudulTA() {
    const newJudul = document.getElementById('editJudulTA').value;
    document.getElementById('judulTAField').value = newJudul;
    closeModal();
    showSimpleNotification('Judul TA berhasil diperbarui', 'success');
}

</script>

@endsection
