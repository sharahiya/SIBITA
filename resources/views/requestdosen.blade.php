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

  /* Styling untuk PDF iframe */
  #pdfViewer {
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }

  /* Loading indicator */
  .pdf-loading {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
    color: #666;
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
              @if (!empty($item->lampiran))
                @if (strtolower(pathinfo($item->lampiran, PATHINFO_EXTENSION)) === 'pdf')
                  <div class="flex flex-col gap-1">
                    <button type="button" class='text-blue-600 hover:underline text-xs'
                      onclick='openModal("{{ route('lampiran.pdf', basename($item->lampiran)) }}", "pdf")'>
                      📄 Lihat PDF
                    </button>
                    <button type="button" class='text-green-600 hover:underline text-xs'
                      onclick='openPdfInNewTab("{{ route('lampiran.pdf', basename($item->lampiran)) }}")'>
                      🔗 Buka di Tab Baru
                    </button>
                  </div>
                @else
                  <button type="button" class='text-blue-600 hover:underline text-xs'
                    onclick='openModal("{{ asset('storage/' . $item->lampiran) }}", "image")'>
                    🖼️ Lihat Lampiran
                  </button>
                @endif
              @endif
              
              @if (!empty($item->deskripsi_ta))
                <button type="button" class='text-purple-600 hover:underline text-xs block mt-1' 
                  onclick='openModal({!! json_encode($item->deskripsi_ta) !!}, "text")'>
                  📝 Lihat Deskripsi
                </button>
              @endif
              
              @if (empty($item->lampiran) && empty($item->deskripsi_ta))
                <span class="text-gray-400">-</span>
              @endif
            </td>
            <td class='px-4 py-2 border border-gray-300 fixed-cell'>{{ ucfirst($item->tipe_pengajuan ?? 'Bimbingan') }}</td>
            <td class='px-4 py-2 border border-gray-300 fixed-cell'>Dospem {{ $item->role ?? '1' }}</td>
            <td class='px-4 py-2 border border-gray-300 flex gap-2 justify-center fixed-cell'>
              <button onclick="acceptRequest({{ $item->tipe_pengajuan === 'bimbingan' ? $item->id_pengajuan : $item->id_seminar }}, '{{ $item->tipe_pengajuan }}')" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">
                Terima
              </button>

              <button onclick="rejectRequest({{ $item->tipe_pengajuan === 'bimbingan' ? $item->id_pengajuan : $item->id_seminar }}, '{{ $item->tipe_pengajuan }}')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
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
        <h3 class="text-lg font-semibold mb-3 text-gray-800">📝 Deskripsi Tugas Akhir</h3>
        <div class="max-h-[60vh] overflow-auto">
          <p id="modalText" class="text-gray-800 text-sm whitespace-pre-line leading-relaxed bg-gray-50 p-4 rounded"></p>
        </div>
      </div>

      <!-- Image Content -->
      <div id="imageContent" class="hidden flex flex-col items-center">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">🖼️ Lampiran</h3>
        <div class="flex justify-center">
          <img id="modalImage" src="" alt="Lampiran" class="max-w-full max-h-[70vh] rounded shadow">
        </div>
      </div>

      <!-- PDF Content -->
      <div id="pdfContent" class="hidden">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">📄 Dokumen PDF</h3>
        <div id="pdfLoadingIndicator" class="pdf-loading">
          <div class="text-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-2"></div>
            <p>Memuat PDF...</p>
          </div>
        </div>
        <iframe 
          id="pdfViewer" 
          src="" 
          class="w-full h-[75vh] rounded border hidden"
          frameborder="0">
        </iframe>
        <div id="pdfError" class="hidden text-center py-8">
          <p class="text-red-500 mb-4">❌ Gagal memuat PDF</p>
          <button onclick="retryLoadPdf()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            🔄 Coba Lagi
          </button>
          <button onclick="openPdfInNewTab(currentPdfUrl)" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 ml-2">
            🔗 Buka di Tab Baru
          </button>
        </div>
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
  let rejectTipe = null;
  let currentPdfUrl = null; // Track current PDF URL for retry

  function openModal(content, type) {
    try {
      const modal = document.getElementById('modalDeskripsi');
      const textContent = document.getElementById('textContent');
      const imageContent = document.getElementById('imageContent');
      const pdfContent = document.getElementById('pdfContent');

      if (!modal || !textContent || !imageContent || !pdfContent) {
        console.error('Modal elements not found');
        return;
      }

      // Hide all content containers first
      textContent.classList.add('hidden');
      imageContent.classList.add('hidden');
      pdfContent.classList.add('hidden');

      switch (type) {
        case 'text':
          if (content) {
            textContent.classList.remove('hidden');
            document.getElementById('modalText').textContent = content;
          } else {
            alert('Tidak ada deskripsi untuk ditampilkan');
            return;
          }
          break;
        case 'image':
          if (content) {
            imageContent.classList.remove('hidden');
            const img = document.getElementById('modalImage');
            img.src = content;
            img.onerror = function() {
              alert('Gagal memuat gambar');
              closeModal();
            };
          } else {
            alert('Tidak ada lampiran untuk ditampilkan');
            return;
          }
          break;
        case 'pdf':
          if (content) {
            currentPdfUrl = content; // Store for retry
            pdfContent.classList.remove('hidden');
            showPdfLoading();
            loadPdf(content);
          } else {
            alert('Tidak ada dokumen PDF untuk ditampilkan');
            return;
          }
          break;
        default:
          console.error('Invalid modal type:', type);
          return;
      }

      modal.classList.remove('hidden');
    } catch (error) {
      console.error('Error opening modal:', error);
      alert('Terjadi kesalahan saat membuka modal');
    }
  }

  function loadPdf(url) {
    const iframe = document.getElementById('pdfViewer');
    const loadingIndicator = document.getElementById('pdfLoadingIndicator');
    const errorDiv = document.getElementById('pdfError');
    
    // Reset states
    iframe.classList.add('hidden');
    errorDiv.classList.add('hidden');
    loadingIndicator.classList.remove('hidden');
    
    // Load PDF with inline parameter
    iframe.src = url + (url.includes('?') ? '&' : '?') + 'inline=1';
    
    // Set up event listeners for iframe
    iframe.onload = function() {
      hidePdfLoading();
    };
    
    iframe.onerror = function() {
      showPdfError();
    };
    
    // Fallback timeout in case onload doesn't fire
    setTimeout(function() {
      if (!iframe.classList.contains('hidden')) {
        return; // Already loaded successfully
      }
      
      // Check if iframe has content
      try {
        // Try to access iframe content to see if it loaded
        if (iframe.contentDocument || iframe.contentWindow) {
          hidePdfLoading();
        } else {
          showPdfError();
        }
      } catch (e) {
        // Cross-origin or other access issues, assume it loaded
        hidePdfLoading();
      }
    }, 5000); // 5 second timeout
  }

  function showPdfLoading() {
    document.getElementById('pdfLoadingIndicator').classList.remove('hidden');
    document.getElementById('pdfViewer').classList.add('hidden');
    document.getElementById('pdfError').classList.add('hidden');
  }

  function hidePdfLoading() {
    document.getElementById('pdfLoadingIndicator').classList.add('hidden');
    document.getElementById('pdfViewer').classList.remove('hidden');
    document.getElementById('pdfError').classList.add('hidden');
  }

  function showPdfError() {
    document.getElementById('pdfLoadingIndicator').classList.add('hidden');
    document.getElementById('pdfViewer').classList.add('hidden');
    document.getElementById('pdfError').classList.remove('hidden');
  }

  function retryLoadPdf() {
    if (currentPdfUrl) {
      loadPdf(currentPdfUrl);
    }
  }

  function openPdfInNewTab(url) {
    if (url) {
      window.open(url, '_blank', 'noopener,noreferrer');
    }
  }

  function closeModal() {
    try {
      const modal = document.getElementById('modalDeskripsi');
      if (modal) {
        modal.classList.add('hidden');
      }

      // Reset content safely
      const modalText = document.getElementById('modalText');
      const modalImage = document.getElementById('modalImage');
      const pdfViewer = document.getElementById('pdfViewer');

      if (modalText) modalText.textContent = '';
      if (modalImage) modalImage.src = '';
      if (pdfViewer) {
        pdfViewer.src = '';
        pdfViewer.onload = null;
        pdfViewer.onerror = null;
      }
      
      currentPdfUrl = null;
    } catch (error) {
      console.error('Error closing modal:', error);
    }
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