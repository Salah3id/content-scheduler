<?php

namespace Database\Seeders;

use App\Enums\PlatformType;
use App\Models\Platform;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Salah Eid',
            'email' => 'test@content.com',
        ]);

        User::factory(5)->create();

        collect([
            ['name' => 'Facebook', 'type' => PlatformType::FACEBOOK],
            ['name' => 'Instagram', 'type' => PlatformType::INSTAGRAM],
            ['name' => 'Twitter', 'type' => PlatformType::TWITTER],
            ['name' => 'LinkedIn', 'type' => PlatformType::LINKEDIN],
        ])->each(fn($platform) => Platform::factory()->create($platform));

        Post::factory(1000)->create();
    }
}
