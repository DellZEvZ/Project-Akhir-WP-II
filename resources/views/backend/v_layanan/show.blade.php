@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Detail Layanan</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('backend.layanan.index') }}">Layanan</a></li>
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
                @if ($layanan->foto)
                    <img src="{{ asset('storage/img-layanan/' . $layanan->foto) }}"
                         alt="{{ $layanan->nama_layanan }}" class="img-fluid rounded mb-3"
                         style="max-height:250px; object-fit:cover; width:100%;">
                @endif

                <h4>{{ $layanan->nama_layanan }}</h4>
                <p class="text-muted">{{ $layanan->deskripsi ?? '-' }}</p>

                <table class="table table-bordered mt-3">
                    <tr><th width="35%">Harga</th><td><strong class="text-success">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</strong></td></tr>
                    <tr><th>Durasi</th><td>{{ $layanan->durasi_menit }} menit</td></tr>
                    <tr><th>Status</th>
                        <td>
                            @if ($layanan->status === 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Ditambahkan</th><td>{{ $layanan->created_at->format('d/m/Y H:i') }}</td></tr>
                </table>

                <a href="{{ route('backend.layanan.edit', $layanan->id) }}" class="btn btn-warning"><i class="mdi mdi-pencil"></i> Edit</a>
                <a href="{{ route('backend.layanan.index') }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
