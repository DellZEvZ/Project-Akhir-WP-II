import 'package:flutter/material.dart';
import '../services/catalog_service.dart';
import '../widgets/katalog_card.dart';
import 'detail_produk.dart';

/// Halaman Produk (StatefulWidget) — data dari API (fallback statis) + pencarian.
class ProdukPage extends StatefulWidget {
  const ProdukPage({super.key});

  @override
  State<ProdukPage> createState() => _ProdukPageState();
}

class _ProdukPageState extends State<ProdukPage> {
  String _keyword = '';
  late Future<List<Map<String, dynamic>>> _future;

  @override
  void initState() {
    super.initState();
    _future = CatalogService.fetchProduk();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Produk'),
        automaticallyImplyLeading: false,
      ),
      body: Column(
        children: [
          Padding(
            padding: const EdgeInsets.all(12),
            child: TextField(
              onChanged: (v) => setState(() => _keyword = v),
              decoration: InputDecoration(
                hintText: 'Cari produk...',
                prefixIcon: const Icon(Icons.search),
                border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                contentPadding: const EdgeInsets.symmetric(vertical: 0),
              ),
            ),
          ),
          Expanded(
            child: FutureBuilder<List<Map<String, dynamic>>>(
              future: _future,
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return const Center(child: CircularProgressIndicator());
                }
                final semua = snapshot.data ?? [];
                final hasil = semua
                    .where((p) => p['nama'].toString().toLowerCase().contains(_keyword.toLowerCase()))
                    .toList();

                if (hasil.isEmpty) {
                  return const Center(
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Icon(Icons.search_off, size: 56, color: Colors.grey),
                        SizedBox(height: 8),
                        Text('Produk tidak ditemukan', style: TextStyle(color: Colors.grey)),
                      ],
                    ),
                  );
                }

                return GridView.builder(
                  padding: const EdgeInsets.all(12),
                  itemCount: hasil.length,
                  gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                    crossAxisCount: 2,
                    crossAxisSpacing: 12,
                    mainAxisSpacing: 12,
                    mainAxisExtent: 210,
                  ),
                  itemBuilder: (context, index) {
                    final produk = hasil[index];
                    return KatalogCard(
                      item: produk,
                      icon: Icons.shopping_bag,
                      subtitle: produk['kategori']?.toString(),
                      onTap: () => Navigator.push(
                        context,
                        MaterialPageRoute(builder: (_) => DetailProduk(produk: produk)),
                      ),
                    );
                  },
                );
              },
            ),
          ),
        ],
      ),
    );
  }
}
