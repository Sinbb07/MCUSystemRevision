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
        Schema::create('tbl_form3a', function (Blueprint $table) {
            $table->string('form3AID')->primary();
            $table->string('user_ID');
            $table->string('protocol');
            $table->string('version_no');
            $table->string('study_site');
            $table->string('pi_name');
            $table->string('coi_name')->nullable();
            $table->string('tel_no')->nullable();
            $table->string('contact_no');
            $table->string('pi_email');
            $table->string('investigator_institution');
            $table->text('institution_address');
            $table->text('recommendations');
            $table->text('research_response');
            $table->text('section_page_number');
            $table->timestamps();

            $table->foreign('user_ID')->references('user_ID')->on('tbl_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_form3a');
    }
};
