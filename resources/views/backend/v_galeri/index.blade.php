@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Galeri Foto</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item active">Galeri</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="mdi mdi-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<div class="row mb-3">
    <div class="col-md-6">
        <h5 class="m-0">Total: {{ $galeris->total() }} foto</h5>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('backend.galeri.create') }}" class="btn btn-primary">
            <i class="mdi mdi-camera-plus"></i> Upload Foto
        </a>
    </div>
</div>

<!-- Filter Tipe -->
<div class="mb-3">
    <a href="{{ route('backend.galeri.index') }}" class="btn btn-sm {{ !request('tipe') ? 'btn-dark' : 'btn-outline-dark' }}">Semua</a>
    <a href="{{ route('backend.galeri.index', ['tipe' => 'haircut']) }}" class="btn btn-sm {{ request('tipe') == 'haircut' ? 'btn-dark' : 'btn-outline-dark' }}">Haircut</a>
    <a href="{{ route('backend.galeri.index', ['tipe' => 'hairstyle']) }}" class="btn btn-sm {{ request('tipe') == 'hairstyle' ? 'btn-dark' : 'btn-outline-dark' }}">Hairstyle</a>
    <a href="{{ route('backend.galeri.index', ['tipe' => 'beard']) }}" class="btn btn-sm {{ request('tipe') == 'beard' ? 'btn-dark' : 'btn-outline-dark' }}">Beard</a>
</div>

<div class="row">
    @forelse ($galeris as $item)
    <div class="col-md-3 col-sm-4 col-6 mb-4">
        <div class="card h-100">
            <img src="{{ asset('storage/img-galeri/' . $item->foto) }}"
                 alt="{{ $item->judul }}"
                 class="card-img-top"
                 style="height:180px; object-fit:cover;">
            <div class="card-body p-2">
                <p class="card-title mb-1 font-weight-bold" style="font-size:13px;">{{ $item->judul }}</p>
                <span class="badge badge-{{ $item->tipe == 'haircut' ? 'primary' : ($item->tipe == 'hairstyle' ? 'info' : 'warning') }}">
                    {{ $item->tipe_label }}
                </span>
                @if ($item->keterangan)
                    <p class="card-text mt-1" style="font-size:11px; color:#888;">{{ Str::limit($item->keterangan, 50) }}</p>
                @endif
            </div>
            <div class="card-footer p-2 text-right">
                <form action="{{ route('backend.galeri.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger show_confirm"
                            data-konf-delete="{{ $item->judul }}" title="Hapus">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="mdi mdi-image-off" style="font-size:64px; color:#ccc;"></i>
        <p class="mt-3 text-muted">Belum ada foto di galeri</p>
        <a href="{{ route('backend.galeri.create') }}" class="btn btn-primary">
            <i class="mdi mdi-camera-plus"></i> Upload Foto Pertama
        </a>
    </div>
    @endforelse
</div>

<div class="mt-2">{{ $galeris->links() }}</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.show_confirm', function (e) {
    e.preventDefault();
    var nama = $(this).data('konf-delete');
    var form = $(this).closest('form');
    Swal.fire({ title: 'Hapus Foto?', text: '"' + nama + '" akan dihapus permanen!', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
    }).then(function (r) { if (r.isConfirmed) form.submit(); });
});
</script>
@endpush
