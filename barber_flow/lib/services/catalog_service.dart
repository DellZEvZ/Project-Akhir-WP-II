import 'package:flutter/foundation.dart';
import 'api_service.dart';
import '../data/layanan_data.dart';
import '../data/produk_data.dart';
import '../data/barber_data.dart';
import '../data/galeri_data.dart';

/// Mode offline: semua data diambil dari data statis lokal.
/// Tidak perlu koneksi ke server Laravel.
///
/// Untuk kembali ke mode online (koneksi ke server), ganti konstanta
/// [_offlineMode] menjadi false.
class CatalogService {
  static const bool _offlineMode = true;

  static Future<List<Map<String, dynamic>>> fetchLayanan() async {
    if (_offlineMode) {
      return List<Map<String, dynamic>>.from(
        layananData.asMap().entries.map((e) => {
          ...e.value,
          'id': e.key + 1,  // id mulai dari 1, bukan 0
        }),
      );
    }
    try {
      final res = await ApiService.get('/layanan');
      final List list = res['data'];
      return list.map((e) => Map<String, dynamic>.from(e)).toList();
    } catch (e) {
      debugPrint('CatalogService.fetchLayanan gagal, pakai data statis. Error: $e');
      return List<Map<String, dynamic>>.from(layananData);
    }
  }

  static Future<List<Map<String, dynamic>>> fetchProduk() async {
    if (_offlineMode) {
      return List<Map<String, dynamic>>.from(
        produkData.asMap().entries.map((e) => {
          ...e.value,
          'id': e.key + 1,  // id mulai dari 1, bukan 0
          'stok': 99,
          'berat': 200,
        }),
      );
    }
    try {
      final res = await ApiService.get('/produk');
      final List list = res['data'];
      return list.map((e) => Map<String, dynamic>.from(e)).toList();
    } catch (e) {
      debugPrint('CatalogService.fetchProduk gagal, pakai data statis. Error: $e');
      return List<Map<String, dynamic>>.from(produkData);
    }
  }

  static Future<List<Map<String, dynamic>>> fetchGaleri() async {
    if (_offlineMode) {
      return List<Map<String, dynamic>>.from(galeriData);
    }
    try {
      final res = await ApiService.get('/galeri');
      final List list = res['data'];
      return list.map((e) => Map<String, dynamic>.from(e)).toList();
    } catch (e) {
      debugPrint('CatalogService.fetchGaleri gagal. Error: $e');
      return List<Map<String, dynamic>>.from(galeriData);
    }
  }

  static Future<List<Map<String, dynamic>>> fetchBarber() async {
    if (_offlineMode) {
      return List<Map<String, dynamic>>.from(barberData);
    }
    try {
      final res = await ApiService.get('/barber');
      final List list = res['data'];
      return list.map((e) => Map<String, dynamic>.from(e)).toList();
    } catch (e) {
      debugPrint('CatalogService.fetchBarber gagal. Error: $e');
      return List<Map<String, dynamic>>.from(barberData);
    }
  }
}
