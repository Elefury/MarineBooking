<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Ticket;
use Illuminate\Support\Str;

class TicketService
{
    public function generateTicket($bookable)
    {
        $ticketNumber = Ticket::generateTicketNumber();
        
        $qrCode = QrCode::size(200)
            ->generate(route('tickets.verify', $ticketNumber));
            
        return $bookable->ticket()->create([
            'ticket_number' => $ticketNumber,
            'qr_code' => $qrCode,
            'status' => 'issued'
        ]);
    }
    
    public function generatePdf(Ticket $ticket)
    {
 
    }
}