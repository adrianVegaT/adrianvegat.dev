<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::role('admin')->first();
        
        if (!$admin) {
            $this->command->warn('No admin user found. Please run UserSeeder first.');
            return;
        }

        $projects = Project::all();
        $categories = Category::all();
        $tags = Tag::all();

        $posts = [
            [
                'title' => 'Cómo implementar autenticación JWT en Laravel',
                'excerpt' => 'Guía paso a paso para implementar autenticación JWT en aplicaciones Laravel con mejores prácticas de seguridad.',
                'content' => "<h2>Introducción</h2>\n<p>JSON Web Tokens (JWT) es un estándar abierto (RFC 7519) que define una forma compacta y autónoma para transmitir información de forma segura entre partes como un objeto JSON.</p>\n\n<h2>Instalación</h2>\n<p>Primero, instala el paquete jwt-auth:</p>\n<pre><code>composer require tymon/jwt-auth</code></pre>\n\n<h2>Configuración</h2>\n<p>Publica la configuración del paquete:</p>\n<pre><code>php artisan vendor:publish --provider=\"Tymon\\JWTAuth\\Providers\\LaravelServiceProvider\"</code></pre>\n\n<h2>Generación de Secret Key</h2>\n<pre><code>php artisan jwt:secret</code></pre>\n\n<p>Esta guía te mostrará cómo configurar completamente JWT en tu aplicación Laravel para crear APIs seguras y escalables.</p>",
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'project_id' => null,
            ],
            [
                'title' => 'Optimización de consultas con Eloquent ORM',
                'excerpt' => 'Técnicas avanzadas para optimizar consultas de base de datos en Laravel usando Eloquent ORM.',
                'content' => "<h2>El Problema N+1</h2>\n<p>Uno de los problemas más comunes de rendimiento en aplicaciones Laravel es el problema N+1, que ocurre cuando realizas consultas adicionales innecesarias.</p>\n\n<h2>Eager Loading</h2>\n<p>La solución es usar eager loading:</p>\n<pre><code>// Mal ❌\n\$users = User::all();\nforeach(\$users as \$user) {\n    echo \$user->posts->count();\n}\n\n// Bien ✅\n\$users = User::with('posts')->get();\nforeach(\$users as \$user) {\n    echo \$user->posts->count();\n}</code></pre>\n\n<h2>Lazy Eager Loading</h2>\n<p>Si ya tienes la colección, puedes usar lazy eager loading:</p>\n<pre><code>\$users->load('posts');</code></pre>\n\n<p>Estas técnicas pueden reducir drásticamente el número de consultas a la base de datos y mejorar significativamente el rendimiento.</p>",
                'status' => 'published',
                'published_at' => now()->subDays(8),
                'project_id' => null,
            ],
            [
                'title' => 'Construcción del sistema de hábitos - Parte 1',
                'excerpt' => 'Primera parte del desarrollo del sistema de tracking de hábitos: configuración inicial y arquitectura.',
                'content' => "<h2>Visión General del Proyecto</h2>\n<p>En esta serie de artículos documentaré el proceso completo de desarrollo del sistema de tracking de hábitos.</p>\n\n<h2>Arquitectura Inicial</h2>\n<p>Decidí usar una arquitectura en capas para mantener el código organizado:</p>\n<ul>\n<li>Controllers: Manejo de peticiones HTTP</li>\n<li>Services: Lógica de negocio</li>\n<li>Repositories: Acceso a datos</li>\n<li>Models: Representación de datos</li>\n</ul>\n\n<h2>Stack Tecnológico</h2>\n<ul>\n<li>Laravel 11 para el backend</li>\n<li>Livewire para interactividad</li>\n<li>Tailwind CSS para estilos</li>\n<li>MySQL para base de datos</li>\n</ul>\n\n<p>En el próximo artículo veremos la implementación del modelo de datos.</p>",
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'project_id' => $projects->where('title', 'Sistema de Tracking de Hábitos')->first()?->id,
            ],
            [
                'title' => 'Implementando Machine Learning para Trading',
                'excerpt' => 'Cómo crear modelos de machine learning para predecir movimientos del mercado de criptomonedas.',
                'content' => "<h2>Recolección de Datos</h2>\n<p>El primer paso es obtener datos históricos del mercado. Usé la API de Binance para descargar información de precios.</p>\n\n<h2>Preprocesamiento</h2>\n<p>Los datos necesitan ser normalizados y preparados:</p>\n<pre><code>import pandas as pd\nfrom sklearn.preprocessing import MinMaxScaler\n\nscaler = MinMaxScaler()\ndata_scaled = scaler.fit_transform(data)</code></pre>\n\n<h2>Modelo LSTM</h2>\n<p>Utilicé una red neuronal LSTM para predecir precios:</p>\n<pre><code>from tensorflow.keras.models import Sequential\nfrom tensorflow.keras.layers import LSTM, Dense\n\nmodel = Sequential([\n    LSTM(50, return_sequences=True),\n    LSTM(50),\n    Dense(1)\n])</code></pre>\n\n<p>El modelo alcanzó una precisión del 78% en el conjunto de prueba.</p>",
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'project_id' => $projects->where('title', 'Bot de Trading con IA')->first()?->id,
            ],
            [
                'title' => 'Control PID para robots móviles',
                'excerpt' => 'Implementación de un controlador PID para mejorar la precisión del movimiento en robots autónomos.',
                'content' => "<h2>¿Qué es un Controlador PID?</h2>\n<p>PID significa Proporcional-Integral-Derivativo. Es un mecanismo de control que calcula un valor de error como la diferencia entre un punto de ajuste deseado y una variable del proceso medida.</p>\n\n<h2>Implementación en Arduino</h2>\n<pre><code>float kp = 2.0;\nfloat ki = 0.5;\nfloat kd = 1.0;\n\nfloat error = 0;\nfloat lastError = 0;\nfloat integral = 0;\n\nvoid loop() {\n  error = setpoint - currentValue;\n  integral += error;\n  float derivative = error - lastError;\n  \n  float output = kp*error + ki*integral + kd*derivative;\n  \n  lastError = error;\n}</code></pre>\n\n<h2>Ajuste de Parámetros</h2>\n<p>El ajuste fino de los parámetros Kp, Ki y Kd es crucial para el rendimiento óptimo del sistema.</p>",
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'project_id' => $projects->where('title', 'Robot Autónomo con Arduino')->first()?->id,
            ],
            [
                'title' => 'Introducción a Vue 3 Composition API',
                'excerpt' => 'Guía completa sobre cómo migrar de Options API a Composition API en Vue 3.',
                'content' => "<h2>¿Por qué Composition API?</h2>\n<p>Composition API ofrece mejor organización del código, reutilización de lógica y mejor soporte para TypeScript.</p>\n\n<h2>Setup Function</h2>\n<pre><code>import { ref, computed } from 'vue'\n\nexport default {\n  setup() {\n    const count = ref(0)\n    const doubled = computed(() => count.value * 2)\n    \n    function increment() {\n      count.value++\n    }\n    \n    return { count, doubled, increment }\n  }\n}</code></pre>\n\n<h2>Composables</h2>\n<p>Los composables permiten extraer y reutilizar lógica:</p>\n<pre><code>function useCounter() {\n  const count = ref(0)\n  const increment = () => count.value++\n  return { count, increment }\n}</code></pre>",
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'project_id' => null,
            ],
            [
                'title' => 'Redes Neuronales Convolucionales para Visión por Computadora',
                'excerpt' => 'Cómo funcionan las CNNs y su aplicación en sistemas de reconocimiento facial.',
                'content' => "<h2>Arquitectura de una CNN</h2>\n<p>Las Redes Neuronales Convolucionales están diseñadas específicamente para procesar datos con estructura de cuadrícula, como imágenes.</p>\n\n<h2>Capas Principales</h2>\n<ul>\n<li><strong>Convolucional:</strong> Extrae características de la imagen</li>\n<li><strong>Pooling:</strong> Reduce dimensionalidad</li>\n<li><strong>Fully Connected:</strong> Clasificación final</li>\n</ul>\n\n<h2>Implementación con TensorFlow</h2>\n<pre><code>model = Sequential([\n    Conv2D(32, (3,3), activation='relu', input_shape=(64,64,3)),\n    MaxPooling2D(2,2),\n    Conv2D(64, (3,3), activation='relu'),\n    MaxPooling2D(2,2),\n    Flatten(),\n    Dense(128, activation='relu'),\n    Dense(10, activation='softmax')\n])</code></pre>",
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'project_id' => $projects->where('title', 'Sistema de Reconocimiento Facial')->first()?->id,
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::create([
                'user_id' => $admin->id,
                'project_id' => $postData['project_id'],
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'status' => $postData['status'],
                'published_at' => $postData['published_at'],
                'meta_title' => $postData['title'],
                'meta_description' => $postData['excerpt'],
            ]);

            // Calcular tiempo de lectura
            $post->calculateReadingTime();

            // Asignar categorías
            $postCategories = [];
            
            if (Str::contains($post->title, ['Laravel', 'Eloquent', 'Vue', 'API'])) {
                $postCategories[] = Category::where('slug', 'desarrollo-web')->first()?->id;
            }
            
            if (Str::contains($post->title, ['JWT', 'Eloquent', 'API', 'Vue'])) {
                $postCategories[] = Category::where('slug', 'programacion')->first()?->id;
            }
            
            if (Str::contains($post->title, ['Machine Learning', 'CNN', 'Reconocimiento'])) {
                $postCategories[] = Category::where('slug', 'inteligencia-artificial')->first()?->id;
            }
            
            if (Str::contains($post->title, ['PID', 'Arduino', 'robot'])) {
                $postCategories[] = Category::where('slug', 'robotica')->first()?->id;
            }

            if (!empty($postCategories)) {
                $post->categories()->attach(array_filter($postCategories));
            }

            // Asignar tags aleatorios
            $randomTags = $tags->random(rand(2, 4))->pluck('id');
            $post->tags()->attach($randomTags);
        }

        $this->command->info('Posts created successfully!');
    }
}