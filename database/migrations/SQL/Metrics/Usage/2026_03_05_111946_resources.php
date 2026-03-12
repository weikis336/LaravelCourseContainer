<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained('servers')->cascadeOnDelete();
            $table->float('cpu_percentage')->nullable();
            $table->float('cpu_load')->nullable();
            $table->float('cpu_temp')->nullable();
            $table->float('memory_percentage')->nullable();
            $table->unsignedBigInteger('memory_used')->nullable();
            $table->unsignedBigInteger('memory_free')->nullable();
            $table->unsignedBigInteger('memory_total')->nullable();
            $table->unsignedBigInteger('swap_used')->nullable();
            $table->unsignedBigInteger('swap_free')->nullable();
            $table->unsignedBigInteger('swap_total')->nullable();
            $table->timestamp('recorded_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
