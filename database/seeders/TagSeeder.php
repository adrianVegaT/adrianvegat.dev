<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React', 
            'Tailwind CSS', 'MySQL', 'PostgreSQL', 'API REST',
            'Python', 'TensorFlow', 'PyTorch', 'Machine Learning',
            'Arduino', 'Raspberry Pi', 'IoT', 'Sensores',
            'Docker', 'Kubernetes', 'Linux', 'Git',
            'Livewire', 'Alpine.js', 'Node.js', 'TypeScript'
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)), // Color aleatorio
            ]);
        }
    }
}