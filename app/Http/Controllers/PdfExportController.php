<?php

namespace App\Http\Controllers;

use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\Form2A;
use App\Models\Form2B;
use App\Models\Form2C;
use App\Models\Form2D;
use App\Models\Form2E;
use App\Models\Form2J;
use App\Models\Form5E;
use App\Models\Form3A;
use App\Models\Form3B;
use App\Models\Form3C;
use App\Models\Form3D;
use App\Models\Form3E;
use App\Models\Form3L;
use App\Models\Protocol;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PdfExportController extends Controller
{
    public function exportForm2A()
    {
        $user = auth()->user();

        $protocol = Form2A::where('user_ID', $user->user_ID)
            ->with('researchInfo')
            ->firstOrFail();

        return Pdf::view('student.forms.form2aPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-2A.pdf');
    }

    public function exportForm2B()
    {
        $user = auth()->user();

        $protocol = Form2B::where('user_ID', $user->user_ID)
            ->with('researchInfo')
            ->firstOrFail();

        return Pdf::view('student.forms.form2bPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-2B.pdf');
    }

    public function exportForm2C()
    {
        $user = auth()->user();

        $protocol = Form2C::where('user_ID', $user->user_ID)
            ->with('researchInfo')
            ->firstOrFail();

        return Pdf::view('student.forms.form2cPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-2C.pdf');
    }

    public function exportForm2D()
    {
        $user = auth()->user();

        // Get form2d data from database
        $form2d = Form2D::where('user_ID', $user->user_ID)
            ->with('researchInfo')
            ->first();

        if (!$form2d) {
            abort(404, 'No form data found. Please save the form first.');
        }

        // Get research info
        $researchInfo = $form2d->researchInfo;
        
        // Get PI name
        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        
        // Get co-investigator
        $coInvestigator = $researchInfo->research_CoInvestigator ?? 'N/A';
        
        // Get contact info
        $piContact = $researchInfo->research_Contact ?? '09XX-XXX-XX74';
        $piEmail = $user->user_Email ?? 'N/A';
        
        // Set dates
        $submissionDate = now()->format('Y-m-d');
        $reviewDate = now()->format('Y-m-d');
        $mcuerbCode = '2025-S1-001';

        return Pdf::view('student.forms.form2dPdf', compact(
            'form2d', 
            'researchInfo', 
            'principalInvestigator', 
            'coInvestigator',
            'piContact',
            'piEmail',
            'submissionDate',
            'reviewDate',
            'mcuerbCode'
        ))
        ->format('Letter')
        ->margins(15, 15, 15, 15)
        ->inline('FORM-2D.pdf');
    }

    public function exportForm2E(Request $request, $protocolId = null)
    {
        \Log::info('exportForm2E called with protocolId: ' . $protocolId);
        
        $user = auth()->user();
        \Log::info('Current user: ' . $user->user_ID);
        
        // If protocol ID is provided in URL, use it
        if ($protocolId) {
            $form2e = Form2E::where('protocol_ID', $protocolId)->first();
            \Log::info('Searching by protocol_ID: ' . $protocolId);
        } else {
            // Get the form2e data for the current reviewer
            $form2e = Form2E::where('user_ID', $user->user_ID)->first();
            \Log::info('Searching by user_ID: ' . $user->user_ID);
        }
        
        \Log::info('Form2E found: ' . ($form2e ? 'Yes' : 'No'));
        
        if ($form2e) {
            \Log::info('Form2E protocol_ID: ' . $form2e->protocol_ID);
            \Log::info('Form2E data: ' . json_encode($form2e->toArray()));
        }
        
        if (!$form2e) {
            // Log all form2e records for debugging
            $allForms = Form2E::all();
            \Log::info('Total Form2E records in database: ' . $allForms->count());
            foreach ($allForms as $form) {
                \Log::info('Form2E record - ID: ' . $form->form2EID . ', Protocol: ' . $form->protocol_ID . ', User: ' . $form->user_ID);
            }
            abort(404, 'Form 2E not found for this protocol');
        }
        
        // Get protocol data
        $protocol_data = Protocol::where('protocol_ID', $form2e->protocol_ID)->first();
        \Log::info('Protocol found: ' . ($protocol_data ? 'Yes' : 'No'));
        
        // Get PI information
        $pi = User::where('user_ID', $protocol_data?->user_ID)->first();
        if ($pi) {
            $pi->full_name = $pi->user_Fname . ' ' . ($pi->user_MI ? $pi->user_MI . ' ' : '') . $pi->user_Lname;
            $pi->phone_number = $pi->user_Phone ?? 'N/A';
            $pi->email = $pi->user_Email ?? 'N/A';
        }
        
        // Get co-investigator from research information
        $coInvestigator = $protocol_data?->researchInformation?->research_CoInvestigator ?? 'N/A';
        
        $data = [
            'form2e' => $form2e,
            'protocol_data' => $protocol_data,
            'protocol' => $protocol_data,
            'pi' => $pi,
            'co_investigator' => $coInvestigator,
            'reviewer' => $user
        ];
        
        \Log::info('Data passed to view: ' . json_encode(array_keys($data)));
        
        $filename = "FORM-2E-{$form2e->protocol_ID}.pdf";
        
        return Pdf::view('erb-reviewer.forms.form2ePdf', $data)
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline($filename);
    }

    public function exportForm2J(Request $request, $protocolId = null)
    {
        $user = auth()->user();
        
        // If protocol ID is provided in URL, use it
        if ($protocolId) {
            $form2j = Form2J::where('protocol_ID', $protocolId)->first();
        } else {
            // Get the form2j data for the current reviewer
            $form2j = Form2J::where('user_ID', $user->user_ID)->first();
        }
        
        if (!$form2j) {
            abort(404, 'Form 2J not found for this protocol');
        }
        
        // Get protocol data
        $protocol_data = Protocol::where('protocol_ID', $form2j->protocol_ID)->first();
        
        // Get PI information
        $pi = User::where('user_ID', $protocol_data?->user_ID)->first();
        if ($pi) {
            $pi->full_name = $pi->user_Fname . ' ' . ($pi->user_MI ? $pi->user_MI . ' ' : '') . $pi->user_Lname;
            $pi->phone_number = $pi->user_Phone ?? 'N/A';
            $pi->email = $pi->user_Email ?? 'N/A';
        }
        
        // Get co-investigator from research information
        $coInvestigator = $protocol_data?->researchInformation?->research_CoInvestigator ?? 'N/A';
        
        $data = [
            'form2j' => $form2j,
            'protocol_data' => $protocol_data,
            'protocol' => $protocol_data,
            'pi' => $pi,
            'co_investigator' => $coInvestigator,
            'reviewer' => $user
        ];
        
        $filename = "FORM-2J-{$form2j->protocol_ID}.pdf";
        
        return Pdf::view('erb-reviewer.forms.form2jPdf', $data)
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline($filename);
    }

    public function exportForm5E()
    {
        $user = auth()->user();

        // Get form5e data from database
        $form5e = Form5E::where('user_ID', $user->user_ID)
            ->with('researchInfo')
            ->first();

        if (!$form5e) {
            abort(404, 'No form data found. Please save the form first.');
        }

        // Get research info
        $researchInfo = $form5e->researchInfo;
        
        // Get PI name
        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        
        // Get co-investigator
        $coInvestigator = $researchInfo->research_CoInvestigator ?? 'N/A';
        
        // Set mcuerb code
        $mcuerbCode = '2025-S1-001';

        return Pdf::view('student.forms.form5ePdf', compact('form5e', 'researchInfo', 'principalInvestigator', 'coInvestigator', 'mcuerbCode'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-5E.pdf');
    }

    public function exportForm3C()
    {
        $user = auth()->user();

        // Get form3c data from database
        $form3c = Form3C::where('user_ID', $user->user_ID)->first();

        if (!$form3c) {
            abort(404, 'No form data found. Please save the form first.');
        }

        // Get PI name
        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        
        // Set mcuerb code
        $mcuerbCode = '2025-S1-001';

        return Pdf::view('student.forms.form3cPdf', compact('form3c', 'principalInvestigator', 'mcuerbCode'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-3C.pdf');
    }

    public function exportProtocolReviewChecklist(Request $request, $protocolId = null)
    {
        $user = auth()->user();
        
        // If protocol ID is not in URL, get it from query parameter
        if (!$protocolId) {
            $protocolId = $request->query('protocol');
        }
        
        if (!$protocolId) {
            abort(404, 'Protocol ID is required');
        }
        
        // Get the form data for the current reviewer and protocol
        $form = \App\Models\IacucProtocolReview::where('reviewer_ID', $user->user_ID)
            ->where('protocol_ID', $protocolId)
            ->first();
        
        if (!$form) {
            // Create empty form structure if not found
            $form = new \App\Models\IacucProtocolReview();
            $form->protocol_ID = $protocolId;
            $form->reviewer_ID = $user->user_ID;
        }
        
        // Get protocol data
        $protocol_data = \App\Models\Protocol::where('protocol_ID', $protocolId)->first();
        
        // Get PI information
        $pi = null;
        if ($protocol_data && $protocol_data->user_ID) {
            $pi = \App\Models\User::where('user_ID', $protocol_data->user_ID)->first();
            if ($pi) {
                $pi->full_name = $pi->user_Fname . ' ' . ($pi->user_MI ? $pi->user_MI . ' ' : '') . $pi->user_Lname;
            }
        }
        
        $data = [
            'form' => $form,
            'protocol_data' => $protocol_data,
            'pi' => $pi,
            'reviewer' => $user
        ];
        
        return Pdf::view('iacuc-reviewer.forms.protocol-review-checklistPdf', $data)
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline("IACUC-Protocol-Review-Checklist-{$protocolId}.pdf");
    }

    public function exportProtocolReview()
    {
        $user = auth()->user();

        // Get form data from database
        $formData = \App\Models\IacucProtocolReview::where('reviewer_ID', $user->user_ID)->first();

        if (!$formData) {
            abort(404, 'No form data found. Please save the form first.');
        }

        // Get research info
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $user->user_ID)->first();
        
        // Get protocol data for this user
        $protocol = \App\Models\Protocol::where('user_ID', $user->user_ID)->first();
        
        // Get PI name
        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";

        return Pdf::view('student.forms.protocol-reviewPdf', compact('formData', 'researchInfo', 'principalInvestigator', 'protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('IACUC-PROTOCOL-REVIEW-FORM.pdf');
    }

    public function exportForm2I($protocolId = null)
    {
        if ($protocolId) {
            $protocol = Protocol::with('user', 'user.researchInformation')->where('protocol_ID', $protocolId)->first();
            
            if (!$protocol) {
                abort(404, 'Protocol not found');
            }

            $data = [
                'date' => now()->format('F d, Y'),
                'protocol' => $protocol,
                'pi' => $protocol->user,
                'research' => $protocol->user->researchInformation,
            ];

            return Pdf::view('erb.forms.form2iPdf', $data)
                ->format('Letter')
                ->margins(15, 15, 15, 15)
                ->download("Exempted_Certificate_{$protocolId}.pdf");
        }

        $protocol = (object)[
            'protocol_ID' => 'ERB-' . date('Y') . '-001',
            'user' => (object)[
                'user_Fname' => 'John',
                'user_MI' => 'D',
                'user_Lname' => 'Doe',
                'user_College' => 'College of Medicine',
                'user_Address' => 'Manila, Philippines'
            ],
            'researchInformation' => (object)[
                'research_title' => 'Sample Research Study'
            ]
        ];

        $data = [
            'date' => now()->format('F d, Y'),
            'protocol' => $protocol,
            'pi' => $protocol->user,
            'research' => $protocol->researchInformation,
        ];

        return Pdf::view('erb.forms.form2iPdf', $data)
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->download('Form-2I.pdf');
    }
    
    public function exportForm3L()
    {
        $user = auth()->user();

        // Get form3l data from database
        $form3l = Form3L::where('user_ID', $user->user_ID)->first();

        if (!$form3l) {
            abort(404, 'No form data found. Please save the form first.');
        }

        // Get research info
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $user->user_ID)->first();
        
        // Get PI name
        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        
        // Set mcuerb code
        $mcuerbCode = '2025-S1-001';

        return Pdf::view('student.forms.form3lPdf', compact('form3l', 'researchInfo', 'principalInvestigator', 'mcuerbCode'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-3L.pdf');
    }

    public function exportForm3A()
    {
        $user = auth()->user();

        // Get form3a data from database
        $form3a = Form3A::where('user_ID', $user->user_ID)->first();

        if (!$form3a) {
            abort(404, 'No form data found. Please save the form first.');
        }

        // Get research info
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $user->user_ID)->first();
        
        // Get PI name
        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        
        // Set mcuerb code
        $mcuerbCode = '2025-S1-001';

        return Pdf::view('student.forms.form3aPdf', compact('form3a', 'researchInfo', 'principalInvestigator', 'mcuerbCode'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-3A.pdf');
    }
    
    public function exportForm3E()
    {
        $user = auth()->user();

        // Get form3e data from database
        $form3e = Form3E::where('user_ID', $user->user_ID)->first();

        if (!$form3e) {
            abort(404, 'No form data found. Please save the form first.');
        }

        // Get research info
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $user->user_ID)->first();
        
        // Get PI name
        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        
        // Set mcuerb code
        $mcuerbCode = '2025-S1-001';

        return Pdf::view('student.forms.form3ePdf', compact('form3e', 'researchInfo', 'principalInvestigator', 'mcuerbCode'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-3E.pdf');
    }

    public function exportForm3B()
    {
        $user = auth()->user();

        $form3b = Form3B::where('user_ID', $user->user_ID)->first();

        if (!$form3b) {
            abort(404, 'No form data found. Please save the form first.');
        }

        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $user->user_ID)->first();
        
        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        
        $mcuerbCode = '2025-S1-001';

        return Pdf::view('student.forms.form3bPdf', compact('form3b', 'researchInfo', 'principalInvestigator', 'mcuerbCode'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-3B.pdf');
    }

    public function exportForm3D()
    {
        $user = auth()->user();

        // Get form3d data from database
        $form3d = Form3D::where('user_ID', $user->user_ID)->first();

        if (!$form3d) {
            abort(404, 'No form data found. Please save the form first.');
        }

        // Get research info
        $researchInfo = \App\Models\ResearchInformation::where('user_ID', $user->user_ID)->first();
        
        // Get PI name
        $mi = $user->user_MI ? "{$user->user_MI}." : '';
        $principalInvestigator = "{$user->user_Fname} {$mi} {$user->user_Lname}";
        
        // Get user email
        $userEmail = $user->user_Email;
        
        // Set mcuerb code
        $mcuerbCode = '2025-S1-001';

        return Pdf::view('student.forms.form3dPdf', compact('form3d', 'researchInfo', 'principalInvestigator', 'userEmail', 'mcuerbCode'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-3D.pdf');
    }
}