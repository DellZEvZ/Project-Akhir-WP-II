import 'package:flutter/material.dart';
import '../theme.dart';
import '../widgets/foto.dart';
import '../services/cart_service.dart';
import 'cart_page.dart';

/// Halaman detail produk. Data diterima via constructor.
class DetailProduk extends StatefulWidget {
  final Map<String, dynamic> produk;
  const DetailProduk({super.key, required this.produk});

  @override
  State<DetailProduk> createState() => _DetailProdukState();
}

class _DetailProdukState extends State<DetailProduk> {
  int _qty = 1;

  @override
  Widget build(BuildContext context) {
    final produk = widget.produk;
    final stok = produk['stok'];
    final stokInt = stok is int ? stok : int.tryParse('$stok') ?? 0;
    final habis = stokInt <= 0;

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
                const SizedBox(height: 4),
                Text(
                  habis ? 'Stok habis' : 'Stok: $stokInt',
                  style: TextStyle(color: habis ? Colors.red : Colors.grey, fontSize: 13),
                ),
                const Divider(height: 30),
                const Text('Deskripsi',
                    style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                const SizedBox(height: 6),
                Text(produk['deskripsi']?.toString() ?? '-',
                    style: const TextStyle(fontSize: 14, height: 1.6, color: Colors.black87)),
                const SizedBox(height: 30),
                if (!habis) ...[
                  Row(
                    children: [
                      const Text('Jumlah', style: TextStyle(fontWeight: FontWeight.bold)),
                      const Spacer(),
                      IconButton(
                        onPressed: _qty > 1 ? () => setState(() => _qty--) : null,
                        icon: const Icon(Icons.remove_circle_outline),
                      ),
                      Text('$_qty', style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                      IconButton(
                        onPressed: _qty < stokInt ? () => setState(() => _qty++) : null,
                        icon: const Icon(Icons.add_circle_outline),
                      ),
                    ],
                  ),
                  const SizedBox(height: 10),
                ],
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton.icon(
                    onPressed: habis
                        ? null
                        : () {
                            CartService.instance.add(produk, qty: _qty);
                            ScaffoldMessenger.of(context).showSnackBar(
                              SnackBar(
                                backgroundColor: AppColors.dark,
                                content: Text('${produk['nama']} ditambahkan ke keranjang.'),
                                action: SnackBarAction(
                                  label: 'LIHAT',
                                  textColor: AppColors.primary,
                                  onPressed: () => Navigator.push(
                                    context,
                                    MaterialPageRoute(builder: (_) => const CartPage()),
                                  ),
                                ),
                              ),
                            );
                            setState(() => _qty = 1);
                          },
                    icon: const Icon(Icons.add_shopping_cart),
                    label: Text(habis ? 'STOK HABIS' : 'TAMBAH KE KERANJANG'),
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
