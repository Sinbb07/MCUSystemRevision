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
        Schema::create('tbl_form3l', function (Blueprint $table) {
            $table->string('form3LID')->primary(); // ✅ Fixed: form2AID to form3LID
            $table->string('user_ID');

            // General Information
            $table->string('study_title');
            $table->string('study_site');
            $table->string('pi_name');
            $table->string('version_number_date');
            
            // Contact Information
            $table->string('tel_no')->nullable();
            $table->string('contact_no');
            $table->string('pi_email');
            $table->string('co_investigators')->nullable();
            $table->string('institution_researcher');
            $table->string('institution_address');
            
            // Effective Period of Ethical Clearance
            $table->date('ethical_from_date');
            $table->date('ethical_to_date');
            
            // Progress Report
            $table->date('study_start');
            $table->date('study_end');
            $table->integer('enrolled_participants');
            $table->integer('required_participants');
            $table->integer('participant_withdrew')->default(0);
            $table->string('deviations');
            $table->text('issues_problems')->nullable();
            $table->text('findings_summary')->nullable();
            $table->text('conclusions')->nullable();
            $table->text('action_dissemination')->nullable();

            $table->timestamps();

            // Add foreign key after declaring column
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
        Schema::dropIfExists('tbl_form3l');
    }
};