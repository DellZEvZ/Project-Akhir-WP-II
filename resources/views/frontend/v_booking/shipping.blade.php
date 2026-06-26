@extends('frontend.v_layouts.app')
@section('title', 'Alamat & Pengiriman')

@section('content')
<section class="py-5" style="background:#f4f4f4;min-height:70vh;">
    <div class="container">
        <h3 class="font-head mb-4">ALAMAT &amp; PENGIRIMAN</h3>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-7">
                <div class="card card-bf">
                    <div class="card-body p-4">
                        <h5 class="font-head mb-3"><i class="bi bi-truck text-gold"></i> Kirim Produk Ke Mana?</h5>

                        <form action="{{ route('booking.shipping.update') }}" method="POST" id="form-ongkir">
                            @csrf
                            <input type="hidden" name="total_berat" value="{{ $totalBerat }}">
                            <input type="hidden" name="kota_tujuan_id" id="in-dest-id">
                            <input type="hidden" name="kota_tujuan_label" id="in-dest-label">
                            <input type="hidden" name="kurir" id="in-kurir">
                            <input type="hidden" name="layanan_ongkir" id="in-layanan">
                            <input type="hidden" name="biaya_ongkir" id="in-biaya">
                            <input type="hidden" name="estimasi_ongkir" id="in-estimasi">

                            <div class="mb-3">
                                <label class="form-label small">Alamat Lengkap (nama jalan, no. rumah, RT/RW) <span class="text-danger">*</span></label>
                                <textarea name="alamat_kirim" id="alamat_kirim" class="form-control @error('alamat_kirim') is-invalid @enderror" rows="2"
                                          placeholder="Contoh: Jl. Melati No. 12, RT 02/RW 05" required>{{ old('alamat_kirim', $order->alamat_kirim ?: ($customer->alamat ?? '')) }}</textarea>
                                @error('alamat_kirim')<small class="text-danger">{{ $message }}</small>@enderror
                                @if (!$order->alamat_kirim && !empty($customer->alamat))
                                    <small class="text-muted"><i class="bi bi-info-circle"></i> Diisi otomatis dari alamat profil Anda. Ubah jika perlu.</small>
                                @endif
                            </div>

                            <div class="mb-3" style="position:relative;" id="dest-wrap">
                                <label class="form-label small">Kecamatan / Kota Tujuan <span class="text-danger">*</span></label>
                                <input type="text" id="cari-tujuan" autocomplete="off"
                                       placeholder="Ketik nama kecamatan/kota, contoh: Tegalsari"
                                       class="form-control">
                                <ul id="dest-list" class="dest-list"></ul>
                                <small class="text-muted">Pilih dari daftar yang muncul agar ongkir dapat dihitung akurat.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small">Kurir</label>
                                <select id="kurir" class="form-select">
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">POS Indonesia</option>
                                </select>
                            </div>

                            <button type="button" id="btn-cek" class="btn btn-outline-gold w-100">
                                <i class="bi bi-search"></i> Cek Ongkos Kirim
                            </button>

                            <div id="hasil-ongkir" class="mt-3"></div>

                            <button type="submit" id="btn-lanjut" class="btn btn-gold btn-lg w-100 mt-3" style="display:none;">
                                <i class="bi bi-arrow-right-circle"></i> Lanjut ke Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card card-bf">
                    <div class="card-body p-4">
                        <h5 class="font-head mb-3">Ringkasan</h5>
                        @foreach ($order->orderItems as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small">{{ $item->produk->nama_produk ?? 'Item' }} <span class="text-muted">x{{ $item->qty }}</span></span>
                                <span class="small">Rp {{ number_format($item->qty * $item->harga, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between small mb-2">
                            <span>Total Berat</span><span>{{ $totalBerat }} gram</span>
                        </div>
                        <div class="d-flex justify-content-between"><strong>Subtotal</strong><strong class="price-tag">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></div>
                        <p class="text-muted small mb-0 mt-2"><i class="bi bi-info-circle"></i> Ongkos kirim akan ditambahkan setelah Anda memilih kurir.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .dest-list {
        list-style: none; margin: 0; padding: 0;
        position: absolute; left: 0; right: 0; top: 100%;
        background: #fff; border: 1px solid #ddd; border-top: none;
        border-radius: 0 0 6px 6px; max-height: 240px; overflow-y: auto;
        box-shadow: 0 6px 16px rgba(0,0,0,.12); z-index: 20; display: none;
    }
    .dest-list li { padding: 10px 12px; font-size: 13px; line-height: 1.4; cursor: pointer; border-bottom: 1px solid #f2f2f2; }
    .dest-list li:last-child { border-bottom: none; }
    .dest-list li:hover { background: #fdf6e3; }
    .dest-list .d-main { font-weight: 600; color: #222; }
    .dest-list .d-sub  { font-size: 11px; color: #999; margin-top: 1px; }
    .dest-empty { padding: 10px 12px; font-size: 12px; color: #999; }
</style>

@push('scripts')
<script>
    const WEIGHT  = {{ $totalBerat }};
    const CSRF    = "{{ csrf_token() }}";

    const cariInput = document.getElementById('cari-tujuan');
    const destList  = document.getElementById('dest-list');
    const inDestId    = document.getElementById('in-dest-id');
    const inDestLabel = document.getElementById('in-dest-label');
    let   cariTimer;

    cariInput.addEventListener('input', function () {
        const keyword = this.value.trim();
        inDestId.value = '';
        clearTimeout(cariTimer);
        if (keyword.length < 3) { destList.style.display = 'none'; return; }

        cariTimer = setTimeout(() => {
            fetch("{{ route('booking.shipping.search') }}?search=" + encodeURIComponent(keyword))
                .then(r => r.json())
                .then(res => {
                    const list = res.data || [];
                    if (!list.length) {
                        destList.innerHTML = '<li class="dest-empty">Tidak ditemukan. Coba kata kunci lain.</li>';
                        destList.style.display = 'block';
                        return;
                    }
                    destList.innerHTML = list.map(d => {
                        const main = `${d.subdistrict_name}, ${d.district_name}`;
                        const sub  = `${d.city_name}, ${d.province_name} ${d.zip_code}`;
                        return `<li data-id="${d.id}" data-label="${d.label}">
                                    <div class="d-main">${main}</div>
                                    <div class="d-sub">${sub}</div>
                                </li>`;
                    }).join('');
                    destList.style.display = 'block';
                })
                .catch(() => {
                    destList.innerHTML = '<li class="dest-empty">Gagal memuat. Coba lagi.</li>';
                    destList.style.display = 'block';
                });
        }, 400);
    });

    destList.addEventListener('click', function (e) {
        const li = e.target.closest('li[data-id]');
        if (!li) return;
        inDestId.value    = li.dataset.id;
        inDestLabel.value = li.dataset.label;
        cariInput.value   = li.dataset.label;
        destList.style.display = 'none';
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#dest-wrap')) destList.style.display = 'none';
    });

    // Cegah submit form jika data ongkir belum lengkap (jaga-jaga selain disable tombol)
    document.getElementById('form-ongkir').addEventListener('submit', function (e) {
        if (!document.getElementById('in-kurir').value || !document.getElementById('in-biaya').value) {
            e.preventDefault();
            alert('Silakan cek ongkos kirim dan pilih salah satu kurir terlebih dahulu sebelum lanjut.');
        }
    });

    document.getElementById('btn-cek').addEventListener('click', function () {
        const courier = document.getElementById('kurir').value;
        const hasil   = document.getElementById('hasil-ongkir');

        if (!inDestId.value) { alert('Pilih kecamatan/kota tujuan dari daftar terlebih dahulu.'); return; }

        hasil.innerHTML = '<p class="text-muted small">Menghitung ongkir...</p>';

        fetch("{{ route('booking.shipping.cost') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ destination: inDestId.value, weight: WEIGHT, courier: courier })
        })
        .then(r => r.json())
        .then(res => {
            const costs = res.data || [];
            if (!costs.length) { hasil.innerHTML = '<p class="text-danger small">Layanan kurir ini tidak tersedia untuk tujuan tersebut.</p>'; return; }

            let html = '<div class="table-responsive"><table class="table table-bordered table-sm"><thead><tr><th>Layanan</th><th>Biaya</th><th>Estimasi</th><th></th></tr></thead><tbody>';
            costs.forEach(s => {
                html += `<tr>
                    <td>${s.service}</td>
                    <td>Rp ${Number(s.cost).toLocaleString('id-ID')}</td>
                    <td>${s.etd || '-'}</td>
                    <td><button type="button" class="btn btn-sm btn-gold pilih-ongkir"
                        data-kurir="${courier}" data-layanan="${s.service}" data-biaya="${s.cost}" data-etd="${s.etd || ''}">Pilih</button></td>
                </tr>`;
            });
            html += '</tbody></table></div>';
            hasil.innerHTML = html;

            document.querySelectorAll('.pilih-ongkir').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('in-kurir').value    = this.dataset.kurir;
                    document.getElementById('in-layanan').value  = this.dataset.layanan;
                    document.getElementById('in-biaya').value    = this.dataset.biaya;
                    document.getElementById('in-estimasi').value = this.dataset.etd;
                    document.getElementById('btn-lanjut').style.display = 'block';
                    hasil.innerHTML += `<div class="alert alert-success small mt-2">Dipilih: ${this.dataset.kurir.toUpperCase()} ${this.dataset.layanan} — Rp ${Number(this.dataset.biaya).toLocaleString('id-ID')}</div>`;
                });
            });
        })
        .catch(() => hasil.innerHTML = '<p class="text-danger small">Gagal menghubungi layanan ongkos kirim. Coba lagi.</p>');
    });
</script>
@endpush
@endsection
