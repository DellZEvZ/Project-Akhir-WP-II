import 'package:flutter/material.dart';
import '../theme.dart';
import '../services/cart_service.dart';
import 'shipping_page.dart';

/// Halaman keranjang produk. Data diambil dari [CartService] (in-memory).
class CartPage extends StatefulWidget {
  const CartPage({super.key});

  @override
  State<CartPage> createState() => _CartPageState();
}

class _CartPageState extends State<CartPage> {
  final _cart = CartService.instance;

  @override
  Widget build(BuildContext context) {
    final items = _cart.items;

    return Scaffold(
      appBar: AppBar(title: const Text('Keranjang')),
      body: items.isEmpty
          ? const Center(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Icon(Icons.shopping_cart_outlined, size: 64, color: Colors.grey),
                  SizedBox(height: 12),
                  Text('Keranjang masih kosong', style: TextStyle(color: Colors.grey)),
                ],
              ),
            )
          : Column(
              children: [
                // List item mengisi sisa ruang
                Expanded(
                  child: ListView.builder(
                    padding: const EdgeInsets.fromLTRB(16, 16, 16, 8),
                    itemCount: items.length,
                    itemBuilder: (context, index) {
                      final item = items[index];
                      final produk = item.produk;

                      return Card(
                        margin: const EdgeInsets.only(bottom: 12),
                        shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10)),
                        child: Padding(
                          padding: const EdgeInsets.all(12),
                          child: Row(
                            children: [
                              Container(
                                width: 56,
                                height: 56,
                                decoration: BoxDecoration(
                                  color: AppColors.dark,
                                  borderRadius: BorderRadius.circular(8),
                                ),
                                child: const Icon(Icons.shopping_bag,
                                    color: AppColors.primary),
                              ),
                              const SizedBox(width: 12),
                              Expanded(
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      produk['nama']?.toString() ?? 'Produk',
                                      style: const TextStyle(
                                          fontWeight: FontWeight.bold),
                                      maxLines: 1,
                                      overflow: TextOverflow.ellipsis,
                                    ),
                                    const SizedBox(height: 4),
                                    Text(
                                      'Rp ${produk['harga']}',
                                      style: const TextStyle(
                                          color: AppColors.primary,
                                          fontWeight: FontWeight.bold),
                                    ),
                                    Text(
                                      'Subtotal: Rp ${item.subtotal}',
                                      style: const TextStyle(
                                          fontSize: 12, color: Colors.grey),
                                    ),
                                  ],
                                ),
                              ),
                              Column(
                                children: [
                                  Row(
                                    mainAxisSize: MainAxisSize.min,
                                    children: [
                                      IconButton(
                                        onPressed: () => setState(() =>
                                            _cart.updateQty(
                                                produk['id'], item.qty - 1)),
                                        icon: const Icon(
                                            Icons.remove_circle_outline,
                                            size: 22),
                                        padding: EdgeInsets.zero,
                                        constraints: const BoxConstraints(),
                                      ),
                                      Padding(
                                        padding: const EdgeInsets.symmetric(
                                            horizontal: 8),
                                        child: Text('${item.qty}',
                                            style: const TextStyle(
                                                fontWeight: FontWeight.bold,
                                                fontSize: 16)),
                                      ),
                                      IconButton(
                                        onPressed: () => setState(() =>
                                            _cart.updateQty(
                                                produk['id'], item.qty + 1)),
                                        icon: const Icon(
                                            Icons.add_circle_outline,
                                            size: 22),
                                        padding: EdgeInsets.zero,
                                        constraints: const BoxConstraints(),
                                      ),
                                    ],
                                  ),
                                  TextButton.icon(
                                    onPressed: () => setState(
                                        () => _cart.remove(produk['id'])),
                                    icon: const Icon(Icons.delete_outline,
                                        size: 16, color: Colors.red),
                                    label: const Text('Hapus',
                                        style: TextStyle(
                                            color: Colors.red, fontSize: 12)),
                                    style: TextButton.styleFrom(
                                        padding: EdgeInsets.zero),
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ),
                      );
                    },
                  ),
                ),
                // Bottom bar subtotal + checkout — bagian dari body, bukan bottomNavigationBar
                Container(
                  padding: const EdgeInsets.symmetric(
                      horizontal: 16, vertical: 12),
                  decoration: const BoxDecoration(
                    color: Colors.white,
                    boxShadow: [
                      BoxShadow(
                          color: Colors.black12,
                          blurRadius: 8,
                          offset: Offset(0, -2))
                    ],
                  ),
                  child: Row(
                    children: [
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            const Text('Subtotal',
                                style: TextStyle(
                                    color: Colors.grey, fontSize: 12)),
                            Text('Rp ${_cart.totalHarga}',
                                style: const TextStyle(
                                    fontWeight: FontWeight.bold,
                                    fontSize: 18)),
                          ],
                        ),
                      ),
                      ElevatedButton.icon(
                        onPressed: () => Navigator.push(
                          context,
                          MaterialPageRoute(
                              builder: (_) => const ShippingPage()),
                        ),
                        icon: const Icon(Icons.local_shipping_outlined),
                        label: const Text('CHECKOUT'),
                      ),
                    ],
                  ),
                ),
              ],
            ),
    );
  }
}
