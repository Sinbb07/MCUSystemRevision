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
        Schema::create('tbl_process_monitoring', function (Blueprint $table) {
            $table->id();
            $table->string('process_code', 20);
            $table->text('process_description');
            $table->enum('user_type', [
                'super_admin', 
                'admin_erb', 
                'admin_iacuc', 
                'pi', 
                'reviewer_erb',
                'reviewer_iacuc'
            ]);
            $table->enum('direction', ['in', 'out']);
            $table->dateTime('timestamp');
            
            $table->string('action_by_user_id');
            $table->string('action_by_user_type');
            $table->string('affected_user_id')->nullable();
            $table->string('affected_user_type')->nullable();
            
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index('timestamp');
            $table->index('user_type');
            $table->index('process_code');
            $table->index('action_by_user_id');
            $table->index('affected_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_process_monitoring');
    }
};
