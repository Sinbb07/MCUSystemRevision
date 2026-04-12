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
        Schema::create('tbl_form5e', function (Blueprint $table) {
            $table->string('form5EID')->primary();
            $table->string('user_ID');

            $table->string('protocol')->nullable();
            $table->string('pi_name');
            $table->string('coiname');
            $table->string('pi_contact', 50);
            $table->string('pi_email');
            $table->string('institution');
            $table->string('institute_address');
            $table->string('erb_contact');
            
            // Basic Documents
            $table->boolean('cover_letter')->default(false);
            $table->boolean('enrollment_proof')->default(false);
            $table->boolean('letter')->default(false);
            $table->boolean('complete_form2b')->default(false);
            $table->boolean('complete_form2a')->default(false);
            $table->boolean('complete_form2d')->default(false);
            
            // Protocol Package
            $table->boolean('study_protocol')->default(false);
            $table->boolean('form2c_eng')->default(false);
            $table->boolean('form2c_fil')->default(false);
            $table->boolean('data_collection')->default(false);
            $table->boolean('cert_validator')->default(false);
            $table->boolean('eng_7_12_yrs')->default(false);
            $table->boolean('fil_7_12_yrs')->default(false);
            $table->boolean('eng_13_17_yrs')->default(false);
            $table->boolean('fil_13_17_yrs')->default(false);
            $table->boolean('advertisement')->default(false);
            $table->boolean('vitae')->default(false);
            $table->boolean('gcp')->default(false);

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
        Schema::dropIfExists('tbl_form5e');
    }
};
