@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Login Cepat - Testing</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Quick Login</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<style>
    .warning-box {
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .warning-box .warning-icon {
        color: #856404;
        font-size: 20px;
        margin-right: 10px;
    }

    .warning-title {
        color: #856404;
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .warning-text {
        color: #856404;
        margin: 0;
    }

    .info-box {
        background: #d1ecf1;
        border: 1px solid #bee5eb;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .info-box .info-icon {
        color: #0c5460;
        font-size: 20px;
        margin-right: 10px;
    }

    .info-title {
        color: #0c5460;
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .info-text {
        color: #0c5460;
        margin: 0;
    }

    .user-card {
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .user-card:hover {
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        transform: translateY(-3px);
    }

    .user-card.current-user {
        border-color: #28a745;
        background: #f0fff4;
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        font-weight: bold;
        margin-right: 20px;
    }

    .user-info h5 {
        margin: 0 0 5px 0;
        color: #333;
        font-size: 18px;
        font-weight: 600;
    }

    .user-email {
        color: #666;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .user-meta {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        font-size: 13px;
        color: #666;
    }

    .meta-item i {
        margin-right: 5px;
        color: #667eea;
    }

    .badge {
        font-size: 12px;
        padding: 5px 10px;
    }

    .badge-super-admin {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .badge-admin {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .badge-staff-kep {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .badge-staff-inv {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .badge-viewer {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #333;
    }

    .permission-badge {
        background: #667eea;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .current-user-badge {
        background: #28a745;
        color: white;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
    }

    .role-description {
        font-size: 11px;
        color: #888;
        margin-top: 5px;
        font-style: italic;
    }

    .permission-details {
        margin-top: 8px;
        padding: 8px;
        background: #f8f9fa;
        border-radius: 5px;
        font-size: 11px;
    }

    .permission-list {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 5px;
    }

    .permission-item {
        background: white;
        border: 1px solid #dee2e6;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 10px;
        color: #666;
    }
</style>

<div class="container-fluid">
    <!-- Warning Box -->
    <div class="warning-box">
        <div class="d-flex align-items-start">
            <i class="fas fa-exclamation-triangle warning-icon"></i>
            <div style="flex: 1;">
                <div class="warning-title">Mode Testing</div>
                <p class="warning-text">
                    Halaman ini hanya tersedia dalam mode <strong>DEBUG</strong>.
                    Gunakan untuk testing cepat dengan berbagai role tanpa perlu logout-login manual.
                </p>
            </div>
        </div>
    </div>

    <!-- Info Credentials -->
    <div class="info-box">
        <div class="d-flex align-items-start">
            <i class="fas fa-info-circle info-icon"></i>
            <div style="flex: 1;">
                <div class="info-title">Informasi Kredensial</div>
                <p class="info-text">
                    Semua akun testing menggunakan password: <strong style="color: #dc3545;">P@55word</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- Current User Info -->
    @if($currentUser)
    <div class="card mb-4" style="border: 2px solid #28a745; border-radius: 10px;">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-user-check mr-2"></i> User yang Sedang Login</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered mb-0">
                <tbody>
                    <tr>
                        <td width="150" class="font-weight-bold">Nama</td>
                        <td>{{ $currentUser->nama }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Email</td>
                        <td>{{ $currentUser->email }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Role</td>
                        <td>
                            @php
                                $userRoles = $currentUser->roles;
                                $userRole = $userRoles->first();
                            @endphp
                            
                            @if($userRole)
                                @if($userRole->name == 'super-admin')
                                    <span class="badge badge-super-admin">
                                        <i class="fas fa-crown"></i> {{ $userRole->display_name }}
                                    </span>
                                @elseif($userRole->name == 'admin')
                                    <span class="badge badge-admin">
                                        <i class="fas fa-user-shield"></i> {{ $userRole->display_name }}
                                    </span>
                                @elseif($userRole->name == 'staff-kepegawaian')
                                    <span class="badge badge-staff-kep">
                                        <i class="fas fa-users"></i> {{ $userRole->display_name }}
                                    </span>
                                @elseif($userRole->name == 'staff-inventaris')
                                    <span class="badge badge-staff-inv">
                                        <i class="fas fa-boxes"></i> {{ $userRole->display_name }}
                                    </span>
                                @else
                                    <span class="badge badge-viewer">
                                        <i class="fas fa-eye"></i> {{ $userRole->display_name }}
                                    </span>
                                @endif
                                <small class="text-muted ml-2">{{ $userRole->description }}</small>
                            @else
                                <span class="badge badge-secondary">No Role Assigned</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Total Permissions</td>
                        <td>
                            @php
                                $totalPermissions = 0;
                                if($userRole) {
                                    $totalPermissions = $userRole->permissions()->count();
                                }
                            @endphp
                            
                            @if($totalPermissions > 0)
                                <span class="badge badge-info">
                                    <i class="fas fa-key"></i> {{ $totalPermissions }} permissions
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    <i class="fas fa-exclamation-triangle"></i> 0 permissions
                                </span>
                                <small class="text-danger ml-2">(Role tidak memiliki permissions!)</small>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Last Login</td>
                        <td>
                            @if($currentUser->last_login)
                                {{ $currentUser->last_login->diffForHumans() }}
                                <small class="text-muted">({{ $currentUser->last_login->isoFormat('DD MMM Y, HH:mm') }})</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- User List -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-users mr-2"></i> Pilih Akun untuk Login</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($users as $user)
                <div class="col-md-6 col-lg-4">
                    <div class="user-card {{ $currentUser && $currentUser->id == $user->id ? 'current-user' : '' }}">
                        <div class="d-flex align-items-start">
                            <div class="user-avatar">
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            </div>
                            <div class="user-info" style="flex: 1;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5>{{ $user->nama }}</h5>
                                        @if($currentUser && $currentUser->id == $user->id)
                                            <span class="current-user-badge">
                                                <i class="fas fa-check-circle"></i> Logged In
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="user-email">{{ $user->email }}</div>

                                <div class="user-meta">
                                    @php
                                        $userRoles = $user->roles;
                                        $userRole = $userRoles->first();
                                        $totalPermissions = 0;
                                        
                                        if($userRole) {
                                            $totalPermissions = $userRole->permissions()->count();
                                        }
                                    @endphp
                                    
                                    <div class="meta-item">
                                        <i class="fas fa-shield-alt"></i>
                                        @if($userRole)
                                            @if($userRole->name == 'super-admin')
                                                <span class="badge badge-super-admin">
                                                    <i class="fas fa-crown"></i> Super Admin
                                                </span>
                                            @elseif($userRole->name == 'admin')
                                                <span class="badge badge-admin">
                                                    <i class="fas fa-user-shield"></i> Admin
                                                </span>
                                            @elseif($userRole->name == 'staff-kepegawaian')
                                                <span class="badge badge-staff-kep">
                                                    <i class="fas fa-users"></i> Staff Kep.
                                                </span>
                                            @elseif($userRole->name == 'staff-inventaris')
                                                <span class="badge badge-staff-inv">
                                                    <i class="fas fa-boxes"></i> Staff Inv.
                                                </span>
                                            @else
                                                <span class="badge badge-viewer">
                                                    <i class="fas fa-eye"></i> Viewer
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary">No Role</span>
                                        @endif
                                    </div>

                                    <div class="meta-item">
                                        <i class="fas fa-key"></i>
                                        @if($totalPermissions > 0)
                                            <span class="permission-badge">{{ $totalPermissions }} perms</span>
                                        @else
                                            <span class="badge badge-warning">0 perms</span>
                                        @endif
                                    </div>

                                    @if($user->pegawai)
                                    <div class="meta-item">
                                        <i class="fas fa-briefcase"></i>
                                        {{ $user->pegawai->jabatan }}
                                    </div>
                                    @endif
                                </div>

                                @if($userRole)
                                <div class="role-description">
                                    @if($userRole->name == 'super-admin')
                                        🔴 Full Access - Semua fitur ({{ $totalPermissions }} permissions)
                                    @elseif($userRole->name == 'admin')
                                        🟠 All except User Management ({{ $totalPermissions }} permissions)
                                    @elseif($userRole->name == 'staff-kepegawaian')
                                        🟡 Kepegawaian Limited ({{ $totalPermissions }} permissions)
                                    @elseif($userRole->name == 'staff-inventaris')
                                        🟢 Inventaris Full Access ({{ $totalPermissions }} permissions)
                                    @elseif($userRole->name == 'viewer')
                                        🔵 View Only ({{ $totalPermissions }} permissions)
                                    @endif
                                </div>
                                @endif

                                @if(!$currentUser || $currentUser->id != $user->id)
                                <form action="{{ route('backend.quick-login.login-as', $user->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="btn btn-login btn-sm btn-block">
                                        <i class="fas fa-sign-in-alt"></i> Login sebagai {{ explode(' ', $user->nama)[0] }}
                                    </button>
                                </form>
                                @else
                                <div class="mt-3">
                                    <a href="{{ route('backend.beranda') }}" class="btn btn-success btn-sm btn-block">
                                        <i class="fas fa-home"></i> Ke Dashboard
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        Tidak ada user yang tersedia
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Permission Legend -->
    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i> Legend - Permission Count by Role</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Role</th>
                                <th class="text-center">Permissions</th>
                                <th>Access Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge badge-super-admin"><i class="fas fa-crown"></i> Super Admin</span></td>
                                <td class="text-center"><strong>38</strong></td>
                                <td><small>Full Access - SEMUA</small></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-admin"><i class="fas fa-user-shield"></i> Admin</span></td>
                                <td class="text-center"><strong>34</strong></td>
                                <td><small>All except User Management</small></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-staff-kep"><i class="fas fa-users"></i> Staff Kepegawaian</span></td>
                                <td class="text-center"><strong>6</strong></td>
                                <td><small>Kepegawaian Limited</small></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-staff-inv"><i class="fas fa-boxes"></i> Staff Inventaris</span></td>
                                <td class="text-center"><strong>13</strong></td>
                                <td><small>Inventaris Full Access</small></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-viewer"><i class="fas fa-eye"></i> Viewer</span></td>
                                <td class="text-center"><strong>6</strong></td>
                                <td><small>View Only</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="font-weight-bold mb-3">Access Details:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="badge badge-super-admin">Super Admin</span>
                            <small class="d-block ml-3 text-muted">✅ User, Pegawai, Absensi, Jadwal, Gaji, Aset, Kategori, Produk, Laporan, Settings</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge badge-admin">Admin</span>
                            <small class="d-block ml-3 text-muted">✅ Semua KECUALI User Management</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge badge-staff-kep">Staff Kepegawaian</span>
                            <small class="d-block ml-3 text-muted">⚠️ View Pegawai, Input Absensi, View Jadwal/Gaji</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge badge-staff-inv">Staff Inventaris</span>
                            <small class="d-block ml-3 text-muted">✅ Full CRUD Aset, Kategori, Produk</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge badge-viewer">Viewer</span>
                            <small class="d-block ml-3 text-muted">👁️ View Only - Tidak bisa Create/Edit/Delete</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Login -->
    <div class="text-center mt-4 mb-4">
        <a href="{{ route('backend.login') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Halaman Login
        </a>
    </div>
</div>

@if(session('success'))
<script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            timer: 2000,
            showConfirmButton: false
        });
    });
</script>
@endif

@if(session('error'))
<script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session("error") }}',
        });
    });
</script>
@endif

@endsection