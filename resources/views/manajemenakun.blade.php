@extends('layouts.layoutadmin')
@section('content')

<div class="container mx-auto px-4 pt-4 max-w-5xl">
    <!-- Header -->
    <div class="bg-white p-6 shadow-md rounded-lg w-full mx-auto">
        <h1 class="text-base font-semibold text-gray-800">Manajemen Akun</h1>
        <p class="text-gray-600 text-sm">Kelola akun mahasiswa dan dosen melalui upload CSV</p>
    </div>

    <!-- Tabs -->
    <div class="mt-4">
        <ul class="flex border-b text-xs font-medium text-gray-600">
            <li class="mr-4 cursor-pointer py-2 px-3 hover:text-blue-600 border-b-2 border-blue-500 text-blue-600" id="tab-mahasiswa-btn">Mahasiswa</li>
            <li class="cursor-pointer py-2 px-3 hover:text-blue-600" id="tab-dosen-btn">Dosen</li>
        </ul>
    </div>

    <!-- Mahasiswa Section -->
    <div id="tab-mahasiswa" class="mt-4">
        <!-- Upload -->
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-sm font-semibold text-gray-800 mb-3">Upload CSV Mahasiswa</h2>
            <div class="flex items-center space-x-2">
                <input type="file" id="csvMahasiswa" accept=".csv" class="text-xs p-2 border rounded-lg w-full md:w-auto">
                <button id="saveMahasiswa" class="text-white bg-blue-600 hover:bg-blue-700 text-xs px-4 py-2 rounded-lg disabled:bg-gray-400" disabled>Save</button>
            </div>
            <p class="text-xs text-gray-500 mt-2">Format: nama,npm,email,angkatan,nip_dosenwali</p>

            <!-- Status Messages -->
            <div id="statusMahasiswa" class="mt-2 hidden">
                <div class="text-xs p-2 rounded"></div>
            </div>

            <!-- Loading -->
            <div id="loadingMahasiswa" class="hidden mt-2">
                <div class="flex items-center text-blue-600">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600 mr-2"></div>
                    <span class="text-xs">Menyimpan data...</span>
                </div>
            </div>
        </div>

        <!-- Tabel Mahasiswa -->
        <div class="bg-white p-6 shadow-md rounded-lg mt-4">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-sm font-semibold text-gray-800">Preview Data Mahasiswa</h3>
                <div class="flex items-center space-x-4">
                    <span id="countMahasiswa" class="text-xs text-gray-500">0 data</span>
                    <span id="errorCountMahasiswa" class="text-xs text-red-500 hidden">0 error</span>
                </div>
            </div>

            <!-- Legend -->
            <div class="flex items-center space-x-4 mb-3">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-red-100 border border-red-300 mr-1"></div>
                    <span class="text-xs text-gray-600">Data bermasalah</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-white border border-gray-300 mr-1"></div>
                    <span class="text-xs text-gray-600">Data valid</span>
                </div>
            </div>

            <input type="text" id="searchMahasiswa" placeholder="Cari mahasiswa..." class="w-full md:w-64 p-2 text-xs border rounded-lg mb-3">
            <div class="overflow-x-auto max-h-60 overflow-y-auto">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead class="text-gray-700 uppercase bg-gray-100 sticky top-0">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NPM</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Angkatan</th>
                            <th class="px-4 py-2">NIP Dosen Wali</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswaTable">
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                Silakan upload file CSV untuk melihat preview data
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Dosen Section -->
    <div id="tab-dosen" class="mt-4 hidden">
        <!-- Upload -->
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-sm font-semibold text-gray-800 mb-3">Upload CSV Dosen</h2>
            <div class="flex items-center space-x-2">
                <input type="file" id="csvDosen" accept=".csv" class="text-xs p-2 border rounded-lg w-full md:w-auto">
                <button id="saveDosenBtn" class="text-white bg-blue-600 hover:bg-blue-700 text-xs px-4 py-2 rounded-lg disabled:bg-gray-400" disabled>Save</button>
            </div>
            <p class="text-xs text-gray-500 mt-2">Format: nama,nip,email,jabatan,bidang,jurusan</p>

            <!-- Status Messages -->
            <div id="statusDosen" class="mt-2 hidden">
                <div class="text-xs p-2 rounded"></div>
            </div>

            <!-- Loading -->
            <div id="loadingDosen" class="hidden mt-2">
                <div class="flex items-center text-blue-600">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600 mr-2"></div>
                    <span class="text-xs">Menyimpan data...</span>
                </div>
            </div>
        </div>

        <!-- Tabel Dosen -->
        <div class="bg-white p-6 shadow-md rounded-lg mt-4">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-sm font-semibold text-gray-800">Preview Data Dosen</h3>
                <div class="flex items-center space-x-4">
                    <span id="countDosen" class="text-xs text-gray-500">0 data</span>
                    <span id="errorCountDosen" class="text-xs text-red-500 hidden">0 error</span>
                </div>
            </div>

            <!-- Legend -->
            <div class="flex items-center space-x-4 mb-3">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-red-100 border border-red-300 mr-1"></div>
                    <span class="text-xs text-gray-600">Data bermasalah</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-white border border-gray-300 mr-1"></div>
                    <span class="text-xs text-gray-600">Data valid</span>
                </div>
            </div>

            <input type="text" id="searchDosen" placeholder="Cari dosen..." class="w-full md:w-64 p-2 text-xs border rounded-lg mb-3">
            <div class="overflow-x-auto max-h-60 overflow-y-auto">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead class="text-gray-700 uppercase bg-gray-100 sticky top-0">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NIP</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Jabatan</th>
                            <th class="px-4 py-2">Bidang Minat</th>
                            <th class="px-4 py-2">Jurusan</th>
                            <th class="px-4 py-2">Fakultas</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody id="dosenTable">
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-400">
                                Silakan upload file CSV untuk melihat preview data
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Custom Alert Modal -->
<div id="alertModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform transition-all duration-300 scale-95" id="alertModalContent">
        <!-- Modal Header -->
        <div class="flex items-center mb-4" id="alertModalHeader">
            <!-- Icon will be inserted here -->
            <h3 class="text-lg font-semibold text-gray-800 ml-3" id="alertModalTitle">Peringatan</h3>
        </div>

        <!-- Modal Body -->
        <div class="mb-6">
            <p class="text-gray-600 text-sm" id="alertModalMessage">Pesan akan ditampilkan di sini</p>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end space-x-3">
            <button id="alertModalCancelBtn" class="hidden px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                Batal
            </button>
            <button id="alertModalOkBtn" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                OK
            </button>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div id="confirmModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform transition-all duration-300 scale-95" id="confirmModalContent">
        <!-- Modal Header -->
        <div class="flex items-center mb-4">
            <div class="bg-yellow-100 rounded-full p-2 mr-3">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Konfirmasi</h3>
        </div>

        <!-- Modal Body -->
        <div class="mb-6">
            <p class="text-gray-600 text-sm" id="confirmModalMessage">Apakah Anda yakin?</p>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end space-x-3">
            <button id="confirmModalCancelBtn" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                Batal
            </button>
            <button id="confirmModalOkBtn" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>

<script>
    let mahasiswaData = [];
    let dosenData = [];
    let existingMahasiswa = [];
    let existingDosen = [];
    let existingJurusan = [];

    const tabMahasiswaBtn = document.getElementById('tab-mahasiswa-btn');
    const tabDosenBtn = document.getElementById('tab-dosen-btn');
    const tabMahasiswa = document.getElementById('tab-mahasiswa');
    const tabDosen = document.getElementById('tab-dosen');

    // Custom Alert Modal Functions
    function showAlert(message, type = 'info', title = null) {
        return new Promise((resolve) => {
            const modal = document.getElementById('alertModal');
            const modalContent = document.getElementById('alertModalContent');
            const modalHeader = document.getElementById('alertModalHeader');
            const modalTitle = document.getElementById('alertModalTitle');
            const modalMessage = document.getElementById('alertModalMessage');
            const okBtn = document.getElementById('alertModalOkBtn');
            const cancelBtn = document.getElementById('alertModalCancelBtn');

            // Set title
            modalTitle.textContent = title || getDefaultTitle(type);

            // Set message
            modalMessage.textContent = message;

            // Set icon and colors based on type
            const iconHTML = getIconHTML(type);
            const existingIcon = modalHeader.querySelector('div');
            if (existingIcon) {
                existingIcon.remove();
            }
            modalHeader.insertAdjacentHTML('afterbegin', iconHTML);

            // Set button colors
            okBtn.className = `px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors ${getButtonClass(type)}`;

            // Hide cancel button for alerts
            cancelBtn.classList.add('hidden');

            // Show modal with animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);

            // Handle OK button
            const handleOk = () => {
                closeModal(modal, modalContent);
                resolve(true);
                okBtn.removeEventListener('click', handleOk);
                document.removeEventListener('keydown', handleEscape);
            };

            // Handle Escape key
            const handleEscape = (e) => {
                if (e.key === 'Escape') {
                    handleOk();
                }
            };

            okBtn.addEventListener('click', handleOk);
            document.addEventListener('keydown', handleEscape);

            // Close when clicking outside
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    handleOk();
                }
            });
        });
    }

    function showConfirm(message, title = 'Konfirmasi') {
        return new Promise((resolve) => {
            const modal = document.getElementById('confirmModal');
            const modalContent = document.getElementById('confirmModalContent');
            const modalMessage = document.getElementById('confirmModalMessage');
            const okBtn = document.getElementById('confirmModalOkBtn');
            const cancelBtn = document.getElementById('confirmModalCancelBtn');

            // Set message
            modalMessage.textContent = message;

            // Show modal with animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);

            // Handle OK button
            const handleOk = () => {
                closeModal(modal, modalContent);
                resolve(true);
                cleanup();
            };

            // Handle Cancel button
            const handleCancel = () => {
                closeModal(modal, modalContent);
                resolve(false);
                cleanup();
            };

            // Handle Escape key
            const handleEscape = (e) => {
                if (e.key === 'Escape') {
                    handleCancel();
                }
            };

            const cleanup = () => {
                okBtn.removeEventListener('click', handleOk);
                cancelBtn.removeEventListener('click', handleCancel);
                document.removeEventListener('keydown', handleEscape);
            };

            okBtn.addEventListener('click', handleOk);
            cancelBtn.addEventListener('click', handleCancel);
            document.addEventListener('keydown', handleEscape);

            // Close when clicking outside
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    handleCancel();
                }
            });
        });
    }

    function closeModal(modal, modalContent) {
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function getDefaultTitle(type) {
        switch (type) {
            case 'success': return 'Berhasil';
            case 'error': return 'Error';
            case 'warning': return 'Peringatan';
            default: return 'Informasi';
        }
    }

    function getIconHTML(type) {
        switch (type) {
            case 'success':
                return `
                    <div class="bg-green-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                `;
            case 'error':
                return `
                    <div class="bg-red-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                `;
            case 'warning':
                return `
                    <div class="bg-yellow-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                `;
            default:
                return `
                    <div class="bg-blue-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                `;
        }
    }

    function getButtonClass(type) {
        switch (type) {
            case 'success':
                return 'bg-green-600 hover:bg-green-700 focus:ring-green-500';
            case 'error':
                return 'bg-red-600 hover:bg-red-700 focus:ring-red-500';
            case 'warning':
                return 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500';
            default:
                return 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500';
        }
    }

    // Tab switch
    tabMahasiswaBtn.addEventListener('click', () => {
        tabMahasiswa.classList.remove('hidden');
        tabDosen.classList.add('hidden');
        tabMahasiswaBtn.classList.add('border-blue-500', 'text-blue-600');
        tabDosenBtn.classList.remove('border-blue-500', 'text-blue-600');
    });

    tabDosenBtn.addEventListener('click', () => {
        tabDosen.classList.remove('hidden');
        tabMahasiswa.classList.add('hidden');
        tabDosenBtn.classList.add('border-blue-500', 'text-blue-600');
        tabMahasiswaBtn.classList.remove('border-blue-500', 'text-blue-600');
    });

    // Helper function to show status
    function showStatus(elementId, message, type = 'success') {
        const statusEl = document.getElementById(elementId);
        const messageEl = statusEl.querySelector('div');

        statusEl.classList.remove('hidden');
        messageEl.textContent = message;
        messageEl.className = `text-xs p-2 rounded ${type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`;

        setTimeout(() => {
            statusEl.classList.add('hidden');
        }, 5000);
    }

    // Load existing data from database
    async function loadExistingData() {
        try {
            const response = await fetch('/api/existing-data');
            if (response.ok) {
                const data = await response.json();
                existingMahasiswa = data.mahasiswa || [];
                existingDosen = data.dosen || [];
                existingJurusan = data.jurusan || [];
            }
        } catch (error) {
            console.log('Could not load existing data:', error);
        }
    }

    // Validate mahasiswa row
    function validateMahasiswaRow(row, index, allRows) {
        const errors = [];

        // Check if row has enough columns
        if (!row || row.length < 5) {
            errors.push('Data tidak lengkap');
            return { hasError: true, errors };
        }

        const nama = row[0] ? row[0].trim() : '';
        const npm = row[1] ? row[1].trim() : '';
        const email = row[2] ? row[2].trim() : '';
        const angkatan = row[3] ? row[3].trim() : '';
        const nip_dosenwali = row[4] ? row[4].trim() : '';

        // Check required fields
        if (!nama || !npm || !email) {
            errors.push('Nama, NPM, dan Email wajib diisi');
        }

        if (npm) {
            if (npm.length !== 13) {
                errors.push('NPM harus 13 karakter');
            }
            if (!/^\d+$/.test(npm)) {
                errors.push('NPM harus berupa angka');
            }
        }

        // Check if mahasiswa already exists in database
        const existingMhs = existingMahasiswa.find(m => m.npm === npm);
        if (existingMhs) {
            errors.push('NPM sudah ada di database');
        }

        // Check duplicate email in database
        const existingEmail = existingMahasiswa.find(m => m.email === email);
        if (existingEmail) {
            errors.push('Email sudah ada di database');
        }

        // Check duplicate within uploaded data
        const duplicateNpm = allRows.find((other, otherIndex) =>
            otherIndex !== index && other[1] && other[1].trim() === npm
        );
        if (duplicateNpm) {
            errors.push('NPM duplikat dalam file');
        }

        const duplicateEmail = allRows.find((other, otherIndex) =>
            otherIndex !== index && other[2] && other[2].trim() === email
        );
        if (duplicateEmail) {
            errors.push('Email duplikat dalam file');
        }

        // Check if NIP dosen exists (if provided)
        if (nip_dosenwali && nip_dosenwali !== '') {
            const dosenExists = existingDosen.find(d => d.nip === nip_dosenwali);
            if (!dosenExists) {
                errors.push(`Dosen NIP ${nip_dosenwali} tidak ada`);
            }
        }

        return {
            hasError: errors.length > 0,
            errors: errors
        };
    }

    // Validate dosen row
    function validateDosenRow(row, index, allRows) {
        const errors = [];

        // Check if row has enough columns
        if (!row || row.length < 6) {
            errors.push('Data tidak lengkap');
            return { hasError: true, errors };
        }

        const nama = row[0] ? row[0].trim() : '';
        const nip = row[1] ? row[1].trim() : '';
        const email = row[2] ? row[2].trim() : '';
        const jabatan = row[3] ? row[3].trim() : '';
        const bidang = row[4] ? row[4].trim() : '';
        const jurusan = row[5] ? row[5].trim() : '';

        // Check required fields
        if (!nama || !nip) {
            errors.push('Nama dan NIP wajib diisi');
        }

        // Validate NIP format (must be exactly 17 characters and numeric)
        if (nip) {
            if (nip.length !== 18) {
                errors.push('NIP harus 18 karakter');
            }
            if (!/^\d+$/.test(nip)) {
                errors.push('NIP harus berupa angka');
            }
        }

        // Check if dosen already exists in database
        const existingDsn = existingDosen.find(d => d.nip === nip);
        if (existingDsn) {
            errors.push('NIP sudah ada di database');
        }

        // Check duplicate within uploaded data
        const duplicateNip = allRows.find((other, otherIndex) =>
            otherIndex !== index && other[1] && other[1].trim() === nip
        );
        if (duplicateNip) {
            errors.push('NIP duplikat dalam file');
        }

        // Check if jurusan exists (if provided)
        if (jurusan && jurusan !== '') {
            const jurusanExists = existingJurusan.find(j =>
                j.nama_jurusan.toLowerCase().includes(jurusan.toLowerCase())
            );
            if (!jurusanExists) {
                errors.push(`Jurusan '${jurusan}' tidak ditemukan`);
            }
        }

        return {
            hasError: errors.length > 0,
            errors: errors
        };
    }

    // CSV upload for Mahasiswa
    document.getElementById('csvMahasiswa').addEventListener('change', async function (e) {
        const file = e.target.files[0];
        if (!file) {
            mahasiswaData = [];
            renderMahasiswaTable();
            document.getElementById('saveMahasiswa').disabled = true;
            return;
        }

        // Load existing data first
        await loadExistingData();

        const reader = new FileReader();
        reader.onload = function (event) {
            try {
                const rows = event.target.result.trim().split('\n').map(row => row.split(','));

                // Validasi header
                const header = rows[0].map(h => h.trim().toLowerCase());
                const expectedHeader = ['nama', 'npm', 'email', 'angkatan', 'nip_dosenwali'];
                const isValidHeader = expectedHeader.every((h, i) => h === header[i]);

                if (!isValidHeader) {
                    showAlert(
                        "Format header CSV Mahasiswa tidak sesuai. Harus: " + expectedHeader.join(', '),
                        'error',
                        'Format Header Salah'
                    );
                    e.target.value = '';
                    return;
                }

                const dataRows = rows.slice(1).filter(row => row.some(cell => cell && cell.trim() !== ''));

                mahasiswaData = dataRows.map((row, index) => {
                    const validation = validateMahasiswaRow(row, index, dataRows);

                    return {
                        no: index + 1,
                        nama: row[0] ? row[0].trim() : '',
                        npm: row[1] ? row[1].trim() : '',
                        email: row[2] ? row[2].trim() : '',
                        angkatan: row[3] ? row[3].trim() : '',
                        nip_dosenwali: row[4] ? row[4].trim() : '',
                        hasError: validation.hasError,
                        errors: validation.errors
                    };
                });

                renderMahasiswaTable();

                const validData = mahasiswaData.filter(m => !m.hasError);
                document.getElementById('saveMahasiswa').disabled = validData.length === 0;
            } catch (error) {
                showAlert('Error membaca file: ' + error.message, 'error');
            }
        };
        reader.readAsText(file);
    });

    function renderMahasiswaTable() {
        const keyword = document.getElementById('searchMahasiswa').value.toLowerCase();
        const table = document.getElementById('mahasiswaTable');
        const countEl = document.getElementById('countMahasiswa');
        const errorCountEl = document.getElementById('errorCountMahasiswa');

        if (mahasiswaData.length === 0) {
            table.innerHTML = `
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                        Silakan upload file CSV untuk melihat preview data
                    </td>
                </tr>
            `;
            countEl.textContent = '0 data';
            errorCountEl.classList.add('hidden');
            return;
        }

        const filteredData = mahasiswaData.filter(m =>
            Object.values(m).some(v => v && v.toString().toLowerCase().includes(keyword))
        );

        const errorCount = filteredData.filter(m => m.hasError).length;

        table.innerHTML = filteredData.map((m, index) => {
            const rowClass = m.hasError ? 'bg-red-50 border-red-200 text-red-700' : 'bg-white border-gray-200 hover:bg-gray-50';
            const statusText = m.hasError ? m.errors.join(', ') : 'Valid';
            const statusClass = m.hasError ? 'text-red-600 text-xs font-medium' : 'text-green-600 text-xs font-medium';

            return `
                <tr class="${rowClass} border-b">
                    <td class="px-4 py-2">${index + 1}</td>
                    <td class="px-4 py-2">${m.nama}</td>
                    <td class="px-4 py-2">${m.npm}</td>
                    <td class="px-4 py-2">${m.email}</td>
                    <td class="px-4 py-2">${m.angkatan}</td>
                    <td class="px-4 py-2">${m.nip_dosenwali}</td>
                    <td class="px-4 py-2 ${statusClass}">${statusText}</td>
                </tr>
            `;
        }).join('');

        countEl.textContent = `${filteredData.length} dari ${mahasiswaData.length} data`;

        if (errorCount > 0) {
            errorCountEl.textContent = `${errorCount} error`;
            errorCountEl.classList.remove('hidden');
        } else {
            errorCountEl.classList.add('hidden');
        }
    }

    document.getElementById('searchMahasiswa').addEventListener('keyup', renderMahasiswaTable);

    // CSV upload for Dosen
    document.getElementById('csvDosen').addEventListener('change', async function (e) {
        const file = e.target.files[0];
        if (!file) {
            dosenData = [];
            renderDosenTable();
            document.getElementById('saveDosenBtn').disabled = true;
            return;
        }

        // Load existing data first
        await loadExistingData();

        const reader = new FileReader();
        reader.onload = function (event) {
            try {
                const rows = event.target.result.trim().split('\n').map(row => row.split(','));

                // Validasi header
                const header = rows[0].map(h => h.trim().toLowerCase());
                const expectedHeader = ['nama', 'nip', 'email', 'jabatan', 'bidang', 'jurusan'];
                const isValidHeader = expectedHeader.every((h, i) => h === header[i]);

                if (!isValidHeader) {
                    showAlert(
                        "Format header CSV Dosen tidak sesuai. Harus: " + expectedHeader.join(', '),
                        'error',
                        'Format Header Salah'
                    );
                    e.target.value = '';
                    return;
                }

                const dataRows = rows.slice(1).filter(row => row.some(cell => cell && cell.trim() !== ''));

                dosenData = dataRows.map((row, index) => {
                    const validation = validateDosenRow(row, index, dataRows);

                    // Find jurusan and fakultas for display
                    const jurusanName = row[5] ? row[5].trim() : '';
                    const jurusan = existingJurusan.find(j =>
                        j.nama_jurusan.toLowerCase().includes(jurusanName.toLowerCase())
                    );

                    const fakultasName = jurusan && jurusan.fakultas ? jurusan.fakultas.nama_fakultas : '';

                    return {
                        no: index + 1,
                        nama: row[0] ? row[0].trim() : '',
                        nip: row[1] ? row[1].trim() : '',
                        email: row[2] ? row[2].trim() : '',
                        jabatan: row[3] ? row[3].trim() : '',
                        bidang: row[4] ? row[4].trim() : '',
                        jurusan: jurusanName,
                        fakultas: fakultasName,
                        hasError: validation.hasError,
                        errors: validation.errors
                    };
                });

                renderDosenTable();

                const validData = dosenData.filter(d => !d.hasError);
                document.getElementById('saveDosenBtn').disabled = validData.length === 0;
            } catch (error) {
                showAlert('Error membaca file: ' + error.message, 'error');
            }
        };
        reader.readAsText(file);
    });

    function renderDosenTable() {
        const keyword = document.getElementById('searchDosen').value.toLowerCase();
        const table = document.getElementById('dosenTable');
        const countEl = document.getElementById('countDosen');
        const errorCountEl = document.getElementById('errorCountDosen');

        if (dosenData.length === 0) {
            table.innerHTML = `
                <tr>
                    <td colspan="9" class="px-4 py-8 text-center text-gray-400">
                        Silakan upload file CSV untuk melihat preview data
                    </td>
                </tr>
            `;
            countEl.textContent = '0 data';
            errorCountEl.classList.add('hidden');
            return;
        }

        const filteredData = dosenData.filter(d =>
            Object.values(d).some(v => v && v.toString().toLowerCase().includes(keyword))
        );

        const errorCount = filteredData.filter(d => d.hasError).length;

        table.innerHTML = filteredData.map((d, index) => {
            const rowClass = d.hasError ? 'bg-red-50 border-red-200 text-red-700' : 'bg-white border-gray-200 hover:bg-gray-50';
            const statusText = d.hasError ? d.errors.join(', ') : 'Valid';
            const statusClass = d.hasError ? 'text-red-600 text-xs font-medium' : 'text-green-600 text-xs font-medium';

            return `
                <tr class="${rowClass} border-b">
                    <td class="px-4 py-2">${index + 1}</td>
                    <td class="px-4 py-2">${d.nama}</td>
                    <td class="px-4 py-2">${d.nip}</td>
                    <td class="px-4 py-2">${d.email}</td>
                    <td class="px-4 py-2">${d.jabatan}</td>
                    <td class="px-4 py-2">${d.bidang}</td>
                    <td class="px-4 py-2">${d.jurusan}</td>
                    <td class="px-4 py-2">${d.fakultas}</td>
                    <td class="px-4 py-2 ${statusClass}">${statusText}</td>
                </tr>
            `;
        }).join('');

        countEl.textContent = `${filteredData.length} dari ${dosenData.length} data`;

        if (errorCount > 0) {
            errorCountEl.textContent = `${errorCount} error`;
            errorCountEl.classList.remove('hidden');
        } else {
            errorCountEl.classList.add('hidden');
        }
    }

    document.getElementById('searchDosen').addEventListener('keyup', renderDosenTable);

    // Save Mahasiswa
    document.getElementById('saveMahasiswa').addEventListener('click', async function () {
        const file = document.getElementById('csvMahasiswa').files[0];
        if (!file) {
            showAlert("Pilih file terlebih dahulu.", 'warning');
            return;
        }

        const loadingEl = document.getElementById('loadingMahasiswa');
        const saveBtn = this;

        loadingEl.classList.remove('hidden');
        saveBtn.disabled = true;

        const formData = new FormData();
        formData.append('csv', file);

        try {
            const response = await fetch("{{ route('admin.upload.mahasiswa') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const data = await response.json();

            loadingEl.classList.add('hidden');
            saveBtn.disabled = false;

            if (data.success) {
                showStatus('statusMahasiswa', data.message, 'success');
                if (data.errors && data.errors.length > 0) {
                    console.log('Errors:', data.errors);
                }
                loadExistingData();
            } else {
                showStatus('statusMahasiswa', data.message, 'error');
            }
        } catch (error) {
            loadingEl.classList.add('hidden');
            saveBtn.disabled = false;
            showStatus('statusMahasiswa', 'Terjadi kesalahan saat upload', 'error');
            console.error(error);
        }
    });

    // Save Dosen
    document.getElementById('saveDosenBtn').addEventListener('click', async function () {
        const file = document.getElementById('csvDosen').files[0];
        if (!file) {
            showAlert("Pilih file terlebih dahulu.", 'warning');
            return;
        }

        const loadingEl = document.getElementById('loadingDosen');
        const saveBtn = this;

        loadingEl.classList.remove('hidden');
        saveBtn.disabled = true;

        const formData = new FormData();
        formData.append('csv', file);

        try {
            const response = await fetch("{{ route('admin.upload.dosen') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const data = await response.json();

            loadingEl.classList.add('hidden');
            saveBtn.disabled = false;

            if (data.success) {
                showStatus('statusDosen', data.message, 'success');
                if (data.errors && data.errors.length > 0) {
                    console.log('Errors:', data.errors);
                }
                loadExistingData();
            } else {
                showStatus('statusDosen', data.message, 'error');
            }
        } catch (error) {
            loadingEl.classList.add('hidden');
            saveBtn.disabled = false;
            showStatus('statusDosen', 'Terjadi kesalahan saat upload', 'error');
            console.error(error);
        }
    });

    // Load existing data on page load
    loadExistingData();
</script>

@endsection
