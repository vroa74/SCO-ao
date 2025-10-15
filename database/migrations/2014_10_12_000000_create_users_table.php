<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rfc', 13)->unique()->nullable();
            $table->string('curp', 20)->unique()->nullable();
            $table->string('direction', 250)->nullable();
            $table->string('position', 35)->nullable();
            $table->enum('sex', ['masculino', 'femenino'])->nullable();
            $table->string('lvl', 10)->nullable();
            $table->integer('tipo')->default(3);   // acá estaba mal escrito 'interger' y el segundo parámetro no va
            $table->boolean('status')->default(true);            
            $table->enum('theme', ['light', 'dark'])->default('dark');            
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
