<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form2J;
use App\Models\Protocol;
use Illuminate\Support\Facades\Auth;

class Form2JController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $userId = $user->user_ID;
        $protocolId = $request->input('protocol_ID');

        // Validate protocol_ID
        if (!$protocolId) {
            return redirect()->back()->with('error', 'Protocol ID is required.');
        }

        // Validate the request data
        $validated = $request->validate([
            'protocol_ID' => 'required|string',
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
            // Check if record already exists for this user and protocol
            $existingForm = Form2J::where('user_ID', $userId)
                ->where('protocol_ID', $protocolId)
                ->first();

            if ($existingForm) {
                // Update existing record
                $existingForm->update($validated);
            } else {
                // Generate form2JID for new record
                $lastId = Form2J::max('form2JID');
                if ($lastId) {
                    $num = intval(substr($lastId, 3)) + 1;
                    $form2JID = 'f2j' . str_pad($num, 6, '0', STR_PAD_LEFT);
                } else {
                    $form2JID = 'f2j000001';
                }

                // Add necessary IDs to validated data before creating
                $validated['user_ID'] = $userId;
                $validated['form2JID'] = $form2JID;
                $validated['protocol_ID'] = $protocolId; // <--- ADD THIS LINE

                // Create new record
                Form2J::create($validated);
            }

            return redirect()->route('form2j.edit', ['protocol' => $protocolId])->with('success', 'Form 2(J) saved successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error saving form: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($protocol)
    {
        $user = auth()->user();
        $userId = $user->user_ID;

        // Fetch protocol data
        $protocol_data = Protocol::where('protocol_ID', $protocol)->first();
        if (!$protocol_data) {
            abort(404, 'Protocol not found');
        }
        $pi = $protocol_data->user;

        // Fetch existing form data for this user and protocol
        $form2j = Form2J::where('user_ID', $userId)
            ->where('protocol_ID', $protocol)
            ->first();
        
        $form2j = $form2j ?? new Form2J();

        return view('erb-reviewer.forms.form2j', compact('form2j', 'protocol_data', 'pi')); 
    }
}