<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First, drop the existing Decision column
        Schema::table('tbl_approved_iacuc', function (Blueprint $table) {
            $table->dropColumn('Decision');
        });
        
        // Then recreate it with the new enum values
        Schema::table('tbl_approved_iacuc', function (Blueprint $table) {
            $table->enum('Decision', ['Approved', 'Resubmission', 'Rejected'])->nullable()->after('Protocol_ID');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_approved_iacuc', function (Blueprint $table) {
            $table->dropColumn('Decision');
            $table->enum('Decision', ['Approved', 'Rejected'])->nullable()->after('Protocol_ID');
        });
    }
};