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
        Schema::create('dial_stat_by_rows', function (Blueprint $table) {
            $table->date('dispositiondate');
            $table->Integer('campaignid');
            
            $table->Integer('instanceid');
            $table->string('campaign');            
            $table->Integer('callduration');
            
            $table->Integer('dial')->default(0);
            $table->Integer('connected')->default(0);
            $table->Integer('noanswer')->default(0);
            $table->Integer('callback')->default(0);
            $table->Integer('voicemail')->default(0);
            $table->Integer('silent')->default(0);
            $table->Integer('qualified')->default(0);
            $table->Integer('busy')->default(0);
            $table->Integer('failed')->default(0);
            $table->Integer('notinterested')->default(0);
            $table->Integer('dnq')->default(0);
            $table->Integer('others')->default(0);

            $table->Integer('connected_duration')->default(0);
            $table->Integer('noanswer_duration')->default(0);
            $table->Integer('callback_duration')->default(0);
            $table->Integer('voicemail_duration')->default(0);
            $table->Integer('silent_duration')->default(0);
            $table->Integer('qualified_duration')->default(0);
            $table->Integer('busy_duration')->default(0);
            $table->Integer('failed_duration')->default(0);
            $table->Integer('notinterested_duration')->default(0);
            $table->Integer('dnq_duration')->default(0);
            $table->Integer('others_duration')->default(0);

            $table->float('connected_percent', precision: 53)->default(0);
            $table->float('noanswer_percent', precision: 53)->default(0);
            $table->float('callback_percent', precision: 53)->default(0);
            $table->float('voicemail_percent', precision: 53)->default(0);
            $table->float('silent_percent', precision: 53)->default(0);
            $table->float('qualified_percent', precision: 53)->default(0);
            $table->float('busy_percent', precision: 53)->default(0);
            $table->float('failed_percent', precision: 53)->default(0);
            $table->float('notinterested_percent', precision: 53)->default(0);
            $table->float('dnq_percent', precision: 53)->default(0);
            $table->float('others_percent', precision: 53)->default(0);

            $table->unique(['dispositiondate', 'campaignid'], 'unique_index_by_rows');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dial_stat_by_rows');
    }
};
