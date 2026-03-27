<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Display the list of products for the current tenant.
     *
     * Supports query parameters:
     * - ?search=batik  → filters by nama_produk or deskripsi
     * - ?stock=available|empty|inactive → filters by stock status
     */
    public function index(): View
    {
        $produks = Produk::where('tenant_id', auth()->user()->tenant_id)
            ->search(request('search'))
            ->stockStatus(request('stock'))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // preserves search/filter params in pagination links

        return view('produk.index', compact('produks'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        return view('produk.create');
    }

    /**
     * Store a newly created product.
     *
     * TENANCY RULE: Automatically attaches the logged-in user's tenant_id.
     */
    public function store(StoreProdukRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Attach tenant_id from the authenticated user
        $data['tenant_id'] = auth()->user()->tenant_id;

        // Handle image upload to local public disk
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store(
                'produk',        // folder inside storage/app/public/
                'public'         // disk name
            );
        }

        // Default status to active if not provided
        $data['status'] = $request->boolean('status', true);

        Produk::create($data);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Show the form for editing a product.
     *
     * TENANCY RULE: Abort 403 if product doesn't belong to the user's tenant.
     */
    public function edit(Produk $produk): View
    {
        $this->authorizeTenant($produk);

        return view('produk.edit', compact('produk'));
    }

    /**
     * Update an existing product.
     *
     * TENANCY RULE: Abort 403 if product doesn't belong to the user's tenant.
     */
    public function update(UpdateProdukRequest $request, Produk $produk): RedirectResponse
    {
        $this->authorizeTenant($produk);

        $data = $request->validated();

        // Handle image upload (replace old image if new one is provided)
        if ($request->hasFile('gambar')) {
            // Delete old image if it exists
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $data['status'] = $request->boolean('status', true);

        $produk->update($data);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Delete a product.
     *
     * TENANCY RULE: Abort 403 if product doesn't belong to the user's tenant.
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        $this->authorizeTenant($produk);

        // Delete the associated image file
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Verify that the given model belongs to the authenticated user's tenant.
     * Aborts with 403 Forbidden if it doesn't match.
     */
    private function authorizeTenant(Produk $produk): void
    {
        if ($produk->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }
    }
}
