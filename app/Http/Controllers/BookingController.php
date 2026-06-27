<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Layanan;
use App\Models\Produk;
use App\Models\Order;
use App\Models\OrderItem;
use App\Helpers\ActivityLogger;

class BookingController extends Controller
{
    /**
     * Ambil order pending (keranjang) milik customer aktif.
     */
    private function getCart()
    {
        $customerId = Session::get('customer')->id;

        return Order::firstOrCreate(
            ['customer_id' => $customerId, 'status' => 'pending'],
            ['total_harga' => 0]
        );
    }

    private function recalcTotal(Order $order)
    {
        $total = $order->orderItems()->get()->sum(fn ($i) => $i->qty * $i->harga);
        $order->update(['total_harga' => $total]);
    }

    // Tampilkan keranjang (layanan + produk)
    public function cart()
    {
        $order = $this->getCart()->load('orderItems.layanan', 'orderItems.produk');
        return view('frontend.v_booking.cart', compact('order'));
    }

    // Tambah layanan ke keranjang
    public function add(Request $request, $id)
    {
        $layanan = Layanan::where('status', 'aktif')->findOrFail($id);
        $order   = $this->getCart();

        // Satu order tidak boleh campur: tolak layanan bila keranjang berisi produk.
        if ($order->orderItems()->whereNotNull('produk_id')->exists()) {
            return $this->mixError($request, $order, 'produk');
        }

        $item = $order->orderItems()->where('layanan_id', $layanan->id)->first();

        if ($item) {
            $item->increment('qty');
        } else {
            $order->orderItems()->create([
                'layanan_id' => $layanan->id,
                'qty'        => 1,
                'harga'      => $layanan->harga,
            ]);
        }

        $this->recalcTotal($order);

        return $this->cartResponse($request, $order, $layanan->nama_layanan);
    }

    // Tambah produk ke keranjang
    public function addProduk(Request $request, $id)
    {
        $produk = Produk::where('status', 1)->findOrFail($id);
        $order  = $this->getCart();

        // Satu order tidak boleh campur: tolak produk bila keranjang berisi layanan.
        if ($order->orderItems()->whereNotNull('layanan_id')->exists()) {
            return $this->mixError($request, $order, 'layanan');
        }

        $item = $order->orderItems()->where('produk_id', $produk->id)->first();

        if ($item) {
            $item->increment('qty');
        } else {
            $order->orderItems()->create([
                'produk_id' => $produk->id,
                'qty'       => 1,
                'harga'     => $produk->harga,
            ]);
        }

        $this->recalcTotal($order);

        return $this->cartResponse($request, $order, $produk->nama_produk);
    }

    /**
     * Balas AJAX dengan JSON (untuk animasi keranjang) atau redirect biasa
     * sebagai fallback non-JS.
     */
    private function cartResponse(Request $request, Order $order, string $name)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'count'   => (int) $order->orderItems()->sum('qty'),
                'total'   => 'Rp ' . number_format($order->fresh()->total_harga, 0, ',', '.'),
                'name'    => $name,
            ]);
        }

        return redirect()->route('booking.cart')
            ->with('success', '"' . $name . '" ditambahkan ke keranjang.');
    }

    /** Tolak pencampuran layanan & produk dalam satu order. */
    private function mixError(Request $request, Order $order, string $existing)
    {
        $msg = $existing === 'produk'
            ? 'Keranjang berisi PRODUK. Selesaikan atau kosongkan dulu untuk booking layanan.'
            : 'Keranjang berisi LAYANAN. Selesaikan atau kosongkan dulu untuk belanja produk.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $msg,
                'count'   => (int) $order->orderItems()->sum('qty'),
            ], 409);
        }

        return redirect()->route('booking.cart')->with('error', $msg);
    }

    // Update qty item
    public function update(Request $request, $itemId)
    {
        $order = $this->getCart();
        $item  = $order->orderItems()->findOrFail($itemId);

        $qty = max(1, (int) $request->qty);
        $item->update(['qty' => $qty]);

        $this->recalcTotal($order);

        return redirect()->route('booking.cart')->with('success', 'Jumlah diperbarui.');
    }

    // Hapus item
    public function remove(Request $request, $itemId)
    {
        $order = $this->getCart();
        $order->orderItems()->where('id', $itemId)->delete();

        $this->recalcTotal($order);
        $order->refresh();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'count'   => (int) $order->orderItems()->sum('qty'),
                'total'   => 'Rp ' . number_format($order->total_harga, 0, ',', '.'),
                'empty'   => $order->orderItems()->count() === 0,
            ]);
        }

        return redirect()->route('booking.cart')->with('success', 'Item dihapus dari keranjang.');
    }

    // Halaman checkout
    public function checkout()
    {
        $order = $this->getCart()->load('orderItems.layanan', 'orderItems.produk');
        $barbers = \App\Models\Barber::aktif()->get();

        if ($order->orderItems->isEmpty()) {
            return redirect()->route('booking.cart')->with('error', 'Keranjang masih kosong.');
        }

        // Order berisi produk (dikirim) wajib pilih ongkos kirim dulu sebelum checkout.
        if ($order->has_produk && ! $order->kota_tujuan_id) {
            return redirect()->route('booking.shipping')
                ->with('error', 'Silakan pilih alamat & ongkos kirim terlebih dahulu.');
        }

        return view('frontend.v_booking.checkout', compact('order', 'barbers'));
    }

    /**
     * Halaman pilih alamat tujuan & ongkos kirim (RajaOngkir) — khusus order
     * yang berisi produk fisik (dikirim), tidak berlaku untuk booking layanan.
     */
    public function selectShipping()
    {
        $order = $this->getCart()->load('orderItems.produk');

        if ($order->orderItems->isEmpty()) {
            return redirect()->route('booking.cart')->with('error', 'Keranjang masih kosong.');
        }

        if (! $order->has_produk) {
            return redirect()->route('booking.checkout');
        }

        // Total berat (gram) seluruh item produk dalam keranjang.
        $totalBerat = $order->orderItems->sum(function ($item) {
            return ($item->produk->berat ?? 0) * $item->qty;
        });
        // Minimal 1 gram agar tidak ditolak API RajaOngkir.
        $totalBerat = max(1, $totalBerat);

        $origin = config('services.rajaongkir.origin');
        $customer = Session::get('customer');

        return view('frontend.v_booking.shipping', compact('order', 'totalBerat', 'origin', 'customer'));
    }

    /**
     * Simpan pilihan alamat tujuan & ongkos kirim ke order, lalu kembali ke checkout.
     */
    public function updateOngkir(Request $request)
    {
        $request->validate([
            'alamat_kirim'      => 'required|string|max:500',
            'kota_tujuan_id'    => 'required|string',
            'kota_tujuan_label' => 'required|string',
            'kurir'             => 'required|string',
            'layanan_ongkir'    => 'required|string',
            'biaya_ongkir'      => 'required|numeric|min:0',
            'estimasi_ongkir'   => 'nullable|string',
            'total_berat'       => 'required|numeric|min:1',
        ], [
            'alamat_kirim.required'      => 'Alamat lengkap wajib diisi.',
            'kota_tujuan_id.required'    => 'Pilih kecamatan/kota tujuan dari daftar yang muncul.',
            'kurir.required'             => 'Klik "Cek Ongkos Kirim" lalu pilih salah satu kurir.',
            'biaya_ongkir.required'      => 'Klik "Cek Ongkos Kirim" lalu pilih salah satu kurir.',
        ]);

        $order = $this->getCart();

        $order->update([
            'alamat_kirim'      => $request->alamat_kirim,
            'kota_tujuan_id'    => $request->kota_tujuan_id,
            'kota_tujuan_label' => $request->kota_tujuan_label,
            'kurir'             => strtoupper($request->kurir),
            'layanan_ongkir'    => $request->layanan_ongkir,
            'biaya_ongkir'      => $request->biaya_ongkir,
            'estimasi_ongkir'   => $request->estimasi_ongkir,
            'total_berat'       => $request->total_berat,
        ]);

        return redirect()->route('booking.checkout')
            ->with('success', 'Pengiriman dipilih. Silakan lanjutkan checkout.');
    }

    // Konfirmasi checkout — jadwal hanya untuk layanan, alamat hanya untuk produk
    public function confirm(Request $request)
    {
        $order = $this->getCart()->load('orderItems');

        if ($order->orderItems->isEmpty()) {
            return redirect()->route('booking.cart')->with('error', 'Keranjang masih kosong.');
        }

        $rules    = ['catatan' => 'nullable|string|max:500'];
        $messages = ['tanggal_booking.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu.'];

        if ($order->has_layanan) {
            $rules['tanggal_booking'] = 'required|date|after_or_equal:today';
            $rules['jam_booking']     = 'required';
            $rules['barber_id']       = 'required|exists:barbers,id';
        }

        $request->validate($rules, $messages);

        // Order berisi produk (dikirim) wajib sudah memilih alamat & ongkos kirim
        // di halaman shipping sebelum bisa dikonfirmasi.
        if ($order->has_produk && ! $order->kota_tujuan_id) {
            return redirect()->route('booking.shipping')
                ->with('error', 'Silakan pilih alamat & ongkos kirim terlebih dahulu.');
        }

        // Cegah tabrakan jadwal: slot (tanggal + jam) tidak boleh dipakai
        // booking aktif lain untuk BARBER yang sama.
        if ($order->has_layanan && $this->slotTaken($request->tanggal_booking, $request->jam_booking, $request->barber_id, $order->id)) {
            $barberNama = \App\Models\Barber::find($request->barber_id)->nama ?? 'Barber ini';
            return back()->withInput()->with('error',
                "{$barberNama} sudah dibooking pada jam {$request->jam_booking} tanggal " .
                \Carbon\Carbon::parse($request->tanggal_booking)->format('d M Y') .
                '. Silakan pilih jam lain atau barber lain.');
        }

        $order->update([
            'status'          => 'confirmed',
            'jenis'           => $order->has_layanan ? 'booking' : 'produk',
            'tanggal_booking' => $request->tanggal_booking,
            'jam_booking'     => $request->jam_booking,
            'barber_id'       => $request->barber_id ?? null,
            'catatan'         => $request->catatan,
        ]);

        $nama = Session::get('customer')->nama;
        $jenis = $order->has_layanan ? 'booking layanan' : 'pembelian produk';
        ActivityLogger::log('create', 'pesanan', "Pelanggan {$nama} membuat {$jenis} #{$order->id} (Rp " . number_format($order->total_harga, 0, ',', '.') . ')', $order);

        return redirect()->route('booking.payment', $order->id)
            ->with('success', 'Pesanan dikonfirmasi! Silakan selesaikan pembayaran.');
    }

    /**
     * Cek apakah slot jadwal (tanggal + jam) sudah dipakai booking aktif lain
     * untuk BARBER yang sama. Barber berbeda boleh melayani jam yang sama.
     */
    private function slotTaken($tanggal, $jam, $barberId, $excludeOrderId): bool
    {
        return Order::where('jenis', 'booking')
            ->whereIn('status', ['confirmed', 'done'])
            ->where('barber_id', $barberId)
            ->where('tanggal_booking', $tanggal)
            ->where('jam_booking', $jam)
            ->where('id', '!=', $excludeOrderId)
            ->exists();
    }

    /**
     * Daftar jam yang sudah penuh pada tanggal tertentu UNTUK BARBER TERTENTU
     * (JSON, untuk checkout). Barber lain tidak memengaruhi ketersediaan jam ini.
     */
    public function slots(Request $request)
    {
        $tanggal  = $request->get('tanggal');
        $barberId = $request->get('barber_id');

        $query = Order::where('jenis', 'booking')
            ->whereIn('status', ['confirmed', 'done'])
            ->whereDate('tanggal_booking', $tanggal);

        if ($barberId) {
            $query->where('barber_id', $barberId);
        }

        $taken = $query->get()
            ->map(fn ($o) => $o->jam_booking ? \Carbon\Carbon::parse($o->jam_booking)->format('H:i') : null)
            ->filter()->unique()->values();

        return response()->json(['taken' => $taken]);
    }

    /**
     * Pastikan order milik customer yang sedang login.
     */
    private function ownedOrder($id): Order
    {
        return Order::where('customer_id', Session::get('customer')->id)->findOrFail($id);
    }

    // Halaman pembayaran
    public function payment($id)
    {
        $order = $this->ownedOrder($id)->load('orderItems.layanan', 'orderItems.produk');
        return view('frontend.v_booking.payment', compact('order'));
    }

    /**
     * Proses pembayaran (SIMULASI). Metode: transfer bank / e-wallet / cash.
     * transfer & e-wallet langsung dianggap lunas + menghasilkan struk;
     * cash dibayar di tempat (belum lunas).
     */
    public function pay(Request $request, $id)
    {
        $order = $this->ownedOrder($id);

        $request->validate([
            'metode_bayar' => 'required|in:transfer,ewallet,cash',
            'kanal_bayar'  => 'required_unless:metode_bayar,cash|nullable|string|max:50',
        ], [
            'kanal_bayar.required_unless' => 'Silakan pilih bank / e-wallet.',
        ]);

        if ($request->metode_bayar === 'cash') {
            $order->update([
                'metode_bayar' => 'cash',
                'kanal_bayar'  => 'Bayar di Tempat',
                'status_bayar' => 'belum',
            ]);

            return redirect()->route('customer.akun')
                ->with('success', 'Pesanan dikonfirmasi. Pembayaran tunai dilakukan saat kedatangan/penerimaan.');
        }

        // Transfer / e-wallet → simpan pilihan, lalu menuju gateway mitra (simulasi).
        $order->update([
            'metode_bayar' => $request->metode_bayar,
            'kanal_bayar'  => $request->kanal_bayar,
            'status_bayar' => 'belum',
        ]);

        return redirect()->route('booking.gateway', $order->id);
    }

    // Halaman gateway mitra (simulasi pembayaran pihak ketiga)
    public function gateway($id)
    {
        $order = $this->ownedOrder($id);

        if ($order->status_bayar === 'lunas' || ! $order->metode_bayar || $order->metode_bayar === 'cash') {
            return redirect()->route('booking.payment', $order->id);
        }

        return view('frontend.v_booking.gateway', compact('order'));
    }

    // Konfirmasi pembayaran dari gateway → tandai lunas + buat struk
    public function payConfirm($id)
    {
        $order = $this->ownedOrder($id);

        if ($order->status_bayar !== 'lunas') {
            $order->update([
                'status_bayar' => 'lunas',
                'no_ref'       => 'BF-' . now()->format('ymdHis') . '-' . strtoupper(Str::random(4)),
                'dibayar_pada' => now(),
            ]);

            $nama = optional(Session::get('customer'))->nama ?? 'Pelanggan';
            ActivityLogger::log('update', 'pembayaran', "Pelanggan {$nama} membayar pesanan #{$order->id} via {$order->kanal_bayar} (Rp " . number_format($order->total_harga, 0, ',', '.') . ')', $order);
        }

        return redirect()->route('booking.struk', $order->id)
            ->with('success', 'Pembayaran berhasil! Berikut struk pembayaran Anda.');
    }

    // Struk / bukti pembayaran
    public function struk($id)
    {
        $order = $this->ownedOrder($id)->load('orderItems.layanan', 'orderItems.produk', 'customer');
        return view('frontend.v_booking.struk', compact('order'));
    }

    // Beli produk → buat order jenis 'produk' lalu menuju pembayaran
    public function buyProduk(Request $request, $id)
    {
        $produk = Produk::where('status', 1)->findOrFail($id);
        $qty    = max(1, (int) $request->qty);

        $order = Order::create([
            'customer_id' => Session::get('customer')->id,
            'status'      => 'confirmed',
            'jenis'       => 'produk',
            'total_harga' => $produk->harga * $qty,
        ]);

        $order->orderItems()->create([
            'produk_id' => $produk->id,
            'qty'       => $qty,
            'harga'     => $produk->harga,
        ]);

        return redirect()->route('booking.payment', $order->id)
            ->with('success', 'Produk siap dibeli. Lengkapi alamat & pembayaran.');
    }
}
