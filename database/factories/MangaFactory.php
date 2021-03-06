<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Manga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manga>
 */
class MangaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->unique()->words(3, true)),
            'author' => $this->faker->name,
            'id' => Manga::genId(),
            'desc' => $this->faker->paragraph(),
            'ongoing' => random_int(0, 1),
            'cover' => 'img/favicon.png',
            'updated_at' => now(),
            'created_at' => now()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Manga $manga) {
            $qty_genres = random_int(1, 10);
            $genres_keys = (array) array_rand(array_keys(Manga::$genres_list), $qty_genres);
            foreach($genres_keys as $genre_key) {
                $genres_keys_array[] = ['genre_key' => $genre_key];
            }
            $manga->genres()->createMany($genres_keys_array);
        });
    }
}
