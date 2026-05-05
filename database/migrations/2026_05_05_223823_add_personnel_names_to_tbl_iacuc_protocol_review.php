<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_iacuc_protocol_review', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_iacuc_protocol_review', 'personnel_names')) {
                $table->text('personnel_names')->nullable()->after('summary_comments');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_iacuc_protocol_review', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_iacuc_protocol_review', 'personnel_names')) {
                $table->dropColumn('personnel_names');
            }
        });
    }
};