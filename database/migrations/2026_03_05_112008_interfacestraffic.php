<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interfaces_traffics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained('servers')->cascadeOnDelete();
            $table->string('interface');
            $table->unsignedBigInteger('network_in')->nullable();
            $table->unsignedBigInteger('network_out')->nullable();
            $table->unsignedBigInteger('network_total')->nullable();
            $table->timestamp('recorded_at')->useCurrent();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('interfaces_traffics');
    }
};
