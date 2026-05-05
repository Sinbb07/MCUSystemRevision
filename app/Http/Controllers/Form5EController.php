<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form5E;
use Illuminate\Support\Facades\Auth;

class Form5EController extends Controller
{
    public function store(Request $request)
    {
        // Validate fields
        $request->validate([
            'protocol' => 'nullable|string|max:255',
            'pi_name' => 'required|string|max:255',
            'coiname' => 'required|string|max:255',
            'pi_contact' => 'required|string|max:20',
            'pi_email' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'institute_address' => 'required|string|max:255',
            'erb_contact' => 'required|string|max:255',

            'cover_letter' => 'nullable',
            'enrollment_proof' => 'nullable',
            'letter' => 'nullable',
            'complete_form2b' => 'nullable',
            'complete_form2a' => 'nullable',
            'complete_form2d' => 'nullable',
            
            'study_protocol' => 'nullable',
            'form2c_eng' => 'nullable',
            'form2c_fil' => 'nullable',
            'data_collection' => 'nullable',
            'cert_validator' => 'nullable',
            'eng_7_12_yrs' => 'nullable',
            'fil_7_12_yrs' => 'nullable',
            'eng_13_17_yrs' => 'nullable',
            'fil_13_17_yrs' => 'nullable',
            'advertisement' => 'nullable',
            'vitae' => 'nullable',
            'gcp' => 'nullable',
        ]);

        // Generate form5EID if new
        $lastId = Form5E::max('form5EID');
        if ($lastId) {
            $num = intval(substr($lastId, 3)) + 1;
            $form5EID = 'f5e' . str_pad($num, 6, '0', STR_PAD_LEFT);
        } else {
            $form5EID = 'f5e000001';
        }

        // Get user
        $user = Auth::user();
        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $fullName = "{$user->user_Fname} {$mi} {$user->user_Lname}";

        // Save or update draft
        Form5E::updateOrCreate(
            ['user_ID' => $user->user_ID],
            [
                'form5EID' => $form5EID,
                'protocol'  => $request->protocol,
                'pi_name'    => $fullName,
                'coiname' => $request->coiname,
                'pi_contact' => $request->pi_contact,
                'pi_email' => $request->pi_email,
                'institution' => $request->institution,
                'institute_address' => $request->institute_address,
                'erb_contact' => $request->erb_contact,

                // Basic Documents
                'cover_letter' => $request->has('cover_letter'),
                'enrollment_proof' => $request->has('enrollment_proof'),
                'letter' => $request->has('letter'),
                'complete_form2b' => $request->has('complete_form2b'),
                'complete_form2a' => $request->has('complete_form2a'),
                'complete_form2d' => $request->has('complete_form2d'),
                
                // Protocol Package
                'study_protocol' => $request->has('study_protocol'),
                'form2c_eng' => $request->has('form2c_eng'),
                'form2c_fil' => $request->has('form2c_fil'),
                'data_collection' => $request->has('data_collection'),
                'cert_validator' => $request->has('cert_validator'),
                'eng_7_12_yrs' => $request->has('eng_7_12_yrs'),
                'fil_7_12_yrs' => $request->has('fil_7_12_yrs'),
                'eng_13_17_yrs' => $request->has('eng_13_17_yrs'),
                'fil_13_17_yrs' => $request->has('fil_13_17_yrs'),
                'advertisement' => $request->has('advertisement'),
                'vitae' => $request->has('vitae'),
                'gcp' => $request->has('gcp'),
            ]
        );

        return redirect()->back()->with('success', 'Form 5(E) has been saved successfully!');
    }

    public function edit()
    {
        $user = auth()->user();

        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        $userId = $user->user_ID;

        // fetch draft if exists
        $form5e = Form5E::where('user_ID', $userId)->first();

        // fetch research info for this user
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form5e', compact('form5e', 'researchInfo', 'principalInvestigator'));
    }
}