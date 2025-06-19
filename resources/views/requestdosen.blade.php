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

  /* Custom modal animations */
  .modal-enter {
    animation: modalFadeIn 0.3s ease-out;
  }

  .modal-content-enter {
    animation: modalSlideIn 0.3s ease-out;
  }

  @keyframes modalFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  @keyframes modalSlideIn {
    from {
      opacity: 0;
      transform: translateY(-20px) scale(0.95);
    }
    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  /* Success modal styling */
  .modal-success {
    border-left: 4px solid #10b981;
  }

  /* Error modal styling */
  .modal-error {
    border-left: 4px solid #ef4444;
  }

  /* Warning modal styling */
  .modal-warning {
    border-left: 4px solid #f59e0b;
  }

  /* Info modal styling */
  .modal-info {
    border-left: 4px solid #3b82f6;
  }
</style>

<div class="container mx-auto px-4 pt-4">
  <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-6xl mx-auto">

    <div class="text-center mb-8">
      <h1 class="text-2xl font-semibold text-gray-800">Request Mahasiswa Bimbingan</h1>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg table-container">
    <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-gray-500 border border-gray-300 min-w-[800px]">
            <thead class="text-[10px] text-white uppercase bg-blue-900">
                <tr>
                    <th class="px-2 sm:px-4 py-2 border border-gray-300 fixed-cell">No</th>
                    <th class="px-2 sm:px-4 py-2 border border-gray-300 fixed-cell">Nama</th>
                    <th class="px-2 sm:px-4 py-2 border border-gray-300 fixed-cell hidden sm:table-cell">NPM</th>
                    <th class="px-2 sm:px-4 py-2 border border-gray-300 fixed-cell hidden md:table-cell">Bidang</th>
                    <th class="px-2 sm:px-4 py-2 border border-gray-300 word-wrap">Judul TA</th>
                    <th class="px-2 sm:px-4 py-2 border border-gray-300 fixed-cell">Deskripsi/Lampiran</th>
                    <th class="px-2 sm:px-4 py-2 border border-gray-300 fixed-cell hidden lg:table-cell">Jenis Ajuan</th>
                    <th class="px-2 sm:px-4 py-2 border border-gray-300 fixed-cell hidden lg:table-cell">Role</th>
                    <th class="px-2 sm:px-4 py-2 border border-gray-300 fixed-cell">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengajuans as $index => $item)
                <tr class='bg-white even:bg-gray-50 border-b hover:bg-blue-50'>
                    <td class='px-2 sm:px-4 py-2 border border-gray-300 font-medium text-gray-900 fixed-cell'>{{ $index + 1 }}</td>
                    <td class='px-2 sm:px-4 py-2 border border-gray-300 font-medium text-gray-900 fixed-cell'>
                        <div class="font-medium">{{ $item->mahasiswa->nama }}</div>
                        <div class="text-gray-500 text-[10px] sm:hidden">{{ $item->mahasiswa->npm }}</div>
                    </td>
                    <td class='px-2 sm:px-4 py-2 border border-gray-300 fixed-cell hidden sm:table-cell'>{{ $item->mahasiswa->npm }}</td>
                    <td class='px-2 sm:px-4 py-2 border border-gray-300 fixed-cell hidden md:table-cell'>{{ $item->bidang ?? '-' }}</td>
                    <td class='px-2 sm:px-4 py-2 border border-gray-300 word-wrap'>
                        <div class="max-w-[150px] sm:max-w-[200px]">{{ $item->topik_ta }}</div>
                        <div class="text-gray-500 text-[10px] md:hidden mt-1">
                            @if($item->bidang)
                                <span>{{ $item->bidang }}</span>
                            @endif
                        </div>
                    </td>
                    <td class='px-2 sm:px-4 py-2 border border-gray-300 fixed-cell'>
                        @if (!empty($item->lampiran))
                            @if (strtolower(pathinfo($item->lampiran, PATHINFO_EXTENSION)) === 'pdf')
                                <div class="flex flex-col gap-1">
                                    <button type="button" class='text-blue-600 hover:underline text-[10px] sm:text-xs'
                                        onclick='openModal("{{ asset('storage/' . $item->lampiran) }}", "pdf")'>
                                        📄 PDF
                                    </button>
                                </div>
                            @else
                                <button type="button" class='text-blue-600 hover:underline text-[10px] sm:text-xs'
                                    onclick='openModal("{{ asset('storage/' . $item->lampiran) }}", "image")'>
                                    🖼️ Lampiran
                                </button>
                            @endif
                        @endif

                        @if (!empty($item->deskripsi_ta))
                            <button type="button" class='text-purple-600 hover:underline text-[10px] sm:text-xs block mt-1'
                                onclick='openModal({!! json_encode($item->deskripsi_ta) !!}, "text")'>
                                📝 Deskripsi
                            </button>
                        @endif

                        @if (empty($item->lampiran) && empty($item->deskripsi_ta))
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class='px-2 sm:px-4 py-2 border border-gray-300 fixed-cell hidden lg:table-cell'>{{ ucfirst($item->tipe_pengajuan ?? 'Bimbingan') }}</td>
                    <td class='px-2 sm:px-4 py-2 border border-gray-300 fixed-cell hidden lg:table-cell'>Dospem {{ $item->dosen_ke ?? '1' }}</td>
                    <td class='px-2 sm:px-4 py-2 border border-gray-300 fixed-cell'>
                        <div class="flex flex-col lg:flex-row gap-1 lg:gap-2 justify-center">
                            <div class="lg:hidden text-[10px] text-gray-500 mb-1">
                                {{ ucfirst($item->tipe_pengajuan ?? 'Bimbingan') }} | Dospem {{ $item->dosen_ke ?? '1' }}
                            </div>
                            <button onclick="showConfirmModal('accept', {{ $item->tipe_pengajuan === 'bimbingan' ? $item->id_pengajuan : $item->id_seminar }}, '{{ $item->tipe_pengajuan }}')" class="bg-green-500 text-white px-2 sm:px-3 py-1 rounded hover:bg-green-600 text-[10px] sm:text-xs">
                                Terima
                            </button>
                            <button onclick="rejectRequest({{ $item->tipe_pengajuan === 'bimbingan' ? $item->id_pengajuan : $item->id_seminar }}, '{{ $item->tipe_pengajuan }}')" class="bg-red-500 text-white px-2 sm:px-3 py-1 rounded hover:bg-red-600 text-[10px] sm:text-xs">
                                Tolak
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
        <iframe
        id="pdfViewer"
        src=""
        class="w-full h-[75vh] rounded border hidden"
        frameborder="0">
    </iframe>
    <div id="pdfLoadingIndicator" class="pdf-loading">
      {{-- <div class="text-center">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-2"></div>
        <p>Memuat PDF...</p>
      </div> --}}
    </div>
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
<div id="modalReject" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96 modal-content-enter">
    <div class="flex items-center mb-4">
      <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <h2 class="text-lg font-semibold text-gray-800">Alasan Penolakan</h2>
    </div>
    <p class="text-gray-600 mb-4">Silakan berikan alasan mengapa pengajuan ini ditolak:</p>
    <textarea id="rejectReason" class="w-full p-3 border border-gray-300 rounded-lg mb-4 focus:ring-2 focus:ring-red-500 focus:border-red-500"
              placeholder="Tulis alasan penolakan..." rows="4"></textarea>
    <div class="flex justify-end gap-3">
      <button onclick="closeRejectModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
        Batal
      </button>
      <button onclick="submitReject()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
        Tolak Pengajuan
      </button>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi -->
<div id="modalConfirm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96 modal-content-enter">
    <div class="flex items-center mb-4">
      <div id="confirmIcon" class="w-10 h-10 rounded-full flex items-center justify-center mr-3">
        <!-- Icon will be set dynamically -->
      </div>
      <h2 id="confirmTitle" class="text-lg font-semibold text-gray-800"></h2>
    </div>
    <p id="confirmMessage" class="text-gray-600 mb-6"></p>
    <div class="flex justify-end gap-3">
      <button onclick="closeConfirmModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
        Batal
      </button>
      <button id="confirmButton" onclick="executeConfirmAction()" class="px-4 py-2 rounded-lg transition-colors">
        <!-- Button text will be set dynamically -->
      </button>
    </div>
  </div>
</div>

<!-- Modal Notifikasi -->
<div id="modalNotification" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96 modal-content-enter">
    <div id="notificationContent" class="text-center">
      <div id="notificationIcon" class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center">
        <!-- Icon will be set dynamically -->
      </div>
      <h3 id="notificationTitle" class="text-lg font-semibold mb-2"></h3>
      <p id="notificationMessage" class="text-gray-600 mb-6"></p>
      <button onclick="closeNotificationModal()" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
        OK
      </button>
    </div>
  </div>
</div>

<script>
  let rejectTargetId = null;
  let rejectTipe = null;
  let currentPdfUrl = null;
  let confirmAction = null;
  let confirmParams = null;

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
            showNotification('warning', 'Tidak Ada Deskripsi', 'Tidak ada deskripsi untuk ditampilkan');
            return;
          }
          break;
        case 'image':
          if (content) {
            imageContent.classList.remove('hidden');
            const img = document.getElementById('modalImage');
            img.src = content;
            img.onerror = function() {
              showNotification('error', 'Gagal Memuat Gambar', 'Terjadi kesalahan saat memuat gambar');
              closeModal();
            };
          } else {
            showNotification('warning', 'Tidak Ada Lampiran', 'Tidak ada lampiran untuk ditampilkan');
            return;
          }
          break;
        case 'pdf':
          if (content) {
            currentPdfUrl = content;
            pdfContent.classList.remove('hidden');
            showPdfLoading();
            loadPdf(content);
          } else {
            showNotification('warning', 'Tidak Ada PDF', 'Tidak ada dokumen PDF untuk ditampilkan');
            return;
          }
          break;
        default:
          console.error('Invalid modal type:', type);
          return;
      }

      modal.classList.remove('hidden');
      modal.classList.add('modal-enter');
    } catch (error) {
      console.error('Error opening modal:', error);
      showNotification('error', 'Kesalahan', 'Terjadi kesalahan saat membuka modal');
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

    // Clear any previous event listeners
    iframe.onload = null;
    iframe.onerror = null;

    // Set the PDF URL
    iframe.src = url;

    // Use a more reliable approach for PDF loading
    let loadingTimeout;
    let hasLoaded = false;

    // Function to handle successful loading
    const handleLoadSuccess = () => {
      if (hasLoaded) return; // Prevent multiple executions
      hasLoaded = true;

      clearTimeout(loadingTimeout);
      hidePdfLoading();
      console.log('PDF loaded successfully');
    };

    // Function to handle loading error
    const handleLoadError = () => {
      if (hasLoaded) return; // Prevent multiple executions
      hasLoaded = true;

      clearTimeout(loadingTimeout);
      showPdfError();
      console.log('PDF failed to load');
    };

    // Set up event listeners
    iframe.addEventListener('load', handleLoadSuccess, { once: true });
    iframe.addEventListener('error', handleLoadError, { once: true });

    // Set up a more aggressive timeout approach
    loadingTimeout = setTimeout(() => {
      if (hasLoaded) return;

      // Try to detect if PDF actually loaded by checking iframe properties
      try {
        // For same-origin PDFs, we can sometimes check the contentDocument
        if (iframe.contentDocument || iframe.contentWindow) {
          console.log('PDF likely loaded (detected via timeout check)');
          handleLoadSuccess();
        } else {
          // If we can't access content, assume it loaded after reasonable time
          console.log('PDF assumed loaded after timeout');
          handleLoadSuccess();
        }
      } catch (e) {
        // Cross-origin or other restrictions - assume success for same-domain PDFs
        console.log('PDF assumed loaded after timeout (cross-origin)');
        handleLoadSuccess();
      }
    }, 2000); // Reduced timeout to 2 seconds

    // Additional fallback - force hide loading after 5 seconds max
    setTimeout(() => {
      if (!hasLoaded) {
        console.log('Force closing loading indicator after 5 seconds');
        handleLoadSuccess();
      }
    }, 5000);
  }

  function showPdfLoading() {
    const loadingIndicator = document.getElementById('pdfLoadingIndicator');
    const pdfViewer = document.getElementById('pdfViewer');
    const errorDiv = document.getElementById('pdfError');

    if (loadingIndicator) loadingIndicator.classList.remove('hidden');
    if (pdfViewer) pdfViewer.classList.add('hidden');
    if (errorDiv) errorDiv.classList.add('hidden');

    console.log('Showing PDF loading indicator');
  }

  function hidePdfLoading() {
    const loadingIndicator = document.getElementById('pdfLoadingIndicator');
    const pdfViewer = document.getElementById('pdfViewer');
    const errorDiv = document.getElementById('pdfError');

    if (loadingIndicator) loadingIndicator.classList.add('hidden');
    if (pdfViewer) pdfViewer.classList.remove('hidden');
    if (errorDiv) errorDiv.classList.add('hidden');

    console.log('Hiding PDF loading indicator');
  }

  function showPdfError() {
    const loadingIndicator = document.getElementById('pdfLoadingIndicator');
    const pdfViewer = document.getElementById('pdfViewer');
    const errorDiv = document.getElementById('pdfError');

    if (loadingIndicator) loadingIndicator.classList.add('hidden');
    if (pdfViewer) pdfViewer.classList.add('hidden');
    if (errorDiv) errorDiv.classList.remove('hidden');

    console.log('Showing PDF error');
  }

  function retryLoadPdf() {
    if (currentPdfUrl) {
      console.log('Retrying PDF load:', currentPdfUrl);
      loadPdf(currentPdfUrl);
    }
  }

  function openPdfInNewTab(url) {
    if (url) {
      console.log('Opening PDF in new tab:', url);
      window.open(url, '_blank', 'noopener,noreferrer');
    }
  }

  function closeModal() {
    try {
      const modal = document.getElementById('modalDeskripsi');
      if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('modal-enter');
      }

      // Reset content safely
      const modalText = document.getElementById('modalText');
      const modalImage = document.getElementById('modalImage');
      const pdfViewer = document.getElementById('pdfViewer');

      if (modalText) modalText.textContent = '';
      if (modalImage) modalImage.src = '';
      if (pdfViewer) {
        pdfViewer.src = '';
        // Clear event listeners
        pdfViewer.onload = null;
        pdfViewer.onerror = null;
      }

      // Reset PDF loading states
      const loadingIndicator = document.getElementById('pdfLoadingIndicator');
      const errorDiv = document.getElementById('pdfError');
      if (loadingIndicator) loadingIndicator.classList.add('hidden');
      if (errorDiv) errorDiv.classList.add('hidden');

      currentPdfUrl = null;
      console.log('Modal closed and reset');
    } catch (error) {
      console.error('Error closing modal:', error);
    }
  }

  function showConfirmModal(action, id, tipe) {
    const modal = document.getElementById('modalConfirm');
    const icon = document.getElementById('confirmIcon');
    const title = document.getElementById('confirmTitle');
    const message = document.getElementById('confirmMessage');
    const button = document.getElementById('confirmButton');

    confirmAction = action;
    confirmParams = { id, tipe };

    if (action === 'accept') {
      icon.className = 'w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3';
      icon.innerHTML = '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
      title.textContent = 'Konfirmasi Penerimaan';
      message.textContent = 'Apakah Anda yakin ingin menerima pengajuan ini?';
      button.className = 'px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors';
      button.textContent = 'Ya, Terima';
    }

    modal.classList.remove('hidden');
    modal.classList.add('modal-enter');
  }

  function closeConfirmModal() {
    const modal = document.getElementById('modalConfirm');
    modal.classList.add('hidden');
    modal.classList.remove('modal-enter');
    confirmAction = null;
    confirmParams = null;
  }

  function executeConfirmAction() {
    if (confirmAction === 'accept' && confirmParams) {
      updateStatus(confirmParams.id, 'diterima', '', confirmParams.tipe);
    }
    closeConfirmModal();
  }

  function rejectRequest(id, tipe) {
    rejectTargetId = id;
    rejectTipe = tipe;
    document.getElementById('rejectReason').value = "";
    const modal = document.getElementById('modalReject');
    modal.classList.remove('hidden');
    modal.classList.add('modal-enter');
  }

  function closeRejectModal() {
    const modal = document.getElementById('modalReject');
    modal.classList.add('hidden');
    modal.classList.remove('modal-enter');
  }

  function submitReject() {
    let reason = document.getElementById('rejectReason').value.trim();
    if (!reason) {
      showNotification('warning', 'Alasan Diperlukan', 'Silakan isi alasan penolakan terlebih dahulu!');
      return;
    }
    updateStatus(rejectTargetId, 'ditolak', reason, rejectTipe);
    closeRejectModal();
  }

  function showNotification(type, title, message) {
    const modal = document.getElementById('modalNotification');
    const icon = document.getElementById('notificationIcon');
    const titleEl = document.getElementById('notificationTitle');
    const messageEl = document.getElementById('notificationMessage');

    titleEl.textContent = title;
    messageEl.textContent = message;

    switch (type) {
      case 'success':
        icon.className = 'w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center';
        icon.innerHTML = '<svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        break;
      case 'error':
        icon.className = 'w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center';
        icon.innerHTML = '<svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        break;
      case 'warning':
        icon.className = 'w-16 h-16 mx-auto mb-4 bg-yellow-100 rounded-full flex items-center justify-center';
        icon.innerHTML = '<svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        break;
      case 'info':
        icon.className = 'w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center';
        icon.innerHTML = '<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        break;
    }

    modal.classList.remove('hidden');
    modal.classList.add('modal-enter');
  }

  function closeNotificationModal() {
    const modal = document.getElementById('modalNotification');
    modal.classList.add('hidden');
    modal.classList.remove('modal-enter');
  }

  function updateStatus(id, status, alasan = '', tipe = 'bimbingan') {
    // Show loading state during request
    showNotification('info', 'Memproses...', 'Sedang memperbarui status pengajuan...');

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
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        closeNotificationModal(); // Close loading notification

        if (data.message || data.status) {
          const title = status === 'diterima' ? 'Pengajuan Diterima' : 'Pengajuan Ditolak';
          const message = data.message || `Pengajuan berhasil ${status}`;
          showNotification('success', title, message);

          setTimeout(() => {
            location.reload();
          }, 2000);
        } else {
          showNotification('error', 'Gagal', 'Respons tidak valid dari server');
        }
    })
    .catch(error => {
        closeNotificationModal(); // Close loading notification
        console.error('Error:', error);
        showNotification('error', 'Kesalahan', 'Terjadi kesalahan saat memperbarui status: ' + error.message);
    });
  }
</script>

@endsection
