<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(8);
        $slug = Str::slug($title, '-');

        return [
            'user_id' => 1,
            'category_id' => $this->faker->numberBetween(1,10),
            'title' => $title,
            'slug' => $slug,
            'summary' => $this->faker->paragraph(),
            'body' => $this->faker->text(1500),
            'published_at' => $this->faker->dateTimeBetween('-1 Week', '+1 week'),
            'featured_image' => $this->faker->imageUrl(),
            'featured_image_caption' => $this->faker->sentence(6),
            'is_featured' => $this->faker->boolean(),
        ];
    }
}
