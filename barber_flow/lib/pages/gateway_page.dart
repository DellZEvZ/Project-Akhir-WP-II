import 'package:flutter/material.dart';
import '../theme.dart';
import '../services/api_service.dart';
import '../services/booking_service.dart';

/// Simulasi halaman gateway pembayaran mitra (bank / e-wallet).
class GatewayPage extends StatefulWidget {
  final int orderId;
  final int total;
  final String metode; // transfer | ewallet
  final String kanal; // BCA, OVO, dst.

  const GatewayPage({
    super.key,
    required this.orderId,
    required this.total,
    required this.metode,
    required this.kanal,
  });

  @override
  State<GatewayPage> createState() => _GatewayPageState();
}

class _GatewayPageState extends State<GatewayPage> {
  bool _loading = false;

  String get _slug => widget.kanal.toLowerCase().replaceAll(' ', '');
  bool get _isBank => widget.metode == 'transfer';
  String get _va => '8${widget.orderId.toString().padLeft(4, '0')} 1234 ${(widget.orderId * 7 % 10000).toString().padLeft(4, '0')}';

  Future<void> _bayar() async {
    setState(() => _loading = true);
    try {
      final res = await BookingService.payBooking(widget.orderId, widget.metode, kanal: widget.kanal);
      if (!mounted) return;
      setState(() => _loading = false);
      await showDialog(
        context: context,
        barrierDismissible: false,
        builder: (_) => AlertDialog(
          icon: const Icon(Icons.check_circle, color: Colors.green, size: 52),
          title: const Text('Pembayaran Berhasil'),
          content: Text(
            'Status: LUNAS\nNo. Ref: ${res['no_ref'] ?? '-'}\nVia: ${widget.kanal}',
            textAlign: TextAlign.center,
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.popUntil(context, (r) => r.isFirst),
              child: const Text('SELESAI'),
            ),
          ],
        ),
      );
    } catch (e) {
      if (!mounted) return;
      setState(() => _loading = false);
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Gagal: $e'), backgroundColor: Colors.red),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFECECED),
      appBar: AppBar(title: const Text('Gateway Pembayaran')),
      body: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          Card(
            clipBehavior: Clip.antiAlias,
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
            child: Column(
              children: [
                // Header mitra
                Container(
                  width: double.infinity,
                  padding: const EdgeInsets.all(20),
                  color: _isBank ? const Color(0xFF0B1F3A) : const Color(0xFF2D1B4E),
                  child: Column(children: [
                    Container(
                      height: 44,
                      padding: const EdgeInsets.symmetric(horizontal: 10),
                      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(8)),
                      child: Image.network(
                        '${ApiService.host}/image/icon/$_slug.png',
                        fit: BoxFit.contain,
                        errorBuilder: (_, __, ___) => Center(
                          child: Text(widget.kanal,
                              style: const TextStyle(fontWeight: FontWeight.w800, color: AppColors.dark)),
                        ),
                      ),
                    ),
                    const SizedBox(height: 8),
                    Text('${_isBank ? 'Virtual Account' : 'E-Wallet'} · ${widget.kanal}',
                        style: const TextStyle(color: Colors.white70, fontSize: 12)),
                  ]),
                ),
                Padding(
                  padding: const EdgeInsets.all(16),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.stretch,
                    children: [
                      Row(mainAxisAlignment: MainAxisAlignment.spaceBetween, children: const [
                        Text('Bayar ke', style: TextStyle(color: Colors.grey)),
                        Text('Barber Flow', style: TextStyle(fontWeight: FontWeight.bold)),
                      ]),
                      const SizedBox(height: 12),
                      Container(
                        padding: const EdgeInsets.all(14),
                        decoration: BoxDecoration(color: const Color(0xFFF6F6F6), borderRadius: BorderRadius.circular(10)),
                        child: Column(children: [
                          const Text('Total Pembayaran', style: TextStyle(color: Colors.grey, fontSize: 12)),
                          Text('Rp ${widget.total}',
                              style: const TextStyle(color: AppColors.gold, fontSize: 26, fontWeight: FontWeight.bold)),
                        ]),
                      ),
                      const SizedBox(height: 14),
                      Text(_isBank ? 'Nomor Virtual Account' : 'Nomor ${widget.kanal} terdaftar',
                          style: const TextStyle(color: Colors.grey, fontSize: 12)),
                      const SizedBox(height: 4),
                      Container(
                        padding: const EdgeInsets.all(12),
                        decoration: BoxDecoration(border: Border.all(color: Colors.grey.shade300), borderRadius: BorderRadius.circular(8)),
                        child: Text(_isBank ? _va : '0812-3456-7890  ·  Barber Flow',
                            style: const TextStyle(fontWeight: FontWeight.bold, letterSpacing: 1)),
                      ),
                      const SizedBox(height: 16),
                      ElevatedButton.icon(
                        onPressed: _loading ? null : _bayar,
                        icon: _loading
                            ? const SizedBox(width: 18, height: 18, child: CircularProgressIndicator(strokeWidth: 2))
                            : const Icon(Icons.check_circle),
                        label: Text(_loading ? 'MEMPROSES...' : 'BAYAR SEKARANG'),
                      ),
                      const SizedBox(height: 10),
                      const Text(
                        'Halaman ini hanya simulasi gateway pembayaran. Tidak ada transaksi nyata.',
                        textAlign: TextAlign.center,
                        style: TextStyle(color: Colors.grey, fontSize: 11),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
