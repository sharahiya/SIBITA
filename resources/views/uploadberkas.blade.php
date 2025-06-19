@extends('layouts.layoutmhs')

@section('content')

<div class="container mx-auto px-4 pt-4 max-w-5xl space-y-6">
  @if(session('success'))
  <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
    {{ session('success') }}
  </div>
  @endif

  @if(session('error'))
  <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
    {{ session('error') }}
  </div>
  @endif
  <!-- Header -->
  <div class="bg-white p-6 shadow-md rounded-lg mb-6">
    <h1 class="text-xl font-extrabold text-gray-800">Tugas Akhir Mahasiswa</h1>
    <p class="text-sm text-gray-600">Informasi lengkap mengenai tugas akhir mahasiswa</p>
  </div>
  <!-- Data Mahasiswa -->
  <div class="bg-white p-6 shadow rounded-xl mb-6 border border-gray-100">
    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">📘 Data Mahasiswa</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
      <div>
        <p class="text-gray-500">Nama</p>
        <p class="text-gray-900 font-medium">{{ $mahasiswa->nama }}</p>
      </div>
      <div>
        <p class="text-gray-500">NPM</p>
        <p class="text-gray-900 font-medium">{{ $mahasiswa->npm }}</p>
      </div>
      <div>
        <p class="text-gray-500">Semester Sajian</p>
        <p class="text-gray-900 font-medium">Genap 2024</p>
      </div>
      <div>
        <p class="text-gray-500">Dosen Wali</p>
        <p class="text-gray-900 font-medium">{{ $mahasiswa->dosenWali->nama ?? '-' }}</p>
      </div>
      <div>
        <p class="text-gray-500">NIP Dosen Wali</p>
        <p class="text-gray-900 font-medium">{{ $mahasiswa->dosenWali->nip ?? '-' }}</p>
      </div>
    </div>
  </div>

  <!-- Informasi Tugas Akhir -->
  <div class="bg-white p-6 shadow rounded-xl border border-gray-100">
    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">🎓 Informasi Tugas Akhir</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
      <div>
        <p class="text-gray-500">Bidang Penelitian</p>
        <p class="text-gray-900 font-medium">{{ $pengajuan->bidang ?? '-' }}</p>
      </div>
      <div>
        <p class="text-gray-500">Judul TA</p>
        <p class="text-gray-900 font-medium">{{ $pengajuan->topik_ta ?? '-' }}</p>
      </div>
      <div class="md:col-span-2">
        <p class="text-gray-500">Deskripsi</p>
        <p class="text-gray-900 whitespace-pre-line">{{ $pengajuan->deskripsi_ta ?? '-' }}</p>
      </div>
      <div>
        <p class="text-gray-500">Dosen Pembimbing 1</p>
        <p class="text-gray-900 font-medium">{{ $dospem1->nama ?? '-' }}</p>
      </div>
      <div>
        <p class="text-gray-500">Dosen Pembimbing 2</p>
        <p class="text-gray-900 font-medium">{{ $dospem2->nama ?? '-' }}</p>
      </div>
    </div>
  </div>


  <div class="bg-white p-8 shadow-md rounded-lg text-sm text-gray-700">
    <h2 class="text-base font-bold text-gray-800 mb-6 border-b pb-2">📎 Upload Berkas Seminar</h2>
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-10">

      @foreach ([
        'sempro' => 'Seminar Proposal (PDF)',
        'semhas' => 'Seminar Hasil (PDF)',
        'sidang' => 'Sidang (PDF)'
      ] as $jenis => $label)

      @php
        $data = $$jenis;
        $canUpload = false;

        // Proposal can always be uploaded
        if ($jenis === 'sempro') {
          $canUpload = true;
        }
        // Semhas requires approved sempro
        else if ($jenis === 'semhas') {
          $canUpload = $sempro && $sempro->status === 'diterima';
        }
        // Sidang requires approved semhas
        else if ($jenis === 'sidang') {
          $canUpload = $semhas && $semhas->status === 'diterima';
        }
      @endphp

      <section x-data="{ modal: false }" class="border rounded-lg p-6 bg-gray-50">
        <h3 class="font-semibold text-blue-700 text-sm mb-2">{{ $label }}</h3>

        {{-- Add notes below each title --}}
        @if(!$data || !$data->lampiran)
            @if($jenis === 'sempro' || $jenis === 'semhas')
                <div class="mb-4 p-3 bg-blue-50 border-l-4 border-blue-400 rounded">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium">📋 Catatan Penting:</p>
                            <p class="mt-1">
                                @if($jenis === 'sempro')
                                    Harap upload hasil catatan notulensi seminar proposal dalam bentuk PDF
                                @elseif($jenis === 'semhas')
                                    Harap upload hasil catatan notulensi seminar hasil dalam bentuk PDF
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($jenis === 'sidang')
                <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-400 rounded">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-green-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-green-800">
                            <p class="font-medium">🎓 Catatan Sidang:</p>
                            <p class="mt-1">Upload dokumen laporan skripsi dalam bentuk PDF</p>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @if ($data && $data->lampiran)
        <div class="mb-2">
          ✅ <span class="text-gray-700">Sudah diunggah:</span>
          <button type="button" @click="modal = true" class="text-blue-600 underline hover:text-blue-800">
            Lihat Berkas PDF
          </button>
        </div>

        <!-- Modal -->
        <div x-show="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
          <div class="bg-white rounded-lg p-4 max-w-5xl w-full h-[90vh] overflow-auto">
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-semibold text-gray-800">📄 {{ $label }}</h3>
              <button @click="modal = false" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>

            <!-- PDF Viewer -->
            <iframe
              src="{{ asset('storage/' . $data->lampiran) }}"
              type="application/pdf"
              class="w-full h-[75vh] rounded border"
              frameborder="0">
              <p>Browser Anda tidak mendukung tampilan PDF.
                <a href="{{ asset('storage/' . $data->lampiran) }}" target="_blank" class="text-blue-600 underline">
                  Klik di sini untuk membuka PDF
                </a>
              </p>
            </iframe>

            <div class="mt-4 flex gap-2">
              <button @click="modal = false"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 flex-1">
                Tutup
              </button>
              <a href="{{ asset('storage/' . $data->lampiran) }}"
                 target="_blank"
                 class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center flex-1">
                Buka di Tab Baru
              </a>
            </div>
          </div>
        </div>

        <!-- Status -->
        <p class="mt-3">
          Status:
          @switch($data->status)
            @case('pending')
              <span class="text-yellow-600 font-semibold">Menunggu Verifikasi</span>
              @break
            @case('selesai')
            @case('diterima')
              <span class="text-green-600 font-semibold">Diterima</span>
              @break
            @case('ditolak')
              <span class="text-red-600 font-semibold">Ditolak</span>

              @if(app()->environment('local'))
              <form action="{{ route('upload.berkas') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2 mt-4">
                @csrf
                <input type="hidden" name="jenis" value="{{ $jenis }}">
                <input type="file" name="berkas" accept=".pdf"
                  class="file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                <button type="submit"
                  class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700">Ajukan Ulang</button>
              </form>
              @endif
              @break
            @default
              <span class="text-gray-600 italic">Tidak diketahui</span>
          @endswitch
        </p>

        <!-- Status Section -->
        <!-- Status Approvals -->
        <div class="mt-4 space-y-3 bg-gray-50 p-4 rounded-lg">
            <h4 class="font-medium text-gray-700">Status Persetujuan:</h4>

            <!-- Dosen Pembimbing 1 -->
            <div>
                <p class="text-sm text-gray-600">
                    {{ $data->pengajuanSeminar->where('dosen_ke', 1)->first()?->dosen->nama ?? 'Dosen Pembimbing 1' }}:
                </p>
                @php
                    $pengajuan1 = $data->pengajuanSeminar->where('dosen_ke', 1)->first();
                @endphp
                @if($pengajuan1)
                    <div class="mt-1">
                        @switch($pengajuan1->status)
                            @case('pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Menunggu Verifikasi
                                </span>
                                @break
                            @case('diterima')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Disetujui
                                </span>
                                @break
                            @case('ditolak')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                                @if($pengajuan1->catatan)
                                    <p class="mt-1 text-sm text-red-600">Catatan: {{ $pengajuan1->catatan }}</p>
                                @endif
                                @break
                        @endswitch
                    </div>
                @endif
            </div>

            <!-- Dosen Pembimbing 2 -->
            <div>
                <p class="text-sm text-gray-600">
                    {{ $data->pengajuanSeminar->where('dosen_ke', 2)->first()?->dosen->nama ?? 'Dosen Pembimbing 2' }}:
                </p>
                @php
                    $pengajuan2 = $data->pengajuanSeminar->where('dosen_ke', 2)->first();
                @endphp
                @if($pengajuan2)
                    <div class="mt-1">
                        @switch($pengajuan2->status)
                            @case('pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Menunggu Verifikasi
                                </span>
                                @break
                            @case('diterima')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Disetujui
                                </span>
                                @break
                            @case('ditolak')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                                @if($pengajuan2->catatan)
                                    <p class="mt-1 text-sm text-red-600">Catatan: {{ $pengajuan2->catatan }}</p>
                                @endif
                                @break
                        @endswitch
                    </div>
                @endif
            </div>
        </div>

        @else
        <!-- Upload Baru -->
        <form action="{{ route('upload.berkas') }}" method="POST" enctype="multipart/form-data"
          class="flex flex-wrap items-center gap-3 mt-3">
          @csrf
          <input type="hidden" name="jenis" value="{{ $jenis }}">

          @if(!$canUpload)
            <div class="text-sm text-gray-500 italic">
              @if($jenis === 'semhas')
                Seminar proposal harus disetujui terlebih dahulu
              @elseif($jenis === 'sidang')
                Seminar hasil harus disetujui terlebih dahulu
              @endif
            </div>
          @endif

          <input type="file"
            name="berkas"
            accept=".pdf"
            class="file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm
              {{ $canUpload
                ? 'file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100'
                : 'file:bg-gray-50 file:text-gray-400 cursor-not-allowed' }}"
            {{ !$canUpload ? 'disabled' : '' }}
            required>

          <button type="submit"
            class="bg-blue-500 text-white px-4 py-1 rounded
              {{ $canUpload
                ? 'hover:bg-blue-600'
                : 'opacity-50 cursor-not-allowed' }}"
            {{ !$canUpload ? 'disabled' : '' }}>
            Upload PDF
          </button>
        </form>

        @if(!$canUpload)
          <p class="mt-2 text-xs text-red-500">
            @if($jenis === 'semhas')
              * Anda harus menyelesaikan dan mendapat persetujuan seminar proposal terlebih dahulu
            @elseif($jenis === 'sidang')
              * Anda harus menyelesaikan dan mendapat persetujuan seminar hasil terlebih dahulu
            @endif
          </p>
        @endif
        @endif
      </section>
      @endforeach

    </form>
  </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


@endsection
