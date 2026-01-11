<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider')->nullable()->after('email'); // google, github
            $table->string('provider_id')->nullable()->after('provider');
            $table->string('avatar')->nullable()->after('provider_id');
            $table->text('bio')->nullable()->after('avatar');
            $table->string('website')->nullable()->after('bio');
            $table->string('github_username')->nullable()->after('website');
            $table->string('twitter_username')->nullable()->after('github_username');
            $table->string('linkedin_url')->nullable()->after('twitter_username');
            
            // Hacer el password nullable para usuarios de login social
            $table->string('password')->nullable()->change();
            
            $table->index(['provider', 'provider_id']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'provider',
                'provider_id',
                'avatar',
                'bio',
                'website',
                'github_username',
                'twitter_username',
                'linkedin_url'
            ]);
        });
    }
};