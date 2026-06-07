@extends('backend.v_layouts.app')
@section('content')
<!-- contentAwal -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $judul }}</h4>

                    <div class="row">

                        <!-- DETAIL PRODUK -->
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <td width="200"><strong>Nama Produk</strong></td>
                                    <td>{{ $show->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori</strong></td>
                                    <td>{{ $show->kategori->nama_kategori }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Harga</strong></td>
                                    <td>Rp. {{ number_format($show->harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Berat</strong></td>
                                    <td>{{ $show->berat }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Stok</strong></td>
                                    <td>{{ $show->stok }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>
                                        @if ($show->status == 1)
                                            <span class="badge badge-success">Publis</span>
                                        @else
                                            <span class="badge badge-secondary">Blok</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Detail</strong></td>
                                    <td>{!! $show->detail !!}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- FOTO UTAMA -->
                        <div class="col-md-4">
                            <h5>Foto Utama</h5>
                            <img src="{{ asset('storage/img-produk/thumb_md_' . $show->foto) }}"
                                 alt="{{ $show->nama_produk }}"
                                 class="img-fluid img-thumbnail">
                        </div>

                    </div>

                    <hr>

                    <!-- FORM TAMBAH GAMBAR -->
                    <div class="row">
                        <div class="col-12">
                            <h5>Tambahkan Gambar Produk</h5>
                            <form action="{{ route('backend.foto_produk.store') }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="produk_id" value="{{ $show->id }}">

                                <div class="form-group">
                                    <label>Pilih Gambar (Bisa multiple)</label>
                                    <input type="file"
                                           name="foto_produk[]"
                                           multiple
                                           class="form-control @error('foto_produk.*') is-invalid @enderror"
                                           accept="image/*">
                                    @error('foto_produk.*')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Upload
                                </button>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <!-- DAFTAR GAMBAR -->
                    @if ($show->gambar->count() > 0)
                        <div class="row">
                            <div class="col-12">
                                <h5>Daftar Gambar Produk</h5>
                                <div class="row">
                                    @foreach ($show->gambar as $item)
                                        <div class="col-md-3 mb-3">
                                            <div class="card">
                                                <img src="{{ asset('storage/img-produk/' . $item->foto) }}"
                                                     class="card-img-top"
                                                     alt="Gambar Produk">
                                                <div class="card-body p-2">
                                                    <form action="{{ route('backend.foto_produk.destroy', $item->id) }}"
                                                          method="POST"
                                                          style="display: inline-block;">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-danger btn-sm btn-block show_confirm"
                                                                data-konf-delete="gambar produk"
                                                                title="Hapus Gambar">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada gambar produk tambahan.
                        </div>
                    @endif

                </div>

                <div class="border-top">
                    <div class="card-body">
                        <a href="{{ route('backend.produk.index') }}">
                            <button type="button" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </button>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- contentAkhir -->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll('.show_confirm');

        buttons.forEach(btn => {
            btn.addEventListener('click', function (event) {
                event.preventDefault();

                const form = this.closest("form");
                const nama = this.getAttribute('data-konf-delete');

                Swal.fire({
                    title: "Hapus data?",
                    text: "\"" + nama + "\" akan dihapus!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
