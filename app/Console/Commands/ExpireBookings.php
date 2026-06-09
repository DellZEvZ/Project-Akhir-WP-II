<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class ExpireBookings extends Command
{
    protected $signature = 'bookings:expire {--minutes=45}';

    protected $description = 'Sembunyikan booking yang belum dibayar melewati batas waktu dari riwayat pelanggan (tetap tersimpan untuk admin).';

    public function handle(): int
    {
        $minutes = (int) $this->option('minutes');
        $cutoff  = now()->subMinutes($minutes);

        // Booking yang dikonfirmasi tapi belum lunas & bukan bayar-di-tempat,
        // serta tidak ada update sejak batas waktu → dianggap kedaluwarsa.
        $count = Order::where('jenis', 'booking')
            ->where('status', 'confirmed')
            ->where('status_bayar', 'belum')
            ->where(fn ($q) => $q->whereNull('metode_bayar')->orWhere('metode_bayar', '!=', 'cash'))
            ->whereNull('hidden_at')
            ->where('updated_at', '<', $cutoff)
            ->update([
                'status'    => 'batal',
                'hidden_at' => now(),
            ]);

        $this->info("{$count} booking kedaluwarsa disembunyikan dari riwayat pelanggan (batas {$minutes} menit).");

        return self::SUCCESS;
    }
}
