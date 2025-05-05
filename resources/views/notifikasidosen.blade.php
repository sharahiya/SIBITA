@extends('layouts.layoutdosen')
@section('content')
    <style>
        .notification-container {
            max-height: 490px; /* Menampilkan 9 notifikasi sebelum scroll */
            overflow-y: auto;
        }
        .notification-item {
            padding: 10px;
            border-radius: 6px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
            background: #D6E6F2; /* Warna biru muda pastel */
        }
    </style>

    <div class="container mx-auto px-4 pt-4">
        <div class="bg-white p-4 shadow-lg rounded-lg w-full max-w-3xl mx-auto">
            <div class="text-center mb-4">
                <h1 class="text-lg font-semibold text-gray-800">Notifikasi</h1>
            </div>
            
            <div class="space-y-3 notification-container" id="notifContainer"></div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let notifContainer = document.getElementById("notifContainer");
            let jenisAjuanList = ["Bimbingan", "Sempro", "Semhas", "Sidang"];
            let totalNotifications = 10; // Total data

            let notifications = "";
            for (let i = 1; i <= totalNotifications; i++) {
                let jenisAjuan = jenisAjuanList[i % 4];

                // Format tanggal seperti "21 Maret 2024"
                let options = { day: "2-digit", month: "long", year: "numeric" };
                let tanggal = new Date().toLocaleDateString("id-ID", options);

                notifications += `
                    <div class='notification-item flex justify-between items-center'>
                        <div>
                            <p class='text-gray-800 text-sm font-medium'>Mahasiswa ${i} mengajukan ${jenisAjuan}</p>
                            <p class='text-gray-600 text-xs'>21081070100${i} - ${tanggal}</p>
                        </div>
                        <a href='requestdosen' class='text-white bg-blue-500 px-2 py-1 text-xs rounded hover:bg-blue-600 transition'>Lihat</a>
                    </div>`;
            }

            notifContainer.innerHTML = notifications;
        });
    </script>

@endsection
