import 'api_service.dart';

/// Layanan booking ke API (memerlukan token).
class BookingService {
  /// Riwayat pesanan customer (booking & produk).
  static Future<List<Map<String, dynamic>>> fetchOrders() async {
    final res = await ApiService.get('/booking', auth: true);
    final List list = res['data'];
    return list.map((e) => Map<String, dynamic>.from(e)).toList();
  }

  /// Membuat booking. Mengembalikan data booking jika sukses, atau melempar pesan.
  static Future<Map<String, dynamic>> createBooking({
    required List<int> layananIds,
    required String tanggal, // yyyy-MM-dd
    required String jam, // HH:mm
    String catatan = '',
  }) async {
    final res = await ApiService.post('/booking', {
      'layanan_ids': layananIds,
      'tanggal_booking': tanggal,
      'jam_booking': jam,
      'catatan': catatan,
    }, auth: true);
    return Map<String, dynamic>.from(res['data']);
  }

  /// Mengirim metode pembayaran untuk sebuah booking.
  static Future<Map<String, dynamic>> payBooking(
    int orderId,
    String metode, {
    String? kanal,
  }) async {
    final res = await ApiService.post('/booking/$orderId/pay', {
      'metode_bayar': metode,
      'kanal_bayar': kanal ?? '',
    }, auth: true);
    return Map<String, dynamic>.from(res['data']);
  }
}
