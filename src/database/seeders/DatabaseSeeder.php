<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Portofolio;
use App\Models\Produk;
use App\Models\ProfilUsaha;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::create([
            'nama_tenant' => 'Toko Baju Jaya',
            'slug' => 'tokobaju',
            'status' => true,
        ]);

        User::create([
            'tenant_id' => $tenant->id,
            'nama' => 'Ahmad Rizky',
            'email' => 'admin@tokobaju.test',
            'password' => Hash::make('password'),
            'role' => 'tenant_admin',
        ]);

        User::create([
            'tenant_id' => null,
            'nama' => 'Super Admin',
            'email' => 'superadmin@mylinx.test',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        ProfilUsaha::create([
            'tenant_id' => $tenant->id,
            'nama_usaha' => 'Toko Baju Jaya',
            'deskripsi' => 'Toko fashion terpercaya sejak 2020. Menyediakan berbagai koleksi pakaian pria dan wanita berkualitas dengan harga terjangkau.',
            'alamat' => 'Jl. Sudirman No. 123, Jakarta Selatan',
            'no_hp' => '+6281234567890',
            'logo' => null,
        ]);

        Portofolio::create([
            'tenant_id' => $tenant->id,
            'judul' => 'Koleksi Lebaran 2025',
            'deskripsi' => 'Katalog lengkap koleksi pakaian muslim untuk menyambut Hari Raya Idul Fitri.',
            'gambar' => 'portofolio/koleksi-lebaran.jpg',
        ]);

        $produkKemeja = Produk::create([
            'tenant_id' => $tenant->id,
            'nama_produk' => 'Kemeja Batik Premium',
            'deskripsi' => 'Kemeja batik pria motif parang, bahan katun premium. Tersedia ukuran M, L, XL.',
            'harga' => 185000.00,
            'stok' => 50,
            'gambar' => null,
            'status' => true,
        ]);

        $produkGamis = Produk::create([
            'tenant_id' => $tenant->id,
            'nama_produk' => 'Gamis Syari Elegant',
            'deskripsi' => 'Gamis syari wanita bahan wolfis premium, cutting umbrella. Warna pastel.',
            'harga' => 250000.00,
            'stok' => 30,
            'gambar' => null,
            'status' => true,
        ]);

        Produk::create([
            'tenant_id' => $tenant->id,
            'nama_produk' => 'Kaos Polos Unisex',
            'deskripsi' => 'Kaos polos cotton combed 30s. Tersedia 12 pilihan warna.',
            'harga' => 75000.00,
            'stok' => 100,
            'gambar' => null,
            'status' => true,
        ]);

        $order = Order::create([
            'tenant_id' => $tenant->id,
            'kode_order' => 'ORD-'.strtoupper(Str::random(8)),
            'nama_pembeli' => 'Budi Santoso',
            'email_pembeli' => 'budi@example.com',
            'total_harga' => 435000.00,
            'status' => 'confirmed',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'produk_id' => $produkKemeja->id,
            'jumlah' => 1,
            'harga' => 185000.00,
            'subtotal' => 185000.00,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'produk_id' => $produkGamis->id,
            'jumlah' => 1,
            'harga' => 250000.00,
            'subtotal' => 250000.00,
        ]);

        Invoice::create([
            'order_id' => $order->id,
            'nomor_invoice' => 'INV-'.date('Ymd').'-0001',
            'qr_code_url' => null,
            'status_pembayaran' => 'paid',
        ]);

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
