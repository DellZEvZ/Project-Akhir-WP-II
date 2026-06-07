<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Produk katalog grooming pria.
     * Produk utama mengacu pada Makarizo Barber Daily Styling Gel
     * (https://makarizo.com/id_ID/product/barber-daily-styling-gel-wet-look-tube-200-ml/).
     */
    public function run(): void
    {
        $userId = \App\Models\User::min('id') ?? 1;

        $kategoriStyling = Kategori::firstOrCreate(['nama_kategori' => 'Hair Styling']);
        $kategoriRambut  = Kategori::firstOrCreate(['nama_kategori' => 'Perawatan Rambut']);
        $kategoriJenggot = Kategori::firstOrCreate(['nama_kategori' => 'Perawatan Jenggot']);

        $produk = [
            [
                'nama_produk' => 'Makarizo Barber Daily Styling Gel Wet Look 200 ml',
                'detail' => 'Hair styling gel untuk pria yang menyukai kombinasi styling mudah dan tampilan kasual. Diformulasikan dengan ekstrak castor oil serta ekstrak citrus & musk, memberikan aroma segar dan sejuk dengan hasil wet look.',
                'harga' => 38000,
                'stok' => 40,
                'berat' => 220,
                'foto' => 'makarizo-barber-daily-gel.png',
                'kategori_id' => $kategoriStyling->id,
            ],
            [
                'nama_produk' => 'Classic Hold Pomade Strong 100 g',
                'detail' => 'Pomade water-based dengan daya tahan kuat dan kilau medium. Mudah dibilas, cocok untuk gaya klasik slick back maupun pompadour.',
                'harga' => 55000, 'stok' => 30, 'berat' => 120,
                'foto' => '', 'kategori_id' => $kategoriStyling->id,
            ],
            [
                'nama_produk' => 'Matte Clay Hair Wax 75 g',
                'detail' => 'Hair clay dengan hasil akhir matte tanpa kilau, daya cengkeram kuat untuk gaya tekstur natural sepanjang hari.',
                'harga' => 49000, 'stok' => 25, 'berat' => 95,
                'foto' => '', 'kategori_id' => $kategoriStyling->id,
            ],
            [
                'nama_produk' => 'Hair Tonic Anti Rontok 200 ml',
                'detail' => 'Hair tonic penyegar kulit kepala yang membantu mengurangi kerontokan dan menjaga rambut tetap sehat serta ternutrisi.',
                'harga' => 42000, 'stok' => 35, 'berat' => 215,
                'foto' => '', 'kategori_id' => $kategoriRambut->id,
            ],
            [
                'nama_produk' => 'Daily Shampoo for Men 250 ml',
                'detail' => 'Sampo harian pria dengan sensasi dingin menyegarkan, membersihkan minyak berlebih tanpa membuat rambut kering.',
                'harga' => 33000, 'stok' => 50, 'berat' => 270,
                'foto' => '', 'kategori_id' => $kategoriRambut->id,
            ],
            [
                'nama_produk' => 'Beard Oil Argan & Jojoba 30 ml',
                'detail' => 'Minyak jenggot dengan argan & jojoba oil untuk melembutkan jenggot, melembapkan kulit, dan memberikan aroma maskulin.',
                'harga' => 60000, 'stok' => 20, 'berat' => 45,
                'foto' => '', 'kategori_id' => $kategoriJenggot->id,
            ],
        ];

        foreach ($produk as $row) {
            $p = Produk::firstOrNew(['nama_produk' => $row['nama_produk']]);
            $p->forceFill(array_merge($row, [
                'user_id' => $userId,
                'status'  => 1,
            ]));
            $p->save();
        }
    }
}
