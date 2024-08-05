<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->Integer('campaignid');
            $table->Integer('instanceid');
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('cellno')->nullable();
            $table->string('idno')->nullable();
            $table->Integer('status')->default(0);
            $table->Integer('agentresponseid')->default(0);
            $table->Integer('agentresponseid_previous')->default(0);
            $table->string('callsid')->nullable();
            $table->string('callid')->nullable();
            $table->string('callstatus')->nullable();
            $table->string('callresult')->nullable();
            $table->Integer('dispositionid')->default(0);
            $table->Integer('callduration')->default(0);
            $table->longText('dial_api_response')->nullable();
            $table->longText('lead_post_response')->nullable();
            $table->Integer('lead_post_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
