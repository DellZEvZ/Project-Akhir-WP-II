import 'package:flutter/material.dart';
import '../theme.dart';
import '../data/paket_data.dart';
import '../widgets/foto.dart';
import 'detail_layanan.dart';

/// Halaman Beranda — menampilkan paket unggulan dalam GridView.
class BerandaPage extends StatelessWidget {
  const BerandaPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('BARBER FLOW'),
        automaticallyImplyLeading: false,
      ),
      body: ListView(
        children: [
          // Banner
          Stack(
            children: [
              const Foto(
                url: 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?auto=format&fit=crop&w=900&q=80',
                height: 180,
              ),
              Container(height: 180, color: Colors.black.withValues(alpha: 0.45)),
              const Positioned(
                left: 20,
                bottom: 24,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text('Tampil Rapi & Bergaya',
                        style: TextStyle(color: Colors.white, fontSize: 22, fontWeight: FontWeight.bold)),
                    SizedBox(height: 4),
                    Text('Paket grooming terbaik untuk pria',
                        style: TextStyle(color: AppColors.goldLight, fontSize: 13)),
                  ],
                ),
              ),
            ],
          ),
          const Padding(
            padding: EdgeInsets.fromLTRB(16, 20, 16, 8),
            child: Text('Paket Unggulan',
                style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
          ),
          GridView.builder(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            padding: const EdgeInsets.all(12),
            itemCount: paketData.length,
            gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
              crossAxisCount: 2,
              crossAxisSpacing: 12,
              mainAxisSpacing: 12,
              mainAxisExtent: 230,
            ),
            itemBuilder: (context, index) {
              final paket = paketData[index];
              return _PaketCard(paket: paket);
            },
          ),
        ],
      ),
    );
  }
}

class _PaketCard extends StatelessWidget {
  final Map<String, dynamic> paket;
  const _PaketCard({required this.paket});

  @override
  Widget build(BuildContext context) {
    return Card(
      clipBehavior: Clip.antiAlias,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      elevation: 3,
      child: InkWell(
        onTap: () => Navigator.push(
          context,
          MaterialPageRoute(builder: (_) => DetailLayanan(layanan: paket)),
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Foto(url: paket['gambar'], height: 110, fallbackIcon: Icons.spa),
            Padding(
              padding: const EdgeInsets.all(8),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(paket['nama'],
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                      style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 13)),
                  const SizedBox(height: 2),
                  Text('Rp ${paket['harga']}',
                      style: const TextStyle(color: AppColors.gold, fontWeight: FontWeight.bold)),
                  const SizedBox(height: 2),
                  Text('${paket['durasi']} menit',
                      style: const TextStyle(color: Colors.grey, fontSize: 11)),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
