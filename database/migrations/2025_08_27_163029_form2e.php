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
            $table->string('protocol_ID');
            
            // Textarea fields (all the comment fields from your blade)
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
            $table->enum('action', [
                'Approve', 
                'Minor Modifications', 
                'Major Modifications', 
                'Disapprove', 
                'Pending if Major Clarifications are Required Before a Decision can be Made'
            ])->nullable();
            
            // Justification
            $table->text('justification')->nullable();

            $table->timestamps();
            
            $table->foreign('user_ID')
                  ->references('user_ID')
                  ->on('tbl_users') // Update with your actual users table name
                  ->onDelete('cascade');
                  
            $table->foreign('protocol_ID')
                  ->references('protocol_ID')
                  ->on('tbl_protocol') // Update with your actual protocol table name
                  ->onDelete('cascade');
                  
            // Add index for faster queries
            $table->index(['user_ID', 'protocol_ID']);
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