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
            $table->Integer('dnc')->default(0);
            $table->Integer('work_number')->default(0);
            $table->Integer('unemployed')->default(0);
            $table->Integer('swearing')->default(0);
            $table->Integer('repeat')->default(0);
            $table->Integer('religion_barrier')->default(0);
            $table->Integer('relative_pays')->default(0);
            $table->Integer('outdoor')->default(0);
            $table->Integer('others_pickup_call')->default(0);
            $table->Integer('not_allowed')->default(0);
            $table->Integer('no_car')->default(0);
            $table->Integer('sick')->default(0);
            $table->Integer('angry')->default(0);
            $table->Integer('in_meeting')->default(0);
            $table->Integer('home_chores')->default(0);
            $table->Integer('goodbyes')->default(0);
            $table->Integer('fallback')->default(0);
            $table->Integer('expecting_call')->default(0);
            $table->Integer('driving')->default(0);
            $table->Integer('children')->default(0);
            $table->Integer('broker')->default(0);
            $table->Integer('bathroom')->default(0);
            $table->Integer('already_your_client')->default(0);
            $table->Integer('already_quoted')->default(0);
            $table->Integer('already_covered')->default(0);
            $table->Integer('reason_unknown')->default(0);
            $table->Integer('timeout')->default(0);
            $table->Integer('user_hangup')->default(0);

            $table->Integer('dnc_duration')->default(0);
            $table->Integer('work_number_duration')->default(0);
            $table->Integer('unemployed_duration')->default(0);
            $table->Integer('swearing_duration')->default(0);
            $table->Integer('repeat_duration')->default(0);
            $table->Integer('religion_barrier_duration')->default(0);
            $table->Integer('relative_pays_duration')->default(0);
            $table->Integer('outdoor_duration')->default(0);
            $table->Integer('others_pickup_call_duration')->default(0);
            $table->Integer('not_allowed_duration')->default(0);
            $table->Integer('no_car_duration')->default(0);
            $table->Integer('sick_duration')->default(0);
            $table->Integer('angry_duration')->default(0);
            $table->Integer('in_meeting_duration')->default(0);
            $table->Integer('home_chores_duration')->default(0);
            $table->Integer('goodbyes_duration')->default(0);
            $table->Integer('fallback_duration')->default(0);
            $table->Integer('expecting_call_duration')->default(0);
            $table->Integer('driving_duration')->default(0);
            $table->Integer('children_duration')->default(0);
            $table->Integer('broker_duration')->default(0);
            $table->Integer('bathroom_duration')->default(0);
            $table->Integer('already_your_client_duration')->default(0);
            $table->Integer('already_quoted_duration')->default(0);
            $table->Integer('already_covered_duration')->default(0);
            $table->Integer('reason_unknown_duration')->default(0);
            $table->Integer('timeout_duration')->default(0);
            $table->Integer('user_hangup_duration')->default(0);

            $table->float('dnc_percent', precision: 53)->default(0);
            $table->float('work_number_percent', precision: 53)->default(0);
            $table->float('unemployed_percent', precision: 53)->default(0);
            $table->float('swearing_percent', precision: 53)->default(0);
            $table->float('repeat_percent', precision: 53)->default(0);
            $table->float('religion_barrier_percent', precision: 53)->default(0);
            $table->float('relative_pays_percent', precision: 53)->default(0);
            $table->float('outdoor_percent', precision: 53)->default(0);
            $table->float('others_pickup_call_percent', precision: 53)->default(0);
            $table->float('not_allowed_percent', precision: 53)->default(0);
            $table->float('no_car_percent', precision: 53)->default(0);
            $table->float('sick_percent', precision: 53)->default(0);
            $table->float('angry_percent', precision: 53)->default(0);
            $table->float('in_meeting_percent', precision: 53)->default(0);
            $table->float('home_chores_percent', precision: 53)->default(0);
            $table->float('goodbyes_percent', precision: 53)->default(0);
            $table->float('fallback_percent', precision: 53)->default(0);
            $table->float('expecting_call_percent', precision: 53)->default(0);
            $table->float('driving_percent', precision: 53)->default(0);
            $table->float('children_percent', precision: 53)->default(0);
            $table->float('broker_percent', precision: 53)->default(0);
            $table->float('bathroom_percent', precision: 53)->default(0);
            $table->float('already_your_client_percent', precision: 53)->default(0);
            $table->float('already_quoted_percent', precision: 53)->default(0);
            $table->float('already_covered_percent', precision: 53)->default(0);
            $table->float('reason_unknown_percent', precision: 53)->default(0);
            $table->float('timeout_percent', precision: 53)->default(0);
            $table->float('user_hangup_percent', precision: 53)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dial_stat_by_rows', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
};
