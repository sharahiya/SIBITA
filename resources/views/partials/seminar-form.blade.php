<div class="space-y-4">
    <h3 class="text-sm font-medium text-gray-800 mb-4">{{ $title }}</h3>

    @if($seminar)
        <!-- Display existing data -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
            <h4 class="text-sm font-semibold text-blue-800 mb-3">Data {{ $title }} Tersimpan</h4>
            <div class="grid grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-gray-600">Tanggal:</span>
                    <span class="text-gray-800 font-medium">{{ $seminar->tanggal_seminar ? \Carbon\Carbon::parse($seminar->tanggal_seminar)->format('d F Y') : '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Waktu:</span>
                    <span class="text-gray-800 font-medium">{{ $seminar->waktu_seminar ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Tempat:</span>
                    <span class="text-gray-800 font-medium">{{ $seminar->tempat_seminar ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Nilai:</span>
                    <span class="text-gray-800 font-medium">{{ $seminar->nilai ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Status:</span>
                    <span class="text-gray-800 font-medium">
                        @if($seminar->status === 'diterima')
                            <span class="text-green-600">Lulus</span>
                        @elseif($seminar->status === 'ditolak')
                            <span class="text-red-600">Tidak Lulus</span>
                        @else
                            {{ $seminar->status }}
                        @endif
                    </span>
                </div>
                @if($seminar->catatan)
                <div class="col-span-2">
                    <span class="text-gray-600">Catatan:</span>
                    <span class="text-gray-800">{{ $seminar->catatan }}</span>
                </div>
                @endif
            </div>
            <button type="button" onclick="showEditForm('{{ $jenis }}')" class="mt-3 bg-blue-600 text-white px-3 py-1 text-xs rounded hover:bg-blue-700">
                Edit Data
            </button>
        </div>
    @endif

    <!-- Form input/edit -->
    <form id="form-{{ $jenis }}" method="POST" action="{{ route('seminar.grades.update', $mahasiswaId) }}"
          class="space-y-4 {{ $seminar ? 'hidden' : '' }}">
        @csrf
        <input type="hidden" name="jenis_seminar" value="{{ $jenis }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal {{ $title }}</label>
                <input type="date" name="tanggal_seminar"
                       value="{{ $seminar->tanggal_seminar ?? '' }}"
                       class="w-full p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Waktu</label>
                <input type="time" name="waktu_seminar"
                       value="{{ $seminar->waktu_seminar ?? '' }}"
                       class="w-full p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Tempat</label>
                <input type="text" name="tempat_seminar"
                       value="{{ $seminar->tempat_seminar ?? '' }}"
                       placeholder="Ruang/Lokasi seminar"
                       class="w-full p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Nilai</label>
                <input type="number" name="nilai" min="0" max="100" step="0.1"
                       value="{{ $seminar->nilai ?? '' }}"
                       placeholder="0-100"
                       class="w-full p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Status</option>
                    <option value="lulus" {{ ($seminar && $seminar->status === 'diterima') ? 'selected' : '' }}>Lulus</option>
                    <option value="tidak_lulus" {{ ($seminar && $seminar->status === 'ditolak') ? 'selected' : '' }}>Tidak Lulus</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                <textarea name="catatan" rows="3"
                          placeholder="Catatan atau komentar..."
                          class="w-full p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500">{{ $seminar->catatan ?? '' }}</textarea>
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 text-xs rounded-lg hover:bg-green-700">
                {{ $seminar ? 'Update' : 'Simpan' }} Data {{ $title }}
            </button>

            @if($seminar)
            <button type="button" onclick="cancelEdit('{{ $jenis }}')"
                    class="bg-gray-500 text-white px-4 py-2 text-xs rounded-lg hover:bg-gray-600">
                Batal
            </button>
            @endif
        </div>
    </form>
</div>

<script>
function showEditForm(jenis) {
    document.getElementById(`form-${jenis}`).classList.remove('hidden');
    document.querySelector(`#form-${jenis}`).previousElementSibling.classList.add('hidden');
}

function cancelEdit(jenis) {
    document.getElementById(`form-${jenis}`).classList.add('hidden');
    document.querySelector(`#form-${jenis}`).previousElementSibling.classList.remove('hidden');
}
</script>
