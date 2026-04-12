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
        Schema::table('tbl_research_information', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_research_information', 'research_type')) {
                $table->string('research_type')->nullable()->after('research_title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_research_information', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_research_information', 'research_type')) {
                $table->dropColumn('research_type');
            }
        });
    }
};
