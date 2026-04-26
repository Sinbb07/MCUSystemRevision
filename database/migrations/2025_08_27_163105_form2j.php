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
            $table->string('user_ID');
            $table->string('protocol_ID');
            
            // Textarea fields (all comment fields from your blade)
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
            
            // Recommended Action (only Approve or Disapprove)
            $table->enum('action', ['Approve', 'Disapprove'])->nullable();
            
            // Justification
            $table->text('justification')->nullable();

            $table->timestamps();
            
            // Foreign key constraints
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
        Schema::dropIfExists('tbl_form2j');
    }
};