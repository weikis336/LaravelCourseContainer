<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('sourceforge_editions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('codename');
            $table->string('version');
            $table->date('release_date');
            $table->string('project');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('sourceforge_editions');
    }
};
