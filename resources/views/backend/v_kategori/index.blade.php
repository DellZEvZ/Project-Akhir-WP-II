@extends('backend.v_layouts.app')

@section('content')
<!-- contentAwal -->

<div class="row">
    <div class="col-12">

        <a href="{{ route('backend.kategori.create') }}">
            <button type="button" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $judul }}</h5>

                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($index as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->nama_kategori }}</td>
                                    <td>

                                        <a href="{{ route('backend.kategori.edit', $row->id) }}" title="Ubah Data">
                                            <button type="button" class="btn btn-cyan btn-sm">
                                                <i class="far fa-edit"></i> Ubah
                                            </button>
                                        </a>

                                        <form method="POST"
                                              action="{{ route('backend.kategori.destroy', $row->id) }}"
                                              style="display: inline-block;">
                                            @csrf
                                            @method('delete')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm show_confirm"
                                                    data-konf-delete="{{ $row->nama_kategori }}"
                                                    title="Hapus Data">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
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
    $(document).ready(function () {
        const buttons = document.querySelectorAll('.show_confirm');

        buttons.forEach(btn => {
            btn.addEventListener('click', function (event) {
                event.preventDefault();

                const form = this.closest("form");
                const nama = this.getAttribute('data-konf-delete');

                Swal.fire({
                    title: "Hapus data?",
                    text: "Kategori \"" + nama + "\" akan dihapus!",
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