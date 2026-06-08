@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Data User</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- contentAwal -->
<!-- ============================================================== -->
<style>
.gradient-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}
.badge-custom-admin {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
/* Tab styling */
.nav-tabs .nav-link {
    color: #667eea;
    font-weight: 500;
}
.nav-tabs .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white !important;
    border-color: transparent;
}
/* Permission cards */
#permissionsContainer .card {
    border-left: 4px solid #667eea;
}
#permissionsContainer .card-header {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
}
.custom-control-input:checked ~ .custom-control-label::before {
    background-color: #667eea;
    border-color: #667eea;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="gradient-header">
            <h4 class="mb-1"><i class="fas fa-users"></i> Manajemen User BARBERFLOW</h4>
            <p class="mb-0">Kelola user yang dapat mengakses sistem BARBERFLOW</p>
        </div>
    </div>
</div>

@if(session('success'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
@endif

{{-- Tab Navigation --}}
<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs mb-3" id="userTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab">
                    <i class="fas fa-users"></i> Manage Users
                </a>
            </li>
            @if(auth()->user()->hasRole('super-admin'))
            <li class="nav-item">
                <a class="nav-link" id="permissions-tab" data-toggle="tab" href="#permissions" role="tab">
                    <i class="fas fa-shield-alt"></i> Manage Role Permissions
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>

{{-- Tab Content --}}
<div class="tab-content" id="userTabsContent">
    {{-- Tab 1: Manage Users --}}
    <div class="tab-pane fade show active" id="users" role="tabpanel">
<div class="row">
    <div class="col-12">
        <div class="mb-3">
            <a href="{{ route('backend.user.create') }}">
                <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah User Baru</button>
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $judul ?? 'Data User' }}</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Email</th>
                                <th width="20%">Nama</th>
                                <th width="12%">No. HP</th>
                                <th width="13%">Role</th>
                                <th width="10%">Status</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($index ?? [] as $row)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <i class="fas fa-envelope text-muted mr-1"></i>
                                    {{ $row->email ?? '-' }}
                                </td>
                                <td>
                                    <i class="fas fa-user text-muted mr-1"></i>
                                    {{ $row->nama ?? '-' }}
                                </td>
                                <td>
                                    <i class="fas fa-phone text-muted mr-1"></i>
                                    {{ $row->hp ?? '-' }}
                                </td>
                                <td class="text-center">
                                    @if ($row->roles->isNotEmpty())
                                        @php
                                            $role = $row->roles->first();
                                        @endphp
                                        @if ($role->name == 'super-admin')
                                            <span class="badge badge-custom-admin"><i class="fas fa-crown"></i> {{ $role->display_name }}</span>
                                        @elseif($role->name == 'admin')
                                            <span class="badge badge-primary"><i class="fas fa-user-shield"></i> {{ $role->display_name }}</span>
                                        @elseif($role->name == 'staff-kepegawaian')
                                            <span class="badge badge-info"><i class="fas fa-users"></i> {{ $role->display_name }}</span>
                                        @elseif($role->name == 'staff-inventaris')
                                            <span class="badge badge-success"><i class="fas fa-boxes"></i> {{ $role->display_name }}</span>
                                        @elseif($role->name == 'viewer')
                                            <span class="badge badge-secondary"><i class="fas fa-eye"></i> {{ $role->display_name }}</span>
                                        @else
                                            <span class="badge badge-info"><i class="fas fa-user"></i> {{ $role->display_name }}</span>
                                        @endif
                                    @else
                                        <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Belum ada role</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (isset($row->status))
                                        @if ($row->status == 1)
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>
                                        @elseif($row->status == 0)
                                        <span class="badge badge-secondary"><i class="fas fa-times-circle"></i> NonAktif</span>
                                        @endif
                                    @else
                                        <span class="badge badge-secondary">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('backend.user.edit', $row->id) }}" title="Ubah Data">
                                        <button type="button" class="btn btn-info btn-sm">
                                            <i class="far fa-edit"></i> Edit
                                        </button>
                                    </a>

                                    <form method="POST" action="{{ route('backend.user.destroy', $row->id) }}"
                                          style="display: inline-block;"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $row->nama }}?');">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data user</p>
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
    </div>
    {{-- End Tab 1 --}}

    {{-- Tab 2: Manage Role Permissions --}}
    @if(auth()->user()->hasRole('super-admin'))
    <div class="tab-pane fade" id="permissions" role="tabpanel">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-shield-alt"></i> Manage Role Permissions
                        </h5>
                        <p class="text-muted">
                            Assign atau remove permissions untuk setiap role. Hanya Super Admin yang dapat mengakses fitur ini.
                        </p>

                        {{-- Role Selection --}}
                        <div class="form-group">
                            <label for="roleSelect">Pilih Role:</label>
                            <select id="roleSelect" class="form-control" style="max-width: 400px;">
                                <option value="">-- Pilih Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Loading State --}}
                        <div id="loadingPermissions" class="text-center py-5" style="display: none;">
                            <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
                            <p class="mt-3">Loading permissions...</p>
                        </div>

                        {{-- Permission Grid --}}
                        <div id="permissionGrid" style="display: none;">
                            <form id="permissionForm">
                                @csrf
                                <input type="hidden" id="selectedRoleId" name="role_id">

                                <div id="permissionsContainer"></div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary" id="savePermissions">
                                        <i class="fas fa-save"></i> Save Changes
                                    </button>
                                    <button type="button" class="btn btn-secondary" id="resetPermissions">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Empty State --}}
                        <div id="emptyState" class="text-center py-5">
                            <i class="fas fa-hand-pointer fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Pilih role untuk mengelola permissions-nya</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- End Tab 2 --}}
</div>
{{-- End Tab Content --}}
<!-- ============================================================== -->
<!-- contentAkhir -->
<!-- ============================================================== -->
@endsection

@push('scripts')
<script>
    /****************************************
     *       Basic Table                   *
     ****************************************/
    $('#zero_config').DataTable();

    /****************************************
     * Role-Permission Management          *
     ****************************************/
    $(document).ready(function() {
        // When role is selected
        $('#roleSelect').on('change', function() {
            const roleId = $(this).val();

            if (!roleId) {
                $('#permissionGrid').hide();
                $('#emptyState').show();
                $('#loadingPermissions').hide();
                return;
            }

            // Show loading
            $('#emptyState').hide();
            $('#permissionGrid').hide();
            $('#loadingPermissions').show();

            // Fetch role permissions via AJAX
            $.ajax({
                url: `/backend/roles/${roleId}/permissions`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#selectedRoleId').val(roleId);
                    renderPermissions(response.permissions, response.rolePermissions);
                    $('#loadingPermissions').hide();
                    $('#permissionGrid').show();
                },
                error: function(xhr) {
                    $('#loadingPermissions').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Failed to load permissions'
                    });
                }
            });
        });

        // Render permissions grouped by module
        function renderPermissions(allPermissions, rolePermissionIds) {
            const modules = {};

            // Group permissions by module
            allPermissions.forEach(permission => {
                if (!modules[permission.module]) {
                    modules[permission.module] = [];
                }
                modules[permission.module].push(permission);
            });

            let html = '';

            // Module name mapping
            const moduleNames = {
                'user_management': 'User Management',
                'user-management': 'User Management',
                'kepegawaian': 'Kepegawaian (HR)',
                'inventaris': 'Inventaris',
                'kategori': 'Kategori',
                'produk': 'Produk'
            };

            // Render each module
            for (const [moduleName, permissions] of Object.entries(modules)) {
                const displayName = moduleNames[moduleName] || moduleName;
                html += `
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-folder-open"></i>
                                ${displayName}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                `;

                permissions.forEach(permission => {
                    const isChecked = rolePermissionIds.includes(permission.id) ? 'checked' : '';
                    html += `
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       class="custom-control-input permission-checkbox"
                                       id="perm_${permission.id}"
                                       name="permissions[]"
                                       value="${permission.id}"
                                       ${isChecked}>
                                <label class="custom-control-label" for="perm_${permission.id}">
                                    <strong>${permission.display_name}</strong>
                                </label>
                                <small class="d-block text-muted">${permission.description || ''}</small>
                            </div>
                        </div>
                    `;
                });

                html += `
                            </div>
                        </div>
                    </div>
                `;
            }

            $('#permissionsContainer').html(html);
        }

        // Save permissions
        $('#permissionForm').on('submit', function(e) {
            e.preventDefault();

            const roleId = $('#selectedRoleId').val();
            const permissions = [];

            $('.permission-checkbox:checked').each(function() {
                permissions.push($(this).val());
            });

            // Confirmation dialog
            Swal.fire({
                title: 'Save Changes?',
                text: `Apakah Anda yakin ingin update permissions untuk role ini?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Save',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menyimpan...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Save via AJAX
                    $.ajax({
                        url: `/backend/roles/${roleId}/permissions`,
                        method: 'PUT',
                        data: {
                            _token: $('input[name="_token"]').val(),
                            permissions: permissions
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message || 'Permissions berhasil diupdate',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'Failed to update permissions'
                            });
                        }
                    });
                }
            });
        });

        // Reset permissions
        $('#resetPermissions').on('click', function() {
            const roleId = $('#roleSelect').val();
            if (roleId) {
                $('#roleSelect').trigger('change'); // Reload original state
            }
        });
    });
</script>
@endpush