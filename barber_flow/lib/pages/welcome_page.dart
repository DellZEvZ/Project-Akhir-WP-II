import 'package:flutter/material.dart';
import '../theme.dart';
import 'login_page.dart';
import 'registrasi_page.dart';

/// Halaman pembuka aplikasi (StatelessWidget).
class WelcomePage extends StatelessWidget {
  const WelcomePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.dark,
      body: SafeArea(
        child: ListView(
          padding: const EdgeInsets.all(28),
          children: [
            const SizedBox(height: 60),
            const Icon(Icons.content_cut, color: AppColors.gold, size: 90),
            const SizedBox(height: 20),
            const Text(
              'BARBER FLOW',
              textAlign: TextAlign.center,
              style: TextStyle(
                color: Colors.white,
                fontSize: 36,
                fontWeight: FontWeight.bold,
                letterSpacing: 2,
              ),
            ),
            const SizedBox(height: 8),
            const Text(
              'Your Style, Your Flow',
              textAlign: TextAlign.center,
              style: TextStyle(color: AppColors.goldLight, fontSize: 16, letterSpacing: 1),
            ),
            const SizedBox(height: 16),
            const Text(
              'Barbershop modern dengan layanan men\'s grooming premium. Tampil rapi, percaya diri, dan bergaya.',
              textAlign: TextAlign.center,
              style: TextStyle(color: Colors.white70, fontSize: 14, height: 1.5),
            ),
            const SizedBox(height: 50),
            ElevatedButton(
              onPressed: () => Navigator.push(
                context,
                MaterialPageRoute(builder: (_) => const RegistrasiPage()),
              ),
              child: const Text('REGISTRASI'),
            ),
            const SizedBox(height: 14),
            OutlinedButton(
              onPressed: () => Navigator.push(
                context,
                MaterialPageRoute(builder: (_) => const LoginPage()),
              ),
              style: OutlinedButton.styleFrom(
                foregroundColor: AppColors.goldLight,
                side: const BorderSide(color: AppColors.gold, width: 2),
                padding: const EdgeInsets.symmetric(vertical: 14),
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
              ),
              child: const Text('LOGIN', style: TextStyle(fontWeight: FontWeight.bold)),
            ),
          ],
        ),
      ),
    );
  }
}
