<x-mail::message>
# Registration confirmed

Hello {{ $ticket['nickname'] }},

Your reservation for **{{ $ticket['concert']['title'] }}** is confirmed.

**Ticket ID:** {{ $ticket['ticket_id'] }}

**Date:** {{ $ticket['concert']['date_formatted'] }}

**Doors open:** {{ $ticket['concert']['doors_open'] }}

**Show time:** {{ $ticket['concert']['show_time'] }}

**Venue:** {{ $ticket['concert']['venue'] }}

**Gate:** {{ $ticket['concert']['gate_code'] }}

<x-mail::button :url="$ticket['view_url']">
View your ticket
</x-mail::button>

You can also [open your printable ticket]({{ $ticket['download_url'] }}).

Keep your ticket ID safe and bring your ticket or QR pass for entry. Your email address is used to send this confirmation and is not saved with your registration.

See you there,<br>
{{ $ticket['concert']['title'] }}
</x-mail::message>
