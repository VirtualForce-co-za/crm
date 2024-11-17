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
        Schema::table('leads', function (Blueprint $table) {
            $table->string('provide_alternative_number')->nullable();
            $table->string('language_preference')->nullable();
            $table->string('make_and_model')->nullable();
            $table->string('capture_year_model')->nullable();
            $table->string('namesurname')->nullable();
            $table->string('idnumber')->nullable();
            $table->string('provide_primary_contact')->nullable();
            $table->string('email')->nullable();
            $table->string('name_first_person')->nullable();
            $table->string('number_first_person')->nullable();
            $table->string('name_second_person')->nullable();
            $table->string('number_second_person')->nullable();
            $table->string('name_third_person')->nullable();
            $table->string('number_third_person')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
        });
    }
};
