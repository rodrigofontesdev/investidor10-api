<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NewsFactory extends Factory
{
    public function definition(): array
    {
        $title = Str::ucfirst(fake()->words(fake()->randomElement([8, 10, 12, 14, 16]), true));
        $category = fake()->randomElement(['Mercados', 'Economia', 'Política', 'Internacional']);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'short_description' => fake()->text(120),
            'content' => fake()->paragraphs(8, true),
            'category' => $category
        ];
    }
}
