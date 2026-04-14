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
        Schema::create('tbl_reviewer_info', function (Blueprint $table) {
            $table->id();
            $table->string('user_ID'); 
            $table->string('college');
            $table->string('department');
            $table->timestamps();

            // Connects to your existing users table
            $table->foreign('user_ID')->references('user_ID')->on('tbl_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_reviewer_info');
    }
};
