@extends('layouts.layoutmhs')

@section('content')
<div class="min-h-screen  flex items-center justify-center px-4">
    <div class="max-w-4xl w-full">
        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-12 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-white bg-opacity-20 rounded-full mb-6">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-4">Persyaratan Belum Terpenuhi</h1>
                <p class="text-blue-100 text-lg">Anda perlu melengkapi persyaratan berikut sebelum dapat mengakses fitur ini</p>
            </div>

            <!-- Content -->
            <div class="px-8 py-12">
                <!-- Requirements Checklist -->
                <div class="space-y-6 mb-12">
                    <h2 class="text-2xl font-semibold text-gray-800 text-center mb-8">
                        📋 Daftar Persyaratan
                    </h2>

                    <!-- Requirement 1: Dosen Pembimbing -->
                    <div class="flex items-start space-x-4 p-6 bg-red-50 border border-red-200 rounded-xl">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-red-800 mb-2">
                                👨‍🏫 Dosen Pembimbing (2 Orang)
                            </h3>
                            <p class="text-red-700 mb-3">
                                Anda harus memiliki <strong>2 dosen pembimbing</strong> yang telah <strong>menyetujui</strong> pengajuan bimbingan Anda.
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-red-600">
                                    <span class="w-2 h-2 bg-red-400 rounded-full mr-3"></span>
                                    Dosen Pembimbing 1 (Wajib)
                                </div>
                                <div class="flex items-center text-sm text-red-600">
                                    <span class="w-2 h-2 bg-red-400 rounded-full mr-3"></span>
                                    Dosen Pembimbing 2 (Wajib)
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Requirement 2: Dosen Penguji -->
                    <div class="flex items-start space-x-4 p-6 bg-orange-50 border border-orange-200 rounded-xl">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-orange-800 mb-2">
                                👩‍⚖️ Dosen Penguji (Minimal 2 Orang)
                            </h3>
                            <p class="text-orange-700 mb-3">
                                Anda harus memiliki <strong>minimal 2 dosen penguji</strong> yang telah ditetapkan oleh admin untuk ujian/seminar.
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-orange-600">
                                    <span class="w-2 h-2 bg-orange-400 rounded-full mr-3"></span>
                                    Dosen Penguji 1 (Wajib)
                                </div>
                                <div class="flex items-center text-sm text-orange-600">
                                    <span class="w-2 h-2 bg-orange-400 rounded-full mr-3"></span>
                                    Dosen Penguji 2 (Wajib)
                                </div>
                                <div class="flex items-center text-sm text-orange-600">
                                    <span class="w-2 h-2 bg-orange-300 rounded-full mr-3"></span>
                                    Dosen Penguji 3 (Opsional)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Process Steps -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-800 text-center mb-8">
                        🚀 Langkah-langkah yang Harus Dilakukan
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Step 1 -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                    1
                                </div>
                                <h3 class="text-lg font-semibold text-blue-800">Ajukan Dosen Pembimbing</h3>
                            </div>
                            <p class="text-blue-700 mb-4">
                                Ajukan permohonan bimbingan kepada 2 dosen pembimbing dan tunggu persetujuan mereka.
                            </p>
                            <a href="{{ route('pengajuan') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Ajukan Sekarang
                            </a>
                        </div>

                        <!-- Step 2 -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                    2
                                </div>
                                <h3 class="text-lg font-semibold text-purple-800">Tunggu Penetapan Penguji</h3>
                            </div>
                            <p class="text-purple-700 mb-4">
                                Setelah pembimbing disetujui, admin akan menetapkan dosen penguji untuk ujian/seminar Anda.
                            </p>
                            <span class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 rounded-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Menunggu Admin
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Current Status -->
                <div class="text-center p-6 bg-gray-50 rounded-xl border border-gray-200">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Status Saat Ini</h3>
                    <p class="text-gray-600 mb-6">
                        Anda belum memenuhi semua persyaratan untuk mengakses fitur ini. Silakan lengkapi persyaratan di atas terlebih dahulu.
                    </p>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('pengajuan') }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Mulai Pengajuan
                        </a>

                        <a href="{{ route('pengajuan2') }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Cek Status Pengajuan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 text-sm">
                💡 <strong>Tips:</strong> Hubungi admin jika Anda mengalami kesulitan dalam proses pengajuan atau memiliki pertanyaan lebih lanjut.
            </p>
        </div>
    </div>
</div>

<style>
/* Custom animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.container > div {
    animation: fadeInUp 0.6s ease-out;
}

/* Hover effects */
.hover-lift:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease-in-out;
}

/* Responsive improvements */
@media (max-width: 640px) {
    .bg-gradient-to-r {
        padding: 2rem 1rem;
    }

    .px-8 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
@endsection
