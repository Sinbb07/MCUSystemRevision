<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Classification;

class SubmittedInquiries extends Controller
{
    /**
     * Display submitted inquiries based on admin type (ERB or IACUC)
     */
    public function index()
    {
        // Determine which classification to filter based on the route prefix
        $routePrefix = request()->route()->getPrefix();
        
        // If route contains 'iacuc', show IACUC classified PIs, otherwise show ERB
        if (str_contains($routePrefix, 'iacuc')) {
            $classificationType = 'IACUC';
        } else {
            $classificationType = 'ERB';
        }
        
        // Get all user IDs that are classified with the determined type
        $classifiedUserIds = Classification::where('reviewClassification', $classificationType)
            ->pluck('user_ID')
            ->toArray();

        if (empty($classifiedUserIds)) {
            $inquiries = collect();
        } else {
            $inquiries = Ticket::with(['user.researchInformation'])
                ->whereIn('User_ID', $classifiedUserIds)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($ticket) {
                    return [
                        'pi_name' => $ticket->user ? 
                            $ticket->user->user_Fname . ' ' . 
                            ($ticket->user->user_MI ? $ticket->user->user_MI . ' ' : '') . 
                            $ticket->user->user_Lname : 'Unknown',
                        'research_title' => $ticket->user && $ticket->user->researchInformation ? 
                            $ticket->user->researchInformation->research_title : 'N/A',
                        'subject' => $ticket->Ticket_Subject,
                        'date_submitted' => $ticket->created_at,
                        'ticket_id' => $ticket->Ticket_ID,
                    ];
                });
        }

        // Return appropriate view based on route
        if (str_contains($routePrefix, 'iacuc')) {
            return view('iacuc.submitted-tickets', compact('inquiries'));
        }
        
        return view('erb.submitted-tickets', compact('inquiries'));
    }

    /**
     * Display a specific ticket based on admin type (ERB or IACUC)
     */
    public function show($ticketId)
    {
        try {
            // Determine which classification to check based on the route prefix
            $routePrefix = request()->route()->getPrefix();
            
            if (str_contains($routePrefix, 'iacuc')) {
                $classificationType = 'IACUC';
                $errorMessage = 'You are not authorized to view this ticket. This user is not classified for IACUC review.';
                $viewPath = 'iacuc.tickets';
                $redirectRoute = 'iacuc.submitted-tickets';
            } else {
                $classificationType = 'ERB';
                $errorMessage = 'You are not authorized to view this ticket. This user is not classified for ERB review.';
                $viewPath = 'erb.tickets';
                $redirectRoute = 'erb.submitted-tickets';
            }
            
            // Get the ticket with user and research information
            $ticket = Ticket::with(['user.researchInformation'])
                ->where('Ticket_ID', $ticketId)
                ->firstOrFail();

            // Check if this ticket's user is classified correctly
            $classification = Classification::where('user_ID', $ticket->User_ID)
                ->where('reviewClassification', $classificationType)
                ->first();

            if (!$classification) {
                abort(403, $errorMessage);
            }

            // Pass the ticket to the view
            return view($viewPath, compact('ticket'));
            
        } catch (\Exception $e) {
            // If ticket not found or any other error, redirect back with error message
            $redirectRoute = str_contains(request()->route()->getPrefix(), 'iacuc') ? 'iacuc.submitted-tickets' : 'erb.submitted-tickets';
            return redirect()->route($redirectRoute)
                ->with('error', 'Ticket not found or you do not have permission to view it.');
        }
    }
}