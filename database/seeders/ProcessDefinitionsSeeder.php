<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcessDefinitionsSeeder extends Seeder
{
    public function run()
    {
        $processes = [
            // ==================== SUPER ADMIN/IRO ====================
            ['SA1', 'Received request from PI', 'super_admin', 'in', 1],
            ['SA2', 'Classification (ERB/IACUC)', 'super_admin', 'out', 2],
            
            // ==================== ADMIN/ERB ====================
            // INCOMING
            ['ERB1', 'Received classified (ERB)', 'admin_erb', 'in', 1],
            ['ERB2', 'Received forms from PI', 'admin_erb', 'in', 2],
            ['ERB3', 'Received manuscript and documents', 'admin_erb', 'in', 3],
            ['ERB4', 'Received accomplished forms from reviewer', 'admin_erb', 'in', 4],
            
            // OUTGOING
            ['ERB5', 'Assign initial forms to PI', 'admin_erb', 'out', 5],
            ['ERB6', 'Assign reviewer', 'admin_erb', 'out', 6],
            ['ERB7', 'Assign fullboard reviewers', 'admin_erb', 'out', 7],
            ['ERB8', 'Send manuscript to reviewer', 'admin_erb', 'out', 8],
            ['ERB9', 'Send evaluation forms to reviewer', 'admin_erb', 'out', 9],
            ['ERB10', 'Decide protocol', 'admin_erb', 'out', 10],
            
            // ==================== ADMIN/IACUC ====================
            // INCOMING
            ['IAC1', 'Received classified (IACUC)', 'admin_iacuc', 'in', 1],
            ['IAC2', 'Received IACUC forms from PI', 'admin_iacuc', 'in', 2],
            ['IAC3', 'Received manuscript and documents', 'admin_iacuc', 'in', 3],
            ['IAC4', 'Received accomplished forms from reviewer', 'admin_iacuc', 'in', 4],
            
            // OUTGOING
            ['IAC5', 'Assign initial forms to PI', 'admin_iacuc', 'out', 5],
            ['IAC6', 'Assign reviewer and grant ethical clearance', 'admin_iacuc', 'out', 6],
            ['IAC7', 'Send manuscript and documents to reviewer', 'admin_iacuc', 'out', 7],
            ['IAC8', 'Send evaluation forms to reviewer', 'admin_iacuc', 'out', 8],
            ['IAC9', 'Decide protocol', 'admin_iacuc', 'out', 9],
            
            // ==================== PI ====================
            // INCOMING
            ['PI1', 'Approval IRO (ERB/IACUC)', 'pi', 'in', 1],
            ['PI2', 'Received initial forms from admin', 'pi', 'in', 2],
            ['PI3', 'Received remarks (if not approved)', 'pi', 'in', 3],
            
            // OUTGOING
            ['PI4', 'Registration submitted', 'pi', 'out', 4],
            ['PI5', 'Send manuscript to admin', 'pi', 'out', 5],
            ['PI6', 'Submit forms to ERB/IACUC', 'pi', 'out', 6],
            
            // ==================== ERB REVIEWER ====================
            // INCOMING
            ['REV_ERB1', 'Received forms and protocol from ERB admin', 'reviewer_erb', 'in', 1],
            ['REV_ERB2', 'Received manuscript and documents', 'reviewer_erb', 'in', 2],
            ['REV_ERB3', 'Received full board invitation', 'reviewer_erb', 'in', 3],
            
            // OUTGOING
            ['REV_ERB4', 'Submit accomplished forms to ERB admin', 'reviewer_erb', 'out', 4],
            
            // ==================== IACUC REVIEWER ====================
            // INCOMING
            ['REV_IAC1', 'Received forms and protocol from IACUC admin', 'reviewer_iacuc', 'in', 1],
            ['REV_IAC2', 'Received manuscript and documents', 'reviewer_iacuc', 'in', 2],
            
            // OUTGOING
            ['REV_IAC3', 'Submit accomplished forms to IACUC admin', 'reviewer_iacuc', 'out', 3],
        ];

        // Clear the table first (optional)
        DB::table('tbl_process_definitions')->truncate();

        foreach ($processes as $process) {
            DB::table('tbl_process_definitions')->insert([
                'process_code' => $process[0],
                'process_description' => $process[1],
                'user_type' => $process[2],
                'direction' => $process[3],
                'sequence_order' => $process[4],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Process definitions seeded successfully!');
        $this->command->info('📊 Total processes: ' . count($processes));
    }
}