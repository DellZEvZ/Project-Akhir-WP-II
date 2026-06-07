@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Data Layanan</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item active">Layanan</li>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6"><h5 class="card-title">Daftar Layanan Barbershop</h5></div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('backend.layanan.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Tambah Layanan
                        </a>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-5">
                        <input type="text" id="searchBox" class="form-control" placeholder="Cari nama layanan...">
                    </div>
                    <div class="col-md-3">
                        <select id="filterStatus" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="resetFilter" class="btn btn-secondary btn-block"><i class="mdi mdi-refresh"></i> Reset</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="layananTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Layanan</th>
                                <th>Harga</th>
                                <th>Durasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($layanans as $index => $item)
                            <tr>
                                <td>{{ $layanans->firstItem() + $index }}</td>
                                <td>
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/img-layanan/' . $item->foto) }}"
                                             alt="{{ $item->nama_layanan }}" class="rounded"
                                             width="50" height="50" style="object-fit:cover;">
                                    @else
                                        <span class="badge badge-light p-2"><i class="mdi mdi-content-cut" style="font-size:20px;"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $item->nama_layanan }}</strong>
                                    @if ($item->deskripsi)
                                        <br><small class="text-muted">{{ Str::limit($item->deskripsi, 60) }}</small>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>{{ $item->durasi_menit }} menit</td>
                                <td>
                                    @if ($item->status === 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('backend.layanan.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail"><i class="mdi mdi-eye"></i></a>
                                    <a href="{{ route('backend.layanan.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="mdi mdi-pencil"></i></a>
                                    <form action="{{ route('backend.layanan.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger show_confirm"
                                                data-konf-delete="{{ $item->nama_layanan }}">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="mdi mdi-content-cut" style="font-size:48px; color:#ccc;"></i>
                                    <p class="mt-2 text-muted">Belum ada data layanan</p>
                                    <a href="{{ route('backend.layanan.create') }}" class="btn btn-primary btn-sm">Tambah Layanan</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $layanans->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    var table = $('#layananTable').DataTable({
        paging: false, searching: true, ordering: true, info: false, autoWidth: false, responsive: true,
        language: { url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json" }
    });
    $('#searchBox').on('keyup', function () { table.search(this.value).draw(); });
    $('#filterStatus').on('change', function () { table.column(5).search(this.value, false, false).draw(); });
    $('#resetFilter').on('click', function () { $('#searchBox').val(''); $('#filterStatus').val(''); table.search('').columns().search('').draw(); });

    $(document).on('click', '.show_confirm', function (e) {
        e.preventDefault();
        var nama = $(this).data('konf-delete');
        var form = $(this).closest('form');
        Swal.fire({ title: 'Hapus Layanan?', text: '"' + nama + '" akan dihapus!', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
        }).then(function (r) { if (r.isConfirmed) form.submit(); });
    });
});
</script>
@endpush
