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
    public function index(): View
    {
        $portofolios = Portofolio::where('tenant_id', auth()->user()->tenant_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('portfolio.builder', compact('portofolios'));
    }

    public function store(StorePortofolioRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['tenant_id'] = auth()->user()->tenant_id;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store(
                'portofolio',
                'public'
            );
        }

        Portofolio::create($data);

        return redirect()
            ->route('portfolio.index')
            ->with('success', 'Portofolio berhasil ditambahkan!');
    }

    public function edit(Portofolio $portfolio): View
    {
        $this->authorizeTenant($portfolio);

        $portofolios = Portofolio::where('tenant_id', auth()->user()->tenant_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('portfolio.builder', [
            'portofolios' => $portofolios,
            'editing' => $portfolio,
        ]);
    }

    public function update(UpdatePortofolioRequest $request, Portofolio $portfolio): RedirectResponse
    {
        $this->authorizeTenant($portfolio);

        $data = $request->validated();

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

    public function destroy(Portofolio $portfolio): RedirectResponse
    {
        $this->authorizeTenant($portfolio);

        if ($portfolio->gambar) {
            Storage::disk('public')->delete($portfolio->gambar);
        }

        $portfolio->delete();

        return redirect()
            ->route('portfolio.index')
            ->with('success', 'Portofolio berhasil dihapus!');
    }

    private function authorizeTenant(Portofolio $portofolio): void
    {
        if ($portofolio->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Anda tidak memiliki akses ke portofolio ini.');
        }
    }
}
