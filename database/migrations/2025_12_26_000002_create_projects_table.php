<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('priority')->default('medium');
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'sort_order']);
            $table->index('archived_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
