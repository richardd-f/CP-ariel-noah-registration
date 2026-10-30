Confirm your registration

Hello {!! $ticket['nickname'] !!},

We received your registration for {!! $ticket['concert']['title'] !!}. It is awaiting email confirmation.

Confirm my Registration: {!! $confirmationUrl !!}

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

View your registration: {!! $ticket['view_url'] !!}
Download your printable ticket: {!! $ticket['download_url'] !!}

Your registration stays pending until you click Confirm my Registration. Keep this email private.
Your email address is used to send this confirmation and is not saved with your registration.
