<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-gray-100 font-poppins min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('components/navbardosen')

    <div class="container mx-auto px-4 pt-4">
    <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-4xl mx-auto mt-16">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-800">Data Dosen Pembimbing</h1>
        </div>

        <h2 class="text-lg font-semibold text-gray-900 mb-2">
            Prof. Dr. Taufik Fuadi Abidin, S.Si, M.Tech
        </h2>
        <p class="text-gray-700 text-sm">Bidang: Data Mining</p>
        <p class="text-gray-700 text-sm">Jumlah Bimbingan: 10</p>

        <!-- Input Link WhatsApp -->
        <div class="mt-4">
            <label for="whatsappGroup" class="text-xs text-gray-600">Link WhatsApp Grup:</label>
            <div class="flex items-center space-x-2 mt-1">
                <input type="text" id="whatsappGroup" 
                    value="{{ auth()->user()->whatsapp_link ?? 'https://chat.whatsapp.com/xxxxx' }}"
                    class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-80 focus:ring-blue-500 focus:border-blue-500"
                    disabled>
                <button id="editWhatsapp" class="px-3 py-2 bg-blue-500 text-white text-xs rounded-lg hover:bg-yellow-600 transition">
                    ✏️ Edit
                </button>
                <button id="saveWhatsapp" class="px-3 py-2 bg-green-500 text-white text-xs rounded-lg hover:bg-green-600 transition hidden">
                    ✅ Simpan
                </button>
            </div>
        </div>

        <!-- Daftar Mahasiswa -->
        <h2 class="text-lg font-semibold text-gray-900 mt-6">Daftar Mahasiswa Bimbingan</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-xs text-left text-gray-500">
                <thead class="text-[10px] text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="p-3"><input type="checkbox"></th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">NPM</th>
                        <th class="px-4 py-2">Bidang</th>
                        <th class="px-4 py-2">Role Dosen</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="p-3"><input type="checkbox"></td>
                        <td class="px-4 py-2 font-medium text-gray-900">Sharahiya</td>
                        <td class="px-4 py-2">2108107010082</td>
                        <td class="px-4 py-2">RPL</td>
                        <td class="px-4 py-2">Dospem1</td>
                        <td class="px-4 py-2">Sempro</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="#" class="text-blue-600 hover:underline">Edit</a>
                            <a href="#" class="text-red-600 hover:underline">Remove</a>
                        </td>
                    </tr>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="p-3"><input type="checkbox"></td>
                        <td class="px-4 py-2 font-medium text-gray-900">Fatiya Quzza</td>
                        <td class="px-4 py-2">2108107010030</td>
                        <td class="px-4 py-2">RPL</td>
                        <td class="px-4 py-2">Dospem2</td>
                        <td class="px-4 py-2">Non</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="#" class="text-blue-600 hover:underline">Edit</a>
                            <a href="#" class="text-red-600 hover:underline">Remove</a>
                        </td>
                    </tr>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="p-3"><input type="checkbox"></td>
                        <td class="px-4 py-2 font-medium text-gray-900">Tyara Rayna</td>
                        <td class="px-4 py-2">2108107010082</td>
                        <td class="px-4 py-2">DM</td>
                        <td class="px-4 py-2">Dospem1</td>
                        <td class="px-4 py-2">Semhas</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="#" class="text-blue-600 hover:underline">Edit</a>
                            <a href="#" class="text-red-600 hover:underline">Remove</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script JavaScript -->
<script>
    document.getElementById('editWhatsapp').addEventListener('click', function () {
        let inputField = document.getElementById('whatsappGroup');
        inputField.disabled = false;
        inputField.focus();
        document.getElementById('editWhatsapp').classList.add('hidden');
        document.getElementById('saveWhatsapp').classList.remove('hidden');
    });

    document.getElementById('saveWhatsapp').addEventListener('click', function () {
        let inputField = document.getElementById('whatsappGroup');
        inputField.disabled = true;
        document.getElementById('editWhatsapp').classList.remove('hidden');
        document.getElementById('saveWhatsapp').classList.add('hidden');
        alert('Link WhatsApp berhasil disimpan!');
    });
</script>

