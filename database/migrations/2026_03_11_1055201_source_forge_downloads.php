<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {  
        Schema::create('sourceforge_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edition_id')->constrained('sourceforge_editions');
            $table->foreignId('platform_id')->constrained('sourceforge_platforms');
            $table->foreignId('country_id')->constrained('sourceforge_countries');
            $table->integer('downloads');
            $table->date('date');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('sourceforge_downloads');
    }
};
