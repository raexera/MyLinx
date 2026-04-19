<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWebsiteSettingsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function editWebsite(): View
    {
        $tenant = auth()->user()->tenant;

        return view('settings.website', compact('tenant'));
    }

    public function updateWebsite(UpdateWebsiteSettingsRequest $request): RedirectResponse
    {
        $tenant = auth()->user()->tenant;
        $validated = $request->validated();

        $tenant->update([
            'nama_tenant' => $validated['nama_tenant'],
            'slug' => $validated['slug'],
            'customization' => [
                'accent_color' => $validated['accent_color'],
                'background_color' => $validated['background_color'],
                'content_order' => $validated['content_order'],
                'product_layout' => $validated['product_layout'],
                'hero_style' => $validated['hero_style'],
            ],
        ]);

        return redirect()
            ->route('settings.website')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function checkSlug(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'slug' => ['required', 'string', 'max:100'],
        ]);

        $slug = strtolower(trim($validated['slug']));
        $tenantId = auth()->user()->tenant_id;

        if (! preg_match('/^[a-z0-9_-]+$/', $slug)) {
            return response()->json([
                'available' => false,
                'reason' => 'Hanya huruf kecil, angka, strip (-), dan garis bawah (_).',
                'slug' => $slug,
            ]);
        }

        if (strlen($slug) < 3) {
            return response()->json([
                'available' => false,
                'reason' => 'Minimal 3 karakter.',
                'slug' => $slug,
            ]);
        }

        $reserved = ['login', 'register', 'dashboard', 'admin', 'api', 'produk',
            'order', 'payment', 'settings', 'profile', 'profil-usaha',
            'portfolio', 'checkout', 'logout', 'landing'];

        if (in_array($slug, $reserved, true)) {
            return response()->json([
                'available' => false,
                'reason' => 'URL ini sudah digunakan oleh sistem.',
                'slug' => $slug,
            ]);
        }

        $taken = \App\Models\Tenant::where('slug', $slug)
            ->where('id', '!=', $tenantId)
            ->exists();

        if ($taken) {
            return response()->json([
                'available' => false,
                'reason' => 'URL ini sudah dipakai tenant lain.',
                'slug' => $slug,
            ]);
        }

        return response()->json([
            'available' => true,
            'reason' => null,
            'slug' => $slug,
        ]);
    }
}
