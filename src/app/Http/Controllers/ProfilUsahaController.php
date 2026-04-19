<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfilUsahaRequest;
use App\Services\QrisValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfilUsahaController extends Controller
{
    public function edit(): View
    {
        $profil = auth()->user()->tenant->profilUsaha
            ?? auth()->user()->tenant->profilUsaha()->create([]);

        return view('profil-usaha.edit', compact('profil'));
    }

    public function update(UpdateProfilUsahaRequest $request, QrisValidator $qrisValidator): RedirectResponse
    {
        $tenant = auth()->user()->tenant;
        $profil = $tenant->profilUsaha ?? $tenant->profilUsaha()->create([]);

        $data = $request->only(['nama_usaha', 'deskripsi', 'alamat', 'no_hp']);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($profil->logo) {
                Storage::disk('public')->delete($profil->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Handle QRIS upload — request already validated it via form request
        if ($request->hasFile('qris_image')) {
            $result = $qrisValidator->validate($request->file('qris_image'));

            if ($result['status'] !== QrisValidator::RESULT_OK) {
                return back()
                    ->withErrors(['qris_image' => $result['message']])
                    ->withInput();
            }

            if ($profil->qris_image) {
                Storage::disk('public')->delete($profil->qris_image);
            }

            $data['qris_image'] = $request->file('qris_image')->store('qris', 'public');
            $data['qris_merchant_name'] = $result['merchant_name'];
            $data['qris_nmid'] = $result['nmid'];
        }

        $profil->update($data);

        return redirect()
            ->route('profil-usaha.edit')
            ->with('success', 'Profil usaha berhasil diperbarui.');
    }

    public function removeQris(): RedirectResponse
    {
        $tenant = auth()->user()->tenant;
        $profil = $tenant->profilUsaha;

        if ($profil && $profil->qris_image) {
            Storage::disk('public')->delete($profil->qris_image);

            $profil->update([
                'qris_image' => null,
                'qris_merchant_name' => null,
                'qris_nmid' => null,
            ]);
        }

        return redirect()
            ->route('profil-usaha.edit')
            ->with('success', 'QRIS berhasil dihapus.');
    }
}
