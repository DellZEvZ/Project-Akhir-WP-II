import 'package:flutter/material.dart';

/// Palet warna utama aplikasi Barber Flow (tema hitam & emas).
class AppColors {
  static const Color dark = Color(0xFF1A1A2E);
  static const Color darker = Color(0xFF12121F);
  static const Color gold = Color(0xFFC9A227);
  static const Color goldLight = Color(0xFFDAA520);
  static const Color bg = Color(0xFFF4F4F4);
}

/// Tema global aplikasi.
ThemeData buildAppTheme() {
  return ThemeData(
    useMaterial3: true,
    scaffoldBackgroundColor: AppColors.bg,
    colorScheme: ColorScheme.fromSeed(
      seedColor: AppColors.gold,
      primary: AppColors.gold,
      surface: Colors.white,
    ),
    appBarTheme: const AppBarTheme(
      backgroundColor: AppColors.dark,
      foregroundColor: Colors.white,
      centerTitle: true,
      elevation: 0,
    ),
    elevatedButtonTheme: ElevatedButtonThemeData(
      style: ElevatedButton.styleFrom(
        backgroundColor: AppColors.gold,
        foregroundColor: AppColors.dark,
        textStyle: const TextStyle(fontWeight: FontWeight.bold),
        padding: const EdgeInsets.symmetric(vertical: 14),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
      ),
    ),
  );
}
