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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->Integer('leadid')->nullable(); 
            $table->Integer('campaignid')->nullable(); 
            $table->Integer('agentid')->nullable(); 
            $table->Integer('instanceid')->nullable(); 
            $table->string('event')->nullable();
            $table->string('callsid')->nullable();
            $table->string('text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
