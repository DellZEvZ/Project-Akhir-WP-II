import 'package:flutter/material.dart';
import '../services/catalog_service.dart';
import '../widgets/katalog_card.dart';
import 'detail_layanan.dart';

/// Halaman Layanan (StatefulWidget) — data dari API (fallback statis) + pencarian.
class LayananPage extends StatefulWidget {
  const LayananPage({super.key});

  @override
  State<LayananPage> createState() => _LayananPageState();
}

class _LayananPageState extends State<LayananPage> {
  String _keyword = '';
  late Future<List<Map<String, dynamic>>> _future;

  @override
  void initState() {
    super.initState();
    _future = CatalogService.fetchLayanan();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Layanan'),
        automaticallyImplyLeading: false,
      ),
      body: Column(
        children: [
          Padding(
            padding: const EdgeInsets.all(12),
            child: TextField(
              onChanged: (v) => setState(() => _keyword = v),
              decoration: InputDecoration(
                hintText: 'Cari layanan...',
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
                    .where((l) => l['nama'].toString().toLowerCase().contains(_keyword.toLowerCase()))
                    .toList();

                if (hasil.isEmpty) {
                  return const Center(
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Icon(Icons.search_off, size: 56, color: Colors.grey),
                        SizedBox(height: 8),
                        Text('Layanan tidak ditemukan', style: TextStyle(color: Colors.grey)),
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
                    final layanan = hasil[index];
                    return KatalogCard(
                      item: layanan,
                      subtitle: '${layanan['durasi']} menit',
                      onTap: () => Navigator.push(
                        context,
                        MaterialPageRoute(builder: (_) => DetailLayanan(layanan: layanan)),
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
