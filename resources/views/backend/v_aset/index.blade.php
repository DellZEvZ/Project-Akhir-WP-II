@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Data Aset/Inventaris</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item">Inventaris</li>
            <li class="breadcrumb-item active" aria-current="page">Aset</li>
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
                        <h5 class="card-title">Daftar Aset/Inventaris</h5>
                    </div>
                    <div class="col-md-6 text-right">
                        @hasPermission('aset.create')
                        <a href="{{ route('backend.aset.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-package-variant-plus"></i> Tambah Aset
                        </a>
                        @endhasPermission
                    </div>
                </div>

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" id="searchBox" class="form-control" placeholder="Cari nama, kode, supplier, lokasi...">
                    </div>
                    <div class="col-md-3">
                        <select id="filterStatus" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                            <option value="dijual">Dijual</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filterKategori" class="form-control">
                            <option value="">Semua Kategori</option>
                            <option value="Alat Medis">Alat Medis</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Kendaraan">Kendaraan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button id="resetFilter" class="btn btn-secondary btn-block">
                            <i class="mdi mdi-refresh"></i> Reset Filter
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="asetTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="3%">No</th>
                                <th width="8%">Kode Aset</th>
                                <th width="15%">Nama Aset</th>
                                <th width="10%">Kategori</th>
                                <th width="8%">Status</th>
                                <th width="10%">Lokasi</th>
                                <th width="12%">Harga Perolehan</th>
                                <th width="12%">Nilai Saat Ini</th>
                                <th width="10%">Maintenance</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aset as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $item->kode_aset }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($item->foto_aset)
                                        <img src="{{ asset('storage/img-aset/' . $item->foto_aset) }}"
                                             alt="{{ $item->nama_aset }}"
                                             class="rounded mr-2"
                                             width="40" height="40"
                                             style="object-fit: cover;">
                                        @else
                                        <img src="{{ asset('storage/img-user/img-default.jpg') }}"
                                             alt="{{ $item->nama_aset }}"
                                             class="rounded mr-2"
                                             width="40" height="40"
                                             style="object-fit: cover;">
                                        @endif
                                        <span>{{ $item->nama_aset }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if ($item->kategori == 'Alat Medis')
                                        <span class="badge badge-pill badge-info">{{ $item->kategori }}</span>
                                    @elseif ($item->kategori == 'Furniture')
                                        <span class="badge badge-pill badge-warning">{{ $item->kategori }}</span>
                                    @elseif ($item->kategori == 'Elektronik')
                                        <span class="badge badge-pill badge-primary">{{ $item->kategori }}</span>
                                    @elseif ($item->kategori == 'Kendaraan')
                                        <span class="badge badge-pill badge-dark">{{ $item->kategori }}</span>
                                    @else
                                        <span class="badge badge-pill badge-secondary">{{ $item->kategori }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status_aset == 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @elseif ($item->status_aset == 'rusak')
                                        <span class="badge badge-warning">Rusak</span>
                                    @elseif ($item->status_aset == 'hilang')
                                        <span class="badge badge-danger">Hilang</span>
                                    @elseif ($item->status_aset == 'dijual')
                                        <span class="badge badge-secondary">Dijual</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="mdi mdi-map-marker text-primary"></i> {{ $item->lokasi ?? '-' }}
                                </td>
                                <td>
                                    <span class="text-success">Rp {{ number_format($item->harga_perolehan, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span class="text-info">Rp {{ number_format($item->nilai_saat_ini, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    @php
                                        $maintenanceStatus = 'ok';
                                        if ($item->next_maintenance) {
                                            $nextMaintenance = \Carbon\Carbon::parse($item->next_maintenance);
                                            $today = \Carbon\Carbon::now();

                                            if ($nextMaintenance->isPast()) {
                                                $maintenanceStatus = 'overdue';
                                            } elseif ($nextMaintenance->diffInDays($today) <= 7) {
                                                $maintenanceStatus = 'upcoming';
                                            }
                                        }
                                    @endphp

                                    @if ($maintenanceStatus == 'ok')
                                        <span class="badge badge-success">OK</span>
                                    @elseif ($maintenanceStatus == 'upcoming')
                                        <span class="badge badge-warning">Segera</span>
                                    @elseif ($maintenanceStatus == 'overdue')
                                        <span class="badge badge-danger">Lewat Jadwal</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('backend.aset.show', $item->id) }}"
                                       class="btn btn-sm btn-info"
                                       title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>

                                    @hasPermission('aset.update')
                                    <a href="{{ route('backend.aset.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    @endhasPermission

                                    @hasPermission('aset.delete')
                                    <form action="{{ route('backend.aset.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger show_confirm"
                                                data-konf-delete="{{ $item->nama_aset }}"
                                                title="Hapus">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                    @endhasPermission
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="mdi mdi-package-variant-closed" style="font-size: 48px;"></i>
                                        <p class="mt-3">Tidak ada data aset/inventaris</p>
                                        <a href="{{ route('backend.aset.create') }}" class="btn btn-primary btn-sm">
                                            <i class="mdi mdi-package-variant-plus"></i> Tambah Aset Pertama
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
        var table = $('#asetTable').DataTable({
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
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "order": [[1, 'asc']] // Order by kode_aset
        });

        // Custom search box
        $('#searchBox').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Filter by status
        $('#filterStatus').on('change', function() {
            var status = this.value;
            if (status === '') {
                table.column(4).search('').draw();
            } else {
                table.column(4).search(status, false, false).draw();
            }
        });

        // Filter by kategori
        $('#filterKategori').on('change', function() {
            var kategori = this.value;
            if (kategori === '') {
                table.column(3).search('').draw();
            } else {
                table.column(3).search(kategori, false, false).draw();
            }
        });

        // Reset filters
        $('#resetFilter').on('click', function() {
            $('#searchBox').val('');
            $('#filterStatus').val('');
            $('#filterKategori').val('');
            table.search('').columns().search('').draw();
        });
    });
</script>
@endpush
