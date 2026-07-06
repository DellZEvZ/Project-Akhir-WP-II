import 'package:flutter/foundation.dart';
import 'api_service.dart';
import '../config/app_config.dart';
import '../data/layanan_data.dart';
import '../data/produk_data.dart';
import '../data/barber_data.dart';
import '../data/galeri_data.dart';

/// Sumber data katalog. Mode ditentukan terpusat oleh [AppConfig.useBackend].
///
/// PENTING soal kestabilan: saat online (useBackend = true) dan permintaan
/// GAGAL, service ini mengembalikan daftar KOSONG — BUKAN data statis lokal.
/// Data statis memakai id palsu (1,2,3…) yang tidak ada di database; jika
/// dipakai untuk booking, server menolak dengan error "exists" (422). Lebih
/// baik tampil kosong + bisa retry daripada katalog palsu yang tak bisa dibooking.
class CatalogService {
  static const bool _offlineMode = !AppConfig.useBackend;

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
      debugPrint('CatalogService.fetchLayanan gagal (online). Error: $e');
      return [];
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
      debugPrint('CatalogService.fetchProduk gagal (online). Error: $e');
      return [];
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
      debugPrint('CatalogService.fetchGaleri gagal (online). Error: $e');
      return [];
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
      debugPrint('CatalogService.fetchBarber gagal (online). Error: $e');
      return [];
    }
  }
}
