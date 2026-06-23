import 'package:flutter/material.dart';
import '../theme.dart';

/// Struk / bukti pembayaran (mengikuti tampilan struk website).
class StrukPage extends StatelessWidget {
  final Map<String, dynamic> order;
  const StrukPage({super.key, required this.order});

  String _rp(dynamic n) {
    final s = (n ?? 0).toString();
    final buf = StringBuffer();
    for (int i = 0; i < s.length; i++) {
      if (i > 0 && (s.length - i) % 3 == 0) buf.write('.');
      buf.write(s[i]);
    }
    return 'Rp $buf';
  }

  Widget _row(String a, String b) => Padding(
        padding: const EdgeInsets.only(bottom: 6),
        child: Row(mainAxisAlignment: MainAxisAlignment.spaceBetween, children: [
          Text(a, style: const TextStyle(color: Colors.grey, fontSize: 13)),
          Flexible(child: Text(b, textAlign: TextAlign.right, style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w600))),
        ]),
      );

  @override
  Widget build(BuildContext context) {
    final lunas = order['status_bayar'] == 'lunas';
    final items = (order['items'] as List?) ?? [];
    final dash = Container(height: 2, margin: const EdgeInsets.symmetric(vertical: 12), decoration: const BoxDecoration(border: Border(bottom: BorderSide(color: Color(0xFFE0E0E0), width: 2, style: BorderStyle.solid))));

    return Scaffold(
      backgroundColor: const Color(0xFFF4F4F4),
      appBar: AppBar(title: const Text('Struk Pembayaran')),
      body: Center(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(20),
          child: Container(
            constraints: const BoxConstraints(maxWidth: 420),
            padding: const EdgeInsets.all(24),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12),
              boxShadow: [BoxShadow(color: Colors.black.withValues(alpha: 0.1), blurRadius: 20, offset: const Offset(0, 8))],
            ),
            child: Column(mainAxisSize: MainAxisSize.min, children: [
              const Text.rich(TextSpan(children: [
                TextSpan(text: 'BARBER', style: TextStyle(fontWeight: FontWeight.w800, fontSize: 22)),
                TextSpan(text: 'FLOW', style: TextStyle(fontWeight: FontWeight.w800, fontSize: 22, color: AppColors.primary)),
              ])),
              const Text("Men's Grooming & Barbershop", style: TextStyle(color: Colors.grey, fontSize: 12)),
              const SizedBox(height: 8),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 4),
                decoration: BoxDecoration(
                  border: Border.all(color: lunas ? Colors.green : Colors.orange, width: 2),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Text(lunas ? '✓ LUNAS' : 'BELUM DIBAYAR',
                    style: TextStyle(color: lunas ? Colors.green : Colors.orange, fontWeight: FontWeight.bold, fontSize: 12)),
              ),
              dash,
              _row('No. Struk', order['no_ref']?.toString() ?? '—'),
              _row('Order ID', '#${order['id']}'),
              if (order['dibayar_pada'] != null) _row('Tanggal', order['dibayar_pada'].toString()),
              _row('Metode', order['kanal_bayar']?.toString() ?? (order['metode_bayar']?.toString() ?? '-')),
              if (order['tanggal_booking'] != null)
                _row('Jadwal', '${order['tanggal_booking']} ${order['jam_booking'] ?? ''}'),
              dash,
              ...items.map((it) => Padding(
                    padding: const EdgeInsets.only(bottom: 6),
                    child: Row(mainAxisAlignment: MainAxisAlignment.spaceBetween, children: [
                      Flexible(child: Text('${it['nama']} x${it['qty']}', style: const TextStyle(fontSize: 13))),
                      Text(_rp(it['harga'] * it['qty']), style: const TextStyle(fontSize: 13)),
                    ]),
                  )),
              dash,
              Row(mainAxisAlignment: MainAxisAlignment.spaceBetween, children: [
                const Text('TOTAL', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
                Text(_rp(order['total_harga']), style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16, color: AppColors.primary)),
              ]),
              if (order['alamat_kirim'] != null) ...[
                const SizedBox(height: 8),
                _row('Kirim ke', order['alamat_kirim'].toString()),
              ],
              const SizedBox(height: 14),
              const Text('Terima kasih telah mempercayai Barber Flow.\nTunjukkan struk ini sebagai bukti pembayaran.',
                  textAlign: TextAlign.center, style: TextStyle(color: Colors.grey, fontSize: 11)),
            ]),
          ),
        ),
      ),
    );
  }
}
