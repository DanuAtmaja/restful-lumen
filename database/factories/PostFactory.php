<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;
    private $post = App\Models\Category::class;

    public function definition(): array
    {
    	return [
    	    'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'category_id' => $this->faker->randomNumber(1)
    	];
    }
}
