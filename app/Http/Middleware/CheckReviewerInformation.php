<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\ReviewerInformation;

class CheckReviewerInformation
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user) {
            // CRITICAL: Bypass check if the user is already on the setup page
            // This prevents the infinite redirect loop
            if ($request->routeIs('*.college-dept*')) {
                return $next($request);
            }

            // Check for IACUC Reviewers
            if ($user->user_Access === 'IACUC Reviewer') {
                $exists = ReviewerInformation::where('user_ID', $user->user_ID)->exists();
                if (!$exists) {
                    return redirect()->route('iacuc-reviewer.college-dept');
                }
            } 
            
            // Check for ERB Reviewers
            elseif ($user->user_Access === 'ERB Reviewer') {
                $exists = \DB::table('tbl_reviewer_information')
                            ->where('user_ID', $user->user_ID)
                            ->exists();
                if (!$exists) {
                    return redirect()->route('erb-reviewer.college-dept');
                }
            }
        }

        return $next($request);
    }
}