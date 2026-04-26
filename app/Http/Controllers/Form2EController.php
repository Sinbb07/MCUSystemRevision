<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form2E;
use App\Models\Protocol;
use Illuminate\Support\Facades\Auth;

class Form2EController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $userId = $user->user_ID;

        // Validate the request data - REMOVED ALL RADIO BUTTON VALIDATIONS
        $validated = $request->validate([
            // Textarea fields
            'main_idea_summarize' => 'nullable|string|max:5000',
            'significance_discuss' => 'nullable|string|max:5000',
            'require_human_participants' => 'nullable|string|max:5000',
            'problem_statement_address' => 'nullable|string|max:5000',
            'adequate' => 'nullable|string|max:5000',
            'information_discuss' => 'nullable|string|max:5000',
            'population_define' => 'nullable|string|max:5000',
            'approx_size' => 'nullable|string|max:5000',
            'participants_manner' => 'nullable|string|max:5000',
            'site_identify' => 'nullable|string|max:5000',
            'appropriate_questions' => 'nullable|string|max:5000',
            'apply_characteristics' => 'nullable|string|max:5000',
            'characteristics_disqualify' => 'nullable|string|max:5000',
            'involvement' => 'nullable|string|max:5000',
            'vulnerability_evaluation' => 'nullable|string|max:5000',
            'indicate_measures' => 'nullable|string|max:5000',
            'describe_procedure' => 'nullable|string|max:5000',
            'overall_procedure_describe' => 'nullable|string|max:5000',
            'confidentiality_measures' => 'nullable|string|max:5000',
            'describe_maintain' => 'nullable|string|max:5000',
            'preserve_data' => 'nullable|string|max:5000',
            'disposition_records' => 'nullable|string|max:5000',
            'minimize_maximize' => 'nullable|string|max:5000',
            'estimated_date' => 'nullable|string|max:5000',
            'techniques_described' => 'nullable|string|max:5000',
            
            // Summary of Recommendations
            'summary_recommendation_1' => 'nullable|string|max:5000',
            'summary_recommendation_2' => 'nullable|string|max:5000',
            'summary_recommendation_3' => 'nullable|string|max:5000',
            'summary_recommendation_4' => 'nullable|string|max:5000',
            
            // Recommended Action
            'action' => 'nullable|string|in:Approve,Minor Modifications,Major Modifications,Disapprove,Pending if Major Clarifications are Required Before a Decision can be Made',
            
            // Justification
            'justification' => 'nullable|string|max:5000',
            
            'protocol_ID' => 'nullable|string|exists:tbl_protocol,protocol_ID',
        ]);

        try {
            $protocolId = $validated['protocol_ID'] ?? null;
            
            // Check if record already exists for this user and protocol
            $existingForm = Form2E::where('user_ID', $userId)
                ->where('protocol_ID', $protocolId)
                ->first();

            if ($existingForm) {
                // Update existing record
                $existingForm->update($validated);
                $message = 'Form 2(E) updated successfully!';
            } else {
                // Generate form2EID for new record
                $lastId = Form2E::max('form2EID');
                if ($lastId) {
                    $num = intval(substr($lastId, 3)) + 1;
                    $form2EID = 'f2e' . str_pad($num, 6, '0', STR_PAD_LEFT);
                } else {
                    $form2EID = 'f2e000001';
                }

                // Add user ID, protocol ID and form2EID to validated data
                $validated['user_ID'] = $userId;
                $validated['protocol_ID'] = $protocolId;
                $validated['form2EID'] = $form2EID;

                // Create new record
                Form2E::create($validated);
                $message = 'Form 2(E) saved successfully!';
            }

            // Redirect back to the form with the protocol ID
            if ($protocolId) {
                return redirect()->route('form2e.edit', ['protocol' => $protocolId])
                    ->with('success', $message);
            }
            
            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error saving form: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($protocol = null)
    {
        $user = auth()->user();
        $userId = $user->user_ID;

        // Get existing form or create new empty instance
        $form2e = Form2E::where('user_ID', $userId) 
            ->where('protocol_ID', $protocol)
            ->first();
            
        // If no existing form, create a new instance with default values
        if (!$form2e) {
            $form2e = new Form2E();
        }

        $protocol_data = null;
        $pi = null;
        
        if ($protocol) {
            $protocol_data = Protocol::with('user')->where('protocol_ID', $protocol)->first();
            if ($protocol_data) {
                $pi = $protocol_data->user;
            }
        }

        return view('erb-reviewer.forms.form2e', compact('form2e', 'protocol_data', 'pi')); 
    }
    
    // Optional: Add a method to view the form (read-only)
    public function show($protocol = null)
    {
        $user = auth()->user();
        $userId = $user->user_ID;

        $form2e = Form2E::where('user_ID', $userId)
            ->where('protocol_ID', $protocol)
            ->firstOrFail();

        $protocol_data = Protocol::with('user')->where('protocol_ID', $protocol)->first();
        $pi = $protocol_data?->user;

        return view('erb-reviewer.forms.form2e-show', compact('form2e', 'protocol_data', 'pi'));
    }
}