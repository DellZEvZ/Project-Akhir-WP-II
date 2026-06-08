import 'api_service.dart';
import '../data/layanan_data.dart';
import '../data/produk_data.dart';

/// Mengambil katalog dari API. Jika API tidak tersedia (offline / server mati),
/// otomatis fallback ke data statis agar aplikasi tetap berjalan.
class CatalogService {
  static Future<List<Map<String, dynamic>>> fetchLayanan() async {
    try {
      final res = await ApiService.get('/layanan');
      final List list = res['data'];
      return list.map((e) => Map<String, dynamic>.from(e)).toList();
    } catch (_) {
      // Fallback ke data statis (Mobile Programming I).
      return List<Map<String, dynamic>>.from(layananData);
    }
  }

  static Future<List<Map<String, dynamic>>> fetchProduk() async {
    try {
      final res = await ApiService.get('/produk');
      final List list = res['data'];
      return list.map((e) => Map<String, dynamic>.from(e)).toList();
    } catch (_) {
      return List<Map<String, dynamic>>.from(produkData);
    }
  }

  static Future<List<Map<String, dynamic>>> fetchGaleri() async {
    try {
      final res = await ApiService.get('/galeri');
      final List list = res['data'];
      return list.map((e) => Map<String, dynamic>.from(e)).toList();
    } catch (_) {
      return [];
    }
  }
}
