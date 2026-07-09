<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Rotasi kredensial akun bawaan pada database PRODUCTION.
 *
 * Tujuan: mengganti email yang mudah ditebak + password seeder publik
 * ("P@55word") agar akun tidak mudah ditembak setelah aplikasi live.
 *
 * ─────────────────────────────────────────────────────────────────────
 *  CARA PAKAI
 *  1. Isi array $users di bawah: untuk tiap email lama, isi email baru
 *     (boleh null jika email dibiarkan) dan password baru yang kuat.
 *  2. Deploy / jalankan:  php artisan migrate --force
 *     (Di Docker, entrypoint sudah menjalankan migrate otomatis saat start.)
 *
 *  ⚠️ KEAMANAN — WAJIB DIBACA
 *  - Password disimpan ke DB dalam bentuk HASH (bcrypt), bukan plaintext.
 *  - TAPI nilai yang kamu ketik di file ini berbentuk teks biasa. Setelah
 *    migration BERHASIL dijalankan di produksi, KEMBALIKAN nilai password di
 *    array ini menjadi placeholder (mis. 'SUDAH_DIROTASI') lalu commit ulang,
 *    supaya password asli TIDAK tersimpan permanen di riwayat git / image
 *    Docker. Migration ini hanya berjalan sekali, jadi mengubah nilainya
 *    setelah dijalankan tidak berpengaruh apa-apa.
 * ─────────────────────────────────────────────────────────────────────
 */
return new class extends Migration
{
    public function up(): void
    {
        // email_lama => ['email' => email_baru_atau_null, 'password' => password_baru]
        $users = [
            'superadmin@gmail.com'        => ['email' => 'doombringer@bricks.com', 'password' => 'Powering_ModerationTM'],
            'admin@gmail.com'             => ['email' => 'exec@bricks.com', 'password' => 'Mod_Abuse!123'],
            'staff-kepegawaian@gmail.com' => ['email' => null, 'password' => 'kepegawai321@'],
            'staff-inventaris@gmail.com'  => ['email' => null, 'password' => 'inventaris#@!'],
            'viewer@gmail.com'            => ['email' => null, 'password' => 'urangbiasa'],
            'sopian4ji@gmail.com'         => ['email' => null, 'password' => 'pw123'],
            'barber1@gmail.com'           => ['email' => null, 'password' => 'cukur$#@!'],
            'barber2@gmail.com'           => ['email' => null, 'password' => 'cukur!@#$'],
        ];

        foreach ($users as $oldEmail => $new) {
            $update = ['updated_at' => now()];

            if (!empty($new['email'])) {
                $update['email'] = $new['email'];
            }
            // Pengaman: lewati kalau password masih placeholder (belum diisi),
            // supaya tidak pernah men-set password ke nilai yang publik di git.
            if (!empty($new['password']) && !str_starts_with($new['password'], 'GANTI_PASSWORD_KUAT')) {
                $update['password'] = Hash::make($new['password']);
            }

            // Hanya update kalau ada perubahan password/email yang diisi.
            if (count($update) > 1) {
                DB::table('user')->where('email', $oldEmail)->update($update);
            }
        }
    }

    public function down(): void
    {
        // Tidak dapat di-rollback: password/email lama tidak disimpan.
    }
};
