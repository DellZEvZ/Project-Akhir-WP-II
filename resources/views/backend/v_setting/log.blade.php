@extends('backend.v_layouts.app')

@section('breadcrumb')
    <h4 class="page-title">Log Aktivitas</h4>
    <div class="ml-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Log Aktivitas</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-history"></i> Log Aktivitas Sistem
                    </h5>
                    <button type="button" class="btn btn-sm btn-light" title="Refresh">
                        <i class="mdi mdi-refresh"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <!-- Filter Section -->
                <form method="GET" action="{{ route('backend.setting.log') }}">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label class="form-label">Filter Jenis</label>
                            <select name="action_type" class="form-control form-control-sm" onchange="this.form.submit()">
                                <option value="">Semua Jenis</option>
                                <option value="login" {{ request('action_type') == 'login' ? 'selected' : '' }}>Login</option>
                                <option value="logout" {{ request('action_type') == 'logout' ? 'selected' : '' }}>Logout</option>
                                <option value="create" {{ request('action_type') == 'create' ? 'selected' : '' }}>Create</option>
                                <option value="update" {{ request('action_type') == 'update' ? 'selected' : '' }}>Update</option>
                                <option value="delete" {{ request('action_type') == 'delete' ? 'selected' : '' }}>Delete</option>
                                <option value="export" {{ request('action_type') == 'export' ? 'selected' : '' }}>Export</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Filter User</label>
                            <select name="user_id" class="form-control form-control-sm" onchange="this.form.submit()">
                                <option value="">Semua User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Filter Modul</label>
                            <select name="module" class="form-control form-control-sm" onchange="this.form.submit()">
                                <option value="">Semua Modul</option>
                                <option value="pegawai" {{ request('module') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                                <option value="aset" {{ request('module') == 'aset' ? 'selected' : '' }}>Aset</option>
                                <option value="user" {{ request('module') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="produk" {{ request('module') == 'produk' ? 'selected' : '' }}>Produk</option>
                                <option value="kategori" {{ request('module') == 'kategori' ? 'selected' : '' }}>Kategori</option>
                                <option value="permission" {{ request('module') == 'permission' ? 'selected' : '' }}>Permission</option>
                                <option value="auth" {{ request('module') == 'auth' ? 'selected' : '' }}>Auth</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}" onchange="this.form.submit()">
                        </div>
                    </div>

                    @if(request()->anyFilled(['action_type', 'user_id', 'module', 'date']))
                    <div class="mb-3">
                        <a href="{{ route('backend.setting.log') }}" class="btn btn-sm btn-secondary">
                            <i class="mdi mdi-refresh"></i> Reset Filter
                        </a>
                    </div>
                    @endif
                </form>

                <!-- Log Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Waktu</th>
                                <th width="15%">User</th>
                                <th width="10%">Jenis</th>
                                <th width="10%">Modul</th>
                                <th width="30%">Keterangan</th>
                                <th width="15%">IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $index => $log)
                            <tr>
                                <td>{{ $logs->firstItem() + $index }}</td>
                                <td>
                                    <small class="text-muted d-block">{{ $log->created_at->format('d M Y') }}</small>
                                    <small class="text-primary">{{ $log->created_at->format('H:i:s') }}</small>
                                </td>
                                <td>
                                    @if($log->user)
                                        <strong>{{ $log->user->nama }}</strong>
                                        <br><small class="text-muted">{{ $log->user->email }}</small>
                                    @else
                                        <span class="text-muted">System</span>
                                    @endif
                                </td>
                                <td>{!! $log->action_badge !!}</td>
                                <td>
                                    <span class="badge badge-secondary">{{ ucfirst($log->module) }}</span>
                                </td>
                                <td>
                                    {{ $log->description }}
                                    @if($log->properties && count($log->properties) > 0)
                                        <button type="button" class="btn btn-xs btn-link p-0 ml-2" data-toggle="modal" data-target="#detailModal{{ $log->id }}">
                                            <i class="mdi mdi-information-outline"></i>
                                        </button>
                                    @endif
                                </td>
                                <td><small class="text-muted">{{ $log->ip_address }}</small></td>
                            </tr>

                            <!-- Detail Modal -->
                            @if($log->properties && count($log->properties) > 0)
                            <div class="modal fade" id="detailModal{{ $log->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Detail Aktivitas</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <dl class="row">
                                                <dt class="col-sm-3">Waktu</dt>
                                                <dd class="col-sm-9">{{ $log->created_at->format('d M Y, H:i:s') }}</dd>

                                                <dt class="col-sm-3">User</dt>
                                                <dd class="col-sm-9">{{ $log->user ? $log->user->nama : 'System' }}</dd>

                                                <dt class="col-sm-3">Aktivitas</dt>
                                                <dd class="col-sm-9">{{ $log->description }}</dd>

                                                <dt class="col-sm-3">Detail</dt>
                                                <dd class="col-sm-9">
                                                    <pre class="bg-light p-3 rounded">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="mdi mdi-information-outline" style="font-size: 2rem; color: #ccc;"></i>
                                    <p class="mt-2">Belum ada log aktivitas</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $logs->links() }}
                </div>

                <!-- Additional Info -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Total Aktivitas</h6>
                                <h3 class="text-primary">{{ $todayLogs }}</h3>
                                <small class="text-muted">Hari ini</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">User Aktif</h6>
                                <h3 class="text-success">{{ $activeUsersToday }}</h3>
                                <small class="text-muted">Hari ini</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Login Terakhir</h6>
                                @if($lastLogin)
                                    <h5 class="text-warning">{{ $lastLogin->user ? $lastLogin->user->nama : 'System' }}</h5>
                                    <small class="text-muted">{{ $lastLogin->created_at->diffForHumans() }}</small>
                                @else
                                    <h5 class="text-warning">-</h5>
                                    <small class="text-muted">Belum ada data</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
