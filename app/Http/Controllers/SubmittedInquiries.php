<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;

class SubmittedInquiries extends Controller
{
    public function index()
    {
        // Get all tickets with PI information
        $inquiries = Ticket::with(['user.researchInformation'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($ticket) {
                return [
                    'pi_name' => $ticket->user ? 
                        $ticket->user->user_Fname . ' ' . $ticket->user->user_Lname : 'Unknown',
                    'research_title' => $ticket->user && $ticket->user->researchInformation ? 
                        $ticket->user->researchInformation->research_title : 'N/A',
                    'subject' => $ticket->Ticket_Subject,
                    'date_submitted' => $ticket->created_at,
                    'ticket_id' => $ticket->Ticket_ID,
                ];
            });

        return view('erb.submitted-tickets', compact('inquiries'));
    }

    public function show($ticketId)
    {
        // Get the specific ticket with user and research information
        $ticket = Ticket::with(['user.researchInformation'])
            ->where('Ticket_ID', $ticketId)
            ->firstOrFail();

        return view('erb.tickets', compact('ticket'));
    }
}
