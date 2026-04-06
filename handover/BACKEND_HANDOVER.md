# MyLinx — Backend Engineering Handover
> **Stack:** Laravel 12 · PostgreSQL · PHP 8.3 · Blade (server-rendered, no SPA)
> **Updated:** 2026-04-06
> **Author:** Frontend Integration Team

---

## 1. Project Overview

MyLinx adalah platform **multi-tenant UMKM storefront**. Setiap UMKM (Tenant) mendapatkan subdirectory storefront publik (`/{slug}/`) dan akses ke CMS admin untuk mengelola produk, order, portofolio, dan pengaturan toko.

**Dua jenis user:**
| Role | `role` value | `tenant_id` | Akses |
|---|---|---|---|
| Super Admin | `super_admin` | `NULL` | Dashboard platform-wide, tidak bisa akses CMS tenant |
| Tenant Admin | `tenant_admin` | UUID | CMS lengkap (produk, order, payment, settings) |

---

## 2. Environment & Infrastructure

```
# src/.env — key values
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5433          # host port (container port 5432)
DB_DATABASE=mylinx
DB_USERNAME=mylinx
DB_PASSWORD=secret

APP_URL=http://localhost:8000
```

**Jalankan dev server:**
```bash
cd src/
php artisan serve        # port 8000
# atau pakai Makefile dari root project
make dev
```

---

## 3. Database Schema

Semua primary key adalah **UUID** (`HasUuids` trait). Database: **PostgreSQL** — string search menggunakan `ilike` (case-insensitive), bukan `like`.

### ERD Ringkas
```
templates         tenants           users
    id ─────────── template_id   tenant_id ──┐
                       id ──────────────────── tenant_id
                       │
              ┌────────┼──────────┬────────────┐
              │        │          │            │
         profil_usahas  portofolios  produks   orders
              └────────            └──────── tenant_id
                                                │
                                         order_items  invoices
                                          order_id      order_id
                                          produk_id
```

### Tabel Lengkap

#### `templates`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | UUID PK | |
| `nama` | string | |
| `thumbnail` | string nullable | |
| `timestamps` | | |

#### `tenants`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | UUID PK | |
| `nama_tenant` | string | Nama bisnis |
| `slug` | string unique | URL prefix storefront (`/{slug}/`) |
| `template_id` | UUID FK → templates | |
| `status` | boolean | `true` = aktif |
| `timestamps` | | |

> **Route Key:** `slug` (bukan `id`). Lihat `getRouteKeyName()` di `Tenant` model.

#### `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | UUID PK | |
| `tenant_id` | UUID FK nullable | NULL = super_admin |
| `nama` | string | Nama tampil di UI |
| `email` | string unique | |
| `password` | string (hashed) | |
| `role` | string | `tenant_admin` / `super_admin` |
| `email_verified_at` | timestamp nullable | |
| `timestamps` | | |

#### `profil_usahas`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | UUID PK | |
| `tenant_id` | UUID FK → tenants | CASCADE delete |
| `nama_usaha` | string | Nama toko untuk publik |
| `deskripsi` | text | |
| `alamat` | string | |
| `no_hp` | string | |
| `logo` | string nullable | Path di `storage/` |
| `timestamps` | | |

#### `portofolios`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | UUID PK | |
| `tenant_id` | UUID FK → tenants | CASCADE delete |
| `judul` | string | |
| `deskripsi` | text | |
| `gambar` | string | Path di `storage/` |
| `timestamps` | | |

#### `produks`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | UUID PK | |
| `tenant_id` | UUID FK → tenants | CASCADE delete |
| `nama_produk` | string | |
| `deskripsi` | text | |
| `harga` | decimal(12,2) | |
| `stok` | integer | default 0 |
| `gambar` | string nullable | Path di `storage/` |
| `status` | boolean | `true` = aktif/tampil di storefront |
| `timestamps` | | |

> **Business Rule:** Produk dengan `stok <= 0` otomatis di-set `status = false` oleh `TenantOrderController`.

#### `orders`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | UUID PK | |
| `tenant_id` | UUID FK → tenants | CASCADE delete |
| `kode_order` | string unique | Format: `ORD-YYYYMMDD-XXXX` |
| `nama_pembeli` | string | Dari form checkout (publik) |
| `email_pembeli` | string | Dari form checkout (publik) |
| `total_harga` | decimal(12,2) | Dihitung server, bukan dari form |
| `status` | string | Lihat enum di bawah |
| `timestamps` | | |

**Order Status Enum:**
```
pending → confirmed → processing → completed
                                ↘
                             cancelled
```

#### `order_items`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | UUID PK | |
| `order_id` | UUID FK → orders | CASCADE delete |
| `produk_id` | UUID FK → produks | RESTRICT delete (tidak bisa hapus produk yg ada di order) |
| `jumlah` | integer | |
| `harga` | decimal(12,2) | Harga saat checkout (snapshot) |
| `subtotal` | decimal(12,2) | `harga × jumlah` |
| `timestamps` | | |

#### `invoices`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | UUID PK | |
| `order_id` | UUID FK → orders | CASCADE delete |
| `nomor_invoice` | string unique | Format: `INV-YYYYMMDD-XXXX` |
| `qr_code_url` | string nullable | **Belum diimplementasi** — placeholder untuk QR pembayaran |
| `status_pembayaran` | string | `unpaid` / `paid` / `cancelled` |
| `timestamps` | | |

---

## 4. Routes

```
GET  /                              landing (public)

# CMS Admin — middleware: auth, verified, has.tenant (tenant_admin only)
GET     /dashboard                  DashboardController (role-based)
GET     /produk                     ProdukController@index
GET     /produk/create              ProdukController@create
POST    /produk                     ProdukController@store
GET     /produk/{produk}/edit       ProdukController@edit
PUT     /produk/{produk}            ProdukController@update
DELETE  /produk/{produk}            ProdukController@destroy
GET     /profil-usaha               ProfilUsahaController@edit
PATCH   /profil-usaha               ProfilUsahaController@update
GET     /portfolio                  PortofolioController@index
POST    /portfolio                  PortofolioController@store
PUT     /portfolio/{portfolio}      PortofolioController@update
DELETE  /portfolio/{portfolio}      PortofolioController@destroy
GET     /order                      OrderController@index       (?search=, ?status=)
GET     /order/{order}              OrderController@show
PATCH   /order/{order}              OrderController@update      (status update)
GET     /payment                    PaymentController@index
GET     /settings/website           SettingController@editWebsite
PATCH   /settings/website           SettingController@updateWebsite
GET     /settings/template          SettingController@editTemplate
PATCH   /settings/template          SettingController@updateTemplate

# User Account — middleware: auth
GET     /profile                    ProfileController@edit
PATCH   /profile                    ProfileController@update
DELETE  /profile                    ProfileController@destroy

# Tenant Storefront — public (prefix: /{tenant_slug}/)
GET     /{tenant}                   TenantPageController@show
GET     /{tenant}/produk/{produk}   TenantPageController@produkDetail
GET     /{tenant}/checkout/{produk} TenantOrderController@create
POST    /{tenant}/checkout/{produk} TenantOrderController@store
GET     /{tenant}/order/{order}/success  TenantOrderController@success
```

---

## 5. Controller Summary

### `DashboardController` (invokable)
Detects role dari `auth()->user()->isSuperAdmin()`:
- **Tenant Admin**: query `Order`, `Produk` by `tenant_id` → pass ke view: `$totalRevenue`, `$ordersThisMonth`, `$activeProducts`, `$totalProducts`, `$recentOrders`, `$pendingOrders`
- **Super Admin**: query platform-wide → pass ke view: `$totalTenants`, `$totalUsers`, `$totalOrders`, `$totalRevenue`, `$recentTenants`

### `OrderController`
- **`index()`**: filter by `tenant_id`, support `?search=` dan `?status=` via Eloquent scopes (`scopeSearch`, `scopeStatus`), paginate(10). Return `$orders`.
- **`show(Order $order)`**: verify `$order->tenant_id === auth()->user()->tenant_id`, eager-load `['orderItems.produk', 'invoice']`. Return `$order`.
- **`update()`**: ubah status order + sync `invoice.status_pembayaran`. Restore stok jika status `cancelled`. Return redirect dengan flash `success`.

### `PaymentController`
- **`index()`**: query `Invoice` through `order.tenant_id`, eager-load `order` (select terbatas), paginate(10). Return `$invoices`.

### `TenantOrderController`
- **`store()`**: menggunakan **DB transaction + pessimistic locking** (`lockForUpdate()`). Harga dihitung dari database (TIDAK dari form). Auto-deactivate produk jika stok habis. Membuat: `Order` → `OrderItem` → `Invoice`.

### `TenantPageController`
- **`show()`**: load `profilUsaha`, `portofolios`, `produks` (only `status=true & stok>0`).
- **`produkDetail()`**: validasi produk belongs to tenant & masih aktif.

---

## 6. Models & Relationships

```php
// User
- belongsTo(Tenant)
- isSuperAdmin(): bool  → role === 'super_admin' && tenant_id === null
- isTenantAdmin(): bool → role === 'tenant_admin' && tenant_id !== null

// Tenant
- belongsTo(Template)
- hasOne(ProfilUsaha)
- hasMany(User)
- hasMany(Produk)
- hasMany(Portofolio)
- hasMany(Order)
- getRouteKeyName() → 'slug'   ← PENTING: binding by slug, bukan UUID

// Order
- belongsTo(Tenant)
- hasMany(OrderItem)
- hasOne(Invoice)
- scopeSearch($term)           ← ilike kode_order, nama_pembeli, email_pembeli
- scopeStatus($status)         ← filter by status string

// Produk
- belongsTo(Tenant)
- hasMany(OrderItem)
- scopeSearch($term)           ← ilike nama_produk, deskripsi
- scopeStockStatus($status)    ← 'available' | 'empty' | 'inactive'

// OrderItem
- belongsTo(Order)
- belongsTo(Produk)            ← RESTRICT on delete: produk tidak bisa dihapus jika ada di orderItem

// Invoice
- belongsTo(Order)

// ProfilUsaha
- belongsTo(Tenant)

// Portofolio
- belongsTo(Tenant)
```

---

## 7. Middleware

### `has.tenant` (`EnsureHasTenant`)
Registered di `bootstrap/app.php`. Redirect ke `dashboard` jika `user->tenant_id === null`.
- Mencegah super_admin mengakses `/produk`, `/order`, `/payment`, `/settings`, `/profil-usaha`.
- API response: `403 Tenant access required.`

### `tenant` (Route middleware pada storefront)
Resolve `{tenant}` parameter dari slug. Jika tenant tidak ditemukan → 404.

---

## 8. Form Requests

### `StoreTenantOrderRequest`
```php
rules: [
    'nama_pembeli' => required|string|max:255,
    'email_pembeli' => required|email|max:255,
    'jumlah'       => required|integer|min:1|max:999,
]
authorize: true  // public checkout, no auth required
```
> **PENTING**: Harga TIDAK di-validate dari form. Controller mengambil harga dari DB.

### `UpdateOrderStatusRequest`
```php
rules: [
    'status' => required|in:pending,confirmed,processing,completed,cancelled
]
authorize: auth()->check() && auth()->user()->tenant_id !== null
```

---

## 9. Business Rules & Logic

### Checkout Flow
```
Buyer → GET /{tenant}/checkout/{produk}
     → POST /{tenant}/checkout/{produk}
          ↓
     DB::transaction()
          1. lockForUpdate() produk row
          2. cek stok > 0 && produk.status = true
          3. hitung total dari DB price (ignore form price)
          4. CREATE order (status: pending)
          5. CREATE order_item
          6. DECREMENT produk.stok
          7. jika stok === 0 → UPDATE produk.status = false
          8. CREATE invoice (status_pembayaran: unpaid)
          ↓
     redirect /{tenant}/order/{order}/success
```

### Order Status → Invoice Sync
| Order Status | Invoice `status_pembayaran` |
|---|---|
| `completed` | `paid` |
| `cancelled` | `cancelled` |
| `processing` | `unpaid` |
| `pending` / `confirmed` | tidak berubah |

### Stock Restoration (Cancel Order)
Jika `order.status` diubah ke `cancelled` dari status sebelumnya yang bukan `cancelled`:
1. `orderItem.produk.stok += orderItem.jumlah`
2. Jika produk sebelumnya `status = false` karena stok habis → `status = true`

---

## 10. Views yang Diharapkan Controller

Setiap view blade dan variabel yang di-pass controller:

| View | Controller | Variabel |
|---|---|---|
| `dashboard` | `DashboardController` | Tenant: `$totalRevenue`, `$ordersThisMonth`, `$activeProducts`, `$totalProducts`, `$recentOrders`, `$pendingOrders` · Super: `$totalTenants`, `$totalUsers`, `$totalOrders`, `$totalRevenue`, `$recentTenants` |
| `order.index` | `OrderController@index` | `$orders` (LengthAwarePaginator) |
| `order.show` | `OrderController@show` | `$order` (with `orderItems.produk`, `invoice`) |
| `payment.index` | `PaymentController@index` | `$invoices` (LengthAwarePaginator, with `order`) |
| `tenant.show` | `TenantPageController@show` | `$tenant`, `$profil`, `$produks`, `$portofolios` |
| `tenant.produk-detail` | `TenantPageController@produkDetail` | `$tenant`, `$profil`, `$produk` |
| `tenant.checkout` | `TenantOrderController@create` | `$tenant`, `$profil`, `$produk` |
| `tenant.order-success` | `TenantOrderController@success` | `$tenant`, `$profil`, `$order`, `$invoice` |
| `produk.index` | `ProdukController@index` | `$produks` (paginated) |
| `produk.create` | `ProdukController@create` | — |
| `produk.edit` | `ProdukController@edit` | `$produk` |
| `portfolio.index` | `PortofolioController@index` | `$portofolios` |
| `settings.website` | `SettingController@editWebsite` | `$profil` |
| `settings.template` | `SettingController@editTemplate` | `$templates`, `$currentTemplate` |
| `profil-usaha.edit` | `ProfilUsahaController@edit` | `$profil` |

---

## 11. Yang Belum Diimplementasikan (Open Items)

### 🔴 Prioritas Tinggi
| Item | Keterangan |
|---|---|
| **QR Code / Payment Gateway** | `invoices.qr_code_url` masih `null`. Belum ada integrasi Midtrans/Xendit. View `order-success` sudah ada placeholder untuk QR. |
| **Email Notifikasi** | Buyer tidak dapat konfirmasi email setelah checkout. Perlu `Mailable` + Queue. |
| **Image Upload Validation** | Produk/portofolio gambar belum divalidasi tipe file dan ukuran di server. |

### 🟡 Prioritas Menengah
| Item | Keterangan |
|---|---|
| **Tenant Registration Flow** | Belum ada self-service onboarding. Tenant dibuat manual/seeder. |
| **Super Admin CMS** | Super admin hanya punya dashboard read-only. Belum bisa manage tenants dari UI. |
| **Produk Multi-gambar** | Skema dan view hanya support 1 gambar (`gambar` string). Kalau mau galeri, perlu tabel `produk_images`. |
| **Order Address** | `orders` tidak punya field alamat pengiriman. Saat ini hanya `nama_pembeli` + `email_pembeli`. |

### 🟢 Nice to Have
| Item | Keterangan |
|---|---|
| **API (REST)** | `routes/api.php` belum dibuat. Jika perlu mobile app integration, scaffold Sanctum + API routes. |
| **Webhook** | Tidak ada webhook handler untuk menerima notifikasi dari payment gateway. |
| **Search (Payment)** | `payment.index` view sudah ada search input tapi `PaymentController@index` belum handle `?search=`. |

---

## 12. Penting untuk Backend Engineer

1. **PostgreSQL `ilike`** — semua search scope menggunakan `ilike` (case-insensitive). Jangan ganti ke `like` karena akan jadi case-sensitive di PostgreSQL.

2. **`.env` DB_PORT=5433** — ini port HOST (Docker mapping). Container internal tetap 5432. Jangan ubah ke 5432 di config.

3. **UUID everywhere** — semua model pakai `HasUuids`. Jangan pernah pakai `int` ID. Route binding bekerja otomatis.

4. **Tenant slug routing** — `Tenant::getRouteKeyName()` mengembalikan `'slug'`. Artinya `/{tenant}` di URL di-resolve berdasarkan `tenants.slug`, bukan `id`. Ini sudah berjalan.

5. **Tenancy security** — `OrderController` dan `TenantOrderController` sudah melakukan manual tenancy check (`$order->tenant_id !== auth()->user()->tenant_id → abort(403)`). Jika menambahkan controller baru, ikuti pattern yang sama.

6. **File storage** — gambar produk/portofolio/logo disimpan di `storage/` via `Storage::disk('public')`. Pastikan `php artisan storage:link` sudah dijalankan.

7. **Pessimistic locking** — `TenantOrderController@store` menggunakan `lockForUpdate()`. Ini kritikal untuk mencegah overselling. Jangan refactor tanpa mempertahankan behavior ini.

---

## 13. Cara Setup Local

```bash
# Clone & setup
cd MyLinx/src
composer install
cp .env.example .env
php artisan key:generate

# Database
# Pastikan PostgreSQL berjalan di port 5433 (atau sesuaikan .env)
php artisan migrate
php artisan db:seed       # jika ada seeder

# Storage
php artisan storage:link

# Assets (Vite)
npm install
npm run dev

# Server
php artisan serve
```

**Test accounts (dari seeder):**
```
Tenant Admin : admin@tokobaju.test / password
Super Admin  : superadmin@mylinx.test / password
```

---

## 14. File Structure Penting

```
src/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php      ← invokable, role-based
│   │   │   ├── OrderController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── ProdukController.php
│   │   │   ├── PortofolioController.php
│   │   │   ├── ProfilUsahaController.php
│   │   │   ├── SettingController.php
│   │   │   └── Tenant/
│   │   │       ├── TenantPageController.php ← public storefront
│   │   │       └── TenantOrderController.php← checkout + transaction
│   │   ├── Middleware/
│   │   │   └── EnsureHasTenant.php          ← alias: has.tenant
│   │   └── Requests/
│   │       ├── StoreTenantOrderRequest.php
│   │       └── UpdateOrderStatusRequest.php
│   └── Models/
│       ├── User.php        ← isSuperAdmin(), isTenantAdmin()
│       ├── Tenant.php      ← getRouteKeyName() = 'slug'
│       ├── Order.php       ← scopeSearch(), scopeStatus()
│       ├── Produk.php      ← scopeSearch(), scopeStockStatus()
│       ├── Invoice.php
│       ├── OrderItem.php
│       ├── ProfilUsaha.php
│       ├── Portofolio.php
│       └── Template.php
├── database/migrations/    ← 11 migration files, semua UUID
├── resources/views/
│   ├── layouts/app.blade.php               ← admin layout
│   ├── dashboard.blade.php                 ← dual-role dashboard
│   ├── order/{index,show}.blade.php
│   ├── payment/index.blade.php
│   ├── produk/{index,create,edit}.blade.php
│   ├── portfolio/index.blade.php
│   ├── settings/{website,template}.blade.php
│   ├── profil-usaha/edit.blade.php
│   └── tenant/{show,produk-detail,checkout,order-success}.blade.php
└── routes/
    ├── web.php             ← semua routes (lihat Section 4)
    └── auth.php            ← Breeze auth routes
```
