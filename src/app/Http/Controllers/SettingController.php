<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTemplateRequest;
use App\Http\Requests\UpdateWebsiteSettingsRequest;
use App\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Show the website settings form (slug + tenant name).
     */
    public function editWebsite(): View
    {
        $tenant = auth()->user()->tenant;

        return view('settings.website', compact('tenant'));
    }

    /**
     * Update the tenant's website settings (slug and name).
     *
     * The slug becomes the tenant's public URL path:
     * mylinx.com/{slug}
     */
    public function updateWebsite(UpdateWebsiteSettingsRequest $request): RedirectResponse
    {
        $tenant = auth()->user()->tenant;
        $validated = $request->validated();

        // Split customization out of the top-level update payload
        $tenant->update([
            'nama_tenant' => $validated['nama_tenant'],
            'slug' => $validated['slug'],
            'customization' => [
                'accent_color' => $validated['accent_color'],
                'content_order' => $validated['content_order'],
                'product_layout' => $validated['product_layout'],
            ],
        ]);

        return redirect()
            ->route('settings.website')
            ->with('success', 'Pengaturan website berhasil disimpan!');
    }

    /**
     * Show the template selection page.
     *
     * Passes all active templates and the tenant's currently selected template.
     */
    public function editTemplate(): View
    {
        $tenant = auth()->user()->tenant->load('template');
        $templates = Template::where('is_active', true)->get();

        return view('settings.template', [
            'tenant' => $tenant,
            'templates' => $templates,
        ]);
    }

    /**
     * Update the tenant's selected template.
     */
    public function updateTemplate(UpdateTemplateRequest $request): RedirectResponse
    {
        $tenant = auth()->user()->tenant;

        $tenant->update([
            'template_id' => $request->validated()['template_id'],
        ]);

        return redirect()
            ->route('settings.template')
            ->with('success', 'Template berhasil diperbarui!');
    }

    /**
     * Check if a slug is available for the current tenant.
     *
     * Returns JSON: { available: bool, reason: string|null, slug: string }
     *
     * The current tenant's own slug is always "available" to them
     * (so they can save without changing it).
     */
    public function checkSlug(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'slug' => ['required', 'string', 'max:100'],
        ]);

        $slug = strtolower(trim($validated['slug']));
        $tenantId = auth()->user()->tenant_id;

        // Rule 1: Format check
        if (! preg_match('/^[a-z0-9_-]+$/', $slug)) {
            return response()->json([
                'available' => false,
                'reason' => 'Hanya huruf kecil, angka, strip (-), dan garis bawah (_).',
                'slug' => $slug,
            ]);
        }

        // Rule 2: Minimum length
        if (strlen($slug) < 3) {
            return response()->json([
                'available' => false,
                'reason' => 'Minimal 3 karakter.',
                'slug' => $slug,
            ]);
        }

        // Rule 3: Reserved words (prevent conflicts with app routes)
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

        // Rule 4: Uniqueness (ignoring the current tenant's own slug)
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
