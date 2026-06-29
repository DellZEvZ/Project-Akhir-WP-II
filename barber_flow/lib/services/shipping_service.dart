import 'api_service.dart';

/// Mode offline: ongkos kirim disimulasikan lokal tanpa RajaOngkir.
class ShippingService {
  static const bool _offlineMode = true;

  // Daftar kota simulasi untuk demo
  static const List<Map<String, dynamic>> _kotaDemo = [
    {'id': 'JKT001', 'label': 'Jakarta Pusat, DKI Jakarta'},
    {'id': 'JKT002', 'label': 'Jakarta Selatan, DKI Jakarta'},
    {'id': 'JKT003', 'label': 'Jakarta Barat, DKI Jakarta'},
    {'id': 'JKT004', 'label': 'Jakarta Timur, DKI Jakarta'},
    {'id': 'JKT005', 'label': 'Jakarta Utara, DKI Jakarta'},
    {'id': 'BDG001', 'label': 'Bandung, Jawa Barat'},
    {'id': 'SBY001', 'label': 'Surabaya, Jawa Timur'},
    {'id': 'YGY001', 'label': 'Yogyakarta, DI Yogyakarta'},
    {'id': 'SMG001', 'label': 'Semarang, Jawa Tengah'},
    {'id': 'MKS001', 'label': 'Makassar, Sulawesi Selatan'},
    {'id': 'MDN001', 'label': 'Medan, Sumatera Utara'},
    {'id': 'PLB001', 'label': 'Palembang, Sumatera Selatan'},
    {'id': 'TGR001', 'label': 'Tangerang, Banten'},
    {'id': 'BKS001', 'label': 'Bekasi, Jawa Barat'},
    {'id': 'DPK001', 'label': 'Depok, Jawa Barat'},
  ];

  static Future<List<Map<String, dynamic>>> searchDestination(String keyword) async {
    if (_offlineMode) {
      if (keyword.trim().length < 3) return [];
      final q = keyword.toLowerCase();
      return _kotaDemo
          .where((k) => k['label'].toString().toLowerCase().contains(q))
          .toList();
    }

    if (keyword.trim().length < 3) return [];
    final res = await ApiService.get(
      '/shipping/search?search=${Uri.encodeQueryComponent(keyword)}',
      auth: true,
    );
    final List list = res['data'] ?? [];
    return list.map((e) => Map<String, dynamic>.from(e)).toList();
  }

  static Future<List<Map<String, dynamic>>> calculateCost({
    required String destinationId,
    required num weight,
    required String courier,
  }) async {
    if (_offlineMode) {
      // Simulasi tarif berdasarkan berat (per 1000g = 1kg)
      final kg = (weight / 1000).ceil();
      final isJabodetabek = destinationId.startsWith('JKT') ||
          destinationId.startsWith('TGR') ||
          destinationId.startsWith('BKS') ||
          destinationId.startsWith('DPK');

      final Map<String, List<Map<String, dynamic>>> tarifKurir = {
        'jne': [
          {
            'service': 'REG',
            'description': 'Layanan Reguler',
            'cost': isJabodetabek ? 9000 * kg : 15000 * kg,
            'etd': isJabodetabek ? '1-2' : '2-4',
          },
          {
            'service': 'YES',
            'description': 'Yakin Esok Sampai',
            'cost': isJabodetabek ? 18000 * kg : 28000 * kg,
            'etd': '1',
          },
        ],
        'jnt': [
          {
            'service': 'EZ',
            'description': 'J&T Reguler',
            'cost': isJabodetabek ? 8000 * kg : 14000 * kg,
            'etd': isJabodetabek ? '1-2' : '2-3',
          },
        ],
        'sicepat': [
          {
            'service': 'BEST',
            'description': 'SiCepat Reguler',
            'cost': isJabodetabek ? 8500 * kg : 13000 * kg,
            'etd': isJabodetabek ? '1' : '2-3',
          },
          {
            'service': 'HALU',
            'description': 'SiCepat Hemat',
            'cost': isJabodetabek ? 7000 * kg : 11000 * kg,
            'etd': isJabodetabek ? '2-3' : '3-5',
          },
        ],
      };

      final courierKey = courier.toLowerCase();
      final tarif = tarifKurir[courierKey] ??
          [
            {
              'service': 'REG',
              'description': 'Layanan Reguler',
              'cost': 12000 * kg,
              'etd': '2-4',
            }
          ];

      return tarif.map((t) => {
            'service': t['service'],
            'description': t['description'],
            'cost': t['cost'],
            'etd': '${t['etd']} hari',
          }).toList();
    }

    final res = await ApiService.post('/shipping/cost', {
      'destination': destinationId,
      'weight': weight,
      'courier': courier,
    }, auth: true);
    final List list = res['data'] ?? [];
    return list.map((e) => Map<String, dynamic>.from(e)).toList();
  }
}
