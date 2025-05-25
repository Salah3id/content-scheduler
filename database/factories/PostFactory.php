<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Platform;
use App\Models\Post;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $scheduled_time = fake()->dateTimeBetween('-3 weeks', '+3 weeks');
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'scheduled_time' => fake()->dateTimeBetween('-3 weeks', '+3 weeks'),
            'status' => $scheduled_time > now() ? 0 : fake()->randomElement([1,2]),
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Post $post) {
            $platforms = Platform::limit(4)->get();

            $pivotData = [];

            foreach ($platforms->random(rand(1, 4)) as $platform) {
                $pivotData[$platform->id] = [
                    'platform_status' => match($post->status->value) {
                        0 => 0,
                        1 => fake()->randomElement([1,3]),
                        2 => fake()->randomElement([2,4]),
                    },
                ];
            }

            $post->platforms()->attach($pivotData);
        });
    }
}

        