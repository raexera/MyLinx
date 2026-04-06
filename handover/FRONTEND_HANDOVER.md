# MyLinx Frontend Handover — Backend API Contract

> **For AI agents**: This doc is the single source of truth for all Blade views.
> Every route, variable, form action, and field name is listed below.
> Do NOT invent routes or field names. Use ONLY what's documented here.

---

## Tech Stack

- Blade SSR (no SPA, no API, no JavaScript frameworks)
- Tailwind CSS + Alpine.js (installed via Breeze)
- Vite for asset compilation (`@vite(['resources/css/app.css', 'resources/js/app.js'])`)
- Font: `Instrument Serif` + `Inter` (loaded in guest layout)
- Brand color: `#2E5136` (dark green)

## Layouts

| Layout | Usage |
|---|---|
| `<x-app-layout>` | Authenticated dashboard pages (has sidebar) |
| `<x-guest-layout>` | Auth pages (login, register) + landing |
| Standalone HTML | Public tenant storefront pages (no layout component) |

## Auth Helpers Available in Blade

```blade
Auth::user()->nama              {{-- User display name --}}
Auth::user()->email
Auth::user()->role               {{-- 'tenant_admin' or 'super_admin' --}}
Auth::user()->tenant_id          {{-- UUID or null --}}
Auth::user()->tenant             {{-- Tenant model (eager-load if needed) --}}
Auth::user()->tenant->slug       {{-- e.g. 'tokobaju' --}}
Auth::user()->tenant->nama_tenant
Auth::user()->isSuperAdmin()     {{-- bool --}}
Auth::user()->isTenantAdmin()    {{-- bool --}}
```

## Flash Messages

All controllers use `->with('success', '...')`. Render with:

```blade
@if(session('success'))
    <div class="...">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="...">{{ session('error') }}</div>
@endif
```

## Validation Errors

All forms use FormRequest validation. Render with:

```blade
@error('field_name')
    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
@enderror
```

Retain old input with `old('field_name')` or `old('field_name', $model->field_name)`.

---

## VIEWS — Complete Contract

### 1. `dashboard.blade.php`

**Route:** `GET /dashboard` → `route('dashboard')`
**Layout:** `<x-app-layout>`

**Variables (tenant_admin):**
```
$totalRevenue    : string (decimal, formatted as Rp)
$ordersThisMonth : int
$activeProducts  : int
$totalProducts   : int
$pendingOrders   : int
$recentOrders    : Collection<Order> (5 items, each has ->invoice, ->orderItems)
  ->kode_order        : string
  ->nama_pembeli      : string
  ->total_harga       : string (decimal)
  ->status            : string (pending|confirmed|processing|completed|cancelled)
  ->created_at        : Carbon
  ->invoice->status_pembayaran : string (unpaid|paid|cancelled)
```

**Variables (super_admin):**
```
$totalTenants   : int
$totalUsers     : int
$totalOrders    : int
$totalRevenue   : string (decimal)
$recentTenants  : Collection<Tenant> (5 items, each has ->profilUsaha)
  ->nama_tenant       : string
  ->slug              : string
  ->created_at        : Carbon
  ->profilUsaha->nama_usaha : string (nullable)
```

**Conditional rendering:**
```blade
@if(Auth::user()->isTenantAdmin()) ... @endif
@if(Auth::user()->isSuperAdmin()) ... @endif
```

---

### 2. `produk/index.blade.php`

**Route:** `GET /produk` → `route('produk.index')`
**Layout:** `<x-app-layout>`

**Variables:**
```
$produks : LengthAwarePaginator<Produk>
  ->id              : string (UUID)
  ->nama_produk     : string
  ->deskripsi       : string
  ->harga           : string (decimal)
  ->stok            : int
  ->gambar          : string|null (path relative to storage, e.g. "produk/abc.jpg")
  ->status          : bool
  ->created_at      : Carbon
```

**Image URL:** `{{ $produk->gambar ? asset('storage/' . $produk->gambar) : '' }}`

**Pagination:** `{{ $produks->links() }}`

**Search form (GET):**
```blade
<form action="{{ route('produk.index') }}" method="GET">
    <input name="search" value="{{ request('search') }}">
    <select name="stock">
        <option value="">Semua</option>
        <option value="available" {{ request('stock') === 'available' ? 'selected' : '' }}>Aktif</option>
        <option value="empty" {{ request('stock') === 'empty' ? 'selected' : '' }}>Habis</option>
        <option value="inactive" {{ request('stock') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
    </select>
</form>
```

**Delete form (inline per row):**
```blade
<form action="{{ route('produk.destroy', $produk) }}" method="POST">
    @csrf @method('DELETE')
    <button type="submit">Hapus</button>
</form>
```

**Links:**
```blade
{{ route('produk.create') }}           {{-- "Tambah Produk Baru" button --}}
{{ route('produk.edit', $produk) }}     {{-- Edit icon per row --}}
```

---

### 3. `produk/create.blade.php`

**Route:** `GET /produk/create` → `route('produk.create')`
**Layout:** `<x-app-layout>`
**Variables:** none (empty form)

**Form:**
```blade
<form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text"   name="nama_produk" value="{{ old('nama_produk') }}" required>
    <input type="number" name="harga"       value="{{ old('harga', 0) }}" min="0" required>
    <input type="number" name="stok"        value="{{ old('stok', 0) }}" min="0" required>
    <textarea name="deskripsi" required>{{ old('deskripsi') }}</textarea>
    <input type="file"   name="gambar" accept="image/jpeg,image/png"> {{-- optional, max 5MB --}}
</form>
```

---

### 4. `produk/edit.blade.php`

**Route:** `GET /produk/{produk}/edit` → `route('produk.edit', $produk)`
**Layout:** `<x-app-layout>`
**Variables:** `$produk` (single Produk model)

**Form:**
```blade
<form action="{{ route('produk.update', $produk) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <input type="text"   name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
    <input type="number" name="harga"       value="{{ old('harga', $produk->harga) }}" required>
    <input type="number" name="stok"        value="{{ old('stok', $produk->stok) }}" required>
    <textarea name="deskripsi" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
    <input type="file"   name="gambar" accept="image/jpeg,image/png"> {{-- optional on edit --}}
</form>
```

**Current image:** `{{ $produk->gambar ? asset('storage/' . $produk->gambar) : '' }}`

---

### 5. `profil-usaha/edit.blade.php`

**Route:** `GET /profil-usaha` → `route('profil-usaha.edit')`
**Layout:** `<x-app-layout>`
**Variables:** `$profil` (ProfilUsaha model, always exists)

**Form:**
```blade
<form action="{{ route('profil-usaha.update') }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PATCH')
    <input type="text"     name="nama_usaha" value="{{ old('nama_usaha', $profil->nama_usaha) }}" required>
    <input type="text"     name="alamat"     value="{{ old('alamat', $profil->alamat) }}" required>
    <textarea name="deskripsi" required>{{ old('deskripsi', $profil->deskripsi) }}</textarea>
    <input type="text"     name="no_hp"      value="{{ old('no_hp', $profil->no_hp) }}" required>
    <input type="file"     name="logo"       accept="image/jpeg,image/png"> {{-- optional, max 2MB --}}
</form>
```

**Current logo:** `{{ $profil->logo ? asset('storage/' . $profil->logo) : '' }}`

---

### 6. `portfolio/builder.blade.php`

**Route:** `GET /portfolio` → `route('portfolio.index')`
**Layout:** `<x-app-layout>`

**Variables:**
```
$portofolios : Collection<Portofolio>
  ->id         : string (UUID)
  ->judul      : string
  ->deskripsi  : string
  ->gambar     : string (path)
  ->created_at : Carbon

$editing : Portofolio|null (set when editing, null when creating new)
```

**Create form:**
```blade
<form action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="judul" value="{{ old('judul') }}" required>
    <textarea name="deskripsi" required>{{ old('deskripsi') }}</textarea>
    <input type="file" name="gambar" accept="image/jpeg,image/png" required>
</form>
```

**Edit form (when `$editing` is set):**
```blade
<form action="{{ route('portfolio.update', $editing) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <input type="text" name="judul" value="{{ old('judul', $editing->judul) }}" required>
    <textarea name="deskripsi" required>{{ old('deskripsi', $editing->deskripsi) }}</textarea>
    <input type="file" name="gambar" accept="image/jpeg,image/png"> {{-- optional on edit --}}
</form>
```

**Links:**
```blade
{{ route('portfolio.edit', $item) }}      {{-- triggers edit mode --}}
{{ route('portfolio.index') }}            {{-- cancel edit, back to create mode --}}
```

**Delete (per item):**
```blade
<form action="{{ route('portfolio.destroy', $item) }}" method="POST">
    @csrf @method('DELETE')
    <button type="submit">Hapus</button>
</form>
```

---

### 7. `order/index.blade.php`

**Route:** `GET /order` → `route('order.index')`
**Layout:** `<x-app-layout>`

**Variables:**
```
$orders : LengthAwarePaginator<Order>
  ->id                : string (UUID)
  ->kode_order        : string (e.g. "ORD-20260325-A7K2")
  ->nama_pembeli      : string
  ->email_pembeli     : string
  ->total_harga       : string (decimal)
  ->status            : string (pending|confirmed|processing|completed|cancelled)
  ->created_at        : Carbon
  ->invoice           : Invoice|null
    ->status_pembayaran : string (unpaid|paid|cancelled)
  ->orderItems        : Collection<OrderItem>
```

**Search form (GET):**
```blade
<form action="{{ route('order.index') }}" method="GET">
    <input name="search" value="{{ request('search') }}">
    <select name="status">
        <option value="">Semua</option>
        <option value="pending"    {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="confirmed"  {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
        <option value="completed"  {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled"  {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
</form>
```

**Detail link:** `{{ route('order.show', $order) }}`

---

### 8. `order/show.blade.php`

**Route:** `GET /order/{order}` → `route('order.show', $order)`
**Layout:** `<x-app-layout>`

**Variables:**
```
$order : Order (single)
  ->kode_order, ->nama_pembeli, ->email_pembeli, ->total_harga, ->status, ->created_at
  ->orderItems : Collection<OrderItem>
    ->jumlah     : int
    ->harga      : string (decimal, unit price at time of purchase)
    ->subtotal   : string (decimal)
    ->produk     : Produk
      ->nama_produk : string
      ->gambar      : string|null
  ->invoice : Invoice
    ->nomor_invoice     : string (e.g. "INV-20260325-B3M9")
    ->status_pembayaran : string
    ->qr_code_url       : string|null
```

**Status update form:**
```blade
<form action="{{ route('order.update', $order) }}" method="POST">
    @csrf @method('PATCH')
    <select name="status">
        <option value="pending"    {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="confirmed"  {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
        <option value="completed"  {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled"  {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
    <button type="submit">Update</button>
</form>
```

**Back link:** `{{ route('order.index') }}`

---

### 9. `payment/index.blade.php`

**Route:** `GET /payment` → `route('payment.index')`
**Layout:** `<x-app-layout>`

**Variables:**
```
$invoices : LengthAwarePaginator<Invoice>
  ->id                  : string (UUID)
  ->nomor_invoice       : string
  ->status_pembayaran   : string (unpaid|paid|cancelled)
  ->created_at          : Carbon
  ->order               : Order
    ->kode_order        : string
    ->nama_pembeli      : string
    ->total_harga       : string (decimal)
    ->status            : string
```

---

### 10. `settings/website.blade.php`

**Route:** `GET /settings/website` → `route('settings.website')`
**Layout:** `<x-app-layout>`
**Variables:** `$tenant` (Tenant model)

**Form:**
```blade
<form action="{{ route('settings.website.update') }}" method="POST">
    @csrf @method('PATCH')
    <input type="text" name="nama_tenant" value="{{ old('nama_tenant', $tenant->nama_tenant) }}" required>
    <input type="text" name="slug" value="{{ old('slug', $tenant->slug) }}" required>
    {{-- slug rules: lowercase, alpha_dash only, unique --}}
</form>
```

**Public URL preview:** `{{ url('/' . $tenant->slug) }}`

---

### 11. `settings/template.blade.php`

**Route:** `GET /settings/template` → `route('settings.template')`
**Layout:** `<x-app-layout>`

**Variables:**
```
$tenant    : Tenant (has ->template_id)
$templates : Collection<Template>
  ->id             : string (UUID)
  ->nama_template  : string
  ->kategori       : string (e-commerce|portfolio|company-profile|catalog)
  ->preview_url    : string
  ->is_active      : bool
```

**Form:**
```blade
<form action="{{ route('settings.template.update') }}" method="POST">
    @csrf @method('PATCH')
    @foreach($templates as $template)
        <input type="radio" name="template_id" value="{{ $template->id }}"
               {{ $tenant->template_id === $template->id ? 'checked' : '' }}>
        {{ $template->nama_template }}
    @endforeach
    <button type="submit">Pilih Template</button>
</form>
```

---

### 12. `tenant/show.blade.php` (PUBLIC — no auth)

**Route:** `GET /{tenant}` → `route('tenant.show', $tenant)`
**Layout:** Standalone HTML (include `@vite(...)` directly)

**Variables:**
```
$tenant      : Tenant
$profil      : ProfilUsaha|null
  ->nama_usaha, ->deskripsi, ->alamat, ->no_hp, ->logo
$produks     : Collection<Produk> (active + in stock only)
  ->id, ->nama_produk, ->deskripsi, ->harga, ->stok, ->gambar
$portofolios : Collection<Portofolio>
  ->judul, ->deskripsi, ->gambar
```

**Links:**
```blade
{{ route('tenant.produk.detail', [$tenant, $produk]) }}  {{-- product detail --}}
{{ route('tenant.checkout', [$tenant, $produk]) }}        {{-- buy button --}}
```

**WhatsApp link:** `https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->no_hp) }}`

---

### 13. `tenant/produk-detail.blade.php` (PUBLIC — NEEDS CREATION)

**Route:** `GET /{tenant}/produk/{produk}` → `route('tenant.produk.detail', [$tenant, $produk])`
**Layout:** Standalone HTML

**Variables:** `$tenant`, `$profil`, `$produk` (single Produk)

**Links:**
```blade
{{ route('tenant.show', $tenant) }}                    {{-- back to storefront --}}
{{ route('tenant.checkout', [$tenant, $produk]) }}     {{-- checkout button --}}
```

---

### 14. `tenant/checkout.blade.php` (PUBLIC — NEEDS CREATION)

**Route:** `GET /{tenant}/checkout/{produk}` → `route('tenant.checkout', [$tenant, $produk])`
**Layout:** Standalone HTML

**Variables:** `$tenant`, `$profil`, `$produk`

**Form:**
```blade
<form action="{{ route('tenant.checkout.store', [$tenant, $produk]) }}" method="POST">
    @csrf
    <input type="text"   name="nama_pembeli"  value="{{ old('nama_pembeli') }}" required>
    <input type="email"  name="email_pembeli" value="{{ old('email_pembeli') }}" required>
    <input type="number" name="jumlah"        value="{{ old('jumlah', 1) }}" min="1" max="{{ $produk->stok }}" required>
</form>
```

**Display (read-only, from backend):**
```blade
{{ $produk->nama_produk }}
Rp {{ number_format($produk->harga, 0, ',', '.') }}
Stok: {{ $produk->stok }}
```

> IMPORTANT: Do NOT add a hidden price input. The backend calculates total from DB.

---

### 15. `tenant/order-success.blade.php` (PUBLIC — NEEDS CREATION)

**Route:** `GET /{tenant}/order/{order}/success` → `route('tenant.order.success', [$tenant, $order])`
**Layout:** Standalone HTML

**Variables:**
```
$tenant, $profil
$order : Order
  ->kode_order, ->nama_pembeli, ->email_pembeli, ->total_harga, ->status, ->created_at
  ->orderItems : Collection<OrderItem>
    ->produk->nama_produk, ->jumlah, ->harga, ->subtotal
$invoice : Invoice
  ->nomor_invoice, ->status_pembayaran, ->qr_code_url (nullable)
```

**Links:**
```blade
{{ route('tenant.show', $tenant) }}  {{-- "Kembali ke Toko" button --}}
```

---

## Sidebar Navigation Reference

The sidebar in `layouts/app.blade.php` should link to:

```blade
{{ route('dashboard') }}           {{-- Dashboard --}}
{{ route('settings.website') }}    {{-- Website --}}
{{ route('settings.template') }}   {{-- Template --}}
{{ route('portfolio.index') }}     {{-- Portfolio --}}
{{ route('produk.index') }}        {{-- Produk --}}
{{ route('order.index') }}         {{-- Order --}}
{{ route('payment.index') }}       {{-- Payment --}}
{{ route('profil-usaha.edit') }}   {{-- Profile (business) --}}
{{ route('logout') }}              {{-- POST form with @csrf --}}
```

Active state detection:
```blade
{{ request()->routeIs('dashboard') ? 'active-class' : 'inactive-class' }}
{{ request()->routeIs('produk.*') ? 'active-class' : 'inactive-class' }}
{{ request()->routeIs('order.*') ? 'active-class' : 'inactive-class' }}
{{ request()->routeIs('portfolio.*') ? 'active-class' : 'inactive-class' }}
{{ request()->routeIs('payment.*') ? 'active-class' : 'inactive-class' }}
{{ request()->routeIs('settings.*') ? 'active-class' : 'inactive-class' }}
{{ request()->routeIs('profil-usaha.*') ? 'active-class' : 'inactive-class' }}
```

---

## Price Formatting Helper

Use everywhere for Indonesian Rupiah:
```blade
Rp {{ number_format($amount, 0, ',', '.') }}
```

---

## Views That Need Creation

| View File | Status |
|---|---|
| `tenant/produk-detail.blade.php` | **NEEDS CREATION** |
| `tenant/checkout.blade.php` | **NEEDS CREATION** |
| `tenant/order-success.blade.php` | **NEEDS CREATION** |
| `profile/edit.blade.php` | **NEEDS CREATION** (Breeze account settings — include the 3 partials in `profile/partials/`) |

All other views already exist and are functional.

---

## Test Accounts (after `make migrate-fresh`)

```
Tenant Admin : admin@tokobaju.test / password
Super Admin  : superadmin@mylinx.test / password
Tenant URL   : http://localhost:8000/tokobaju
```
