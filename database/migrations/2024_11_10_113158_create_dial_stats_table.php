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
        Schema::create('dial_stats', function (Blueprint $table) {
            $table->date('dispositiondate');
            $table->Integer('campaignid');
            $table->Integer('instanceid');
            $table->string('campaign');
            $table->Integer('dispositionid');
            $table->string('disposition');
            $table->Integer('callduration');
            $table->unique(['dispositiondate', 'campaignid'], 'unique_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dial_stats');
    }
};
