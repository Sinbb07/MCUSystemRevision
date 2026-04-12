<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form3D;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Form3DController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate fields - remove boolean validation for confirmation_all_changes
            $request->validate([
                'add_remove' => 'nullable|string',
                'add_methods' => 'nullable|string',
                'additional_data' => 'nullable|string',
                'remove_participants' => 'nullable|string',
                'minor_changes' => 'nullable|string',
                'extension' => 'nullable|string',
                'other_documents' => 'nullable|string',
                'thesisadviser' => 'nullable|string',
                'notedby' => 'nullable|string',
                'coordinator' => 'nullable|string',
            ]);

            $userId = Auth::user()->user_ID;
            
            // Debug: Check if user is authenticated
            if (!$userId) {
                return redirect()->back()->with('error', 'User not authenticated');
            }

            // Check if form already exists
            $existingForm = Form3D::where('user_ID', $userId)->first();

            $formData = [
                'add_remove' => $request->add_remove,
                'add_methods' => $request->add_methods,
                'additional_data' => $request->additional_data,
                'remove_participants' => $request->remove_participants,
                'minor_changes' => $request->minor_changes,
                'extension' => $request->extension,
                'confirmation_all_changes' => $request->has('confirmation_all_changes'), // This handles the checkbox properly
                'other_documents' => $request->other_documents,
                'thesisadviser' => $request->thesisadviser,
                'notedby' => $request->notedby,
                'coordinator' => $request->coordinator,
            ];

            if ($existingForm) {
                // Update existing form
                $existingForm->update($formData);
                $message = 'Form updated successfully!';
            } else {
                // Generate new form3DID
                $lastId = Form3D::max('form3DID');
                if ($lastId) {
                    $num = intval(substr($lastId, 3)) + 1;
                    $form3DID = 'f3d' . str_pad($num, 6, '0', STR_PAD_LEFT);
                } else {
                    $form3DID = 'f3d000001';
                }

                // Create new form
                Form3D::create(array_merge([
                    'form3DID' => $form3DID,
                    'user_ID' => $userId,
                ], $formData));
                $message = 'Form saved successfully!';
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Form3D Save Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error saving form: ' . $e->getMessage());
        }
    }

    public function edit()
    {
        $user = auth()->user();

        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        $userEmail = $user->user_Email;
        $userId = $user->user_ID;

        // fetch draft if exists (safe null-checks to avoid errors)
        $form3d = Form3D::where('user_ID', $userId)->first();

        // fetch research info for this user
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form3d', compact('form3d', 'researchInfo','principalInvestigator','userEmail'));
    }
}