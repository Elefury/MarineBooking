<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\TicketService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;



class TicketController extends Controller
{
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        
        if ($ticket->bookable instanceof \App\Models\Booking) {
            $ticket->bookable->load('cruiseLine');
        } elseif ($ticket->bookable instanceof \App\Models\VoyageBooking) {
            $ticket->bookable->load(['voyage.departurePort', 'voyage.arrivalPort']);
        }

        return view('tickets.show', [
            'ticket' => $ticket,
            'vessel' => $ticket->bookable->cruiseLine->vessel ?? null
        ]);
    }

    

    public function download(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
    
        $ticket->load('bookable.user');
        
        if ($ticket->bookable_type === \App\Models\Booking::class) {
            $ticket->load(['bookable.cruiseLine']);
        } elseif ($ticket->bookable_type === \App\Models\VoyageBooking::class) {
            $ticket->load(['bookable.voyage.departurePort', 'bookable.voyage.arrivalPort']);
        }

        $type = $ticket->bookable_type === \App\Models\Booking::class ? 'cruise' : 'voyage';
        
        $pdf = PDF::loadView('tickets.pdf', [
            'ticket' => $ticket,
            'type' => $type
        ]);

        return $pdf->download("ticket-{$ticket->ticket_number}.pdf");
    }

    public function verify(string $ticketNumber)
    {
        $ticket = Ticket::where('ticket_number', $ticketNumber)->firstOrFail();
        
        if ($ticket->status === 'issued') {
            $ticket->update([
                'status' => 'checked',
                'checked_in_at' => now()
            ]);
        }
        
        return response()->json([
            'valid' => true,
            'ticket' => $ticket->load('bookable')
        ]);
    }
    
    public function checkIn(Ticket $ticket)
    {
        if ($ticket->status !== 'used') {
            $ticket->update([
                'status' => 'used',
                'checked_in_at' => now()
            ]);
            
            return back()->with('success', 'Ticket checked in successfully');
        }
        
        return back()->with('error', 'Ticket already used');
    }

    public function verifyForm()
    {
        return view('tickets.verify');
    }

    public function verifyCheck(Request $request)
    {
        $ticket = Ticket::where('ticket_number', $request->ticket_number)->first();
        
        if (!$ticket) {
            return back()->with('error', 'Ticket not found');
        }
        
        if ($ticket->status === 'used') {
            return back()->with('error', 'Ticket already used');
        }
        
        $ticket->update([
            'status' => 'used',
            'checked_in_at' => now()
        ]);
        
        return view('tickets.verify-result', compact('ticket'));
    }

    public function view(User $user, Ticket $ticket)
    {
        if ($ticket->bookable_type === \App\Models\VoyageBooking::class) {
            return $user->id === $ticket->bookable->user_id;
        }
        
        return $user->id === $ticket->bookable->user_id;
    }
}
