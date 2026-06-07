import 'api_service.dart';

/// Layanan autentikasi customer ke API Laravel.
class AuthService {
  /// Register. Mengembalikan null jika sukses, atau pesan error.
  static Future<String?> register(String nama, String email, String password) async {
    try {
      final res = await ApiService.post('/register', {
        'nama': nama,
        'email': email,
        'password': password,
      });
      await ApiService.saveToken(res['data']['token']);
      return null;
    } on ApiException catch (e) {
      return e.message;
    } catch (_) {
      return 'Tidak dapat terhubung ke server.';
    }
  }

  /// Login. Mengembalikan null jika sukses, atau pesan error.
  static Future<String?> login(String email, String password) async {
    try {
      final res = await ApiService.post('/login', {
        'email': email,
        'password': password,
      });
      await ApiService.saveToken(res['data']['token']);
      return null;
    } on ApiException catch (e) {
      return e.message;
    } catch (_) {
      return 'Tidak dapat terhubung ke server.';
    }
  }

  static Future<void> logout() async {
    try {
      await ApiService.post('/logout', {}, auth: true);
    } catch (_) {
      // abaikan error jaringan saat logout
    }
    await ApiService.clearToken();
  }
}
