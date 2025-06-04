@extends('layouts.layoutdosen')

@section('content')
<style>
    .notification-container {
        max-height: 490px;
        overflow-y: auto;
    }
    .notification-item {
        padding: 12px;
        border-radius: 8px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        background: #D6E6F2;
    }
</style>

<div class="container mx-auto px-4 pt-4">
    <div class="bg-white p-4 shadow-lg rounded-lg w-full max-w-3xl mx-auto">
        <div class="text-center mb-4">
            <h1 class="text-lg font-semibold text-gray-800">Notifikasi</h1>
        </div>
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded text-sm text-center my-2">
                {{ session('success') }}
            </div>
        @endif
        @if($notifikasis->isNotEmpty())
        <div class="flex justify-end gap-2 mb-4">
            <form action="{{ route('notifikasi.baca.semua') }}" method="POST" onsubmit="return confirm('Tandai semua notifikasi sebagai sudah dibaca?')">
                @csrf
                <input type="hidden" name="id_user" value="{{ $dosenId }}">
                <button type="submit" class="bg-green-600 text-white text-sm px-3 py-1 rounded hover:bg-green-700 transition">
                    Tandai Sudah Dibaca
                </button>
            </form>

            <form action="{{ route('notifikasi.hapus.semua') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua notifikasi?')">
                @csrf
                <input type="hidden" name="id_user" value="{{ $dosenId }}">
                <button type="submit" class="bg-red-600 text-white text-sm px-3 py-1 rounded hover:bg-red-700 transition">
                    Hapus Semua
                </button>
            </form>
        </div>
    @endif
        <div class="space-y-3 notification-container" id="notifContainer">
            @forelse($notifikasis as $index => $notif)
                @php
                    $tanggal = \Carbon\Carbon::parse($notif->tanggal_kirim)->translatedFormat('d F Y');
                    $isUnread = $notif->status_baca === 'belum';
                    $bgClass = $isUnread ? 'bg-yellow-100 font-semibold' : 'bg-gray-100';
                    $tipe = $notif->tipe_notifikasi ?? 'Umum';
                    $pesan = $notif->pesan ?? '';
                    $notifId = $notif->id_notifikasi;
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

<script>
    let notifikasi = @json($notifikasis);

    function getRedirectUrl(tipe) {
        const routes = {
            "Pengajuan Bimbingan": "/requestdosen",
            "Pengajuan Seminar Proposal": "/requestdosen",
            "Pengajuan Seminar Hasil": "/requestdosen",
            "Pengajuan Proposal": "/requestdosen",
            "Pengajuan Hasil": "/requestdosen",
            "Pengajuan Sidang": "/requestdosen",
        };

        return routes[tipe] || "/dosen/dashboard";
    }

    function handleClick(index) {
        const notif = notifikasi[index];
        const redirectUrl = getRedirectUrl(notif.tipe_notifikasi);
        fetch(`/notifikasi/baca/${notif.id_notifikasi}`, {
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
</script>
@endsection
