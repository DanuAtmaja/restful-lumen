<?php

namespace Database\Factories;

use App\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostTagFactory extends Factory
{
    protected $model = Model::class;

    public function definition(): array
    {
    	return [
    	    'post_id' => factory(App\Post::class, 20)->create(),
            'tag_id' => factory(App\Tag::class, 5)->create()
    	];
    }
}
