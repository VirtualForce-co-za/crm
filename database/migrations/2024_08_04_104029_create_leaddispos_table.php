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
        Schema::create('leaddispos', function (Blueprint $table) {
            $table->id();
            $table->Integer('leadid');
            $table->Integer('campaignid');
            $table->Integer('instanceid');
            $table->Integer('agentresponseid')->default(0);
            $table->Integer('agentresponseid_previous')->default(0);
            $table->string('callsid')->nullable();
            $table->string('callid')->nullable();
            $table->string('callstatus')->nullable();
            $table->string('callresult')->nullable();
            $table->Integer('dispositionid')->default(0);
            $table->Integer('callduration')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaddispos');
    }
};
