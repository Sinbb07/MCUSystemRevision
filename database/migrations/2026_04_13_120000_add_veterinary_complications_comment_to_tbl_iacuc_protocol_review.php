<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_iacuc_protocol_review', function (Blueprint $table) {
            $table->text('veterinary_complications_comment')->nullable()->after('complications_comment');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_iacuc_protocol_review', function (Blueprint $table) {
            $table->dropColumn('veterinary_complications_comment');
        });
    }
};
