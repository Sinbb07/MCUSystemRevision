<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblIacucProtocolReview extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tbl_iacuc_protocol_review')) {
            Schema::create('tbl_iacuc_protocol_review', function (Blueprint $table) {
                $table->id();
                $table->string('review_id')->unique(); // Added for the UUID in your controller
                $table->string('protocol_ID'); // Changed to string to match your image_de1261.png
                $table->string('reviewer_ID'); // Changed to string to match your image_de1261.png
                
                // Form Fields
                $table->text('study_title')->nullable();
                $table->string('pi_person')->nullable();
                $table->string('adviser')->nullable();

                // Checklist Comments
                $table->text('scientific_merit_comment')->nullable();
                $table->text('training_experience_comment')->nullable();
                $table->text('overview_section_comment')->nullable();
                $table->text('rational_justification_comment')->nullable();
                $table->text('adequate_justification_comment')->nullable();
                $table->text('unnecessary_duplication_comment')->nullable();
                $table->text('experimental_procedures_comment')->nullable();
                $table->text('endpoint_duration_comment')->nullable();
                $table->text('euthanasia_method_comment')->nullable();
                $table->text('pain_category_comment')->nullable();
                $table->text('alternative_housing_comment')->nullable();
                $table->text('hazardous_material_comment')->nullable();
                $table->text('multiple_survival_comment')->nullable();
                $table->text('pain_relief_comment')->nullable();
                $table->text('ill_debilitated_comment')->nullable();
                $table->text('complications_comment')->nullable();
                $table->text('veterinary_complications_comment')->nullable();
                $table->text('proposed_anesthesia_comment')->nullable();
                $table->text('post_procedural_comment')->nullable();
                $table->text('appropriate_method_comment')->nullable();
                $table->text('summary_comments')->nullable();

                $table->timestamps();
                $table->unique(['protocol_ID', 'reviewer_ID'], 'iacuc_protocol_review_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_iacuc_protocol_review');
    }
} // No semicolon here!