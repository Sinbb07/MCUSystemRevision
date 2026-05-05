<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_form2d', function (Blueprint $table) {
            // Drop radio columns if they exist
            $columns = [
                'study_involvement', 'study_purpose', 'participant_inclusion', 'voluntary',
                'withdraw', 'study_nature', 'risks_benefits', 'potential_benefits',
                'mitigation', 'alternate_procedure', 'participant_responsibilities',
                'study_expenses', 'compensation', 'participant_records', 'data_protection',
                'study_duration', 'number_subject', 'findings_results', 'contact',
                'approval', 'presentation_language'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('tbl_form2d', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down(): void
    {
        // down method optional
    }
};