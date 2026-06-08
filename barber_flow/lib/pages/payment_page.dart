import 'package:flutter/material.dart';
import '../theme.dart';
import '../services/api_service.dart';
import '../services/booking_service.dart';
import 'gateway_page.dart';

/// Halaman pilih metode + kanal pembayaran. Online → gateway simulasi,
/// cash → langsung tercatat.
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
  String _kanal = 'BCA';
  bool _loading = false;

  static const _bank = [['BCA', 'bca'], ['BNI', 'bni'], ['Mandiri', 'mandiri'], ['BRI', 'bri']];
  static const _ewallet = [['OVO', 'ovo'], ['DANA', 'dana'], ['GoPay', 'gopay'], ['ShopeePay', 'shopeepay']];

  List<List<String>> get _channels => _metode == 'transfer' ? _bank : (_metode == 'ewallet' ? _ewallet : const []);

  void _setMetode(String m) {
    setState(() {
      _metode = m;
      if (_channels.isNotEmpty) _kanal = _channels.first.first;
    });
  }

  Future<void> _lanjut() async {
    if (_metode == 'cash') {
      setState(() => _loading = true);
      try {
        await BookingService.payBooking(widget.orderId, 'cash');
        if (!mounted) return;
        setState(() => _loading = false);
        await showDialog(
          context: context,
          builder: (_) => AlertDialog(
            icon: const Icon(Icons.store, color: AppColors.gold, size: 48),
            title: const Text('Pesanan Dikonfirmasi'),
            content: const Text('Pembayaran tunai dilakukan saat kedatangan / penerimaan.'),
            actions: [
              TextButton(onPressed: () => Navigator.popUntil(context, (r) => r.isFirst), child: const Text('SELESAI')),
            ],
          ),
        );
      } catch (e) {
        if (!mounted) return;
        setState(() => _loading = false);
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('Gagal: $e'), backgroundColor: Colors.red));
      }
      return;
    }

    // Online → gateway simulasi
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) => GatewayPage(orderId: widget.orderId, total: widget.total, metode: _metode, kanal: _kanal),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final metodeList = const [
      {'value': 'transfer', 'label': 'Transfer Bank', 'icon': Icons.account_balance},
      {'value': 'ewallet', 'label': 'E-Wallet', 'icon': Icons.account_balance_wallet},
      {'value': 'cash', 'label': 'Bayar di Tempat', 'icon': Icons.payments},
    ];

    return Scaffold(
      appBar: AppBar(title: const Text('Pembayaran')),
      body: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(color: AppColors.dark, borderRadius: BorderRadius.circular(10)),
            child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
              Text(widget.namaLayanan, style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 16)),
              const SizedBox(height: 6),
              Text('Total: Rp ${widget.total}', style: const TextStyle(color: AppColors.goldLight, fontSize: 18, fontWeight: FontWeight.bold)),
            ]),
          ),
          const SizedBox(height: 20),
          const Text('Metode Pembayaran', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15)),
          const SizedBox(height: 8),
          ...metodeList.map((m) {
            final value = m['value'] as String;
            final selected = _metode == value;
            return Card(
              color: selected ? AppColors.gold.withValues(alpha: 0.12) : null,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8),
                side: BorderSide(color: selected ? AppColors.gold : Colors.grey.shade300, width: selected ? 2 : 1),
              ),
              child: ListTile(
                onTap: () => _setMetode(value),
                leading: Icon(m['icon'] as IconData, color: AppColors.gold),
                title: Text(m['label'] as String),
                trailing: Icon(selected ? Icons.radio_button_checked : Icons.radio_button_unchecked, color: selected ? AppColors.gold : Colors.grey),
              ),
            );
          }),
          if (_channels.isNotEmpty) ...[
            const SizedBox(height: 12),
            Text('Pilih ${_metode == 'transfer' ? 'Bank' : 'E-Wallet'}', style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 14)),
            const SizedBox(height: 8),
            ..._channels.map((c) {
              final name = c[0], slug = c[1];
              final selected = _kanal == name;
              return Card(
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(8),
                  side: BorderSide(color: selected ? AppColors.gold : Colors.grey.shade300, width: selected ? 2 : 1),
                ),
                child: ListTile(
                  onTap: () => setState(() => _kanal = name),
                  leading: _Logo(slug: slug, name: name),
                  title: Text(name),
                  trailing: Icon(selected ? Icons.radio_button_checked : Icons.radio_button_unchecked, color: selected ? AppColors.gold : Colors.grey),
                ),
              );
            }),
          ],
          const SizedBox(height: 24),
          ElevatedButton.icon(
            onPressed: _loading ? null : _lanjut,
            icon: _loading
                ? const SizedBox(width: 18, height: 18, child: CircularProgressIndicator(strokeWidth: 2))
                : Icon(_metode == 'cash' ? Icons.check_circle : Icons.arrow_forward),
            label: Text(_metode == 'cash' ? 'KONFIRMASI' : 'LANJUT KE PEMBAYARAN'),
          ),
        ],
      ),
    );
  }
}

/// Logo kanal pembayaran dari server, fallback ke teks bila gambar tak ada.
class _Logo extends StatelessWidget {
  final String slug;
  final String name;
  const _Logo({required this.slug, required this.name});

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: 46,
      height: 30,
      child: Image.network(
        '${ApiService.host}/image/icon/$slug.png',
        fit: BoxFit.contain,
        errorBuilder: (_, __, ___) => Container(
          alignment: Alignment.center,
          decoration: BoxDecoration(color: AppColors.dark, borderRadius: BorderRadius.circular(4)),
          child: Text(name.length > 4 ? name.substring(0, 4) : name,
              style: const TextStyle(color: Colors.white, fontSize: 9, fontWeight: FontWeight.bold)),
        ),
      ),
    );
  }
}
