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
        'sempro' => 'Seminar Proposal (JPG/PNG)',
        'semhas' => 'Seminar Hasil (JPG/PNG)',
        'sidang' => 'Sidang (PDF)'
      ] as $jenis => $label)

      @php $data = $$jenis; @endphp



      <section x-data="{ modal: false }" class="border rounded-lg p-6 bg-gray-50">
        <h3 class="font-semibold text-blue-700 text-sm mb-2">{{ $label }}</h3>

        @if ($data && $data->lampiran)
        <div class="mb-2">
          ✅ <span class="text-gray-700">Sudah diunggah:</span>
          <button type="button" @click="modal = true" class="text-blue-600 underline hover:text-blue-800">
            Lihat Berkas
          </button>
        </div>

        <!-- Modal -->
<div x-show="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-4 max-w-3xl w-full h-[90vh] overflow-auto">
      @if ($jenis === 'sidang')
        <iframe src="{{ asset('storage/' . $data->lampiran) }}" type="application/pdf" class="w-full h-[80vh] rounded border"
          frameborder="0"></iframe>
      @else
        <img src="{{ asset('storage/' . $data->lampiran) }}" alt="Lampiran {{ ucfirst($jenis) }}"
          class="max-w-full max-h-[80vh] rounded mx-auto">
      @endif
      <button @click="modal = false"
        class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">Tutup</button>
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
                <input type="file" name="berkas" accept=".jpg,.jpeg,.png,.pdf"
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

        @else
        <!-- Upload Baru -->
        <form action="{{ route('upload.berkas') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-3 mt-3">
          @csrf
          <input type="hidden" name="jenis" value="{{ $jenis }}">
          <input type="file" name="berkas" accept=".jpg,.jpeg,.png,.pdf"
            class="file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
          <button type="submit"
            class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">Upload</button>
        </form>
        @endif
      </section>
      @endforeach

    </form>
  </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


@endsection
