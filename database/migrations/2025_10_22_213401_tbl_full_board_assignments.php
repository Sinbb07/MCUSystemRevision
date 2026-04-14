<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_full_board_assignments', function (Blueprint $table) {
            $table->string('assignment_ID')->primary();
            $table->string('protocol_ID');
            $table->string('reviewer_ID'); // The ERB Reviewer user_ID
            $table->string('assigned_by'); // User who made the assignment
            $table->timestamps();

            // Foreign keys
            $table->foreign('protocol_ID')->references('protocol_ID')->on('tbl_protocol')->onDelete('cascade');
            $table->foreign('reviewer_ID')->references('user_ID')->on('tbl_users')->onDelete('cascade');
            $table->foreign('assigned_by')->references('user_ID')->on('tbl_users')->onDelete('cascade');
            
            // Ensure a reviewer isn't assigned twice to the same protocol
            $table->unique(['protocol_ID', 'reviewer_ID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_full_board_assignments');
    }
};