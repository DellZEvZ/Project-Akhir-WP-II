import 'package:flutter/material.dart';
import '../theme.dart';
import '../services/booking_service.dart';

/// Halaman pembayaran untuk booking yang sudah tersimpan di server.
class PaymentPage extends StatefulWidget {
  final int orderId;
  final int total;
  final String namaLayanan;

  const PaymentPage({
    super.key,
    required this.orderId,
    required this.total,
    required this.namaLayanan,
  });

  @override
  State<PaymentPage> createState() => _PaymentPageState();
}

class _PaymentPageState extends State<PaymentPage> {
  String _metode = 'transfer';
  bool _loading = false;
  String? _statusLabel;

  final _metodeList = const [
    {'value': 'transfer', 'label': 'Transfer Bank', 'icon': Icons.account_balance},
    {'value': 'ewallet', 'label': 'E-Wallet (OVO / GoPay / Dana)', 'icon': Icons.account_balance_wallet},
    {'value': 'cash', 'label': 'Bayar di Tempat (Cash)', 'icon': Icons.payments},
  ];

  Future<void> _bayar() async {
    setState(() => _loading = true);
    try {
      final res = await BookingService.payBooking(widget.orderId, _metode);
      if (!mounted) return;
      setState(() {
        _loading = false;
        _statusLabel = res['status_bayar_label']?.toString() ?? 'Tercatat';
      });
      showDialog(
        context: context,
        builder: (_) => AlertDialog(
          icon: const Icon(Icons.check_circle, color: Colors.green, size: 48),
          title: const Text('Pembayaran Tercatat'),
          content: Text('Status: $_statusLabel\n\n'
              '${_metode == 'cash' ? 'Silakan bayar di tempat saat kedatangan.' : 'Menunggu verifikasi admin setelah transfer.'}'),
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
      appBar: AppBar(title: const Text('Pembayaran')),
      body: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: AppColors.dark,
              borderRadius: BorderRadius.circular(10),
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(widget.namaLayanan,
                    style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 16)),
                const SizedBox(height: 6),
                Text('Total: Rp ${widget.total}',
                    style: const TextStyle(color: AppColors.goldLight, fontSize: 18, fontWeight: FontWeight.bold)),
              ],
            ),
          ),
          const SizedBox(height: 20),
          const Text('Pilih Metode Pembayaran',
              style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15)),
          const SizedBox(height: 8),
          ..._metodeList.map((m) {
            final value = m['value'] as String;
            final selected = _metode == value;
            return Card(
              color: selected ? AppColors.gold.withValues(alpha: 0.15) : null,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8),
                side: BorderSide(
                  color: selected ? AppColors.gold : Colors.grey.shade300,
                  width: selected ? 2 : 1,
                ),
              ),
              child: ListTile(
                onTap: () => setState(() => _metode = value),
                leading: Icon(m['icon'] as IconData, color: AppColors.gold),
                title: Text(m['label'] as String),
                trailing: Icon(
                  selected ? Icons.radio_button_checked : Icons.radio_button_unchecked,
                  color: selected ? AppColors.gold : Colors.grey,
                ),
              ),
            );
          }),
          const SizedBox(height: 10),
          if (_metode != 'cash')
            Container(
              padding: const EdgeInsets.all(14),
              decoration: BoxDecoration(
                color: Colors.amber.shade50,
                borderRadius: BorderRadius.circular(8),
                border: Border.all(color: Colors.amber.shade200),
              ),
              child: Text(
                _metode == 'transfer'
                    ? 'Transfer ke:\nBCA 1234567890 a.n. Barber Flow\nMandiri 0980980980 a.n. Barber Flow'
                    : 'E-Wallet:\nOVO / GoPay / Dana: 0812-3456-7890 (Barber Flow)',
                style: const TextStyle(fontSize: 13, height: 1.5),
              ),
            )
          else
            Container(
              padding: const EdgeInsets.all(14),
              decoration: BoxDecoration(
                color: Colors.blue.shade50,
                borderRadius: BorderRadius.circular(8),
              ),
              child: const Text('Pembayaran dilakukan langsung di tempat saat kedatangan.',
                  style: TextStyle(fontSize: 13)),
            ),
          const SizedBox(height: 24),
          ElevatedButton.icon(
            onPressed: _loading ? null : _bayar,
            icon: _loading
                ? const SizedBox(width: 18, height: 18, child: CircularProgressIndicator(strokeWidth: 2))
                : const Icon(Icons.check_circle),
            label: Text(_loading ? 'MEMPROSES...' : 'KONFIRMASI PEMBAYARAN'),
          ),
        ],
      ),
    );
  }
}
