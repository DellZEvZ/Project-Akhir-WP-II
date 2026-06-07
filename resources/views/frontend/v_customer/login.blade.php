@extends('frontend.v_layouts.app')
@section('title', 'Login')

@section('content')
<section class="py-5" style="background:#f4f4f4;min-height:75vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <ul class="nav nav-pills nav-justified mb-3" id="authTab" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#loginTab">Login</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#registerTab">Daftar</button></li>
                </ul>

                <div class="card card-bf">
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <!-- LOGIN -->
                            <div class="tab-pane fade show active" id="loginTab">
                                <h4 class="font-head text-center mb-3">MASUK AKUN</h4>

                                @if (session('login_error'))
                                    <div class="alert alert-danger py-2 small">{{ session('login_error') }}</div>
                                @endif

                                <form action="{{ route('customer.login.post') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label small">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email') }}" placeholder="email@contoh.com" required>
                                        </div>
                                        @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" name="password" class="form-control" placeholder="••••••" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-gold w-100"><i class="bi bi-box-arrow-in-right"></i> Masuk</button>
                                </form>

                                <div class="text-center my-3 text-muted small">— atau —</div>
                                <a href="{{ route('customer.google.redirect') }}" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-google text-danger"></i> Login dengan Google
                                </a>
                            </div>

                            <!-- REGISTER -->
                            <div class="tab-pane fade" id="registerTab">
                                <h4 class="font-head text-center mb-3">DAFTAR AKUN</h4>
                                <form action="{{ route('customer.register') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label small">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                                   value="{{ old('nama') }}" placeholder="Nama kamu" required>
                                        </div>
                                        @error('nama')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email') }}" placeholder="email@contoh.com" required>
                                        </div>
                                        @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="Minimal 6 karakter" required>
                                        </div>
                                        @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Konfirmasi Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-gold w-100"><i class="bi bi-person-plus"></i> Daftar</button>
                                </form>

                                <div class="text-center my-3 text-muted small">— atau —</div>
                                <a href="{{ route('customer.google.redirect') }}" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-google text-danger"></i> Daftar dengan Google
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if ($errors->has('nama') || $errors->has('password') || (old('email') && session('errors')))
@push('scripts')
<script>
    // Buka tab register jika error berasal dari form register
    document.addEventListener('DOMContentLoaded', function () {
        var trigger = document.querySelector('[data-bs-target="#registerTab"]');
        if (trigger) new bootstrap.Tab(trigger).show();
    });
</script>
@endpush
@endif
@endsection
