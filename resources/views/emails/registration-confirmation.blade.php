<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">
    <meta name="supported-color-schemes" content="dark">
    <title>Your {{ $ticket['concert']['title'] }} ticket</title>
    <style>
        :root { color-scheme: dark; supported-color-schemes: dark; }
        @media only screen and (max-width: 480px) {
            .card-padding { padding: 24px 16px !important; }
            .ticket-column { display: block !important; width: 100% !important; }
            .event-details { padding: 24px 0 0 !important; }
            .action-column { display: block !important; width: 100% !important; padding: 0 0 12px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #030303; color: #f3f4f6; font-family: Arial, Helvetica, sans-serif;">
    <div style="display: none; max-height: 0; overflow: hidden; mso-hide: all;">You're in. Your ticket {{ $ticket['ticket_id'] }} and QR pass are ready.</div>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#030303" style="background-color: #030303;">
        <tr>
            <td align="center" style="padding: 24px 12px;">
                <table role="presentation" width="520" cellspacing="0" cellpadding="0" border="0" bgcolor="#0a0a0f" style="width: 100%; max-width: 520px; background-color: #0a0a0f; border: 1px solid #27272f; border-radius: 24px; overflow: hidden;">
                    <tr>
                        <td height="5" bgcolor="#0c5156" style="height: 5px; background: linear-gradient(90deg, #0c5156, #0b4f3e); font-size: 0; line-height: 5px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="card-padding" style="padding: 32px 24px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 20px;">
                                        <table role="presentation" width="80" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td align="center" valign="middle" width="80" height="80" bgcolor="#073337" style="width: 80px; height: 80px; background-color: #073337; border: 1px solid #10d9aa; border-radius: 50%; color: #10d9aa; font-size: 44px; font-weight: bold; line-height: 80px;">&#10003;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <h1 style="margin: 0 0 8px; color: #ffffff; font-size: 32px; line-height: 38px; letter-spacing: -1px;">You're in.</h1>
                                        <p style="margin: 0; color: #d1d5db; font-size: 14px; line-height: 22px;">Your reservation is confirmed.<br>Here is your anonymous concert pass.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 24px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#050505" style="background-color: #050505; border: 1px solid #242429; border-radius: 16px;">
                                            <tr>
                                                <td style="padding: 18px 16px;">
                                                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tr>
                                                            <td style="padding-bottom: 12px; border-bottom: 1px solid #242429; color: #9ca3af; font-family: Consolas, 'Courier New', monospace; font-size: 11px;">ANONYMOUS PASS ID</td>
                                                            <td align="right" style="padding-bottom: 12px; border-bottom: 1px solid #242429;">
                                                                <span style="display: inline-block; padding: 4px 7px; border: 1px solid #07515a; border-radius: 4px; background-color: #062026; color: #67e8f9; font-family: Consolas, 'Courier New', monospace; font-size: 11px;">&#9679; VALIDATED</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="padding-top: 14px;">
                                                                <div style="padding: 14px; border: 1px solid #2d2d39; border-radius: 12px; background-color: #0e0e18; color: #67e8f9; font-family: Consolas, 'Courier New', monospace; font-size: 22px; font-weight: bold; letter-spacing: 2px; overflow-wrap: anywhere;">{{ $ticket['ticket_id'] }}</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="padding-top: 20px;">
                                                                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                    <tr>
                                                                        <td class="ticket-column" width="46%" valign="middle">
                                                                            <table role="presentation" align="center" width="200" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="width: 100%; max-width: 200px; background-color: #ffffff; border-radius: 12px;">
                                                                                <tr>
                                                                                    <td align="center" style="padding: 10px 8px 12px;">
                                                                                        <img src="{{ $message->embedData($qrCode, 'ticket-qr.png', 'image/png') }}" width="168" height="168" alt="QR code for ticket {{ $ticket['ticket_id'] }}" style="display: block; width: 168px; height: 168px; border: 0;">
                                                                                        <p style="margin: 6px 0 0; color: #1f2937; font-family: Consolas, 'Courier New', monospace; font-size: 11px; line-height: 16px;">Scan at<br>{{ $ticket['concert']['gate_code'] }}</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                        <td class="ticket-column event-details" width="54%" valign="middle" style="padding-left: 16px; overflow-wrap: anywhere;">
                                                                            <p style="margin: 0 0 4px; color: #9ca3af; font-family: Consolas, 'Courier New', monospace; font-size: 11px;">EVENT:</p>
                                                                            <p style="margin: 0 0 12px; color: #ffffff; font-size: 13px; font-weight: bold; line-height: 18px;">{{ $ticket['concert']['title'] }} {{ date('Y', strtotime($ticket['concert']['date_iso'])) }}</p>
                                                                            <p style="margin: 0 0 4px; color: #9ca3af; font-family: Consolas, 'Courier New', monospace; font-size: 11px;">DATE:</p>
                                                                            <p style="margin: 0 0 4px; color: #d1d5db; font-family: Consolas, 'Courier New', monospace; font-size: 12px; line-height: 18px;">{{ $ticket['concert']['date_formatted'] }}</p>
                                                                            <p style="margin: 0 0 12px; color: #d1d5db; font-family: Consolas, 'Courier New', monospace; font-size: 12px; line-height: 18px;">{{ $ticket['concert']['show_time'] }}<br>Doors: {{ $ticket['concert']['doors_open'] }}</p>
                                                                            <p style="margin: 0 0 4px; color: #9ca3af; font-family: Consolas, 'Courier New', monospace; font-size: 11px;">VENUE:</p>
                                                                            <p style="margin: 0 0 12px; color: #d1d5db; font-family: Consolas, 'Courier New', monospace; font-size: 12px; line-height: 18px;">{{ $ticket['concert']['venue'] }}</p>
                                                                            <p style="margin: 0 0 4px; color: #9ca3af; font-family: Consolas, 'Courier New', monospace; font-size: 11px;">GUEST ALIAS:</p>
                                                                            <p style="margin: 0; color: #f472b6; font-family: Consolas, 'Courier New', monospace; font-size: 13px; font-weight: bold; line-height: 19px;">{{ $ticket['nickname'] }}</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 24px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td class="action-column" width="50%" valign="top" style="padding-right: 6px;">
                                                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tr>
                                                            <td align="center" bgcolor="#7c3aed" style="border: 1px solid #8b5cf6; border-radius: 10px; background: linear-gradient(90deg, #9333ea, #06b6d4); mso-padding-alt: 14px 12px;">
                                                                <a href="{{ $ticket['download_url'] }}" style="display: block; padding: 14px 12px; color: #ffffff; font-size: 13px; font-weight: bold; line-height: 18px; text-decoration: none;">Download Ticket</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td class="action-column" width="50%" valign="top" style="padding-left: 6px;">
                                                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tr>
                                                            <td align="center" bgcolor="#18181b" style="background-color: #18181b; border: 1px solid #35353d; border-radius: 10px; mso-padding-alt: 14px 12px;">
                                                                <a href="{{ $ticket['view_url'] }}" style="display: block; padding: 14px 12px; color: #e5e7eb; font-size: 13px; font-weight: bold; line-height: 18px; text-decoration: none;">View Ticket</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top: 20px;">
                                        <p style="margin: 0; color: #9ca3af; font-family: Consolas, 'Courier New', monospace; font-size: 11px; line-height: 18px;">Keep your ticket ID safe. Your email address is not saved with your registration.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
