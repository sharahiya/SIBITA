@extends('layouts.layoutmhs')

@section('content')
<style>
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 50;
        background-color: rgba(0, 0, 0, 0.4);
        justify-content: center;
        align-items: center;
    }
    .modal.show {
        display: flex;
    }
</style>

<div class="container mx-auto px-4 py-6">
    <div class="bg-white p-6 shadow-xl rounded-xl w-full max-w-3xl mx-auto space-y-4">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800">Notifikasi</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded text-sm text-center">
                {{ session('success') }}
            </div>
        @endif

        @if($notifikasi->isNotEmpty())
            <div class="flex justify-end gap-2 mb-4">
                <form action="{{ route('notifikasi.baca.semua') }}" method="POST" onsubmit="return confirm('Tandai semua notifikasi sebagai sudah dibaca?')">
                    @csrf
                    <input type="hidden" name="id_user" value="{{ $mahasiswaId }}">
                    <button type="submit" class="bg-green-600 text-white text-sm px-3 py-1 rounded hover:bg-green-700 transition">
                        Tandai Sudah Dibaca
                    </button>
                </form>

                <form action="{{ route('notifikasi.hapus.semua') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua notifikasi?')">
                    @csrf
                    <input type="hidden" name="id_user" value="{{ $mahasiswaId }}">
                    <button type="submit" class="bg-red-600 text-white text-sm px-3 py-1 rounded hover:bg-red-700 transition">
                        Hapus Semua
                    </button>
                </form>
            </div>
        @endif

        <div class="space-y-3 max-h-[500px] overflow-y-auto" id="notifContainer">
            @forelse($notifikasi as $index => $notif)
                @php
                    $pesan = $notif->pesan ?? '';
                    $isRejected = Str::contains(strtolower($pesan), 'ditolak');
                    $isUnread = $notif->status_baca === 'belum';
                    $tanggal = \Carbon\Carbon::parse($notif->tanggal_kirim)->translatedFormat('d F Y');
                    $tipe = $notif->tipe_notifikasi ?? 'Umum';
                    $notifId = $notif->id_notifikasi;

                    $bgClass = $isUnread
                        ? ($isRejected ? 'bg-red-100 border-l-4 border-red-500' : 'bg-yellow-100 border-l-4 border-yellow-500')
                        : ($isRejected ? 'bg-red-50' : 'bg-gray-50');
                @endphp

                <div class="p-4 rounded-lg shadow-sm {{ $bgClass }} flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <p class="text-gray-800 text-sm font-medium">{{ $pesan }}</p>
                        <p class="text-gray-500 text-xs italic mt-1">{{ $tipe }} • {{ $tanggal }}</p>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <button onclick="handleClick({{ $index }})"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 text-xs rounded transition">
                            🔍 Lihat
                        </button>
                        @if($isUnread)
                            <form action="{{ route('notifikasi.baca.satu', $notifId) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 text-xs hover:underline">Tandai Dibaca</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm text-center py-4">🚫 Tidak ada notifikasi.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal -->
<div id="modalReject" class="modal">
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md">
        <div class="text-lg font-semibold text-red-600 mb-2">❌ Pengajuan Ditolak</div>
        <div id="modalMessage" class="text-gray-700 text-sm mb-4"></div>
        <div class="flex justify-center gap-4">
            <button onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded transition">Tutup</button>
            <button id="btnAjukanDospem" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Ajukan Dospem Baru</button>
        </div>
    </div>
</div>

<script>
    let notifikasi = @json($notifikasi);
    notifikasi = notifikasi.map(n => ({
        ...n,
        isRejected: n.pesan?.toLowerCase().includes('penolakan') || n.pesan?.toLowerCase().includes('ditolak'),
    }));

    function getRedirectUrl(tipe) {
        const routes = {
            "Penolakan Bimbingan": "/pengajuan",
            "Penerimaan Bimbingan": "/pengajuan",
            "Penolakan Seminar Proposal": "/sempro",
            "Penerimaan Seminar Proposal": "/sempro",
            "Penolakan Seminar Hasil": "/semhas",
            "Penerimaan Seminar Hasil": "/semhas",
            "Penolakan Sidang": "/sidang",
            "Penerimaan Sidang": "/sidang"
        };
        return routes[tipe] || "/dashboard";
    }

    function handleClick(index) {
        const notif = notifikasi[index];
        if (notif.isRejected) {
            let alasan = "Tidak ada alasan spesifik.";
            if (notif.pesan && notif.pesan.includes(":")) {
                alasan = notif.pesan.split(":")[1]?.trim() || alasan;
            }
            document.getElementById("modalMessage").innerText = `Alasan: ${alasan}`;
            document.getElementById("modalReject").classList.add("show");
        } else {
            const redirectUrl = getRedirectUrl(notif.tipe_notifikasi);
            const notifId = notif.id_notifikasi;

            fetch(`/notifikasi/baca/${notifId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            }).then(() => {
                window.location.href = redirectUrl;
            }).catch(error => {
                console.error('Error marking notification as read:', error);
            });
        }
    }

    function closeModal() {
        document.getElementById("modalReject").classList.remove("show");
    }

    document.getElementById("btnAjukanDospem").addEventListener("click", function () {
        window.location.href = "/pengajuan";
    });
</script>
@endsection
