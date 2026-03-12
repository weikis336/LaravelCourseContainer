<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('machine_id')->unique();
            $table->string('server_name');
            $table->string('server_serial')->nullable();
            $table->string('server_distro')->nullable();
            $table->string('server_platform')->nullable();
            $table->string('server_architecture')->nullable();
            $table->string('server_release')->nullable();
            $table->string('cpu_brand')->nullable();
            $table->unsignedSmallInteger('cpu_cores')->nullable();
            $table->unsignedSmallInteger('cpu_threads')->nullable();
            $table->float('cpu_frequency')->nullable();       // e.g. 2.8 GHz
            $table->unsignedBigInteger('memory_size')->nullable(); // bytes
            $table->text('disk_type')->nullable();            // JSON array
            $table->text('disk_bus')->nullable();             // JSON array
            $table->text('disk_size')->nullable();            // JSON array (bytes)
            $table->text('disk_name')->nullable();            // JSON array
            $table->text('disk_vendor')->nullable();          // JSON array
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
