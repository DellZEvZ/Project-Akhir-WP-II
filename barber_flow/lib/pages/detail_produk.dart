import 'package:flutter/material.dart';
import '../theme.dart';
import '../widgets/foto.dart';

/// Halaman detail produk. Data diterima via constructor.
class DetailProduk extends StatelessWidget {
  final Map<String, dynamic> produk;
  const DetailProduk({super.key, required this.produk});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text(produk['nama'])),
      body: ListView(
        children: [
          Foto(url: produk['gambar'], height: 240, fallbackIcon: Icons.shopping_bag),
          Padding(
            padding: const EdgeInsets.all(20),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Chip(
                  label: Text(produk['kategori']?.toString() ?? 'Produk', style: const TextStyle(fontSize: 11)),
                  backgroundColor: AppColors.dark,
                  labelStyle: const TextStyle(color: AppColors.primary),
                  visualDensity: VisualDensity.compact,
                ),
                const SizedBox(height: 10),
                Text(produk['nama'],
                    style: const TextStyle(fontSize: 22, fontWeight: FontWeight.bold)),
                const SizedBox(height: 8),
                Text('Rp ${produk['harga']}',
                    style: const TextStyle(
                        color: AppColors.primary, fontSize: 22, fontWeight: FontWeight.bold)),
                const Divider(height: 30),
                const Text('Deskripsi',
                    style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                const SizedBox(height: 6),
                Text(produk['deskripsi'],
                    style: const TextStyle(fontSize: 14, height: 1.6, color: Colors.black87)),
                const SizedBox(height: 30),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton.icon(
                    onPressed: () {
                      ScaffoldMessenger.of(context).showSnackBar(
                        const SnackBar(
                          backgroundColor: AppColors.dark,
                          content: Text('Produk ditambahkan ke keranjang (simulasi).'),
                        ),
                      );
                    },
                    icon: const Icon(Icons.add_shopping_cart),
                    label: const Text('Tambah ke Keranjang'),
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
