@extends('layouts.layoutdosen')
@section('content')
<style>
  .table-container {
    max-height: 400px;
    overflow-y: auto;
  }

  .word-wrap {
    white-space: normal;
    word-break: break-word;
    max-width: 250px;
  }

  .fixed-cell {
    white-space: nowrap;
  }

</style>


<div class="container mx-auto px-4 pt-4">
  <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-6xl mx-auto">

    <div class="text-center mb-8">
      <h1 class="text-2xl font-semibold text-gray-800">Request Mahasiswa Bimbingan</h1>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg table-container">
      <table class="w-full text-xs text-left text-gray-500 border border-gray-300">
        <thead class="text-[10px] text-white uppercase bg-blue-900">
          <tr>
            <th class="px-4 py-2 border border-gray-300 fixed-cell">No</th>
            <th class="px-4 py-2 border border-gray-300 fixed-cell">Nama</th>
            <th class="px-4 py-2 border border-gray-300 fixed-cell">NPM</th>
            <th class="px-4 py-2 border border-gray-300 fixed-cell">Bidang</th>
            <th class="px-4 py-2 border border-gray-300 word-wrap">Judul Tugas Akhir</th>
            <th class="px-4 py-2 border border-gray-300 fixed-cell">Deskripsi/Lampiran</th>
            <th class="px-4 py-2 border border-gray-300 fixed-cell">Jenis Ajuan</th>
            <th class="px-4 py-2 border border-gray-300 fixed-cell">Role</th>
            <th class="px-4 py-2 border border-gray-300 fixed-cell">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pengajuans as $index => $item)
          <tr class='bg-white even:bg-gray-50 border-b hover:bg-blue-50'>
            <td class='px-4 py-2 border border-gray-300 font-medium text-gray-900 fixed-cell'>{{ $index + 1 }}</td>
            <td class='px-4 py-2 border border-gray-300 font-medium text-gray-900 fixed-cell'>{{ $item->mahasiswa->nama }}</td>
            <td class='px-4 py-2 border border-gray-300 fixed-cell'>{{ $item->mahasiswa->npm }}</td>
            <td class='px-4 py-2 border border-gray-300 fixed-cell'>{{ $item->bidang ?? '-' }}</td>
            <td class='px-4 py-2 border border-gray-300 word-wrap'>{{ $item->topik_ta }}</td>
            <td class='px-4 py-2 border border-gray-300 fixed-cell'>
              @if ($item->lampiran)
              @if (pathinfo($item->lampiran, PATHINFO_EXTENSION) === 'pdf')
              <button type="button" class='text-blue-600 hover:underline' onclick='openModal("{{ asset('storage/' . $item->lampiran) }}", "pdf")'>Lihat PDF</button>
              @else
              <button type="button" class='text-blue-600 hover:underline' onclick='openModal("{{ asset('storage/' . $item->lampiran) }}", "image")'>Lihat Lampiran</button>
              @endif
              @endif
              @if ($item->deskripsi_ta)
              <button type="button" class='text-blue-600 hover:underline' onclick='openModal(@json($item->deskripsi_ta), "text")'>Lihat Deskripsi</button>
              @endif
            </td>
            <td class='px-4 py-2 border border-gray-300 fixed-cell'>{{ ucfirst($item->tipe_pengajuan ?? 'Bimbingan') }}</td>
            <td class='px-4 py-2 border border-gray-300 fixed-cell'>Dospem {{ $item->role ?? '1' }}</td>
            <td class='px-4 py-2 border border-gray-300 flex gap-2 justify-center fixed-cell'>
              <button onclick="acceptRequest({{ $item->tipe_pengajuan === 'bimbingan' ? $item->id_pengajuan : $item->id_seminar }}, '{{ $item->tipe_pengajuan }}')" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                Terima
              </button>

              <button onclick="rejectRequest({{ $item->tipe_pengajuan === 'bimbingan' ? $item->id_pengajuan : $item->id_seminar }}, '{{ $item->tipe_pengajuan }}')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                Tolak
              </button>
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Updated Modal -->
<div id="modalDeskripsi" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-6xl max-h-[90vh] overflow-auto">
      <!-- Text Content -->
      <div id="textContent" class="hidden">
        <p id="modalText" class="text-gray-800 text-sm whitespace-pre-line"></p>
      </div>

      <!-- Image Content -->
      <div id="imageContent" class="hidden flex justify-center">
        <img id="modalImage" src="" alt="Lampiran" class="max-w-full max-h-[70vh] rounded shadow">
      </div>

      <!-- PDF Content -->
      <div id="pdfContent" class="hidden">
        {{-- <iframe id="pdfViewer" src="" type="application/pdf" class="w-full h-[75vh] rounded border" allowfullscreen></iframe> --}}
        <iframe id="pdfViewer" src="" type="application/pdf" class="w-full h-[80vh] rounded border"
            frameborder="0"></iframe>
      </div>

      <div class="mt-6 flex justify-end">
        <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600" onclick="closeModal()">Tutup</button>
      </div>
    </div>
  </div>

<!-- Modal Alasan Penolakan -->
<div id="modalReject" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-lg font-semibold mb-2">Alasan Penolakan</h2>
    <textarea id="rejectReason" class="w-full p-2 border rounded mb-4" placeholder="Tulis alasan..."></textarea>
    <div class="flex justify-end gap-2">
      <button onclick="closeRejectModal()" class="bg-gray-400 text-white px-3 py-1 rounded">Batal</button>
      <button onclick="submitReject()" class="bg-red-600 text-white px-3 py-1 rounded">Kirim</button>
    </div>
  </div>
</div>
<script>
  let rejectTargetId = null;

  function openModal(content, type) {
    const modal = document.getElementById('modalDeskripsi');
    const textContent = document.getElementById('textContent');
    const imageContent = document.getElementById('imageContent');
    const pdfContent = document.getElementById('pdfContent');

    // Hide all content containers first
    textContent.classList.add('hidden');
    imageContent.classList.add('hidden');
    pdfContent.classList.add('hidden');

    // Show appropriate content based on type
    switch (type) {
      case 'text':
        textContent.classList.remove('hidden');
        document.getElementById('modalText').textContent = content;
        break;
      case 'image':
        imageContent.classList.remove('hidden');
        document.getElementById('modalImage').src = content;
        break;
      case 'pdf':
        pdfContent.classList.remove('hidden');
        document.getElementById('pdfViewer').src = content;
        break;
    }

    modal.classList.remove('hidden');
  }

  function closeModal() {
    const modal = document.getElementById('modalDeskripsi');
    modal.classList.add('hidden');

    // Reset content
    document.getElementById('modalText').textContent = '';
    document.getElementById('modalImage').src = '';
    document.getElementById('pdfViewer').src = '';
  }

  function acceptRequest(id, tipe) {
    if (confirm('Yakin ingin menerima pengajuan ini?')) {
      updateStatus(id, 'diterima', '', tipe);
    }
  }

  function rejectRequest(id, tipe) {
    rejectTargetId = id;
    rejectTipe = tipe;
    document.getElementById('rejectReason').value = "";
    document.getElementById('modalReject').classList.remove('hidden');
  }


  function closeRejectModal() {
    document.getElementById('modalReject').classList.add('hidden');
  }

  function submitReject() {
    let reason = document.getElementById('rejectReason').value.trim();
    if (!reason) {
      alert('Silakan isi alasan penolakan!');
      return;
    }
    updateStatus(rejectTargetId, 'ditolak', reason, rejectTipe);
    closeRejectModal();
  }

  function updateStatus(id, status, alasan = '', tipe = 'bimbingan') {
    fetch("{{ route('pengajuan.updateStatus') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            id_pengajuan: id,
            status: status,
            alasan: alasan,
            tipe: tipe
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memperbarui status');
    });
}

</script>

@endsection
