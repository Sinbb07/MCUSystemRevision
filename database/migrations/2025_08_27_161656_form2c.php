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
        Schema::create('tbl_form2c', function (Blueprint $table) {
            $table->string('form2CID')->primary();
            $table->string('user_ID');

            // Part I: Basic Info
            $table->string('protocol')->nullable();
            $table->string('pi_name');
            $table->string('coiname');
            $table->string('pi_contact', 50);
            $table->string('pi_email');
            $table->string('institution');
            $table->string('institute_address');
            $table->string('erb_contact');

            // Part III: Details
            $table->longText('description_purpose')->nullable();
            $table->longText('procedures')->nullable();
            $table->longText('participant_selection')->nullable();
            $table->longText('participation')->nullable();
            $table->string('duration')->nullable();
            $table->longText('risks_hazards')->nullable();
            $table->longText('benefits')->nullable();
            $table->longText('injury_management')->nullable();
            $table->longText('compensation')->nullable();
            $table->longText('confidentiality')->nullable();
            $table->longText('right_to_refuse')->nullable();

            $table->string('title_name')->nullable();
            $table->string('approval_mcueerb')->nullable();
            $table->string('contact_mcueerb')->nullable();

            // Part IV: Certificate of Consent
            $table->enum('consent_q1', ['Yes', 'No'])->nullable();
            $table->enum('consent_q2', ['Yes', 'No'])->nullable();
            $table->enum('consent_q3', ['Yes', 'No'])->nullable();
            $table->enum('consent_q4', ['Yes', 'No'])->nullable();
            $table->enum('consent_q5', ['Yes', 'No'])->nullable();
            $table->enum('consent_q6', ['Yes', 'No'])->nullable();
            $table->enum('consent_q7', ['Yes', 'No'])->nullable();
            $table->enum('consent_q8', ['Yes', 'No'])->nullable();
            $table->enum('consent_q9', ['Yes', 'No'])->nullable();
            $table->enum('consent_q10', ['Yes', 'No'])->nullable();

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
        Schema::dropIfExists('tbl_form2c');
    }
};
