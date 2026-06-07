import 'package:flutter/material.dart';
import '../theme.dart';

/// Menampilkan gambar dari URL dengan fallback ikon jika gagal dimuat.
class Foto extends StatelessWidget {
  final String url;
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

  @override
  Widget build(BuildContext context) {
    return Image.network(
      url,
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
            child: CircularProgressIndicator(color: AppColors.gold, strokeWidth: 2),
          ),
        );
      },
      errorBuilder: (context, error, stack) => Container(
        width: width ?? double.infinity,
        height: height,
        color: AppColors.dark,
        child: Icon(fallbackIcon, color: AppColors.gold, size: 48),
      ),
    );
  }
}
