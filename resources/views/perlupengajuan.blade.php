@extends('layouts.layoutmhs')

@section('content')
<div class="container text-center py-5">
    <h2>Pengajuan Diperlukan</h2>
    <p class="mt-3">Anda harus mengajukan dosen pembimbing terlebih dahulu sebelum mengakses fitur ini.</p>
    <a href="{{ route('pengajuan') }}" class="btn btn-primary mt-4 text-blue">Ajukan Sekarang</a>
</div>
@endsection
