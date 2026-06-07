import 'package:flutter/material.dart';

/// Tombol reusable untuk aksi "Pesan / Booking".
class TombolPesan extends StatelessWidget {
  final String label;
  final IconData icon;
  final VoidCallback onPressed;

  const TombolPesan({
    super.key,
    this.label = 'Pesan Sekarang',
    this.icon = Icons.calendar_month,
    required this.onPressed,
  });

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: double.infinity,
      child: ElevatedButton.icon(
        onPressed: onPressed,
        icon: Icon(icon),
        label: Text(label),
      ),
    );
  }
}
