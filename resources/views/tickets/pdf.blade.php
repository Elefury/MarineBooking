<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Билет {{ $ticket->ticket_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .ticket { width: 100%; max-width: 600px; margin: 0 auto; border: 2px solid #333; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .qr-code { text-align: center; margin: 20px 0; }
        .details { margin-bottom: 20px; }
        .footer { text-align: center; font-size: 12px; margin-top: 20px; color: #666; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>Посадочный билет</h1>
            <p>#{{ $ticket->ticket_number }}</p>
            <p>Статус: {{ strtoupper($ticket->status) }}</p>
        </div>
        
        <div class="qr-code">
            {!! $ticket->qr_code !!}
        </div>
        
        <div class="details">
            @if($type === 'cruise')
                @isset($ticket->bookable->cruiseLine)
                    <h2>Круиз: {{ $ticket->bookable->cruiseLine->name }}</h2>
                    <p>Время отправления: {{ $ticket->bookable->cruiseLine->departure_time->format('d M Y H:i') }}</p>
                @endisset

            @else
                
                @isset($ticket->bookable->voyage)
                    <h2>Рейс #{{ $ticket->bookable->voyage->voyage_number }}</h2>
                    @isset($ticket->bookable->voyage->departurePort, $ticket->bookable->voyage->arrivalPort)
                        <p>Направление: {{ $ticket->bookable->voyage->departurePort->name }} → 
                           {{ $ticket->bookable->voyage->arrivalPort->name }}</p>
                    @endisset
                @endisset
            @endif
        </div>
        
        <div class="footer">
            <p>Спасибо за использование нашего сервиса!</p>
            <p>Покажите данный билет при посадке на судно</p>
        </div>
    </div>
</body>
</html>