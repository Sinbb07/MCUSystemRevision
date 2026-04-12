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
        Schema::create('tbl_form2d', function (Blueprint $table) {
            $table->string('form2DID', 10)->primary();
            $table->string('user_ID', 10);
            
            // Radio button fields
            $table->string('study_involvement', 10);
            $table->text('statement_study_involve')->nullable();
            
            $table->string('study_purpose', 10);
            $table->text('statement_study_purpose')->nullable();
            
            $table->string('participant_inclusion', 10);
            $table->text('explanation_inclusion')->nullable();
            
            $table->string('voluntary', 10);
            $table->text('provisions')->nullable();
            
            $table->string('withdraw', 10);
            $table->text('withdrawal_statement')->nullable();
            
            $table->string('study_nature', 10);
            $table->text('statement_study_nature')->nullable();
            
            $table->string('risks_benefits', 10);
            $table->text('disclose_risks_benefits')->nullable();
            
            $table->string('potential_benefits', 10);
            $table->text('potential_benefits_statement')->nullable();
            
            $table->string('mitigation', 10);
            $table->text('provision_mitigations')->nullable();
            
            $table->string('alternate_procedure', 10);
            $table->text('alternate_procedure_lists')->nullable();
            
            $table->string('participant_responsibilities', 10);
            $table->text('statement_responsibilities')->nullable();
            
            $table->string('study_expenses', 10);
            $table->text('expenses_statement')->nullable();
            
            $table->string('compensation', 10);
            $table->text('compensation_statement')->nullable();
            
            $table->string('participant_records', 10);
            $table->text('statement_participant_records')->nullable();
            
            $table->string('data_protection', 10);
            $table->text('data_protection_description')->nullable();
            
            $table->string('study_duration', 10);
            $table->text('expected_study_duration')->nullable();
            
            $table->string('number_subject', 10);
            $table->text('approximate_number_subject')->nullable();
            
            $table->string('findings_results', 10);
            $table->text('explanation_findings_results')->nullable();
            
            $table->string('contact', 10);
            $table->text('person_contact')->nullable();
            
            $table->string('approval', 10);
            $table->text('statement_approval')->nullable();
            
            $table->string('presentation_language', 10);
            $table->text('manifestation_presentation')->nullable();

            $table->timestamps();

            // Foreign key constraint - make sure users table exists first
            //$table->foreign('user_ID')->references('user_ID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_form2d');
    }
};