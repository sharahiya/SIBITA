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
                    alert("Format header CSV Mahasiswa tidak sesuai. Harus: " + expectedHeader.join(', '));
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
                alert('Error membaca file: ' + error.message);
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
                    alert("Format header CSV Dosen tidak sesuai. Harus: " + expectedHeader.join(', '));
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
                alert('Error membaca file: ' + error.message);
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
    document.getElementById('saveMahasiswa').addEventListener('click', function () {
        const file = document.getElementById('csvMahasiswa').files[0];
        if (!file) return alert("Pilih file terlebih dahulu.");

        const loadingEl = document.getElementById('loadingMahasiswa');
        const saveBtn = this;

        loadingEl.classList.remove('hidden');
        saveBtn.disabled = true;

        const formData = new FormData();
        formData.append('csv', file);

        fetch("{{ route('admin.upload.mahasiswa') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
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
        })
        .catch(err => {
            loadingEl.classList.add('hidden');
            saveBtn.disabled = false;
            showStatus('statusMahasiswa', 'Terjadi kesalahan saat upload', 'error');
            console.error(err);
        });
    });

    // Save Dosen
    document.getElementById('saveDosenBtn').addEventListener('click', function () {
        const file = document.getElementById('csvDosen').files[0];
        if (!file) return alert("Pilih file terlebih dahulu.");

        const loadingEl = document.getElementById('loadingDosen');
        const saveBtn = this;

        loadingEl.classList.remove('hidden');
        saveBtn.disabled = true;

        const formData = new FormData();
        formData.append('csv', file);

        fetch("{{ route('admin.upload.dosen') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
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
        })
        .catch(err => {
            loadingEl.classList.add('hidden');
            saveBtn.disabled = false;
            showStatus('statusDosen', 'Terjadi kesalahan saat upload', 'error');
            console.error(err);
        });
    });

    // Load existing data on page load
    loadExistingData();
</script>

@endsection
