<?php

namespace Database\Factories;

use App\Models\Portofolio;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortofolioFactory extends Factory
{
    protected $model = Portofolio::class;

    public function definition(): array
    {
        $portofolioList = [
            ['judul' => 'Koleksi Lebaran 2025', 'desk' => 'Rangkaian busana muslim eksklusif untuk menyambut Hari Raya Idul Fitri. Desain elegan dengan bahan premium.'],
            ['judul' => 'Katalog Produk Ramadhan', 'desk' => 'Katalog lengkap produk spesial bulan Ramadhan termasuk hampers, mukena, dan perlengkapan ibadah.'],
            ['judul' => 'Project Catering Kantor', 'desk' => 'Dokumentasi layanan catering harian untuk 3 kantor di Jakarta dengan menu Nusantara bergilir.'],
            ['judul' => 'Pameran Craft Jakarta 2025', 'desk' => 'Partisipasi di pameran kerajinan tangan Jakarta Convention Center. Booth design dan display produk.'],
            ['judul' => 'Kolaborasi Brand Lokal', 'desk' => 'Proyek kolaborasi eksklusif dengan brand lokal untuk menghasilkan produk limited edition.'],
        ];

        $item = fake()->randomElement($portofolioList);

        return [
            'tenant_id' => Tenant::factory(),
            'judul' => $item['judul'],
            'deskripsi' => $item['desk'],
            'gambar' => 'portofolio/placeholder-'.fake()->numberBetween(1, 5).'.jpg',
        ];
    }
}
