<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form2E;
use Illuminate\Support\Facades\Auth;

class Form2EController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $userId = $user->user_ID;

        // Validate the request data
        $validated = $request->validate([
            // Radio button fields
            'main_idea_study' => 'nullable|string|in:Yes,No',
            'scientific_significance' => 'nullable|string|in:Yes,No',
            'human_participants' => 'nullable|string|in:Yes,No',
            'problem_statement' => 'nullable|string|in:Yes,No',
            'background_study' => 'nullable|string|in:Yes,No',
            'relevant_information' => 'nullable|string|in:Yes,No',
            'population' => 'nullable|string|in:Yes,No',
            'sample_size' => 'nullable|string|in:Yes,No',
            'manner' => 'nullable|string|in:Yes,No',
            'study_site' => 'nullable|string|in:Yes,No',
            'research_questions' => 'nullable|string|in:Yes,No',
            'conditions_characteristics' => 'nullable|string|in:Yes,No',
            'characteristics' => 'nullable|string|in:Yes,No',
            'participant_vulnerability' => 'nullable|string|in:Yes,No',
            'special_vulnerability' => 'nullable|string|in:Yes,No',
            'special_measures' => 'nullable|string|in:Yes,No',
            'study_procedure' => 'nullable|string|in:Yes,No',
            'overall_procedures' => 'nullable|string|in:Yes,No',
            'anonymity_confidentiality' => 'nullable|string|in:Yes,No',
            'maintained' => 'nullable|string|in:Yes,No',
            'data_confidentiality' => 'nullable|string|in:Yes,No',
            'records_data' => 'nullable|string|in:Yes,No',
            'risks_likelihood' => 'nullable|string|in:Yes,No',
            'duration' => 'nullable|string|in:Yes,No',
            'techniques' => 'nullable|string|in:Yes,No',
            
            // Textarea fields
            'main_idea_summarize' => 'nullable|string|max:1000',
            'significance_discuss' => 'nullable|string|max:1000',
            'require_human_participants' => 'nullable|string|max:1000',
            'problem_statement_address' => 'nullable|string|max:1000',
            'adequate' => 'nullable|string|max:1000',
            'information_discuss' => 'nullable|string|max:1000',
            'population_define' => 'nullable|string|max:1000',
            'approx_size' => 'nullable|string|max:1000',
            'participants_manner' => 'nullable|string|max:1000',
            'site_identify' => 'nullable|string|max:1000',
            'appropriate_questions' => 'nullable|string|max:1000',
            'apply_characteristics' => 'nullable|string|max:1000',
            'characteristics_disqualify' => 'nullable|string|max:1000',
            'involvement' => 'nullable|string|max:1000',
            'vulnerability_evaluation' => 'nullable|string|max:1000',
            'indicate_measures' => 'nullable|string|max:1000',
            'describe_procedure' => 'nullable|string|max:1000',
            'overall_procedure_describe' => 'nullable|string|max:1000',
            'confidentiality_measures' => 'nullable|string|max:1000',
            'describe_maintain' => 'nullable|string|max:1000',
            'preserve_data' => 'nullable|string|max:1000',
            'disposition_records' => 'nullable|string|max:1000',
            'minimize_maximize' => 'nullable|string|max:1000',
            'estimated_date' => 'nullable|string|max:1000',
            'techniques_described' => 'nullable|string|max:1000',
            
            // Summary of Recommendations
            'summary_recommendation_1' => 'nullable|string|max:1000',
            'summary_recommendation_2' => 'nullable|string|max:1000',
            'summary_recommendation_3' => 'nullable|string|max:1000',
            'summary_recommendation_4' => 'nullable|string|max:1000',
            
            // Recommended Action
            'action' => 'nullable|string|in:Approve,Minor Modifications,Major Modifications,Disapprove,Pending if Major Clarifications are Required Before a Decision can be Made',
            
            // Justification
            'justification' => 'nullable|string|max:2000',
        ]);

        try {
            // Check if record already exists for this user
            $existingForm = Form2E::where('user_ID', $userId)->first();

            if ($existingForm) {
                // Update existing record
                $existingForm->update($validated);
                $form2EID = $existingForm->form2EID;
            } else {
                // Generate form2EID for new record
                $lastId = Form2E::max('form2EID');
                if ($lastId) {
                    $num = intval(substr($lastId, 3)) + 1;
                    $form2EID = 'f2e' . str_pad($num, 6, '0', STR_PAD_LEFT);
                } else {
                    $form2EID = 'f2e000001';
                }

                // Add user ID and form2EID to validated data
                $validated['user_ID'] = $userId;
                $validated['form2EID'] = $form2EID;

                // Create new record
                Form2E::create($validated);
            }

            return redirect()->route('form2e.edit')->with('success', 'Form 2(E) saved successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error saving form: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit()
    {
        $user = auth()->user();
        $userId = $user->user_ID;

        // Fetch existing form data or create empty instance
        $form2e = Form2E::where('user_ID', $userId)->first() ?? new Form2E();

        return view('erb-reviewer.forms.form2e', compact('form2e')); 
    }
}