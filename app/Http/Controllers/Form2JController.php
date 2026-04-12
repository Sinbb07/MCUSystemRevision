<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form2J;
use Illuminate\Support\Facades\Auth;

class Form2JController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $userId = $user->user_ID;

        // Validate the request data
        $validated = $request->validate([
            // Radio button fields
            'potential_manner' => 'nullable|string|in:Yes,No',
            'conditions_characteristics' => 'nullable|string|in:Yes,No',
            'susceptible_risks' => 'nullable|string|in:Yes,No',
            'special_vulnerability' => 'nullable|string|in:Yes,No',
            'special_measures' => 'nullable|string|in:Yes,No',
            'study_methods' => 'nullable|string|in:Yes,No',
            'confidentiality' => 'nullable|string|in:Yes,No',
            'confidential_procedures' => 'nullable|string|in:Yes,No',
            'disposition_records' => 'nullable|string|in:Yes,No',
            
            // Textarea fields
            'manner_described' => 'nullable|string|max:1000',
            'apply_characteristics' => 'nullable|string|max:1000',
            'exclusion_people' => 'nullable|string|max:1000',
            'relevant' => 'nullable|string|max:1000',
            'indicate_measures' => 'nullable|string|max:1000',
            'describe_study_methods' => 'nullable|string|max:1000',
            'anonymity' => 'nullable|string|max:1000',
            'discussed_confidentiality' => 'nullable|string|max:1000',
            'disposition_discuss' => 'nullable|string|max:1000',
            
            // Summary of Recommendations
            'summary_recommendation_1' => 'nullable|string|max:1000',
            'summary_recommendation_2' => 'nullable|string|max:1000',
            'summary_recommendation_3' => 'nullable|string|max:1000',
            'summary_recommendation_4' => 'nullable|string|max:1000',
            
            // Recommended Action
            'action' => 'nullable|string|in:Approve,Disapprove',
            
            // Justification
            'justification' => 'nullable|string|max:2000',
        ]);

        try {
            // Check if record already exists for this user
            $existingForm = Form2J::where('user_ID', $userId)->first();

            if ($existingForm) {
                // Update existing record
                $existingForm->update($validated);
                $form2JID = $existingForm->form2JID;
            } else {
                // Generate form2JID for new record
                $lastId = Form2J::max('form2JID');
                if ($lastId) {
                    $num = intval(substr($lastId, 3)) + 1;
                    $form2JID = 'f2j' . str_pad($num, 6, '0', STR_PAD_LEFT);
                } else {
                    $form2JID = 'f2j000001';
                }

                // Add user ID and form2JID to validated data
                $validated['user_ID'] = $userId;
                $validated['form2JID'] = $form2JID;

                // Create new record
                Form2J::create($validated);
            }

            return redirect()->route('form2j.edit')->with('success', 'Form 2(J) saved successfully!');
            
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
        $form2j = Form2J::where('user_ID', $userId)->first() ?? new Form2J();

        return view('erb-reviewer.forms.form2j', compact('form2j')); 
    }
}