@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Data Pegawai</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5 class="card-title">Daftar Pegawai</h5>
                    </div>
                    <div class="col-md-6 text-right">
                        @hasPermission('pegawai.create')
                        <a href="{{ route('backend.pegawai.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-account-plus"></i> Tambah Pegawai
                        </a>
                        @endhasPermission
                    </div>
                </div>

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="searchBox" class="form-control" placeholder="Cari nama, email, jabatan, no hp...">
                    </div>
                    <div class="col-md-3">
                        <select id="filterStatus" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="cuti">Cuti</option>
                            <option value="resign">Resign</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filterDepartemen" class="form-control">
                            <option value="">Semua Departemen</option>
                            <option value="Medis">Medis</option>
                            <option value="Administrasi">Administrasi</option>
                            <option value="Kepegawaian">Kepegawaian</option>
                            <option value="Farmasi">Farmasi</option>
                            <option value="IT">IT</option>
                            <option value="Keamanan">Keamanan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="resetFilter" class="btn btn-secondary btn-block">
                            <i class="mdi mdi-refresh"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="pegawaiTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nama</th>
                                <th width="18%">Email</th>
                                <th width="15%">Jabatan</th>
                                <th width="12%">Departemen</th>
                                <th width="10%">Status</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pegawai as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($item->foto)
                                        <img src="{{ asset('storage/img-pegawai/' . $item->foto) }}"
                                             alt="{{ $item->nama }}"
                                             class="rounded-circle mr-2"
                                             width="40" height="40">
                                        @else
                                        <img src="{{ asset('storage/img-user/img-default.jpg') }}"
                                             alt="{{ $item->nama }}"
                                             class="rounded-circle mr-2"
                                             width="40" height="40">
                                        @endif
                                        <span>{{ $item->nama }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->jabatan }}</td>
                                <td>{{ $item->departemen }}</td>
                                <td>
                                    @if ($item->status_pegawai == 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @elseif ($item->status_pegawai == 'cuti')
                                        <span class="badge badge-info">Cuti</span>
                                    @elseif ($item->status_pegawai == 'resign')
                                        <span class="badge badge-danger">Resign</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('backend.pegawai.show', $item->id) }}"
                                       class="btn btn-sm btn-info"
                                       title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>

                                    @hasPermission('pegawai.update')
                                    <a href="{{ route('backend.pegawai.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    @endhasPermission

                                    @hasPermission('pegawai.delete')
                                    <form action="{{ route('backend.pegawai.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger show_confirm"
                                                data-konf-delete="{{ $item->nama }}"
                                                title="Hapus">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                    @endhasPermission
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="mdi mdi-account-off" style="font-size: 48px;"></i>
                                        <p class="mt-3">Tidak ada data pegawai</p>
                                        <a href="{{ route('backend.pegawai.create') }}" class="btn btn-primary btn-sm">
                                            <i class="mdi mdi-account-plus"></i> Tambah Pegawai Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#pegawaiTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]]
        });

        // Custom search box
        $('#searchBox').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Filter by status
        $('#filterStatus').on('change', function() {
            var status = this.value;
            if (status === '') {
                table.column(5).search('').draw();
            } else {
                table.column(5).search(status, false, false).draw();
            }
        });

        // Filter by departemen
        $('#filterDepartemen').on('change', function() {
            var departemen = this.value;
            if (departemen === '') {
                table.column(4).search('').draw();
            } else {
                table.column(4).search(departemen, false, false).draw();
            }
        });

        // Reset filters
        $('#resetFilter').on('click', function() {
            $('#searchBox').val('');
            $('#filterStatus').val('');
            $('#filterDepartemen').val('');
            table.search('').columns().search('').draw();
        });
    });
</script>
@endpush
