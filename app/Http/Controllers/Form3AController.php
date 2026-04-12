<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form3A;
use Illuminate\Support\Facades\Auth;

class Form3AController extends Controller
{
    public function store(Request $request)
    {
        // Validate fields
        $request->validate([
            'protocol' => 'required|string|max:255',
            'version_no' => 'required|string|max:255',
            'study_site' => 'required|string|max:255',
            'pi_name' => 'required|string|max:255',
            'coi_name' => 'nullable|string|max:255',
            'tel_no' => 'nullable|string|max:20',
            'contact_no' => 'required|string|max:20',
            'pi_email' => 'required|email|max:255',
            'investigator_institution' => 'required|string|max:255',
            'institution_address' => 'required|string|max:255',
            'recommendations' => 'required|string',
            'research_response' => 'required|string',
            'section_page_number' => 'required|string',
        ]);

        // Generate form2CID if new
        $lastId = Form3A::max('form3AID');
        if ($lastId) {
            $num = intval(substr($lastId, 3)) + 1;
            $form3AID = 'f3a' . str_pad($num, 6, '0', STR_PAD_LEFT);
        } else {
            $form3AID = 'f3a000001';
        }

        // Save or update draft
        Form3A::updateOrCreate(
            ['user_ID' => Auth::user()->user_ID],
            [
                'form3AID' => $form3AID,
                'protocol' => $request->protocol,
                'version_no' => $request->version_no,
                'study_site' => $request->study_site,
                'pi_name' => $request->pi_name,
                'coi_name' => $request->coi_name,
                'tel_no' => $request->tel_no,
                'contact_no' => $request->contact_no,
                'pi_email' => $request->pi_email,
                'investigator_institution' => $request->investigator_institution,
                'institution_address' => $request->institution_address,
                'recommendations' => $request->recommendations,
                'research_response' => $request->research_response,
                'section_page_number' => $request->section_page_number,
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
        $form3a = Form3A::where('user_ID', $userId)->first();

        // fetch research info for this user
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $userId)->first();

        return view('student.forms.form3a', compact('form3a', 'researchInfo','principalInvestigator'));
    }
}
