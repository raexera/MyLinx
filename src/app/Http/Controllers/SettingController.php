<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTemplateRequest;
use App\Http\Requests\UpdateWebsiteSettingsRequest;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;
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

        $tenant->update($request->validated());

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
            'tenant'    => $tenant,
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
}
