<?php

namespace App\Http\Controllers;

use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\Form2A;
use App\Models\Form2B;
use App\Models\Form2C;
use App\Models\Form2D;
use App\Models\Form5E;
use App\Models\Protocol;
use App\Models\User;
class PdfExportController extends Controller
{
    public function exportForm2A()
    {
        //sample code
        $user = auth()->user();

        $protocol = Form2A::where('user_ID', $user->user_ID)
            ->with('researchInfo') // if you need related info
            ->firstOrFail();

        //dito din palitan mo nalang din
        return Pdf::view('student.forms.form2aPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-2A.pdf');
    }
    public function exportForm2B()
    {
        //sample code
        $user = auth()->user();

        // Fetch the Form2B record for this user
        $protocol = Form2B::where('user_ID', $user->user_ID)
            ->with('researchInfo') // if you need related info
            ->firstOrFail();

        //dito din palitan mo nalang din
        return Pdf::view('student.forms.form2bPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-2B.pdf');
    }
    public function exportForm2C()
    {
        //sample code
        $user = auth()->user();

        // Fetch the Form2B record for this user
        $protocol = Form2C::where('user_ID', $user->user_ID)
            ->with('researchInfo') // if you need related info
            ->firstOrFail();

        //dito din palitan mo nalang din
        return Pdf::view('student.forms.form2cPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-2C.pdf');
    }

    public function exportForm2D()
    {
        //sample code
        $user = auth()->user();

        // Fetch the Form2B record for this user
        $protocol = Form2D::where('user_ID', $user->user_ID)
            ->with('researchInfo') // if you need related info
            ->firstOrFail();

        //dito din palitan mo nalang din
        return Pdf::view('student.forms.form2dPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-2D.pdf');
    }

    public function exportForm5E()
    {
        //sample code
        $user = auth()->user();

        // Fetch the Form2B record for this user
        $protocol = Form5E::where('user_ID', $user->user_ID)
            ->with('researchInfo') // if you need related info
            ->firstOrFail();

        //dito din palitan mo nalang din
        return Pdf::view('student.forms.form5ePdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-5E.pdf');
    }

    public function exportForm3C()
    {
        //sample code
        $protocol = (object)[
            
        ];

        //dito din palitan mo nalang din
        return Pdf::view('student.forms.form3cPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-3C.pdf');
    }

    public function exportForm3D()
    {
        //sample code
        $protocol = (object)[
            
        ];

        //dito din palitan mo nalang din
        return Pdf::view('student.forms.form3dPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-3D.pdf');
    }


    public function exportForm3L()
    {
        //sample code
        $protocol = (object)[
            
        ];

        //dito din palitan mo nalang din
        return Pdf::view('student.forms.form3lPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('FORM-3L.pdf');
    }

    public function exportProtocolReviewCheckList()
    {
        //sample code
        $protocol = (object)[
            
        ];

        //dito din palitan mo nalang din
        return Pdf::view('iacuc-reviewer.forms.protocol-review-checklistPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('IACUC-Protocol-Review-Checklist.pdf');
    }

    public function exportProtocolReview()
    {
        //sample code
        $protocol = (object)[
            
        ];

        //dito din palitan mo nalang din
        return Pdf::view('iacuc-reviewer.forms.protocol-reviewPdf', compact('protocol'))
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->inline('IACUC-Protocol-Review-Form.pdf');
    }

    public function exportForm2I($protocolId = null)
    {
        if ($protocolId) {
            // Get protocol with relationships
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

        // Fallback if no protocol ID
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
}
