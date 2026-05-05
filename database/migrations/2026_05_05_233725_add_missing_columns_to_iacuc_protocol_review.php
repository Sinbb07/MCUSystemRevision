<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_iacuc_protocol_review', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_iacuc_protocol_review', 'animal_species')) {
                $table->text('animal_species')->nullable()->after('study_title');
            }
            if (!Schema::hasColumn('tbl_iacuc_protocol_review', 'animal_source')) {
                $table->text('animal_source')->nullable()->after('animal_species');
            }
            if (!Schema::hasColumn('tbl_iacuc_protocol_review', 'number_cage')) {
                $table->text('number_cage')->nullable()->after('pain_category_comment');
            }
            if (!Schema::hasColumn('tbl_iacuc_protocol_review', 'use_anesthetics')) {
                $table->text('use_anesthetics')->nullable()->after('complications_comment');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_iacuc_protocol_review', function (Blueprint $table) {
            $table->dropColumn(['animal_species', 'animal_source', 'number_cage', 'use_anesthetics']);
        });
    }
};