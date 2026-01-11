<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Desarrollo Web',
                'slug' => 'desarrollo-web',
                'description' => 'Proyectos y artículos sobre desarrollo web, frontend y backend',
                'color' => '#3B82F6',
                'icon' => 'code',
            ],
            [
                'name' => 'Inteligencia Artificial',
                'slug' => 'inteligencia-artificial',
                'description' => 'Proyectos relacionados con IA, Machine Learning y Deep Learning',
                'color' => '#8B5CF6',
                'icon' => 'brain',
            ],
            [
                'name' => 'Robótica',
                'slug' => 'robotica',
                'description' => 'Proyectos de robótica, IoT y sistemas embebidos',
                'color' => '#F59E0B',
                'icon' => 'robot',
            ],
            [
                'name' => 'Programación',
                'slug' => 'programacion',
                'description' => 'Tutoriales y recursos sobre lenguajes de programación',
                'color' => '#10B981',
                'icon' => 'terminal',
            ],
            [
                'name' => 'DevOps',
                'slug' => 'devops',
                'description' => 'Automatización, CI/CD, contenedores y despliegue',
                'color' => '#EF4444',
                'icon' => 'server',
            ],
            [
                'name' => 'Bases de Datos',
                'slug' => 'bases-de-datos',
                'description' => 'Diseño, optimización y gestión de bases de datos',
                'color' => '#6366F1',
                'icon' => 'database',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}