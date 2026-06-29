import 'package:flutter/material.dart';
import 'payment_page.dart';

/// Ringkasan pesanan PRODUK setelah berhasil dibuat di server.
/// [order] adalah hasil format() dari BookingApiController (sudah berisi
/// total_akhir, biaya_ongkir, dst).
class BookingSummaryProduk extends StatelessWidget {
  final Map<String, dynamic> order;
  const BookingSummaryProduk({super.key, required this.order});

  Widget _row(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 6),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(width: 110, child: Text(label, style: const TextStyle(color: Colors.grey, fontSize: 13))),
          Expanded(child: Text(value, style: const TextStyle(fontWeight: FontWeight.w500, fontSize: 14))),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final items = (order['items'] as List?) ?? [];
    final totalAkhir = order['total_akhir'] ?? order['total_harga'] ?? 0;

    return Scaffold(
      appBar: AppBar(title: const Text('Ringkasan Pesanan')),
      body: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          const Center(child: Icon(Icons.check_circle, color: Colors.green, size: 80)),
          const SizedBox(height: 8),
          const Center(child: Text('Pesanan Berhasil!', style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold))),
          const Center(
            child: Text('Pesanan Anda telah tersimpan di sistem kami',
                style: TextStyle(color: Colors.grey, fontSize: 12)),
          ),
          const SizedBox(height: 24),
          Card(
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text('Detail Pesanan', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                  const Divider(),
                  ...items.map((i) => _row('${i['nama']} x${i['qty']}', 'Rp ${i['harga']}')),
                  const Divider(),
                  _row('Alamat', '${order['alamat_kirim'] ?? '-'}'),
                  _row('Tujuan', '${order['kota_tujuan_label'] ?? '-'}'),
                  _row('Kurir', '${order['kurir'] ?? '-'} ${order['layanan_ongkir'] ?? ''}'),
                  _row('Ongkos Kirim', 'Rp ${order['biaya_ongkir'] ?? 0}'),
                  const Divider(),
                  _row('Total Bayar', 'Rp $totalAkhir'),
                ],
              ),
            ),
          ),
          const SizedBox(height: 24),
          ElevatedButton.icon(
            onPressed: () => Navigator.push(
              context,
              MaterialPageRoute(
                builder: (_) => PaymentPage(
                  orderId: order['id'] as int,
                  total: totalAkhir is int ? totalAkhir : int.tryParse('$totalAkhir') ?? 0,
                  namaLayanan: 'Pesanan Produk #${order['id']}',
                ),
              ),
            ),
            icon: const Icon(Icons.payment),
            label: const Text('LANJUT KE PEMBAYARAN'),
          ),
          const SizedBox(height: 10),
          OutlinedButton.icon(
            onPressed: () => Navigator.popUntil(context, (route) => route.isFirst),
            icon: const Icon(Icons.home),
            label: const Text('KEMBALI KE BERANDA'),
          ),
        ],
      ),
    );
  }
}
