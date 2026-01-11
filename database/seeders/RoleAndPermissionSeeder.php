<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            // Projects
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',
            'publish projects',
            
            // Posts
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'publish posts',
            
            // Categories
            'manage categories',
            
            // Tags
            'manage tags',
            
            // Comments
            'view comments',
            'create comments',
            'edit own comments',
            'delete own comments',
            'moderate comments',
            
            // Users
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        
        // Admin - Tiene todos los permisos
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Author - Puede crear y gestionar contenido
        $authorRole = Role::create(['name' => 'author']);
        $authorRole->givePermissionTo([
            'view projects',
            'create projects',
            'edit projects',
            'publish projects',
            'view posts',
            'create posts',
            'edit posts',
            'publish posts',
            'manage categories',
            'manage tags',
            'view comments',
            'moderate comments',
        ]);

        // User - Solo puede comentar
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view projects',
            'view posts',
            'view comments',
            'create comments',
            'edit own comments',
            'delete own comments',
        ]);
    }
}