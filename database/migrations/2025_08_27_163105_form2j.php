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
        Schema::create('tbl_form2j', function (Blueprint $table) {
            $table->string('form2JID')->primary();
            $table->string('user_ID')->constrained('tbl_users')->onDelete('cascade');
            
            // Radio button fields
            $table->string('potential_manner')->nullable();
            $table->string('conditions_characteristics')->nullable();
            $table->string('susceptible_risks')->nullable();
            $table->string('special_vulnerability')->nullable();
            $table->string('special_measures')->nullable();
            $table->string('study_methods')->nullable();
            $table->string('confidentiality')->nullable();
            $table->string('confidential_procedures')->nullable();
            $table->string('disposition_records')->nullable();
            
            // Textarea fields
            $table->text('manner_described')->nullable();
            $table->text('apply_characteristics')->nullable();
            $table->text('exclusion_people')->nullable();
            $table->text('relevant')->nullable();
            $table->text('indicate_measures')->nullable();
            $table->text('describe_study_methods')->nullable();
            $table->text('anonymity')->nullable();
            $table->text('discussed_confidentiality')->nullable();
            $table->text('disposition_discuss')->nullable();
            
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_form2j');
    }
};