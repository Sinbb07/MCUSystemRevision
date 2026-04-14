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

            'cover_letter' => 'nullable|boolean',
            'enrollment_proof' => 'nullable|boolean',
            'letter' => 'nullable|boolean',
            'complete_form2b' => 'nullable|boolean',
            'complete_form2a' => 'nullable|boolean',
            'complete_form2d' => 'nullable|boolean',
            
            // Protocol Package
            'study_protocol' => 'nullable|boolean',
            'form2c_eng' => 'nullable|boolean',
            'form2c_fil' => 'nullable|boolean',
            'data_collection' => 'nullable|boolean',
            'cert_validator' => 'nullable|boolean',
            'eng_7_12_yrs' => 'nullable|boolean',
            'fil_7_12_yrs' => 'nullable|boolean',
            'eng_13_17_yrs' => 'nullable|boolean',
            'fil_13_17_yrs' => 'nullable|boolean',
            'advertisement' => 'nullable|boolean',
            'vitae' => 'nullable|boolean',
            'gcp' => 'nullable|boolean',
        ]);

        // Generate form2CID if new
        $lastId = Form5E::max('form5EID');
        if ($lastId) {
            $num = intval(substr($lastId, 3)) + 1;
            $form5EID = 'f5e' . str_pad($num, 6, '0', STR_PAD_LEFT);
        } else {
            $form5EID = 'f5e000001';
        }

        // Save or update draft
        Form5E::updateOrCreate(
            ['user_ID' => Auth::user()->user_ID],
            [
                'form5EID' => $form5EID,
                'protocol'  => $request->protocol,
                'pi_name'    => auth()->user()->full_name,
                'coiname' => $request->coiname,
                'pi_contact' => $request->pi_contact,
                'pi_email' => $request->pi_email,
                'institution' => $request->institution,
                'institute_address' => $request->institute_address,
                'erb_contact' => $request->erb_contact,

                // Basic Documents
                'cover_letter' => $request->boolean('cover_letter'),
                'enrollment_proof' => $request->boolean('enrollment_proof'),
                'letter' => $request->boolean('letter'),
                'complete_form2b' => $request->boolean('complete_form2b'),
                'complete_form2a' => $request->boolean('complete_form2a'),
                'complete_form2d' => $request->boolean('complete_form2d'),
                
                // Protocol Package
                'study_protocol' => $request->boolean('study_protocol'),
                'form2c_eng' => $request->boolean('form2c_eng'),
                'form2c_fil' => $request->boolean('form2c_fil'),
                'data_collection' => $request->boolean('data_collection'),
                'cert_validator' => $request->boolean('cert_validator'),
                'eng_7_12_yrs' => $request->boolean('eng_7_12_yrs'),
                'fil_7_12_yrs' => $request->boolean('fil_7_12_yrs'),
                'eng_13_17_yrs' => $request->boolean('eng_13_17_yrs'),
                'fil_13_17_yrs' => $request->boolean('fil_13_17_yrs'),
                'advertisement' => $request->boolean('advertisement'),
                'vitae' => $request->boolean('vitae'),
                'gcp' => $request->boolean('gcp'),
            ]
        );

        return redirect()->back()->with('success', 'Your draft has been saved!');
    }

    public function edit()
    {
        $user = auth()->user();

        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        $userEmail = $user->user_Email;
        $userId = $user->user_ID;

        // fetch draft if exists (safe null-checks to avoid errors)
        $form5e = Form5E::where('user_ID', $userId)->first();

        // fetch research info for this user
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form5e', compact('form5e', 'researchInfo','principalInvestigator'));
    }
}
