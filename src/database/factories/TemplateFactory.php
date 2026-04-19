<?php

namespace Database\Factories;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Template>
 */
class TemplateFactory extends Factory
{
    protected $model = Template::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $templates = [
            ['nama' => 'Minimalist', 'slug' => 'minimalist', 'kategori' => 'e-commerce'],
            ['nama' => 'Bold Retail', 'slug' => 'bold-retail', 'kategori' => 'e-commerce'],
            ['nama' => 'Creative Portfolio', 'slug' => 'creative-portfolio', 'kategori' => 'portfolio'],
            ['nama' => 'Warm F&B', 'slug' => 'warm-fnb', 'kategori' => 'f&b'],
        ];

        $template = fake()->randomElement($templates);

        return [
            'nama_template' => $template['nama'],
            'slug_key' => $template['slug'],
            'kategori' => $template['kategori'],
            'preview_url' => '/images/templates/'.$template['slug'].'.png',
            'is_active' => true,
        ];
    }
}
