import 'dart:async';
import 'package:flutter/material.dart';
import '../theme.dart';
import '../services/auth_service.dart';
import '../services/cart_service.dart';
import '../services/shipping_service.dart';
import '../services/booking_service.dart';
import 'booking_summary_produk.dart';

/// Halaman pilih alamat & ongkos kirim (RajaOngkir) untuk pesanan produk.
/// Mengikuti pola yang sama dengan versi web: cari tujuan -> pilih kurir ->
/// hitung ongkir -> pilih layanan -> checkout.
class ShippingPage extends StatefulWidget {
  const ShippingPage({super.key});

  @override
  State<ShippingPage> createState() => _ShippingPageState();
}

class _ShippingPageState extends State<ShippingPage> {
  final _alamatCtrl = TextEditingController();
  final _cariCtrl = TextEditingController();

  List<Map<String, dynamic>> _hasilCari = [];
  Map<String, dynamic>? _tujuanTerpilih;
  String _kurir = 'jne';
  Timer? _debounce;
  bool _mencari = false;

  List<Map<String, dynamic>> _hasilOngkir = [];
  Map<String, dynamic>? _ongkirTerpilih;
  bool _menghitungOngkir = false;
  bool _loadingSubmit = false;

  final _cart = CartService.instance;

  @override
  void initState() {
    super.initState();
    _prefillAlamat();
  }

  Future<void> _prefillAlamat() async {
    final profil = await AuthService.me();
    if (!mounted || profil == null) return;
    final alamat = profil['alamat']?.toString() ?? '';
    if (alamat.isNotEmpty) {
      setState(() => _alamatCtrl.text = alamat);
    }
  }

  @override
  void dispose() {
    _alamatCtrl.dispose();
    _cariCtrl.dispose();
    _debounce?.cancel();
    super.dispose();
  }

  void _onCariChanged(String value) {
    setState(() => _tujuanTerpilih = null);
    _debounce?.cancel();
    if (value.trim().length < 3) {
      setState(() => _hasilCari = []);
      return;
    }
    _debounce = Timer(const Duration(milliseconds: 400), () async {
      setState(() => _mencari = true);
      try {
        final hasil = await ShippingService.searchDestination(value);
        if (!mounted) return;
        setState(() {
          _hasilCari = hasil;
          _mencari = false;
        });
      } catch (_) {
        if (!mounted) return;
        setState(() => _mencari = false);
      }
    });
  }

  Future<void> _cekOngkir() async {
    if (_tujuanTerpilih == null) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Pilih kecamatan/kota tujuan dari daftar terlebih dahulu.')),
      );
      return;
    }

    setState(() {
      _menghitungOngkir = true;
      _hasilOngkir = [];
      _ongkirTerpilih = null;
    });

    try {
      final hasil = await ShippingService.calculateCost(
        destinationId: '${_tujuanTerpilih!['id']}',
        weight: _cart.totalBerat,
        courier: _kurir,
      );
      if (!mounted) return;
      setState(() {
        _hasilOngkir = hasil;
        _menghitungOngkir = false;
      });
      if (hasil.isEmpty) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Layanan kurir ini tidak tersedia untuk tujuan tersebut.')),
        );
      }
    } catch (e) {
      if (!mounted) return;
      setState(() => _menghitungOngkir = false);
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Gagal menghitung ongkir: $e'), backgroundColor: Colors.red),
      );
    }
  }

  Future<void> _lanjutCheckout() async {
    if (_alamatCtrl.text.trim().isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Alamat lengkap wajib diisi.')),
      );
      return;
    }
    if (_ongkirTerpilih == null) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Silakan cek ongkos kirim dan pilih salah satu kurir terlebih dahulu.')),
      );
      return;
    }

    setState(() => _loadingSubmit = true);

    try {
      final items = _cart.items
          .map((i) => {'produk_id': i.produk['id'], 'qty': i.qty})
          .toList();

      final order = await BookingService.createProdukOrder(
        items: items,
        alamatKirim: _alamatCtrl.text.trim(),
        kotaTujuanId: '${_tujuanTerpilih!['id']}',
        kotaTujuanLabel: _tujuanTerpilih!['label']?.toString() ?? '',
        kurir: _kurir,
        layananOngkir: _ongkirTerpilih!['service']?.toString() ?? '',
        biayaOngkir: _ongkirTerpilih!['cost'] is num
            ? _ongkirTerpilih!['cost']
            : num.tryParse('${_ongkirTerpilih!['cost']}') ?? 0,
        estimasiOngkir: _ongkirTerpilih!['etd']?.toString(),
        totalBerat: _cart.totalBerat,
      );

      if (!mounted) return;
      _cart.clear();
      setState(() => _loadingSubmit = false);

      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => BookingSummaryProduk(order: order)),
      );
    } catch (e) {
      if (!mounted) return;
      setState(() => _loadingSubmit = false);
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Gagal membuat pesanan: $e'), backgroundColor: Colors.red),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Alamat & Pengiriman')),
      body: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          const Text('Alamat Lengkap', style: TextStyle(fontWeight: FontWeight.bold)),
          const SizedBox(height: 8),
          TextField(
            controller: _alamatCtrl,
            maxLines: 2,
            decoration: const InputDecoration(
              hintText: 'Contoh: Jl. Melati No. 12, RT 02/RW 05',
              border: OutlineInputBorder(),
            ),
          ),
          const SizedBox(height: 20),
          const Text('Kecamatan / Kota Tujuan', style: TextStyle(fontWeight: FontWeight.bold)),
          const SizedBox(height: 8),
          TextField(
            controller: _cariCtrl,
            onChanged: _onCariChanged,
            decoration: InputDecoration(
              hintText: 'Ketik nama kecamatan/kota, contoh: Tegalsari',
              border: const OutlineInputBorder(),
              suffixIcon: _mencari
                  ? const Padding(
                      padding: EdgeInsets.all(12),
                      child: SizedBox(width: 16, height: 16, child: CircularProgressIndicator(strokeWidth: 2)),
                    )
                  : null,
            ),
          ),
          if (_hasilCari.isNotEmpty)
            Container(
              margin: const EdgeInsets.only(top: 4),
              decoration: BoxDecoration(border: Border.all(color: Colors.grey.shade300)),
              constraints: const BoxConstraints(maxHeight: 220),
              child: ListView.builder(
                shrinkWrap: true,
                itemCount: _hasilCari.length,
                itemBuilder: (context, index) {
                  final d = _hasilCari[index];
                  return ListTile(
                    dense: true,
                    title: Text('${d['subdistrict_name']}, ${d['district_name']}', style: const TextStyle(fontSize: 13)),
                    subtitle: Text('${d['city_name']}, ${d['province_name']} ${d['zip_code']}', style: const TextStyle(fontSize: 11)),
                    onTap: () {
                      setState(() {
                        _tujuanTerpilih = d;
                        _cariCtrl.text = d['label']?.toString() ?? '';
                        _hasilCari = [];
                      });
                    },
                  );
                },
              ),
            ),
          const Text('Pilih dari daftar yang muncul agar ongkir dapat dihitung akurat.',
              style: TextStyle(fontSize: 11, color: Colors.grey)),
          const SizedBox(height: 20),
          const Text('Kurir', style: TextStyle(fontWeight: FontWeight.bold)),
          const SizedBox(height: 8),
          DropdownButtonFormField<String>(
            initialValue: _kurir,
            decoration: const InputDecoration(border: OutlineInputBorder()),
            items: const [
              DropdownMenuItem(value: 'jne', child: Text('JNE')),
              DropdownMenuItem(value: 'tiki', child: Text('TIKI')),
              DropdownMenuItem(value: 'pos', child: Text('POS Indonesia')),
            ],
            onChanged: (v) => setState(() => _kurir = v ?? 'jne'),
          ),
          const SizedBox(height: 16),
          OutlinedButton.icon(
            onPressed: _menghitungOngkir ? null : _cekOngkir,
            icon: _menghitungOngkir
                ? const SizedBox(width: 16, height: 16, child: CircularProgressIndicator(strokeWidth: 2))
                : const Icon(Icons.search),
            label: const Text('CEK ONGKOS KIRIM'),
          ),
          const SizedBox(height: 16),
          ..._hasilOngkir.map((s) {
            final selected = _ongkirTerpilih == s;
            return Card(
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8),
                side: BorderSide(color: selected ? AppColors.primary : Colors.grey.shade300, width: selected ? 2 : 1),
              ),
              child: ListTile(
                onTap: () => setState(() => _ongkirTerpilih = s),
                title: Text('${s['service']}'),
                subtitle: Text('Estimasi: ${s['etd'] ?? '-'}'),
                trailing: Text('Rp ${s['cost']}', style: const TextStyle(fontWeight: FontWeight.bold, color: AppColors.primary)),
              ),
            );
          }),
          if (_ongkirTerpilih != null)
            Container(
              margin: const EdgeInsets.only(top: 8),
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(color: Colors.green.shade50, borderRadius: BorderRadius.circular(8)),
              child: Text(
                'Dipilih: ${_kurir.toUpperCase()} ${_ongkirTerpilih!['service']} — Rp ${_ongkirTerpilih!['cost']}',
                style: TextStyle(color: Colors.green.shade800),
              ),
            ),
          const SizedBox(height: 24),
          ElevatedButton.icon(
            onPressed: _loadingSubmit ? null : _lanjutCheckout,
            icon: _loadingSubmit
                ? const SizedBox(width: 18, height: 18, child: CircularProgressIndicator(strokeWidth: 2, color: Colors.white))
                : const Icon(Icons.arrow_forward),
            label: Text(_loadingSubmit ? 'MEMPROSES...' : 'LANJUT KE CHECKOUT'),
          ),
        ],
      ),
    );
  }
}
