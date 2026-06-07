<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Layanan;
use App\Models\Produk;
use App\Models\Order;
use App\Models\OrderItem;
use App\Helpers\ImageHelper;

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

    // Tampilkan keranjang booking
    public function cart()
    {
        $order = $this->getCart()->load('orderItems.layanan');
        return view('frontend.v_booking.cart', compact('order'));
    }

    // Tambah layanan ke keranjang
    public function add($id)
    {
        $layanan = Layanan::where('status', 'aktif')->findOrFail($id);
        $order   = $this->getCart();

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

        return redirect()->route('booking.cart')
            ->with('success', 'Layanan "' . $layanan->nama_layanan . '" ditambahkan ke booking.');
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
    public function remove($itemId)
    {
        $order = $this->getCart();
        $order->orderItems()->where('id', $itemId)->delete();

        $this->recalcTotal($order);

        return redirect()->route('booking.cart')->with('success', 'Item dihapus dari booking.');
    }

    // Halaman checkout
    public function checkout()
    {
        $order = $this->getCart()->load('orderItems.layanan');

        if ($order->orderItems->isEmpty()) {
            return redirect()->route('booking.cart')->with('error', 'Keranjang booking masih kosong.');
        }

        return view('frontend.v_booking.checkout', compact('order'));
    }

    // Konfirmasi booking
    public function confirm(Request $request)
    {
        $request->validate([
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_booking'     => 'required',
            'catatan'         => 'nullable|string|max:500',
        ], [
            'tanggal_booking.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu.',
        ]);

        $order = $this->getCart();

        if ($order->orderItems()->count() === 0) {
            return redirect()->route('booking.cart')->with('error', 'Keranjang booking masih kosong.');
        }

        $order->update([
            'status'          => 'confirmed',
            'tanggal_booking' => $request->tanggal_booking,
            'jam_booking'     => $request->jam_booking,
            'catatan'         => $request->catatan,
        ]);

        return redirect()->route('booking.payment', $order->id)
            ->with('success', 'Booking dibuat! Silakan selesaikan pembayaran.');
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

    // Proses pembayaran (pilih metode + upload bukti bila transfer)
    public function pay(Request $request, $id)
    {
        $order = $this->ownedOrder($id);

        $request->validate([
            'metode_bayar' => 'required|in:transfer,cash,ewallet',
            'bukti'        => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $data = ['metode_bayar' => $request->metode_bayar];

        if ($request->metode_bayar === 'cash') {
            // Bayar di tempat → langsung tercatat, verifikasi saat kedatangan.
            $data['status_bayar'] = 'belum';
        } else {
            // Transfer / e-wallet → butuh bukti, lalu menunggu verifikasi admin.
            if ($request->hasFile('bukti')) {
                $file     = $request->file('bukti');
                $fileName = 'bukti_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                ImageHelper::storeImage($file, 'img-bukti', $fileName);
                $data['bukti_bayar']  = $fileName;
                $data['status_bayar'] = 'menunggu_verifikasi';
            } else {
                return back()->with('error', 'Silakan unggah bukti pembayaran untuk metode transfer / e-wallet.');
            }
        }

        // Untuk order produk, alamat pengiriman wajib diisi.
        if ($order->jenis === 'produk') {
            $request->validate(['alamat_kirim' => 'required|string|max:500']);
            $data['alamat_kirim'] = $request->alamat_kirim;
        }

        $order->update($data);

        return redirect()->route('customer.akun')
            ->with('success', 'Pembayaran tercatat. Status: ' . $order->fresh()->status_bayar_label . '.');
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
