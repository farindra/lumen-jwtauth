<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition(): array
    {
        $genres = ['action','adventure','comedy','horror'];

    	return [
    	    'id' => $uuid = $this->faker->uuid,
            'title' => $this->faker->text(50),
            'description' => $this->faker->text(150),
            'embed_url' => $this->faker->url . '/' .  $uuid,
            'genres' => json_encode( array_slice($genres, rand(0, sizeof($genres) - 1)) ),
            'viewed' => rand(),
    	];
    }
}
