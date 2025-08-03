<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'programming', 'web_development', 'mobile_development', 'artificial_intelligence',
            'machine_learning', 'data_science', 'information_security', 'cloud_computing',
            'devops', 'hardware', 'software', 'networks', 'iot', 'blockchain', 'virtual_reality',
            'augmented_reality', 'games', 'robotics', 'databases', 'front_end', 'back_end',
            'full_stack', 'ui_ux', 'automation', 'big_data', 'mobile', 'open_source',
            'educational_technology', 'software_engineering', 'others'
        ];

        $techTags = [
            'laravel', 'php', 'vue', 'javascript', 'html', 'css', 'react', 'nodejs', 'api', 'docker',
            'kubernetes', 'devops', 'tensorflow', 'pytorch', 'linux', 'graphql', 'postgresql', 'mongodb',
            'redis', 'aws', 'azure', 'flutter', 'android', 'ios', 'ci/cd', 'nextjs', 'nestjs', 'vite'
        ];

        $users = User::all();

        foreach ($users as $user) {
            $postCount = rand(1, 3);
            for ($i = 0; $i < $postCount; $i++) {
                Post::create([
                    'owner_id' => $user->id,
                    'title' => "Post de {$user->name}",
                    'content' => "<h2>Título do post</h2><p>Este é o conteúdo em HTML do post $i do usuário {$user->name}.</p>",
                    'estimated_reading_time' => rand(2, 10),
                    'description' => "Post sobre tecnologia",
                    'category' => $categories[array_rand($categories)],
                    'tags' => array_slice($techTags, rand(0, count($techTags) - 4), 3),
                ]);
            }
        }
    }
}
