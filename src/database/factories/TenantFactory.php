<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $nama = fake('id_ID')->company();

        return [
            'nama_tenant' => $nama,
            'slug' => Str::slug($nama).'-'.fake()->unique()->numberBetween(100, 999),
            'status' => true,
        ];
    }
}
