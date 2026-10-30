You're in.

Hello {!! $ticket['nickname'] !!},

Your reservation for {!! $ticket['concert']['title'] !!} is confirmed.

Ticket ID: {!! $ticket['ticket_id'] !!}
Date: {!! $ticket['concert']['date_formatted'] !!}
Doors open: {!! $ticket['concert']['doors_open'] !!}
Show time: {!! $ticket['concert']['show_time'] !!}
Venue: {!! $ticket['concert']['venue'] !!}
Gate: {!! $ticket['concert']['gate_code'] !!}

Your registration details
Keep this email as a record of the information you submitted.

@foreach ($registrationRows as $label => $value)
{!! $label !!}: {!! $value !!}
@endforeach

View your ticket: {!! $ticket['view_url'] !!}
Download your printable ticket: {!! $ticket['download_url'] !!}

Keep your ticket ID safe and bring your ticket or QR pass for entry.
Your email address is used to send this confirmation and is not saved with your registration.
