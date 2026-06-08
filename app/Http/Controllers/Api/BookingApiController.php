<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Layanan;
use Illuminate\Http\Request;

class BookingApiController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('orderItems.layanan')
            ->where('customer_id', $request->user()->id)
            ->where('status', '!=', 'pending')
            ->latest()
            ->get()
            ->map(fn ($o) => $this->format($o));

        return response()->json(['success' => true, 'data' => $orders]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_ids'     => 'required|array|min:1',
            'layanan_ids.*'   => 'integer|exists:layanans,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_booking'     => 'required',
            'catatan'         => 'nullable|string|max:500',
        ]);

        $order = Order::create([
            'customer_id'     => $request->user()->id,
            'status'          => 'confirmed',
            'tanggal_booking' => $request->tanggal_booking,
            'jam_booking'     => $request->jam_booking,
            'catatan'         => $request->catatan,
            'total_harga'     => 0,
        ]);

        $total = 0;
        foreach ($request->layanan_ids as $id) {
            $l = Layanan::find($id);
            $order->orderItems()->create([
                'layanan_id' => $l->id,
                'qty'        => 1,
                'harga'      => $l->harga,
            ]);
            $total += $l->harga;
        }
        $order->update(['total_harga' => $total]);

        return response()->json([
            'success' => true,
            'data'    => $this->format($order->load('orderItems.layanan')),
            'message' => 'Booking berhasil dibuat',
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $order = Order::with('orderItems.layanan')
            ->where('customer_id', $request->user()->id)
            ->find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $this->format($order)]);
    }

    public function pay(Request $request, $id)
    {
        $request->validate([
            'metode_bayar' => 'required|in:transfer,cash,ewallet',
            'kanal_bayar'  => 'nullable|string|max:50',
        ]);

        $order = Order::where('customer_id', $request->user()->id)->find($id);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan'], 404);
        }

        if ($request->metode_bayar === 'cash') {
            // Bayar di tempat.
            $order->update([
                'metode_bayar' => 'cash',
                'kanal_bayar'  => 'Bayar di Tempat',
                'status_bayar' => 'belum',
            ]);
        } else {
            // Simulasi gateway berhasil → langsung lunas + nomor referensi (struk).
            $order->update([
                'metode_bayar' => $request->metode_bayar,
                'kanal_bayar'  => $request->kanal_bayar,
                'status_bayar' => 'lunas',
                'no_ref'       => 'BF-' . now()->format('ymdHis') . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
                'dibayar_pada' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'id'                 => $order->id,
                'metode_bayar'       => $order->metode_bayar,
                'kanal_bayar'        => $order->kanal_bayar,
                'no_ref'             => $order->no_ref,
                'total_harga'        => (int) $order->total_harga,
                'status_bayar'       => $order->status_bayar,
                'status_bayar_label' => $order->status_bayar_label,
            ],
            'message' => 'Pembayaran tercatat',
        ]);
    }

    private function format(Order $o): array
    {
        return [
            'id'              => $o->id,
            'status'          => $o->status,
            'status_label'    => $o->status_label,
            'tanggal_booking' => $o->tanggal_booking?->toDateString(),
            'jam_booking'     => $o->jam_booking ? \Carbon\Carbon::parse($o->jam_booking)->format('H:i') : null,
            'total_harga'     => (int) $o->total_harga,
            'catatan'         => $o->catatan,
            'items'           => $o->orderItems->map(fn ($i) => [
                'layanan' => $i->layanan->nama_layanan ?? 'Layanan',
                'qty'     => $i->qty,
                'harga'   => (int) $i->harga,
            ]),
        ];
    }
}
