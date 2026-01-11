<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('summary')->nullable(); // Resumen corto para listados
            $table->string('image')->nullable(); // Imagen principal del proyecto
            $table->string('repository_url')->nullable(); // GitHub, GitLab, etc.
            $table->string('demo_url')->nullable(); // URL del proyecto en producción
            $table->string('subdomain')->nullable(); // Subdominio si aplica
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false); // Para destacar proyectos
            $table->integer('order')->default(0); // Orden de visualización
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('status');
            $table->index('is_featured');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};