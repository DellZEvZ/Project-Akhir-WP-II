import 'package:flutter/material.dart';
import '../theme.dart';
import 'beranda_page.dart';
import 'layanan_page.dart';
import 'produk_page.dart';

/// Halaman utama dengan BottomNavigationBar (Beranda, Layanan, Produk).
class MainPage extends StatefulWidget {
  const MainPage({super.key});

  @override
  State<MainPage> createState() => _MainPageState();
}

class _MainPageState extends State<MainPage> {
  int _currentIndex = 0;

  final List<Widget> _pages = const [
    BerandaPage(),
    LayananPage(),
    ProdukPage(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _pages[_currentIndex],
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _currentIndex,
        onTap: (i) => setState(() => _currentIndex = i),
        backgroundColor: AppColors.dark,
        selectedItemColor: AppColors.goldLight,
        unselectedItemColor: Colors.white60,
        type: BottomNavigationBarType.fixed,
        items: const [
          BottomNavigationBarItem(icon: Icon(Icons.home), label: 'Beranda'),
          BottomNavigationBarItem(icon: Icon(Icons.content_cut), label: 'Layanan'),
          BottomNavigationBarItem(icon: Icon(Icons.shopping_bag), label: 'Produk'),
        ],
      ),
    );
  }
}
