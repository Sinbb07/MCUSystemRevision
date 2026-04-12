<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_forms')->insert([
            [
                'form_code' => 'IACUC DOCUMENTS',
                'form_name' => 'IACUC RESEARCH SUBMISSION',
                'form_view' => 'student/submit-form-layout',
                'form_type' => 'Submission',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}