@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Detail Pegawai</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('backend.pegawai.index') }}">Pegawai</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h5 class="card-title">Detail Pegawai</h5>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('backend.pegawai.edit', $pegawai->id) }}" class="btn btn-warning">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('backend.pegawai.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="row">
                    <!-- Kolom Kiri - Foto dan Info Utama -->
                    <div class="col-md-4">
                        <div class="text-center mb-4">
                            @if ($pegawai->foto)
                            <img src="{{ asset('storage/img-pegawai/' . $pegawai->foto) }}"
                                 alt="{{ $pegawai->nama }}"
                                 class="rounded img-fluid"
                                 style="max-width: 300px; max-height: 300px; object-fit: cover;">
                            @else
                            <img src="{{ asset('storage/img-user/img-default.jpg') }}"
                                 alt="{{ $pegawai->nama }}"
                                 class="rounded img-fluid"
                                 style="max-width: 300px; max-height: 300px; object-fit: cover;">
                            @endif
                        </div>

                        <div class="card border">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3">Status Pegawai</h5>
                                <div class="text-center mb-3">
                                    @if ($pegawai->status_pegawai == 'aktif')
                                        <span class="badge badge-success p-2" style="font-size: 14px;">
                                            <i class="mdi mdi-check-circle"></i> Aktif
                                        </span>
                                    @elseif ($pegawai->status_pegawai == 'cuti')
                                        <span class="badge badge-info p-2" style="font-size: 14px;">
                                            <i class="mdi mdi-calendar-clock"></i> Cuti
                                        </span>
                                    @elseif ($pegawai->status_pegawai == 'resign')
                                        <span class="badge badge-danger p-2" style="font-size: 14px;">
                                            <i class="mdi mdi-account-off"></i> Resign
                                        </span>
                                    @endif
                                </div>

                                <hr>

                                <div class="mb-2">
                                    <strong><i class="mdi mdi-briefcase text-primary"></i> Jabatan:</strong><br>
                                    <span class="ml-4">{{ $pegawai->jabatan }}</span>
                                </div>

                                <div class="mb-2">
                                    <strong><i class="mdi mdi-office-building text-primary"></i> Departemen:</strong><br>
                                    <span class="ml-4">{{ $pegawai->departemen }}</span>
                                </div>

                                <div class="mb-2">
                                    <strong><i class="mdi mdi-cash text-success"></i> Gaji Pokok:</strong><br>
                                    <span class="ml-4 text-success">Rp {{ number_format($pegawai->gaji_pokok, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan - Detail Lengkap -->
                    <div class="col-md-8">
                        <!-- Informasi Pribadi -->
                        <div class="card border mb-3">
                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="mdi mdi-account"></i> Informasi Pribadi
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Nama Lengkap</label>
                                        <p class="mb-0"><strong>{{ $pegawai->nama }}</strong></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Email</label>
                                        <p class="mb-0">
                                            <i class="mdi mdi-email"></i> {{ $pegawai->email }}
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Nomor HP</label>
                                        <p class="mb-0">
                                            @if ($pegawai->no_hp)
                                                <i class="mdi mdi-phone"></i> {{ $pegawai->no_hp }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Jenis Kelamin</label>
                                        <p class="mb-0">
                                            @if ($pegawai->jenis_kelamin == 'laki-laki')
                                                <i class="mdi mdi-gender-male text-primary"></i> Laki-laki
                                            @elseif ($pegawai->jenis_kelamin == 'perempuan')
                                                <i class="mdi mdi-gender-female text-danger"></i> Perempuan
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="text-muted small">Alamat</label>
                                        <p class="mb-0">
                                            @if ($pegawai->alamat)
                                                <i class="mdi mdi-map-marker"></i> {{ $pegawai->alamat }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Kepegawaian -->
                        <div class="card border mb-3">
                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="mdi mdi-calendar-account"></i> Informasi Kepegawaian
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Tanggal Masuk</label>
                                        <p class="mb-0">
                                            <i class="mdi mdi-calendar-check"></i>
                                            {{ \Carbon\Carbon::parse($pegawai->tanggal_masuk)->format('d F Y') }}
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Masa Kerja</label>
                                        <p class="mb-0">
                                            <i class="mdi mdi-briefcase-clock"></i>
                                            @php
                                                $masaKerja = \Carbon\Carbon::parse($pegawai->tanggal_masuk)->diff(\Carbon\Carbon::now());
                                                $tahun = $masaKerja->y;
                                                $bulan = $masaKerja->m;
                                            @endphp
                                            @if ($tahun > 0)
                                                {{ $tahun }} tahun
                                            @endif
                                            @if ($bulan > 0)
                                                {{ $bulan }} bulan
                                            @endif
                                            @if ($tahun == 0 && $bulan == 0)
                                                Baru bergabung
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Tanggal Lahir</label>
                                        <p class="mb-0">
                                            @if ($pegawai->tanggal_lahir)
                                                <i class="mdi mdi-cake-variant"></i>
                                                {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d F Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Umur</label>
                                        <p class="mb-0">
                                            @if ($pegawai->tanggal_lahir)
                                                <i class="mdi mdi-account-clock"></i>
                                                {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->age }} tahun
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Akun User -->
                        <div class="card border">
                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="mdi mdi-account-key"></i> Informasi Akun Sistem
                                </h5>
                            </div>
                            <div class="card-body">
                                @if ($pegawai->user)
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">User Terhubung</label>
                                        <p class="mb-0">
                                            <i class="mdi mdi-account-check text-success"></i>
                                            <strong>{{ $pegawai->user->nama }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Email User</label>
                                        <p class="mb-0">
                                            <i class="mdi mdi-email"></i> {{ $pegawai->user->email }}
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="{{ route('backend.user.edit', $pegawai->user->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="mdi mdi-account-edit"></i> Lihat Detail User
                                        </a>
                                    </div>
                                </div>
                                @else
                                <div class="text-center text-muted py-3">
                                    <i class="mdi mdi-account-off" style="font-size: 32px;"></i>
                                    <p class="mb-0">Tidak terhubung dengan akun user sistem</p>
                                    <a href="{{ route('backend.pegawai.edit', $pegawai->id) }}" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="mdi mdi-link-variant"></i> Hubungkan dengan User
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Action Buttons -->
                <div class="text-center">
                    <a href="{{ route('backend.pegawai.edit', $pegawai->id) }}" class="btn btn-warning">
                        <i class="mdi mdi-pencil"></i> Edit Pegawai
                    </a>
                    <a href="{{ route('backend.pegawai.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
