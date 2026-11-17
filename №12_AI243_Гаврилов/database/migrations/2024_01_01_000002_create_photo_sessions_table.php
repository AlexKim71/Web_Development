<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photo_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('session_date');
            $table->integer('duration'); // в хвилинах
            $table->enum('type', ['весільна', 'сімейна', 'портретна', 'інші']);
            $table->enum('status', ['нові', 'в процесі', 'завершено'])->default('нові');
            $table->foreignId('client_id')
                ->constrained('clients')
                ->onDelete('cascade');
            $table->foreignId('manager_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_sessions');
    }
};

