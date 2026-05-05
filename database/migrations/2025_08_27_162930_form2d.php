<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_form2d', function (Blueprint $table) {
            $table->string('form2DID', 10)->primary();
            $table->string('user_ID', 10);
            
            // Only textarea fields - removed all radio button fields
            $table->text('statement_study_involve')->nullable();
            $table->text('statement_study_purpose')->nullable();
            $table->text('explanation_inclusion')->nullable();
            $table->text('provisions')->nullable();
            $table->text('withdrawal_statement')->nullable();
            $table->text('statement_study_nature')->nullable();
            $table->text('disclose_risks_benefits')->nullable();
            $table->text('potential_benefits_statement')->nullable();
            $table->text('provision_mitigations')->nullable();
            $table->text('alternate_procedure_lists')->nullable();
            $table->text('statement_responsibilities')->nullable();
            $table->text('expenses_statement')->nullable();
            $table->text('compensation_statement')->nullable();
            $table->text('statement_participant_records')->nullable();
            $table->text('data_protection_description')->nullable();
            $table->text('expected_study_duration')->nullable();
            $table->text('approximate_number_subject')->nullable();
            $table->text('explanation_findings_results')->nullable();
            $table->text('person_contact')->nullable();
            $table->text('statement_approval')->nullable();
            $table->text('manifestation_presentation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_form2d');
    }
};