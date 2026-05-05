<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IacucProtocolReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IacucProtocolReviewController extends Controller
{
    public function store(Request $request)
    {
        // Validate fields
        $request->validate([
            'procedure_title_study' => 'nullable|string',
            'objectives' => 'nullable|string',
            'duration_timeframe' => 'nullable|string',
            'pi_name' => 'nullable|string',
            'qualification' => 'nullable|string',
            'significance' => 'nullable|string',
            'animal_species' => 'nullable|string',
            'animal_source' => 'nullable|string',
            'reason_basis' => 'nullable|string',
            'number_animals' => 'nullable|string',
            'conditioning_process' => 'nullable|string',
            'cage_type' => 'nullable|string',
            'number_cage' => 'nullable|string',
            'cleaning_method' => 'nullable|string',
            'room_temp' => 'nullable|string',
            'animal_diet' => 'nullable|string',
            'method_description' => 'nullable|string',
            'dosing_method' => 'nullable|string',
            'collection_method' => 'nullable|string',
            'exam_process' => 'nullable|string',
            'use_anesthetics' => 'nullable|string',
            'surgery_location' => 'nullable|string',
            'during_after' => 'nullable|string',
            'measure_description' => 'nullable|string',
            'name_qualification' => 'nullable|string',
            'select_method' => 'nullable|string',
            'non_animal_model' => 'nullable|string',
            'personnel_names' => 'nullable|string',
        ]);

        // Get existing form or generate new review_id
        $existingForm = IacucProtocolReview::where('reviewer_ID', Auth::user()->user_ID)->first();
        
        if ($existingForm) {
            $reviewId = $existingForm->review_id;
        } else {
            $reviewId = 'IACUC-REV-' . strtoupper(Str::random(8));
        }

        // Save or update
        IacucProtocolReview::updateOrCreate(
            ['reviewer_ID' => Auth::user()->user_ID],
            [
                'review_id' => $reviewId,
                'protocol_ID' => $request->protocol_id ?? 'PENDING-' . date('Ymd'),
                'reviewer_ID' => Auth::user()->user_ID,
                'study_title' => $request->procedure_title_study,
                'pi_person' => $request->pi_name,
                'adviser' => $request->adviser_name ?? null,
                'scientific_merit_comment' => $request->objectives,
                'training_experience_comment' => $request->qualification,
                'overview_section_comment' => $request->duration_timeframe,
                'rational_justification_comment' => $request->significance,
                'adequate_justification_comment' => $request->reason_basis,
                'unnecessary_duplication_comment' => $request->number_animals,
                'experimental_procedures_comment' => $request->method_description,
                'endpoint_duration_comment' => $request->conditioning_process,
                'euthanasia_method_comment' => $request->select_method,
                'pain_category_comment' => $request->cage_type,
                'alternative_housing_comment' => $request->cleaning_method,
                'hazardous_material_comment' => $request->room_temp,
                'multiple_survival_comment' => $request->animal_diet,
                'pain_relief_comment' => $request->dosing_method,
                'ill_debilitated_comment' => $request->collection_method,
                'complications_comment' => $request->exam_process,
                'veterinary_complications_comment' => $request->surgery_location,
                'proposed_anesthesia_comment' => $request->during_after,
                'post_procedural_comment' => $request->measure_description,
                'appropriate_method_comment' => $request->name_qualification,
                'summary_comments' => $request->non_animal_model,
                'personnel_names' => $request->personnel_names,
                // Add these missing fields
                'animal_species' => $request->animal_species,
                'animal_source' => $request->animal_source,
                'number_cage' => $request->number_cage,
                'use_anesthetics' => $request->use_anesthetics,
            ]
        );

        return redirect()->back()->with('success', 'Protocol Review Form saved successfully!');
    }

    public function edit()
    {
        $user = auth()->user();
        
        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        
        // Get research info
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $user->user_ID)->first();
        
        // Get protocol data for this user
        $protocol = \App\Models\Protocol::where('user_ID', $user->user_ID)->first();
        
        // Get existing form data if any
        $formData = IacucProtocolReview::where('reviewer_ID', $user->user_ID)->first();

        return view('student.forms.protocol-review', compact('researchInfo', 'formData', 'principalInvestigator', 'protocol'));
    }
}