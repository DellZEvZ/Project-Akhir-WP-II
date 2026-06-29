/// Keranjang belanja PRODUK (in-memory, hilang saat app ditutup).
/// Pola singleton sederhana — cukup untuk kebutuhan aplikasi ini tanpa
/// menambah dependency state-management baru.
class CartItem {
  final Map<String, dynamic> produk;
  int qty;

  CartItem({required this.produk, this.qty = 1});

  int get subtotal {
    final harga = produk['harga'];
    final h = harga is int ? harga : int.tryParse('$harga') ?? 0;
    return h * qty;
  }

  num get beratTotal {
    final berat = produk['berat'];
    final b = berat is num ? berat : num.tryParse('$berat') ?? 0;
    return b * qty;
  }
}

class CartService {
  CartService._();
  static final CartService instance = CartService._();

  final List<CartItem> _items = [];

  List<CartItem> get items => List.unmodifiable(_items);

  bool get isEmpty => _items.isEmpty;
  int get totalItem => _items.fold(0, (sum, i) => sum + i.qty);
  int get totalHarga => _items.fold(0, (sum, i) => sum + i.subtotal);
  num get totalBerat {
    final total = _items.fold<num>(0, (sum, i) => sum + i.beratTotal);
    // Minimal 1 gram agar tidak ditolak API RajaOngkir (sama seperti web).
    return total < 1 ? 1 : total;
  }

  void add(Map<String, dynamic> produk, {int qty = 1}) {
    final id = produk['id'];
    final existing = _items.where((i) => i.produk['id'] == id).toList();
    if (existing.isNotEmpty) {
      existing.first.qty += qty;
    } else {
      _items.add(CartItem(produk: produk, qty: qty));
    }
  }

  void updateQty(int produkId, int qty) {
    CartItem? item;
    for (final i in _items) {
      if (i.produk['id'] == produkId) {
        item = i;
        break;
      }
    }
    if (item == null) return;
    if (qty <= 0) {
      remove(produkId);
    } else {
      item.qty = qty;
    }
  }

  void remove(int produkId) {
    _items.removeWhere((i) => i.produk['id'] == produkId);
  }

  void clear() {
    _items.clear();
  }
}
