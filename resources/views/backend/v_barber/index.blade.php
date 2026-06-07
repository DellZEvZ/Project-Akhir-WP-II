@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Data Barber</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item active">Barber</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5 class="card-title">Daftar Barber</h5>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('backend.barber.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-account-plus"></i> Tambah Barber
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-5">
                        <input type="text" id="searchBox" class="form-control" placeholder="Cari nama, spesialisasi, no hp...">
                    </div>
                    <div class="col-md-3">
                        <select id="filterStatus" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="resetFilter" class="btn btn-secondary btn-block">
                            <i class="mdi mdi-refresh"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="barberTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Foto</th>
                                <th width="22%">Nama</th>
                                <th width="25%">Spesialisasi</th>
                                <th width="12%">Pengalaman</th>
                                <th width="10%">Status</th>
                                <th width="11%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barbers as $index => $item)
                            <tr>
                                <td>{{ $barbers->firstItem() + $index }}</td>
                                <td>
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/img-barber/' . $item->foto) }}"
                                             alt="{{ $item->nama }}"
                                             class="rounded-circle"
                                             width="45" height="45" style="object-fit:cover;">
                                    @else
                                        <img src="{{ asset('storage/img-user/img-default.jpg') }}"
                                             alt="{{ $item->nama }}"
                                             class="rounded-circle"
                                             width="45" height="45" style="object-fit:cover;">
                                    @endif
                                </td>
                                <td><strong>{{ $item->nama }}</strong><br><small class="text-muted">{{ $item->no_hp }}</small></td>
                                <td>{{ $item->spesialisasi }}</td>
                                <td>{{ $item->pengalaman_tahun }} tahun</td>
                                <td>
                                    @if ($item->status === 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('backend.barber.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('backend.barber.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('backend.barber.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger show_confirm"
                                                data-konf-delete="{{ $item->nama }}" title="Hapus">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="mdi mdi-content-cut" style="font-size:48px; color:#ccc;"></i>
                                    <p class="mt-2 text-muted">Belum ada data barber</p>
                                    <a href="{{ route('backend.barber.create') }}" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-account-plus"></i> Tambah Barber Pertama
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $barbers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    var table = $('#barberTable').DataTable({
        paging: false, searching: true, ordering: true, info: false, autoWidth: false, responsive: true,
        language: { url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json" }
    });

    $('#searchBox').on('keyup', function () { table.search(this.value).draw(); });
    $('#filterStatus').on('change', function () {
        table.column(5).search(this.value ? this.value : '', false, false).draw();
    });
    $('#resetFilter').on('click', function () {
        $('#searchBox').val(''); $('#filterStatus').val('');
        table.search('').columns().search('').draw();
    });

    // Konfirmasi hapus
    $(document).on('click', '.show_confirm', function (e) {
        e.preventDefault();
        var nama = $(this).data('konf-delete');
        var form = $(this).closest('form');
        Swal.fire({
            title: 'Hapus Barber?',
            text: 'Data "' + nama + '" akan dihapus permanen!',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
        }).then(function (result) { if (result.isConfirmed) form.submit(); });
    });
});
</script>
@endpush
