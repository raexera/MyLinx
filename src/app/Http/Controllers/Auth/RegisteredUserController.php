<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ProfilUsaha;
use App\Models\Template;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * Wraps the entire onboarding flow in a DB transaction:
     * 1. Create Tenant (with unique slug)
     * 2. Create User (linked to tenant)
     * 3. Create empty ProfilUsaha (so /profil-usaha never 500s)
     *
     * If any step fails, everything rolls back cleanly.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($request) {

            // ── Step 1: Find the default template ────────────────
            $template = Template::where('is_active', true)->first();

            if (! $template) {
                $template = Template::create([
                    'nama_template' => 'Minimalist',
                    'slug_key'      => 'minimalist',
                    'kategori'      => 'e-commerce',
                    'preview_url'   => '/images/templates/minimalist.png',
                    'is_active'     => true,
                ]);
            }

            // ── Step 2: Create the Tenant ────────────────────────
            $storeName = $request->store_name ?: $request->name."'s Store";
            $baseSlug = Str::slug($storeName);

            // Ensure slug uniqueness
            $slug = $baseSlug;
            $counter = 1;
            while (Tenant::where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$counter;
                $counter++;
            }

            $tenant = Tenant::create([
                'nama_tenant' => $storeName,
                'slug' => $slug,
                'template_id' => $template->id,
                'status' => true,
            ]);

            // ── Step 3: Create the User (linked to tenant) ──────
            $user = User::create([
                'tenant_id' => $tenant->id,
                'nama' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'tenant_admin',
            ]);

            // ── Step 4: Create empty ProfilUsaha ─────────────────
            // This prevents the 500 error when a new user visits /profil-usaha
            // before filling out their business profile.
            ProfilUsaha::create([
                'tenant_id' => $tenant->id,
                'nama_usaha' => $storeName,
                'deskripsi' => '',
                'alamat' => '',
                'no_hp' => '',
            ]);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
