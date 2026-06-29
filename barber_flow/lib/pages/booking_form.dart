import 'package:flutter/material.dart';
import '../theme.dart';
import '../services/auth_service.dart';
import '../services/booking_service.dart';
import '../services/catalog_service.dart';
import 'booking_summary.dart';

/// Form pemesanan layanan. Wajib pilih barber agar sistem bisa mencegah
/// bentrok jadwal per-barber (barber A & B boleh dibooking di jam yang
/// sama, tapi barber yang sama tidak boleh dobel).
class BookingForm extends StatefulWidget {
  final Map<String, dynamic> layanan;
  const BookingForm({super.key, required this.layanan});

  @override
  State<BookingForm> createState() => _BookingFormState();
}

class _BookingFormState extends State<BookingForm> {
  final _formKey = GlobalKey<FormState>();
  final _namaCtrl = TextEditingController();
  final _hpCtrl = TextEditingController();
  final _catatanCtrl = TextEditingController();

  DateTime? _tanggal;
  TimeOfDay? _jam;
  bool _loading = false;

  late Future<List<Map<String, dynamic>>> _barberFuture;
  Map<String, dynamic>? _barberTerpilih;

  @override
  void initState() {
    super.initState();
    _barberFuture = CatalogService.fetchBarber();
    _prefillFromProfile();
  }

  Future<void> _prefillFromProfile() async {
    final data = await AuthService.me();
    if (!mounted || data == null) return;
    setState(() {
      _namaCtrl.text = data['nama']?.toString() ?? '';
      _hpCtrl.text = data['no_hp']?.toString() ?? '';
    });
  }

  @override
  void dispose() {
    _namaCtrl.dispose();
    _hpCtrl.dispose();
    _catatanCtrl.dispose();
    super.dispose();
  }

  Future<void> _pickTanggal() async {
    final now = DateTime.now();
    final picked = await showDatePicker(
      context: context,
      initialDate: now,
      firstDate: now,
      lastDate: now.add(const Duration(days: 60)),
    );
    if (picked != null) setState(() => _tanggal = picked);
  }

  Future<void> _pickJam() async {
    final picked = await showTimePicker(
      context: context,
      initialTime: const TimeOfDay(hour: 10, minute: 0),
    );
    if (picked != null) setState(() => _jam = picked);
  }

  Future<void> _submit() async {
    if (!_formKey.currentState!.validate()) return;
    if (_tanggal == null || _jam == null) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Pilih tanggal dan jam booking.')),
      );
      return;
    }
    if (_barberTerpilih == null) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Pilih barber terlebih dahulu.')),
      );
      return;
    }

    setState(() => _loading = true);

    int? orderId;

    final id = widget.layanan['id'];
    final barberId = _barberTerpilih!['id'];
    if (id is int && barberId is int) {
      try {
        final tgl = '${_tanggal!.year}-${_tanggal!.month.toString().padLeft(2, '0')}-${_tanggal!.day.toString().padLeft(2, '0')}';
        final jam = '${_jam!.hour.toString().padLeft(2, '0')}:${_jam!.minute.toString().padLeft(2, '0')}';
        final result = await BookingService.createBooking(
          layananIds: [id],
          barberId: barberId,
          tanggal: tgl,
          jam: jam,
          catatan: _catatanCtrl.text,
          layananNama: widget.layanan['nama']?.toString() ?? '',
          layananHarga: (widget.layanan['harga'] is int)
              ? widget.layanan['harga'] as int
              : int.tryParse('${widget.layanan['harga']}') ?? 0,
          layananDurasi: (widget.layanan['durasi'] is int)
              ? widget.layanan['durasi'] as int
              : int.tryParse('${widget.layanan['durasi']}') ?? 0,
          barberNama: _barberTerpilih!['nama']?.toString() ?? '',
        );
        orderId = result['id'] as int?;
      } catch (e) {
        if (!mounted) return;
        setState(() => _loading = false);
        // Pesan dari server sudah jelas (mis. bentrok jadwal per-barber),
        // tampilkan langsung tanpa dibungkus ulang.
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('$e'), backgroundColor: Colors.red),
        );
        return;
      }
    } else {
      if (!mounted) return;
      setState(() => _loading = false);
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Error: Data layanan atau barber tidak valid.')),
      );
      return;
    }

    if (!mounted) return;
    setState(() => _loading = false);

    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) => BookingSummary(
          layanan: widget.layanan,
          nama: _namaCtrl.text,
          hp: _hpCtrl.text,
          tanggal: _tanggal!,
          jam: _jam!,
          catatan: _catatanCtrl.text,
          orderId: orderId,
          barberNama: _barberTerpilih!['nama']?.toString(),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final tglText = _tanggal == null
        ? 'Pilih tanggal'
        : '${_tanggal!.day}/${_tanggal!.month}/${_tanggal!.year}';
    final jamText = _jam == null ? 'Pilih jam' : _jam!.format(context);

    return Scaffold(
      appBar: AppBar(title: const Text('Form Pemesanan')),
      body: Form(
        key: _formKey,
        child: ListView(
          padding: const EdgeInsets.all(20),
          children: [
            Container(
              padding: const EdgeInsets.all(14),
              decoration: BoxDecoration(
                color: AppColors.dark,
                borderRadius: BorderRadius.circular(10),
              ),
              child: Row(
                children: [
                  const Icon(Icons.content_cut, color: AppColors.primary),
                  const SizedBox(width: 12),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(widget.layanan['nama'],
                            style: const TextStyle(
                                color: Colors.white, fontWeight: FontWeight.bold)),
                        Text('Rp ${widget.layanan['harga']}',
                            style: const TextStyle(color: Colors.white70)),
                      ],
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 20),
            const Text('Pilih Barber', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15)),
            const SizedBox(height: 8),
            FutureBuilder<List<Map<String, dynamic>>>(
              future: _barberFuture,
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return const Padding(
                    padding: EdgeInsets.symmetric(vertical: 12),
                    child: Center(child: CircularProgressIndicator()),
                  );
                }
                final daftarBarber = snapshot.data ?? [];
                if (daftarBarber.isEmpty) {
                  return const Padding(
                    padding: EdgeInsets.symmetric(vertical: 8),
                    child: Text('Tidak ada barber tersedia saat ini.', style: TextStyle(color: Colors.red)),
                  );
                }
                return Column(
                  children: daftarBarber.map((b) {
                    final selected = _barberTerpilih?['id'] == b['id'];
                    return Card(
                      margin: const EdgeInsets.only(bottom: 8),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(8),
                        side: BorderSide(
                          color: selected ? AppColors.primary : Colors.grey.shade300,
                          width: selected ? 2 : 1,
                        ),
                      ),
                      child: ListTile(
                        onTap: () => setState(() => _barberTerpilih = b),
                        leading: CircleAvatar(
                          backgroundColor: AppColors.dark,
                          child: Text(
                            (b['nama'] ?? '?').toString().substring(0, 1).toUpperCase(),
                            style: const TextStyle(color: Colors.white),
                          ),
                        ),
                        title: Text(b['nama']?.toString() ?? 'Barber'),
                        subtitle: Text(b['spesialisasi']?.toString() ?? '-'),
                        trailing: Icon(
                          selected ? Icons.radio_button_checked : Icons.radio_button_unchecked,
                          color: selected ? AppColors.primary : Colors.grey,
                        ),
                      ),
                    );
                  }).toList(),
                );
              },
            ),
            const SizedBox(height: 16),
            TextFormField(
              controller: _namaCtrl,
              decoration: const InputDecoration(
                labelText: 'Nama',
                prefixIcon: Icon(Icons.person),
                border: OutlineInputBorder(),
              ),
              validator: (v) => (v == null || v.isEmpty) ? 'Nama wajib diisi' : null,
            ),
            const SizedBox(height: 16),
            TextFormField(
              controller: _hpCtrl,
              keyboardType: TextInputType.phone,
              decoration: const InputDecoration(
                labelText: 'Nomor HP',
                prefixIcon: Icon(Icons.phone),
                border: OutlineInputBorder(),
              ),
              validator: (v) => (v == null || v.isEmpty) ? 'Nomor HP wajib diisi' : null,
            ),
            const SizedBox(height: 16),
            Row(
              children: [
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: _pickTanggal,
                    icon: const Icon(Icons.calendar_today, size: 18),
                    label: Text(tglText, overflow: TextOverflow.ellipsis),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: _pickJam,
                    icon: const Icon(Icons.access_time, size: 18),
                    label: Text(jamText, overflow: TextOverflow.ellipsis),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 16),
            TextFormField(
              controller: _catatanCtrl,
              maxLines: 3,
              decoration: const InputDecoration(
                labelText: 'Catatan (opsional)',
                prefixIcon: Icon(Icons.note),
                border: OutlineInputBorder(),
              ),
            ),
            const SizedBox(height: 24),
            ElevatedButton.icon(
              onPressed: _loading ? null : _submit,
              icon: _loading
                  ? const SizedBox(width: 18, height: 18, child: CircularProgressIndicator(strokeWidth: 2))
                  : const Icon(Icons.check_circle),
              label: Text(_loading ? 'MEMPROSES...' : 'KONFIRMASI BOOKING'),
            ),
          ],
        ),
      ),
    );
  }
}
