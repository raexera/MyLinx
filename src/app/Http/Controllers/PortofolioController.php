<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePortofolioRequest;
use App\Http\Requests\UpdatePortofolioRequest;
use App\Models\Portofolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PortofolioController extends Controller
{
    /**
     * Display the portfolio builder with existing items.
     */
    public function index(): View
    {
        $portofolios = Portofolio::where('tenant_id', auth()->user()->tenant_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('portfolio.builder', compact('portofolios'));
    }

    /**
     * Store a newly created portfolio item.
     *
     * TENANCY RULE: Automatically attaches the logged-in user's tenant_id.
     */
    public function store(StorePortofolioRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Attach tenant_id from the authenticated user
        $data['tenant_id'] = auth()->user()->tenant_id;

        // Handle image upload to local public disk
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store(
                'portofolio',    // folder inside storage/app/public/
                'public'         // disk name
            );
        }

        Portofolio::create($data);

        return redirect()
            ->route('portfolio.index')
            ->with('success', 'Portofolio berhasil ditambahkan!');
    }

    /**
     * Show the form for editing a portfolio item.
     *
     * TENANCY RULE: Abort 403 if item doesn't belong to the user's tenant.
     */
    public function edit(Portofolio $portfolio): View
    {
        $this->authorizeTenant($portfolio);

        $portofolios = Portofolio::where('tenant_id', auth()->user()->tenant_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('portfolio.builder', [
            'portofolios' => $portofolios,
            'editing'     => $portfolio,
        ]);
    }

    /**
     * Update an existing portfolio item.
     *
     * TENANCY RULE: Abort 403 if item doesn't belong to the user's tenant.
     */
    public function update(UpdatePortofolioRequest $request, Portofolio $portfolio): RedirectResponse
    {
        $this->authorizeTenant($portfolio);

        $data = $request->validated();

        // Handle image upload (replace old image if new one is provided)
        if ($request->hasFile('gambar')) {
            if ($portfolio->gambar) {
                Storage::disk('public')->delete($portfolio->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('portofolio', 'public');
        }

        $portfolio->update($data);

        return redirect()
            ->route('portfolio.index')
            ->with('success', 'Portofolio berhasil diperbarui!');
    }

    /**
     * Delete a portfolio item.
     *
     * TENANCY RULE: Abort 403 if item doesn't belong to the user's tenant.
     */
    public function destroy(Portofolio $portfolio): RedirectResponse
    {
        $this->authorizeTenant($portfolio);

        // Delete the associated image file
        if ($portfolio->gambar) {
            Storage::disk('public')->delete($portfolio->gambar);
        }

        $portfolio->delete();

        return redirect()
            ->route('portfolio.index')
            ->with('success', 'Portofolio berhasil dihapus!');
    }

    /**
     * Verify that the given model belongs to the authenticated user's tenant.
     * Aborts with 403 Forbidden if it doesn't match.
     */
    private function authorizeTenant(Portofolio $portofolio): void
    {
        if ($portofolio->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Anda tidak memiliki akses ke portofolio ini.');
        }
    }
}
