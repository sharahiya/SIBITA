<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .notification-container {
            max-height: 490px; /* Menampilkan 9 notifikasi sebelum scroll */
            overflow-y: auto;
        }
        .notification-item {
            padding: 12px;
            border-radius: 8px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .accepted {
            background: #E3F2FD;
        }
        .rejected {
            background: #FDECEC;
        }
        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 50;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .modal.show {
            display: flex;
            opacity: 1;
            transform: scale(1);
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .modal-header {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }
        .modal-body {
            color: #555;
            font-size: 0.9rem;
            margin-top: 8px;
        }
        .modal-footer {
            margin-top: 16px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn-close {
            background: #ccc;
            color: #333;
        }
        .btn-close:hover {
            background: #b3b3b3;
        }
        .btn-submit {
            background: #007BFF;
            color: white;
        }
        .btn-submit:hover {
            background: #0056b3;
        }
    </style>
</head>
<body class="bg-blue-100 font-poppins min-h-screen flex flex-col text-base">
    
    @include('components/navbar')

    <div class="container mx-auto px-4 pt-4">
        <div class="bg-white p-4 shadow-lg rounded-lg w-full max-w-3xl mx-auto mt-16">
            <div class="text-center mb-4">
                <h1 class="text-lg font-semibold text-gray-800">Notifikasi</h1>
            </div>
            
            <div class="space-y-3 notification-container" id="notifContainer"></div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modalReject" class="modal">
        <div class="modal-content">
            <div class="modal-header">Pengajuan Ditolak</div>
            <div id="modalMessage" class="modal-body"></div>
            <div class="modal-footer">
                <button onclick="closeModal()" class="btn btn-close">Tutup</button>
                <a href="pengajuan" class="btn btn-submit">Ajukan Dospem Baru</a>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let notifContainer = document.getElementById("notifContainer");

        let notifikasi = [
            { jenis: "Dospem", status: "Diterima", pesan: "Dosen A menerima permohonan dospem Anda.", tanggal: new Date(2024, 2, 24) },
            { jenis: "Dospem", status: "Ditolak", pesan: "Dosen B menolak permohonan dospem Anda.", alasan: "Kuota sudah penuh.", tanggal: new Date(2024, 2, 23) },
            { jenis: "Sempro", status: "Diterima", pesan: "Seminar Proposal Anda telah diterima oleh dosen.", tanggal: new Date(2024, 2, 22) },
            { jenis: "Semhas", status: "Diterima", pesan: "Seminar Hasil Anda telah diterima oleh dosen.", tanggal: new Date(2024, 2, 21) },
            { jenis: "Sidang", status: "Diterima", pesan: "Sidang Skripsi Anda telah diterima oleh dosen.", tanggal: new Date(2024, 2, 20) },
            { jenis: "Dospem", status: "Ditolak", pesan: "Dosen C menolak permohonan dospem Anda.", alasan: "Tidak sesuai bidang keahlian.", tanggal: new Date(2024, 2, 19) },
            { jenis: "Dospem", status: "Diterima", pesan: "Dosen D menerima permohonan dospem Anda.", tanggal: new Date(2024, 2, 18) },
            { jenis: "Sidang", status: "Diterima", pesan: "Sidang Skripsi Anda telah diterima oleh dosen.", tanggal: new Date(2024, 2, 17) },
            { jenis: "Sempro", status: "Diterima", pesan: "Seminar Proposal Anda telah diterima oleh dosen.", tanggal: new Date(2024, 2, 16) },
            { jenis: "Dospem", status: "Ditolak", pesan: "Dosen E menolak permohonan dospem Anda.", alasan: "Sudah memiliki banyak bimbingan.", tanggal: new Date(2024, 2, 15) }
        ];

        let notifications = "";
        notifikasi.forEach((notif, index) => {
            let statusClass = notif.status === "Ditolak" ? "rejected" : "accepted";
            let tanggalFormat = notif.tanggal.toLocaleDateString("id-ID", { day: '2-digit', month: 'long', year: 'numeric' });

            notifications += `
                <div class='notification-item ${statusClass} flex justify-between items-center'>
                    <div>
                        <p class='text-gray-800 text-sm font-medium'>${notif.pesan}</p>
                        <p class='text-gray-600 text-xs'>${tanggalFormat}</p>
                    </div>
                    <button onclick="handleClick(${index})" class='text-white bg-blue-500 px-2 py-1 text-xs rounded hover:bg-blue-600 transition'>Lihat</button>
                </div>`;
        });

        notifContainer.innerHTML = notifications;

        // Tambahkan scroll jika lebih dari 9 notifikasi
        if (notifikasi.length > 9) {
            notifContainer.style.overflowY = "auto";
        }

        // Event handler untuk klik tombol "Lihat"
        window.handleClick = function(index) {
            let notif = notifikasi[index];

            if (notif.status === "Ditolak") {
                document.getElementById("modalMessage").innerText = `Alasan: ${notif.alasan}`;
                document.getElementById("modalReject").classList.add("show");
            } else {
                window.location.href = "dashboard"; // Jika diterima, arahkan ke dashboard
            }
        };

        // Fungsi menutup modal
        window.closeModal = function() {
            document.getElementById("modalReject").classList.remove("show");
        };

        // Event listener untuk tombol "Ajukan Dospem Baru"
        document.getElementById("btnAjukanDospem").addEventListener("click", function() {
            window.location.href = "pengajuan"; // Arahkan ke halaman pengajuan dospem
        });

    });
</script>

<!-- Modal Pop-Up -->
<div id="modalReject" class="modal">
    <div class="modal-content">
        <div class="modal-header">Pengajuan Ditolak</div>
        <div id="modalMessage" class="modal-body"></div>
        <div class="modal-footer">
            <button onclick="closeModal()" class="btn btn-close">Tutup</button>
            <button id="btnAjukanDospem" class="btn btn-submit">Ajukan Dospem Baru</button>
        </div>
    </div>
</div>

    </script>

    @include('components/footer')
</body>
</html>
