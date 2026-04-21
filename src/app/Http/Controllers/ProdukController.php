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
    public function index(): View
    {
        $produks = Produk::where('tenant_id', auth()->user()->tenant_id)
            ->withCount('orderItems')
            ->search(request('search'))
            ->stockStatus(request('stock'))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('produk.index', compact('produks'));
    }

    public function create(): View
    {
        return view('produk.create');
    }

    public function store(StoreProdukRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['tenant_id'] = auth()->user()->tenant_id;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store(
                'produk',
                'public'
            );
        }

        $data['status'] = $request->boolean('status', true);

        Produk::create($data);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk): View
    {
        $this->authorizeTenant($produk);

        return view('produk.edit', compact('produk'));
    }

    public function update(UpdateProdukRequest $request, Produk $produk): RedirectResponse
    {
        $this->authorizeTenant($produk);

        $data = $request->validated();

        if ($request->hasFile('gambar')) {

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

public function destroy(Produk $produk): RedirectResponse
{
    $this->authorizeTenant($produk);

    if ($produk->orderItems()->exists()) {
        return redirect()
            ->route('produk.index')
            ->with('error', 'Produk tidak bisa dihapus karena sudah memiliki pesanan. Nonaktifkan produk untuk menyembunyikannya dari storefront.');
    }

    if ($produk->gambar) {
        Storage::disk('public')->delete($produk->gambar);
    }

    try {
        $produk->delete();
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() === '23503') {
            return redirect()
                ->route('produk.index')
                ->with('error', 'Produk tidak bisa dihapus karena sudah memiliki pesanan. Nonaktifkan produk untuk menyembunyikannya dari storefront.');
        }
        throw $e;
    }

    return redirect()
        ->route('produk.index')
        ->with('success', 'Produk berhasil dihapus!');
}

    private function authorizeTenant(Produk $produk): void
    {
        if ($produk->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }
    }
}
