<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\Portofolio;
use App\Models\Produk;
use App\Models\ProfilUsaha;
use App\Models\Template;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Creates a complete demo dataset for thesis defense:
     * 1 Template → 1 Tenant → 1 User + 1 ProfilUsaha + 3 Produks
     * + 1 Order (with 2 items) + 1 Invoice
     */
    public function run(): void
    {
        // =====================================================================
        // 1. Template
        // =====================================================================
        $template = Template::create([
            'nama_template' => 'Minimalist E-Commerce',
            'kategori'      => 'e-commerce',
            'preview_url'   => '/images/templates/minimalist-ecommerce.png',
            'is_active'     => true,
        ]);

        // =====================================================================
        // 2. Tenant
        // =====================================================================
        $tenant = Tenant::create([
            'nama_tenant' => 'Toko Baju Jaya',
            'slug'        => 'tokobaju',
            'template_id' => $template->id,
            'status'      => true,
        ]);

        // =====================================================================
        // 3. User (Tenant Admin)
        // =====================================================================
        User::create([
            'tenant_id' => $tenant->id,
            'nama'      => 'Ahmad Rizky',
            'email'     => 'admin@tokobaju.test',
            'password'  => Hash::make('password'),
            'role'      => 'tenant_admin',
        ]);

        // =====================================================================
        // 4. Super Admin (no tenant — platform owner)
        // =====================================================================
        User::create([
            'tenant_id' => null,
            'nama'      => 'Super Admin',
            'email'     => 'superadmin@mylinx.test',
            'password'  => Hash::make('password'),
            'role'      => 'super_admin',
        ]);

        // =====================================================================
        // 5. Profil Usaha (Business Profile)
        // =====================================================================
        ProfilUsaha::create([
            'tenant_id'  => $tenant->id,
            'nama_usaha' => 'Toko Baju Jaya',
            'deskripsi'  => 'Toko fashion terpercaya sejak 2020. Menyediakan berbagai koleksi pakaian pria dan wanita berkualitas dengan harga terjangkau.',
            'alamat'     => 'Jl. Sudirman No. 123, Jakarta Selatan',
            'no_hp'      => '081234567890',
            'logo'       => null,
        ]);

        // =====================================================================
        // 6. Portofolio
        // =====================================================================
        Portofolio::create([
            'tenant_id' => $tenant->id,
            'judul'     => 'Koleksi Lebaran 2025',
            'deskripsi' => 'Katalog lengkap koleksi pakaian muslim untuk menyambut Hari Raya Idul Fitri.',
            'gambar'    => 'portofolio/koleksi-lebaran.jpg',
        ]);

        // =====================================================================
        // 7. Produk (3 items)
        // =====================================================================
        $produkKemeja = Produk::create([
            'tenant_id'  => $tenant->id,
            'nama_produk' => 'Kemeja Batik Premium',
            'deskripsi'  => 'Kemeja batik pria motif parang, bahan katun premium. Tersedia ukuran M, L, XL.',
            'harga'      => 185000.00,
            'stok'       => 50,
            'gambar'     => null,
            'status'     => true,
        ]);

        $produkGamis = Produk::create([
            'tenant_id'  => $tenant->id,
            'nama_produk' => 'Gamis Syari Elegant',
            'deskripsi'  => 'Gamis syari wanita bahan wolfis premium, cutting umbrella. Warna pastel.',
            'harga'      => 250000.00,
            'stok'       => 30,
            'gambar'     => null,
            'status'     => true,
        ]);

        Produk::create([
            'tenant_id'  => $tenant->id,
            'nama_produk' => 'Kaos Polos Unisex',
            'deskripsi'  => 'Kaos polos cotton combed 30s. Tersedia 12 pilihan warna.',
            'harga'      => 75000.00,
            'stok'       => 100,
            'gambar'     => null,
            'status'     => true,
        ]);

        // =====================================================================
        // 8. Order (sample order with 2 items)
        // =====================================================================
        $order = Order::create([
            'tenant_id'     => $tenant->id,
            'kode_order'    => 'ORD-' . strtoupper(Str::random(8)),
            'nama_pembeli'  => 'Budi Santoso',
            'email_pembeli' => 'budi@example.com',
            'total_harga'   => 435000.00,
            'status'        => 'confirmed',
        ]);

        // =====================================================================
        // 9. Order Items
        // =====================================================================
        OrderItem::create([
            'order_id'  => $order->id,
            'produk_id' => $produkKemeja->id,
            'jumlah'    => 1,
            'harga'     => 185000.00,
            'subtotal'  => 185000.00,
        ]);

        OrderItem::create([
            'order_id'  => $order->id,
            'produk_id' => $produkGamis->id,
            'jumlah'    => 1,
            'harga'     => 250000.00,
            'subtotal'  => 250000.00,
        ]);

        // =====================================================================
        // 10. Invoice
        // =====================================================================
        Invoice::create([
            'order_id'          => $order->id,
            'nomor_invoice'     => 'INV-' . date('Ymd') . '-0001',
            'qr_code_url'       => null,
            'status_pembayaran' => 'paid',
        ]);

        // =====================================================================
        // Console feedback
        // =====================================================================
        $this->command->info('');
        $this->command->info('=============================================');
        $this->command->info('  MyLinx demo data seeded successfully!');
        $this->command->info('=============================================');
        $this->command->info('  Tenant Admin : admin@tokobaju.test');
        $this->command->info('  Super Admin  : superadmin@mylinx.test');
        $this->command->info('  Password     : password');
        $this->command->info('  Tenant URL   : http://localhost:8000/tokobaju');
        $this->command->info('=============================================');
        $this->command->info('');
    }
}
