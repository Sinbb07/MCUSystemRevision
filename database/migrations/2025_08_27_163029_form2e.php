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
        Schema::create('tbl_form2e', function (Blueprint $table) {
            $table->string('form2EID')->primary();
            $table->string('user_ID');
            
            // Radio button fields
            $table->string('main_idea_study')->nullable();
            $table->string('scientific_significance')->nullable();
            $table->string('human_participants')->nullable();
            $table->string('problem_statement')->nullable();
            $table->string('background_study')->nullable();
            $table->string('relevant_information')->nullable();
            $table->string('population')->nullable();
            $table->string('sample_size')->nullable();
            $table->string('manner')->nullable();
            $table->string('study_site')->nullable();
            $table->string('research_questions')->nullable();
            $table->string('conditions_characteristics')->nullable();
            $table->string('characteristics')->nullable();
            $table->string('participant_vulnerability')->nullable();
            $table->string('special_vulnerability')->nullable();
            $table->string('special_measures')->nullable();
            $table->string('study_procedure')->nullable();
            $table->string('overall_procedures')->nullable();
            $table->string('anonymity_confidentiality')->nullable();
            $table->string('maintained')->nullable();
            $table->string('data_confidentiality')->nullable();
            $table->string('records_data')->nullable();
            $table->string('risks_likelihood')->nullable();
            $table->string('duration')->nullable();
            $table->string('techniques')->nullable();
            
            // Textarea fields
            $table->text('main_idea_summarize')->nullable();
            $table->text('significance_discuss')->nullable();
            $table->text('require_human_participants')->nullable();
            $table->text('problem_statement_address')->nullable();
            $table->text('adequate')->nullable();
            $table->text('information_discuss')->nullable();
            $table->text('population_define')->nullable();
            $table->text('approx_size')->nullable();
            $table->text('participants_manner')->nullable();
            $table->text('site_identify')->nullable();
            $table->text('appropriate_questions')->nullable();
            $table->text('apply_characteristics')->nullable();
            $table->text('characteristics_disqualify')->nullable();
            $table->text('involvement')->nullable();
            $table->text('vulnerability_evaluation')->nullable();
            $table->text('indicate_measures')->nullable();
            $table->text('describe_procedure')->nullable();
            $table->text('overall_procedure_describe')->nullable();
            $table->text('confidentiality_measures')->nullable();
            $table->text('describe_maintain')->nullable();
            $table->text('preserve_data')->nullable();
            $table->text('disposition_records')->nullable();
            $table->text('minimize_maximize')->nullable();
            $table->text('estimated_date')->nullable();
            $table->text('techniques_described')->nullable();
            
            // Summary of Recommendations
            $table->text('summary_recommendation_1')->nullable();
            $table->text('summary_recommendation_2')->nullable();
            $table->text('summary_recommendation_3')->nullable();
            $table->text('summary_recommendation_4')->nullable();
            
            // Recommended Action
            $table->string('action')->nullable();
            
            // Justification
            $table->text('justification')->nullable();

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
        Schema::dropIfExists('tbl_form2e');
    }
};