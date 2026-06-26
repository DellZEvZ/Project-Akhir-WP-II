<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Hanya order yang sudah dikonfirmasi customer (bukan keranjang 'pending')
        $query = Order::with(['customer', 'orderItems.layanan', 'orderItems.produk'])
            ->where('status', '!=', 'pending');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        // Statistik ringkas
        $stats = [
            'confirmed'  => Order::where('status', 'confirmed')->count(),
            'done'       => Order::where('status', 'done')->count(),
            'verifikasi' => Order::where('status_bayar', 'menunggu_verifikasi')->count(),
            'pendapatan' => Order::where('status_bayar', 'lunas')->get()->sum(fn ($o) => $o->total_akhir),
        ];

        return view('backend.v_order.index', [
            'judul'  => 'Manajemen Pesanan',
            'orders' => $orders,
            'stats'  => $stats,
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'orderItems.layanan', 'orderItems.produk']);

        return view('backend.v_order.show', [
            'judul' => 'Detail Pesanan',
            'order' => $order,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,done,batal',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan #' . $order->id . ' diperbarui menjadi "' . $order->status_label . '".');
    }

    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate(['aksi' => 'required|in:lunas,tolak']);

        if ($request->aksi === 'lunas') {
            $order->update(['status_bayar' => 'lunas']);
            $msg = 'Pembayaran pesanan #' . $order->id . ' diverifikasi LUNAS.';
        } else {
            $order->update(['status_bayar' => 'belum']);
            $msg = 'Pembayaran pesanan #' . $order->id . ' ditolak. Customer diminta bayar ulang.';
        }

        return back()->with('success', $msg);
    }
}
