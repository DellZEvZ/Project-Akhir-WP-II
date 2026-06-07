import 'api_service.dart';

/// Layanan booking ke API (memerlukan token).
class BookingService {
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
  static Future<Map<String, dynamic>> payBooking(int orderId, String metode) async {
    final res = await ApiService.post('/booking/$orderId/pay', {
      'metode_bayar': metode,
    }, auth: true);
    return Map<String, dynamic>.from(res['data']);
  }
}
