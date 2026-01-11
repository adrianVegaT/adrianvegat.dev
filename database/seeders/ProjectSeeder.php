<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::role('admin')->first();
        
        if (!$admin) {
            $this->command->warn('No admin user found. Please run UserSeeder first.');
            return;
        }

        $categories = Category::all();

        $projects = [
            [
                'title' => 'Sistema de Tracking de Hábitos',
                'summary' => 'Aplicación web para el seguimiento y análisis de hábitos diarios con estadísticas y reportes.',
                'description' => "Sistema completo de seguimiento de hábitos desarrollado con Laravel y Livewire. Permite a los usuarios crear hábitos personalizados, realizar seguimiento diario, visualizar estadísticas y generar reportes de progreso.\n\nCaracterísticas principales:\n- Gestión de hábitos personalizados\n- Seguimiento diario con calendario\n- Estadísticas y gráficos de progreso\n- Recordatorios y notificaciones\n- Sistema de rachas y logros",
                'repository_url' => 'https://github.com/adrianvega/habit-tracker',
                'demo_url' => 'https://habits.adrianvegat.dev',
                'subdomain' => 'habits',
                'status' => 'published',
                'is_featured' => true,
                'order' => 1,
                'published_at' => now()->subMonths(3),
            ],
            [
                'title' => 'Bot de Trading con IA',
                'summary' => 'Sistema automatizado de trading usando machine learning para análisis de mercado.',
                'description' => "Bot de trading automatizado que utiliza algoritmos de machine learning para analizar el mercado de criptomonedas y ejecutar operaciones.\n\nTecnologías utilizadas:\n- Python para el backend\n- TensorFlow para modelos de ML\n- API de Binance para trading\n- PostgreSQL para almacenamiento de datos\n- Docker para deployment\n\nEl sistema analiza patrones históricos y ejecuta operaciones basadas en señales generadas por los modelos de IA.",
                'repository_url' => 'https://github.com/adrianvega/trading-bot',
                'status' => 'published',
                'is_featured' => true,
                'order' => 2,
                'published_at' => now()->subMonths(2),
            ],
            [
                'title' => 'Robot Autónomo con Arduino',
                'summary' => 'Robot móvil autónomo con sensores ultrasónicos para navegación y detección de obstáculos.',
                'description' => "Proyecto de robótica que implementa un robot móvil completamente autónomo capaz de navegar en espacios cerrados evitando obstáculos.\n\nComponentes:\n- Arduino Mega como controlador principal\n- Sensores ultrasónicos HC-SR04\n- Motores DC con encoders\n- Módulo Bluetooth para comunicación\n- Batería LiPo de 11.1V\n\nAlgoritmos implementados:\n- Mapeo del entorno\n- Planificación de rutas\n- Control PID para los motores\n- Detección y evasión de obstáculos",
                'repository_url' => 'https://github.com/adrianvega/autonomous-robot',
                'status' => 'published',
                'is_featured' => false,
                'order' => 3,
                'published_at' => now()->subMonth(),
            ],
            [
                'title' => 'API REST de Gestión de Proyectos',
                'summary' => 'API RESTful completa para gestión de proyectos con autenticación JWT y documentación Swagger.',
                'description' => "API REST desarrollada con Laravel que proporciona endpoints completos para la gestión de proyectos, tareas, usuarios y equipos.\n\nCaracterísticas:\n- Autenticación con JWT\n- CRUD completo de recursos\n- Relaciones complejas entre entidades\n- Validaciones robustas\n- Rate limiting y throttling\n- Documentación con Swagger/OpenAPI\n- Tests unitarios y de integración\n- Versionado de API",
                'repository_url' => 'https://github.com/adrianvega/project-api',
                'demo_url' => 'https://api-docs.adrianvegat.dev',
                'status' => 'published',
                'is_featured' => false,
                'order' => 4,
                'published_at' => now()->subWeeks(3),
            ],
            [
                'title' => 'Dashboard Analítico en Vue.js',
                'summary' => 'Dashboard interactivo con gráficos en tiempo real y análisis de datos.',
                'description' => "Dashboard analítico desarrollado con Vue.js 3 y Composition API que permite visualizar datos en tiempo real.\n\nStack tecnológico:\n- Vue 3 con Composition API\n- Pinia para state management\n- Chart.js para gráficos\n- Tailwind CSS para estilos\n- Vite como build tool\n- WebSocket para datos en tiempo real\n\nFuncionalidades:\n- Gráficos interactivos y actualizables\n- Filtros dinámicos\n- Exportación de reportes\n- Modo oscuro\n- Responsive design",
                'repository_url' => 'https://github.com/adrianvega/analytics-dashboard',
                'status' => 'published',
                'is_featured' => false,
                'order' => 5,
                'published_at' => now()->subWeeks(2),
            ],
            [
                'title' => 'Sistema de Reconocimiento Facial',
                'summary' => 'Aplicación de reconocimiento facial usando deep learning con Python y OpenCV.',
                'description' => "Sistema de reconocimiento facial implementado con redes neuronales convolucionales para detección e identificación de personas.\n\nTecnologías:\n- Python 3.10\n- OpenCV para procesamiento de imágenes\n- TensorFlow/Keras para el modelo\n- Face Recognition library\n- Flask para la API\n- SQLite para base de datos\n\nCapacidades:\n- Detección de rostros en tiempo real\n- Identificación de personas\n- Registro de nuevos rostros\n- Verificación de identidad\n- Logs de accesos",
                'repository_url' => 'https://github.com/adrianvega/face-recognition',
                'status' => 'published',
                'is_featured' => true,
                'order' => 6,
                'published_at' => now()->subWeek(),
            ],
        ];

        foreach ($projects as $projectData) {
            $project = Project::create([
                'user_id' => $admin->id,
                'title' => $projectData['title'],
                'slug' => Str::slug($projectData['title']),
                'summary' => $projectData['summary'],
                'description' => $projectData['description'],
                'repository_url' => $projectData['repository_url'],
                'demo_url' => $projectData['demo_url'] ?? null,
                'subdomain' => $projectData['subdomain'] ?? null,
                'status' => $projectData['status'],
                'is_featured' => $projectData['is_featured'],
                'order' => $projectData['order'],
                'published_at' => $projectData['published_at'],
            ]);

            // Asignar categorías según el tipo de proyecto
            $projectCategories = [];
            
            if (Str::contains($project->title, ['Hábitos', 'Dashboard', 'API'])) {
                $projectCategories[] = Category::where('slug', 'desarrollo-web')->first()?->id;
            }
            
            if (Str::contains($project->title, ['IA', 'Trading', 'Reconocimiento'])) {
                $projectCategories[] = Category::where('slug', 'inteligencia-artificial')->first()?->id;
            }
            
            if (Str::contains($project->title, ['Robot', 'Arduino'])) {
                $projectCategories[] = Category::where('slug', 'robotica')->first()?->id;
            }
            
            if (Str::contains($project->title, ['API', 'Bot'])) {
                $projectCategories[] = Category::where('slug', 'programacion')->first()?->id;
            }

            if (!empty($projectCategories)) {
                $project->categories()->attach(array_filter($projectCategories));
            }
        }

        $this->command->info('Projects created successfully!');
    }
}