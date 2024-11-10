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
        Schema::table('dial_stat_by_rows', function (Blueprint $table) {
            $table->Integer('callduration')->default(0)->change();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dial_stat_by_rows', function (Blueprint $table) {
            $table->Integer('callduration')->change();
        });        
    }
};
