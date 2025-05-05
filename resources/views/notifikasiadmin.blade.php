@extends('layouts.layoutadmin')

@section('content')
<style>
    .notification-container {
        max-height: 490px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 10px;
        border-radius: 6px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.05);
        background-color: #D6E6F2; /* Belum dibaca */
        transition: background-color 0.3s;
    }

    .notification-item.read {
        background-color: #ffffff; /* Sudah dibaca */
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
        const notifContainer = document.getElementById("notifContainer");
        const jenisAjuanList = ["Penetapan Penguji", "Sempro", "Semhas", "Sidang"];
        const totalNotifications = 10;

        let notifications = "";

        for (let i = 1; i <= totalNotifications; i++) {
            const jenisAjuan = jenisAjuanList[i % 4];
            const tanggal = new Date().toLocaleDateString("id-ID", { day: "2-digit", month: "long", year: "numeric" });

            notifications += `
                <div class='notification-item flex justify-between items-center'>
                    <div>
                        <p class='text-gray-800 text-sm font-medium'>Mahasiswa ${i} mengajukan ${jenisAjuan}</p>
                        <p class='text-gray-600 text-xs'>21081070100${i} - ${tanggal}</p>
                    </div>
                    <a href='#' 
                       class='text-white bg-blue-500 px-2 py-1 text-xs rounded hover:bg-blue-600 transition'
                       onclick='markAsRead(this)'>
                        Lihat
                    </a>
                </div>`;
        }

        notifContainer.innerHTML = notifications;
    });

    function markAsRead(button) {
        const notifDiv = button.closest('.notification-item');
        notifDiv.classList.add('read');
        // redirect atau fetch data detail bisa ditambahkan di sini
    }
</script>
@endsection
