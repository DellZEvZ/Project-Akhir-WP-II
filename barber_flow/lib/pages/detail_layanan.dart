import 'package:flutter/material.dart';
import '../theme.dart';
import '../widgets/foto.dart';
import '../widgets/tombol_pesan.dart';
import 'booking_form.dart';

/// Halaman detail layanan/paket. Data diterima via constructor.
class DetailLayanan extends StatelessWidget {
  final Map<String, dynamic> layanan;
  const DetailLayanan({super.key, required this.layanan});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text(layanan['nama'])),
      body: ListView(
        children: [
          Foto(url: layanan['gambar'], height: 240, fallbackIcon: Icons.content_cut),
          Padding(
            padding: const EdgeInsets.all(20),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(layanan['nama'],
                    style: const TextStyle(fontSize: 24, fontWeight: FontWeight.bold)),
                const SizedBox(height: 8),
                Text('Rp ${layanan['harga']}',
                    style: const TextStyle(
                        color: AppColors.primary, fontSize: 22, fontWeight: FontWeight.bold)),
                const SizedBox(height: 12),
                Row(
                  children: [
                    const Icon(Icons.access_time, size: 18, color: AppColors.dark),
                    const SizedBox(width: 6),
                    Text('Durasi: ${layanan['durasi']} menit',
                        style: const TextStyle(fontSize: 14)),
                  ],
                ),
                const Divider(height: 30),
                const Text('Deskripsi',
                    style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                const SizedBox(height: 6),
                Text(layanan['deskripsi'],
                    style: const TextStyle(fontSize: 14, height: 1.6, color: Colors.black87)),
                const SizedBox(height: 30),
                TombolPesan(
                  label: 'Pesan Sekarang',
                  onPressed: () => Navigator.push(
                    context,
                    MaterialPageRoute(builder: (_) => BookingForm(layanan: layanan)),
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
