import 'package:flutter/material.dart';
import 'payment_page.dart';

/// Halaman ringkasan pemesanan (menerima data dari form via constructor).
class BookingSummary extends StatelessWidget {
  final Map<String, dynamic> layanan;
  final String nama;
  final String hp;
  final DateTime tanggal;
  final TimeOfDay jam;
  final String catatan;
  final int? orderId; // tidak null jika booking tersimpan di server

  const BookingSummary({
    super.key,
    required this.layanan,
    required this.nama,
    required this.hp,
    required this.tanggal,
    required this.jam,
    required this.catatan,
    this.orderId,
  });

  Widget _row(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 6),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 110,
            child: Text(label, style: const TextStyle(color: Colors.grey, fontSize: 13)),
          ),
          Expanded(
            child: Text(value,
                style: const TextStyle(fontWeight: FontWeight.w500, fontSize: 14)),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Ringkasan Booking')),
      body: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          const Center(
            child: Icon(Icons.check_circle, color: Colors.green, size: 80),
          ),
          const SizedBox(height: 8),
          const Center(
            child: Text('Booking Berhasil!',
                style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold)),
          ),
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
                  const Text('Detail Pesanan',
                      style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                  const Divider(),
                  _row('Layanan', layanan['nama']),
                  _row('Harga', 'Rp ${layanan['harga']}'),
                  _row('Durasi', '${layanan['durasi']} menit'),
                  const Divider(),
                  _row('Nama', nama),
                  _row('No. HP', hp),
                  _row('Tanggal', '${tanggal.day}/${tanggal.month}/${tanggal.year}'),
                  _row('Jam', jam.format(context)),
                  _row('Catatan', catatan.isEmpty ? '-' : catatan),
                ],
              ),
            ),
          ),
          const SizedBox(height: 24),
          if (orderId != null)
            ElevatedButton.icon(
              onPressed: () => Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (_) => PaymentPage(
                    orderId: orderId!,
                    total: (layanan['harga'] is int)
                        ? layanan['harga'] as int
                        : int.tryParse('${layanan['harga']}') ?? 0,
                    namaLayanan: layanan['nama'].toString(),
                  ),
                ),
              ),
              icon: const Icon(Icons.payment),
              label: const Text('LANJUT KE PEMBAYARAN'),
            ),
          if (orderId != null) const SizedBox(height: 10),
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
