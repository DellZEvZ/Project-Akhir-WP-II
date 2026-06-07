@extends('backend.v_layouts.app')

@section('breadcrumb')
<h4 class="page-title">Edit Pegawai</h4>
<div class="ml-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('backend.pegawai.index') }}">Pegawai</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Form Edit Pegawai</h5>

                <form action="{{ route('backend.pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <!-- Nama -->
                            <div class="form-group">
                                <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('nama') is-invalid @enderror"
                                       id="nama"
                                       name="nama"
                                       value="{{ old('nama', $pegawai->nama) }}"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $pegawai->email) }}"
                                       placeholder="contoh@email.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- No HP -->
                            <div class="form-group">
                                <label for="no_hp">Nomor HP</label>
                                <input type="text"
                                       class="form-control @error('no_hp') is-invalid @enderror"
                                       id="no_hp"
                                       name="no_hp"
                                       value="{{ old('no_hp', $pegawai->no_hp) }}"
                                       placeholder="08xxxxxxxxxx">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror"
                                          id="alamat"
                                          name="alamat"
                                          rows="3"
                                          placeholder="Masukkan alamat lengkap">{{ old('alamat', $pegawai->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jabatan -->
                            <div class="form-group">
                                <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('jabatan') is-invalid @enderror"
                                       id="jabatan"
                                       name="jabatan"
                                       value="{{ old('jabatan', $pegawai->jabatan) }}"
                                       placeholder="Contoh: Dokter Umum, Perawat, Admin"
                                       required>
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Departemen -->
                            <div class="form-group">
                                <label for="departemen">Departemen <span class="text-danger">*</span></label>
                                <select class="form-control @error('departemen') is-invalid @enderror"
                                        id="departemen"
                                        name="departemen"
                                        required>
                                    <option value="">-- Pilih Departemen --</option>
                                    <option value="Medis" {{ old('departemen', $pegawai->departemen) == 'Medis' ? 'selected' : '' }}>Medis</option>
                                    <option value="Administrasi" {{ old('departemen', $pegawai->departemen) == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                                    <option value="Kepegawaian" {{ old('departemen', $pegawai->departemen) == 'Kepegawaian' ? 'selected' : '' }}>Kepegawaian</option>
                                    <option value="Farmasi" {{ old('departemen', $pegawai->departemen) == 'Farmasi' ? 'selected' : '' }}>Farmasi</option>
                                    <option value="IT" {{ old('departemen', $pegawai->departemen) == 'IT' ? 'selected' : '' }}>IT</option>
                                    <option value="Keamanan" {{ old('departemen', $pegawai->departemen) == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                                </select>
                                @error('departemen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <!-- Status Pegawai -->
                            <div class="form-group">
                                <label for="status_pegawai">Status Pegawai <span class="text-danger">*</span></label>
                                <select class="form-control @error('status_pegawai') is-invalid @enderror"
                                        id="status_pegawai"
                                        name="status_pegawai"
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="aktif" {{ old('status_pegawai', $pegawai->status_pegawai) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="cuti" {{ old('status_pegawai', $pegawai->status_pegawai) == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                    <option value="resign" {{ old('status_pegawai', $pegawai->status_pegawai) == 'resign' ? 'selected' : '' }}>Resign</option>
                                </select>
                                @error('status_pegawai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Masuk -->
                            <div class="form-group">
                                <label for="tanggal_masuk">Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                       id="tanggal_masuk"
                                       name="tanggal_masuk"
                                       value="{{ old('tanggal_masuk', $pegawai->tanggal_masuk) }}"
                                       required>
                                @error('tanggal_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date"
                                       class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                       id="tanggal_lahir"
                                       name="tanggal_lahir"
                                       value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="form-group">
                                <label>Jenis Kelamin</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="jenis_kelamin"
                                           id="laki_laki"
                                           value="laki-laki"
                                           {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'laki-laki' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="laki_laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="jenis_kelamin"
                                           id="perempuan"
                                           value="perempuan"
                                           {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                                @error('jenis_kelamin')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gaji Pokok -->
                            <div class="form-group">
                                <label for="gaji_pokok">Gaji Pokok <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number"
                                           class="form-control @error('gaji_pokok') is-invalid @enderror"
                                           id="gaji_pokok"
                                           name="gaji_pokok"
                                           value="{{ old('gaji_pokok', $pegawai->gaji_pokok) }}"
                                           placeholder="5000000"
                                           required>
                                    @error('gaji_pokok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- User -->
                            <div class="form-group">
                                <label for="user_id">Link ke User (Opsional)</label>
                                <select class="form-control @error('user_id') is-invalid @enderror"
                                        id="user_id"
                                        name="user_id">
                                    <option value="">-- Pilih User --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $pegawai->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->nama }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Hubungkan pegawai dengan akun user sistem jika ada</small>
                            </div>

                            <!-- Foto -->
                            <div class="form-group">
                                <label for="foto">Foto Pegawai</label>

                                <!-- Preview Foto Lama -->
                                @if ($pegawai->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/img-pegawai/' . $pegawai->foto) }}"
                                         alt="{{ $pegawai->nama }}"
                                         class="rounded"
                                         style="max-width: 200px; max-height: 200px;">
                                    <p class="small text-muted mt-1">Foto saat ini</p>
                                </div>
                                @endif

                                <input type="file"
                                       class="form-control @error('foto') is-invalid @enderror"
                                       id="foto"
                                       name="foto"
                                       accept="image/jpeg,image/png,image/jpg"
                                       onchange="previewFoto()">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto</small>

                                <!-- Preview Foto Baru -->
                                <img class="foto-preview mt-2 rounded"
                                     src=""
                                     alt="Preview Foto"
                                     style="display: none; max-width: 200px; max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Action Buttons -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Update
                        </button>
                        <a href="{{ route('backend.pegawai.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
