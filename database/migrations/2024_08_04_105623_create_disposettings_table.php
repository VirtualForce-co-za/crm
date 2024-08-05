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
        Schema::create('disposettings', function (Blueprint $table) {
            $table->id();
            $table->Integer('agentresponseid')->nullable();
            $table->Integer('dispositionid')->nullable();
            $table->Integer('instanceid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposettings');
    }
};
