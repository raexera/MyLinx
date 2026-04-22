<?php

namespace Database\Factories;

use App\Models\ProfilUsaha;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfilUsahaFactory extends Factory
{
    protected $model = ProfilUsaha::class;

    public function definition(): array
    {
        $usahaList = [
            ['nama' => 'Toko Berkah Jaya', 'desk' => 'Menyediakan berbagai kebutuhan fashion muslim pria dan wanita berkualitas premium dengan harga bersahabat. Melayani pembelian grosir dan eceran sejak 2019.'],
            ['nama' => 'Warung Kopi Nusantara', 'desk' => 'Kedai kopi speciality yang menyajikan biji kopi pilihan dari seluruh penjuru Nusantara. Dari Aceh Gayo hingga Papua Wamena.'],
            ['nama' => 'Batik Sekar Arum', 'desk' => 'Produsen batik tulis dan cap asli Pekalongan. Melestarikan motif tradisional dengan sentuhan desain modern untuk generasi muda.'],
            ['nama' => 'Dapur Sunda Asli', 'desk' => 'Catering dan frozen food masakan Sunda autentik. Resep turun temurun, bahan segar setiap hari, tanpa MSG.'],
            ['nama' => 'Craft & Co Handmade', 'desk' => 'Workshop kreatif yang menghasilkan produk handmade dari rotan, kayu, dan bahan alami. Mendukung pengrajin lokal Jawa Barat.'],
        ];

        $usaha = fake()->randomElement($usahaList);

        $cities = [
            'Jl. Sudirman No. 45, Jakarta Selatan',
            'Jl. Braga No. 12, Bandung',
            'Jl. Malioboro No. 88, Yogyakarta',
            'Jl. Tunjungan No. 21, Surabaya',
            'Jl. Pandanaran No. 55, Semarang',
        ];

        return [
            'tenant_id' => Tenant::factory(),
            'nama_usaha' => $usaha['nama'],
            'deskripsi' => $usaha['desk'],
            'alamat' => fake()->randomElement($cities),
            'no_hp' => '+628'.fake()->numerify('#########'),
            'logo' => null,
        ];
    }
}
