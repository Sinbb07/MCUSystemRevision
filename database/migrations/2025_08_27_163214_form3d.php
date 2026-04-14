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
        Schema::create('tbl_form3d', function (Blueprint $table) {
            $table->string('form3DID')->primary();
            $table->string('user_ID');
            $table->text('add_remove')->nullable();
            $table->text('add_methods')->nullable();
            $table->text('additional_data')->nullable();
            $table->text('remove_participants')->nullable();
            $table->text('minor_changes')->nullable();
            $table->text('extension')->nullable();
            $table->boolean('confirmation_all_changes')->default(false);
            $table->text('other_documents')->nullable();
            $table->string('thesisadviser')->nullable();
            $table->string('notedby')->nullable();
            $table->string('coordinator')->nullable();
            $table->timestamps();

            $table->foreign('user_ID')->references('user_ID')->on('tbl_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_form3d');
    }
};