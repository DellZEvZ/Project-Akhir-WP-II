import 'package:flutter/material.dart';
import '../theme.dart';

/// Menampilkan gambar dari URL dengan fallback ikon jika kosong / gagal dimuat.
class Foto extends StatelessWidget {
  final String? url;
  final double? width;
  final double height;
  final IconData fallbackIcon;

  const Foto({
    super.key,
    required this.url,
    this.width,
    this.height = 180,
    this.fallbackIcon = Icons.content_cut,
  });

  Widget _fallback() => Container(
        width: width ?? double.infinity,
        height: height,
        color: AppColors.dark,
        child: Icon(fallbackIcon, color: AppColors.primary, size: 48),
      );

  @override
  Widget build(BuildContext context) {
    // Tidak ada foto → tampilkan ikon fallback (hindari Image.network(null)).
    if (url == null || url!.isEmpty) return _fallback();

    return Image.network(
      url!,
      width: width ?? double.infinity,
      height: height,
      fit: BoxFit.cover,
      loadingBuilder: (context, child, progress) {
        if (progress == null) return child;
        return Container(
          width: width ?? double.infinity,
          height: height,
          color: AppColors.dark,
          child: const Center(
            child: CircularProgressIndicator(color: AppColors.primary, strokeWidth: 2),
          ),
        );
      },
      errorBuilder: (context, error, stack) => _fallback(),
    );
  }
}
