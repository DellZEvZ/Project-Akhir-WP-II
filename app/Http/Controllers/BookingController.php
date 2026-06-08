<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Layanan;
use App\Models\Produk;
use App\Models\Order;
use App\Models\OrderItem;

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

        if ($order->orderItems->isEmpty()) {
            return redirect()->route('booking.cart')->with('error', 'Keranjang masih kosong.');
        }

        return view('frontend.v_booking.checkout', compact('order'));
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
        }
        if ($order->has_produk) {
            $rules['alamat_kirim'] = 'required|string|max:500';
        }

        $request->validate($rules, $messages);

        // Cegah tabrakan jadwal dengan booking pelanggan lain.
        if ($order->has_layanan && $this->slotTaken($request->tanggal_booking, $request->jam_booking, $order->id)) {
            return back()->withInput()->with('error',
                'Maaf, jadwal ' . $request->tanggal_booking . ' jam ' . $request->jam_booking .
                ' sudah dibooking pelanggan lain. Silakan pilih jam lain.');
        }

        $order->update([
            'status'          => 'confirmed',
            'jenis'           => $order->has_layanan ? 'booking' : 'produk',
            'tanggal_booking' => $request->tanggal_booking,
            'jam_booking'     => $request->jam_booking,
            'alamat_kirim'    => $request->alamat_kirim,
            'catatan'         => $request->catatan,
        ]);

        return redirect()->route('booking.payment', $order->id)
            ->with('success', 'Pesanan dikonfirmasi! Silakan selesaikan pembayaran.');
    }

    /** Cek apakah slot (tanggal+jam) sudah dipakai booking aktif lain. */
    private function slotTaken($tanggal, $jam, $excludeOrderId): bool
    {
        return Order::where('jenis', 'booking')
            ->whereIn('status', ['confirmed', 'done'])
            ->where('tanggal_booking', $tanggal)
            ->where('jam_booking', $jam)
            ->where('id', '!=', $excludeOrderId)
            ->exists();
    }

    /** Daftar jam penuh pada tanggal tertentu (JSON, untuk checkout). */
    public function slots(Request $request)
    {
        $taken = Order::where('jenis', 'booking')
            ->whereIn('status', ['confirmed', 'done'])
            ->whereDate('tanggal_booking', $request->get('tanggal'))
            ->get()
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

        // Hanya valid bila metode online sudah dipilih & belum lunas.
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
