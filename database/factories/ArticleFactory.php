<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $content = $this->faker->realText();

        return [
            'user_id' => User::all()->random(),
            'title' => $this->faker->titleMale,
            'description' => $this->faker->realText(),
            'content' => $content,
            'word_count' => strlen($content),
            'read_time' => $this->faker->numberBetween(1, 40)
        ];
    }
}
