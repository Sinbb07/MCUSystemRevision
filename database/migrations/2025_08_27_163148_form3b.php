<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_form3b', function (Blueprint $table) {
            $table->string('form3BID')->primary();
            $table->string('user_ID');
            $table->integer('total_participants')->nullable();
            $table->enum('review_type', ['2nd_review', '3rd_review'])->nullable();
            $table->text('recommendation_from_last_review')->nullable();
            $table->text('recommendation_indication')->nullable();
            
            // Protocol-related issues
            $table->text('protocol_issues_1')->nullable();
            $table->text('protocol_issues_2')->nullable();
            $table->text('indicate_protocol_related')->nullable();
            $table->string('protocol_related_page')->nullable();
            
            // Ethical-related issues
            $table->text('ethical_issues_1')->nullable();
            $table->text('ethical_issues_2')->nullable();
            $table->text('indicate_ethical_issue')->nullable();
            $table->string('ethical_related_page')->nullable();
            
            // Consent-related issues
            $table->text('consent_issues_1')->nullable();
            $table->text('consent_issues_2')->nullable();
            $table->text('indicate_consent_related')->nullable();
            $table->string('consent_related_page')->nullable();
            
            // Review changes
            $table->text('review_changes_1')->nullable();
            $table->text('review_changes_2')->nullable();
            $table->text('indicate_review_changes')->nullable();
            $table->string('review_changes_page')->nullable();
            
            $table->timestamps();

            $table->foreign('user_ID')->references('user_ID')->on('tbl_users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_form3b');
    }
};