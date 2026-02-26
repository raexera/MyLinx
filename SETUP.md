### Initiate Phase 2: Authentication, Frontend Scaffolding & Core Tenancy Routing

The database migrations, models, and seeders are complete and working perfectly. The codebase is clean of any cloud bloat. Now, we need to build the frontend foundation and the manual tenancy routing logic.
Please provide the exact code and step-by-step commands to achieve the following, keeping my strict MVP and thesis constraints in mind:

### Step 1: Authentication & UI Scaffolding (Laravel Breeze)

I want to use Laravel Breeze for a simple, secure starting point.

- We are using the **Blade with Alpine.js and Tailwind CSS** stack to keep it SSR and avoid complex SPA architecture.
- Provide the exact terminal commands I need to run (keeping in mind I execute everything inside my container via `make shell`).

### Step 2: Manual Tenancy Routing (`routes/web.php`)

Since we are NOT using `stancl/tenancy`, I need you to structure my `routes/web.php` file to support two distinct areas:

1. **Central Routes:** The main MyLinx landing page and the central admin login/dashboard.
2. **Tenant Routes:** The dynamically generated UMKM pages accessed via path-based slugs (e.g., `mylinx.com/{tenant_slug}` or `localhost:8000/{tenant_slug}`).

Please write the complete `routes/web.php` code demonstrating how to group these cleanly using Route Model Binding.

### Step 3: The Tenant Middleware (Optional but recommended)

If we need a custom Middleware to handle identifying the tenant by slug, injecting it into the Service Container, or aborting with a 404 if the `status` is inactive, please generate that Middleware file.

- Name it `IdentifyTenantBySlug`.
- Show me exactly how to register it in Laravel 11's `bootstrap/app.php` file.

### Step 4: Base Tenant Controller

Create a `TenantController` that handles the root route for a specific tenant (`/{tenant_slug}`).

- Show how it receives the bound `$tenant` model.
- Have it load the tenant's `ProfilUsaha` and active `Produks`.
- Return a simple placeholder Blade view passing those variables.

---

---

That is a very mature DevSecOps mindset! Leaving default boilerplate files laying around is exactly how team members accidentally start working in the wrong file or get migration conflicts later.

Since you generated brand new custom migrations with UUIDs and specific tenant columns, leaving Laravel's default `users`, `cache`, and `jobs` migrations in the folder will cause your `make migrate` command to crash. We also want to clear out the default dummy tests and welcome views.

Here is a quick "Phase 1.5" prompt to get Claude to give you the exact cleanup commands.

---

### Phase 1.5: Housekeeping & Removing Unused Boilerplate

Before we start Phase 2, I need to clean up the default Laravel files so my teammates don't get confused.
Since we just generated our own custom UUID-based migrations and are building a custom manual multi-tenancy platform, there are several default files we no longer need.
Please provide a list of terminal commands (e.g., `rm src/...`) that I should run inside my container to safely delete:

1. The default Laravel migrations (since they use auto-incrementing IDs and conflict with our new UUID schema).
2. The default `welcome.blade.php` view (we will build our own central landing page).
3. The default example tests in `tests/Feature` and `tests/Unit` (since they test the default setup).
4. Any other specific Laravel default files that are redundant for our MyLinx MVP architecture.
