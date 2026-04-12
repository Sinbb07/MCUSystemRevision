<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentDashboard extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $studentId = $student->user_ID;

        // Get the latest protocol for the student
        $latestProtocol = DB::table('tbl_protocol')
            ->where('user_ID', $studentId)
            ->orderBy('created_at', 'desc')
            ->first();

        // Status of Review
        $reviewStatus = 'No Submission';
        if ($latestProtocol) {
            $protocolId = $latestProtocol->protocol_ID;
            
            // Check if protocol is under review
            $underReview = DB::table('tbl_initial_review')
                ->where('protocol_ID', $protocolId)
                ->exists();

            // Check if protocol has been evaluated
            $evaluated = DB::table('tbl_evaluated_reviews')
                ->where('protocol_ID', $protocolId)
                ->exists();

            if ($evaluated) {
                $reviewStatus = 'Evaluated';
            } elseif ($underReview) {
                $reviewStatus = 'Under Review';
            } else {
                $reviewStatus = 'Submitted';
            }
        }

        // Count submitted documents (forms that the student has files for) with form_type = 'Submission'
        $submittedDocumentsCount = DB::table('tbl_research_files')
            ->join('tbl_forms', 'tbl_research_files.form_id', '=', 'tbl_forms.form_id')
            ->where('tbl_research_files.user_ID', $studentId)
            ->where('tbl_research_files.status', 'active')
            ->where('tbl_forms.form_type', 'Submission')
            ->count();

        // Count pending documents (forms assigned to student but not submitted) with form_type = 'Submission'
        $pendingDocumentsCount = DB::table('tbl_form_user')
            ->join('tbl_forms', 'tbl_form_user.form_id', '=', 'tbl_forms.form_id')
            ->where('tbl_form_user.user_ID', $studentId)
            ->where('tbl_forms.form_type', 'Submission')
            ->whereNotIn('tbl_form_user.form_id', function($query) use ($studentId) {
                $query->select('form_id')
                      ->from('tbl_research_files')
                      ->where('user_ID', $studentId)
                      ->where('status', 'active');
            })
            ->count();

        // Get submitted documents details for the modal (only Submission type)
        $submittedDocuments = DB::table('tbl_research_files')
            ->join('tbl_forms', 'tbl_research_files.form_id', '=', 'tbl_forms.form_id')
            ->where('tbl_research_files.user_ID', $studentId)
            ->where('tbl_research_files.status', 'active')
            ->where('tbl_forms.form_type', 'Submission')
            ->select('tbl_forms.form_name', 'tbl_research_files.file_name', 'tbl_research_files.submitted_at')
            ->get();

        // Get pending documents details for the modal (only Submission type)
        $pendingDocuments = DB::table('tbl_form_user')
            ->join('tbl_forms', 'tbl_form_user.form_id', '=', 'tbl_forms.form_id')
            ->where('tbl_form_user.user_ID', $studentId)
            ->where('tbl_forms.form_type', 'Submission')
            ->whereNotIn('tbl_form_user.form_id', function($query) use ($studentId) {
                $query->select('form_id')
                      ->from('tbl_research_files')
                      ->where('user_ID', $studentId)
                      ->where('status', 'active');
            })
            ->select('tbl_forms.form_name')
            ->get();

        // Deadline (you might want to get this from your protocol or settings table)
        $deadline = $latestProtocol->deadline ?? '2025/08/05'; // Default or from database

        return view('student.dashboard', compact(
            'reviewStatus',
            'submittedDocumentsCount',
            'pendingDocumentsCount',
            'deadline',
            'submittedDocuments',
            'pendingDocuments'
        ));
    }
}