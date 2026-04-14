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
                $table->unsignedBigInteger('protocol_ID');
                $table->unsignedBigInteger('reviewer_ID');
                $table->text('complications_comment')->nullable(); // ADD THIS LINE
                $table->json('data')->nullable();
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