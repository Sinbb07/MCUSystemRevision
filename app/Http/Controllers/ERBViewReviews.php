<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EvaluatedReviews;
use App\Models\User;
use App\Models\ReviewerFile;
use App\Models\ResearchInformation;
use App\Models\FormsTable;
use App\Models\InitialReview;
use App\Models\Protocol;
class ERBViewReviews extends Controller
{
    public function index()
    {
        // Fetch all evaluated reviews with related protocol, reviewer, and PI info
        // Filter only ERB protocols (protocols starting with 'ERB-')
        $evaluatedReviews = EvaluatedReviews::with([
            'reviewer',
            'protocol.researchInformation.user',
        ])
        ->whereHas('protocol', function($query) {
            $query->where('protocol_ID', 'like', 'ERB-%');
        })
        ->get();

        return view('erb.view-reviews', compact('evaluatedReviews'));
    }

    public function showFiles($protocolId, $reviewerId)
    {
        // Verify the protocol is ERB before showing files
        $protocol = Protocol::where('protocol_ID', $protocolId)
            ->where('protocol_ID', 'like', 'ERB-%')
            ->firstOrFail();

        $files = ReviewerFile::where('protocol_ID', $protocolId)
            ->where('reviewer_ID', $reviewerId)
            ->get();

        $reviewer = User::where('user_ID', $reviewerId)->first();

        return view('erb.viewing-file', compact('files', 'reviewer'));
    }
    
    public function iacucIndex()
    {
        // Fetch all evaluated reviews with related protocol, reviewer, and PI info
        // Filter only IACUC protocols (protocols starting with 'IACUC-')
        $evaluatedReviews = EvaluatedReviews::with([
            'reviewer',
            'protocol.researchInformation.user',
        ])
        ->whereHas('protocol', function($query) {
            $query->where('protocol_ID', 'like', 'IACUC-%');
        })
        ->get();

        return view('iacuc.view-reviews', compact('evaluatedReviews'));
    }

    public function iacucShowFiles($protocolId, $reviewerId)
    {
        // Verify the protocol is IACUC before showing files
        $protocol = Protocol::where('protocol_ID', $protocolId)
            ->where('protocol_ID', 'like', 'IACUC-%')
            ->firstOrFail();

        $files = ReviewerFile::where('protocol_ID', $protocolId)
            ->where('reviewer_ID', $reviewerId)
            ->get();

        $reviewer = User::where('user_ID', $reviewerId)->first();

        return view('iacuc.viewing-file', compact('files', 'reviewer'));
    }
}
