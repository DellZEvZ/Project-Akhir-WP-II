/// Konfigurasi aplikasi.
///
/// Ganti [baseUrl] sesuai lingkungan:
/// - Android Emulator : http://10.0.2.2:8000/api  (localhost host machine)
/// - HP fisik (WiFi)  : http://IP-LAPTOP:8000/api  (mis. 192.168.1.5)
/// - Windows desktop  : http://127.0.0.1:8000/api
class AppConfig {
  static const String baseUrl = 'http://10.0.2.2:8000/api';

  /// Timeout permintaan HTTP (detik).
  static const int timeoutSeconds = 8;
}
