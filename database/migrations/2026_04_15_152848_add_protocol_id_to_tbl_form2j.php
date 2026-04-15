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
        Schema::table('tbl_form2j', function (Blueprint $table) {
            // Add protocol_ID after user_ID
            $table->string('protocol_ID')->after('user_ID')->nullable();
            
            // Add the foreign key constraint
            $table->foreign('protocol_ID')
                  ->references('protocol_ID')
                  ->on('tbl_protocols')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_form2j', function (Blueprint $table) {
            $table->dropForeign(['protocol_ID']);
            $table->dropColumn('protocol_ID');
        });
    }
};
