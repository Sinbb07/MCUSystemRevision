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
        Schema::create('tbl_form3e', function (Blueprint $table) {
            $table->string('form3EID')->primary();
            $table->string('user_ID');
            $table->text('amend_provisions')->nullable();
            $table->text('orig_procedure')->nullable();
            $table->text('proposed_amendments')->nullable();
            $table->text('justification')->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('tbl_form3e');
    }
};
