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
        Schema::create('tbl_form3c', function (Blueprint $table) {
            $table->string('form3CID')->primary();
            $table->string('user_ID');

            // General Information
            $table->string('study_title');
            $table->string('study_site');
            $table->string('pi_name');
            
            // Contact Information
            $table->string('tel_no')->nullable();
            $table->string('contact_no');
            $table->string('pi_email');
            $table->string('investigator_institution');
            $table->string('institution_address');
            $table->string('college_dept');
            $table->string('ethical_clearance');
            
            // Progress Report
            $table->date('study_start');
            $table->date('study_end');
            $table->integer('enrolled_participants');
            $table->integer('required_participants');
            $table->integer('participant_withdrew')->default(0);
            $table->string('deviations');
            $table->text('new_information')->nullable();
            $table->text('issues_problems')->nullable();

            $table->timestamps();

            $table->foreign('user_ID')
                  ->references('user_ID')
                  ->on('tbl_users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_form3c');
    }
};
