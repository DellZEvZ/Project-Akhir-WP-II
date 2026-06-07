@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Detail Barber</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('backend.barber.index') }}">Barber</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    @if ($barber->foto)
                        <img src="{{ asset('storage/img-barber/' . $barber->foto) }}"
                             alt="{{ $barber->nama }}" class="rounded-circle mr-3"
                             width="80" height="80" style="object-fit:cover;">
                    @else
                        <img src="{{ asset('storage/img-user/img-default.jpg') }}"
                             alt="{{ $barber->nama }}" class="rounded-circle mr-3"
                             width="80" height="80" style="object-fit:cover;">
                    @endif
                    <div>
                        <h4 class="mb-0">{{ $barber->nama }}</h4>
                        <p class="text-muted mb-0">{{ $barber->spesialisasi }}</p>
                        @if ($barber->status === 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr><th width="35%">Nama</th><td>{{ $barber->nama }}</td></tr>
                    <tr><th>Spesialisasi</th><td>{{ $barber->spesialisasi }}</td></tr>
                    <tr><th>Pengalaman</th><td>{{ $barber->pengalaman_tahun }} tahun</td></tr>
                    <tr><th>Nomor HP</th><td>{{ $barber->no_hp ?? '-' }}</td></tr>
                    <tr><th>Status</th>
                        <td>
                            @if ($barber->status === 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Ditambahkan</th><td>{{ $barber->created_at->format('d/m/Y H:i') }}</td></tr>
                </table>

                <a href="{{ route('backend.barber.edit', $barber->id) }}" class="btn btn-warning">
                    <i class="mdi mdi-pencil"></i> Edit
                </a>
                <a href="{{ route('backend.barber.index') }}" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
