<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition(): array
    {
        $produkList = [
            ['nama' => 'Kemeja Batik Solo Premium', 'desk' => 'Kemeja batik tulis asli Solo dengan motif parang klasik. Bahan katun primissima yang adem dan nyaman dipakai seharian.'],
            ['nama' => 'Gamis Syari Rayon Polos', 'desk' => 'Gamis syari bahan rayon premium, cutting umbrella lebar. Cocok untuk pengajian, arisan, atau acara formal.'],
            ['nama' => 'Kaos Polos Cotton Combed 30s', 'desk' => 'Kaos polos unisex bahan cotton combed 30s. Tersedia 15 pilihan warna. Sablon DTF berkualitas tinggi.'],
            ['nama' => 'Celana Chino Slim Fit', 'desk' => 'Celana chino pria slim fit bahan twill stretch. Nyaman dipakai untuk kerja maupun hangout.'],
            ['nama' => 'Hijab Pashmina Diamond', 'desk' => 'Pashmina bahan diamond italiano. Tidak mudah kusut, jatuhnya cantik. Ukuran 175x75cm.'],
            ['nama' => 'Tas Tote Bag Kanvas', 'desk' => 'Tote bag kanvas tebal 12oz dengan resleting. Desain minimalis cocok untuk daily use.'],
            ['nama' => 'Sandal Kulit Handmade', 'desk' => 'Sandal kulit sapi asli buatan pengrajin Cibaduyut. Sol karet anti slip, jahitan rapi dan kuat.'],
            ['nama' => 'Kopi Arabica Toraja 250gr', 'desk' => 'Biji kopi arabica single origin dari Toraja. Roasting medium, notes cokelat dan buah berry.'],
            ['nama' => 'Sambal Matah Bali 200ml', 'desk' => 'Sambal matah khas Bali, fresh tanpa pengawet. Dibuat dari serai, daun jeruk, dan cabai rawit pilihan.'],
            ['nama' => 'Madu Hutan Kalimantan 500ml', 'desk' => 'Madu hutan asli dari lebah liar Kalimantan. Kental, rasa autentik, tanpa campuran gula.'],
        ];

        $produk = fake()->randomElement($produkList);

        return [
            'tenant_id' => Tenant::factory(),
            'nama_produk' => $produk['nama'],
            'deskripsi' => $produk['desk'],
            'harga' => fake()->randomElement([25000, 49000, 75000, 125000, 185000, 250000, 350000, 675000, 1250000]),
            'stok' => fake()->numberBetween(0, 100),
            'gambar' => null,
            'status' => fake()->boolean(85),
        ];
    }

    public function habis(): static
    {
        return $this->state(fn (array $attributes) => [
            'stok' => 0,
            'status' => false,
        ]);
    }
}
