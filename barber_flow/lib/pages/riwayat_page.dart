import 'package:flutter/material.dart';
import '../theme.dart';
import '../services/booking_service.dart';
import 'struk_page.dart';
import 'payment_page.dart';

/// Riwayat pesanan (booking & produk) — mengikuti riwayat akun website.
class RiwayatPage extends StatefulWidget {
  const RiwayatPage({super.key});

  @override
  State<RiwayatPage> createState() => _RiwayatPageState();
}

class _RiwayatPageState extends State<RiwayatPage> {
  late Future<List<Map<String, dynamic>>> _future;

  @override
  void initState() {
    super.initState();
    _future = BookingService.fetchOrders();
  }

  Future<void> _refresh() async {
    setState(() => _future = BookingService.fetchOrders());
    await _future;
  }

  String _rp(dynamic n) {
    final s = (n ?? 0).toString();
    final buf = StringBuffer();
    for (int i = 0; i < s.length; i++) {
      if (i > 0 && (s.length - i) % 3 == 0) buf.write('.');
      buf.write(s[i]);
    }
    return 'Rp $buf';
  }

  Widget _badge(String text, Color color) => Container(
        margin: const EdgeInsets.only(right: 6, top: 4),
        padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
        decoration: BoxDecoration(color: color.withValues(alpha: 0.15), borderRadius: BorderRadius.circular(20)),
        child: Text(text, style: TextStyle(color: color, fontSize: 11, fontWeight: FontWeight.bold)),
      );

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Riwayat Pesanan')),
      body: FutureBuilder<List<Map<String, dynamic>>>(
        future: _future,
        builder: (context, snap) {
          if (snap.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator(color: AppColors.gold));
          }
          if (snap.hasError) {
            return Center(child: Text('Gagal memuat: ${snap.error}'));
          }
          final orders = snap.data ?? [];
          if (orders.isEmpty) {
            return const Center(
              child: Column(mainAxisSize: MainAxisSize.min, children: [
                Icon(Icons.receipt_long, size: 56, color: Colors.grey),
                SizedBox(height: 8),
                Text('Belum ada riwayat pesanan.', style: TextStyle(color: Colors.grey)),
              ]),
            );
          }
          return RefreshIndicator(
            onRefresh: _refresh,
            child: ListView.builder(
              padding: const EdgeInsets.all(16),
              itemCount: orders.length,
              itemBuilder: (context, i) {
                final o = orders[i];
                final lunas = o['status_bayar'] == 'lunas';
                final belum = o['status_bayar'] == 'belum';
                final isProduk = o['jenis'] == 'produk';
                final items = (o['items'] as List?) ?? [];
                final namaPertama = items.isNotEmpty ? items.first['nama'].toString() : 'Pesanan';

                return Card(
                  margin: const EdgeInsets.only(bottom: 12),
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                  child: Padding(
                    padding: const EdgeInsets.all(14),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Text('${isProduk ? 'Pesanan' : 'Booking'} #${o['id']}',
                                style: const TextStyle(fontWeight: FontWeight.bold)),
                            Text(_rp(o['total_harga']),
                                style: const TextStyle(color: AppColors.gold, fontWeight: FontWeight.bold)),
                          ],
                        ),
                        Wrap(children: [
                          _badge(o['status_label']?.toString() ?? '-', o['status'] == 'done' ? Colors.green : Colors.blueGrey),
                          _badge(o['status_bayar_label']?.toString() ?? '-', lunas ? Colors.green : (belum ? Colors.red : Colors.orange)),
                        ]),
                        if (o['tanggal_booking'] != null)
                          Padding(
                            padding: const EdgeInsets.only(top: 6),
                            child: Text('📅 ${o['tanggal_booking']}   🕒 ${o['jam_booking'] ?? '-'} WIB',
                                style: const TextStyle(fontSize: 12, color: Colors.grey)),
                          ),
                        const SizedBox(height: 6),
                        ...items.map((it) => Text('• ${it['nama']} (${it['qty']}x)  ${_rp(it['harga'])}',
                            style: const TextStyle(fontSize: 13))),
                        const SizedBox(height: 8),
                        Row(children: [
                          if (lunas)
                            OutlinedButton.icon(
                              onPressed: () => Navigator.push(context, MaterialPageRoute(builder: (_) => StrukPage(order: o))),
                              icon: const Icon(Icons.receipt, size: 18),
                              label: const Text('Lihat Struk'),
                            ),
                          if (belum && o['metode_bayar'] != 'cash')
                            ElevatedButton.icon(
                              onPressed: () => Navigator.push(
                                context,
                                MaterialPageRoute(
                                  builder: (_) => PaymentPage(
                                    orderId: o['id'] as int,
                                    total: o['total_harga'] as int,
                                    namaLayanan: namaPertama,
                                  ),
                                ),
                              ).then((_) => _refresh()),
                              icon: const Icon(Icons.credit_card, size: 18),
                              label: const Text('Bayar Sekarang'),
                            ),
                        ]),
                      ],
                    ),
                  ),
                );
              },
            ),
          );
        },
      ),
    );
  }
}
