<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP Anonymous Concert Pass · {{ $registration->anonymous_ticket_id }}</title>

    <!-- Google Fonts: Space Grotesk & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            body {
                background: #000000 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
            .ticket-card {
                border: 2px solid #ffffff !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="bg-[#030303] text-gray-100 min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8 font-sans selection:bg-purple-600/40 selection:text-white">

    <!-- Ambient Aurora in background -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0 no-print">
        <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] rounded-full bg-purple-600/20 blur-[130px] animate-aurora-1"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[450px] h-[450px] rounded-full bg-cyan-500/20 blur-[130px] animate-aurora-2"></div>
        <div class="absolute inset-0 bg-cyber-grid opacity-30"></div>
    </div>

    <!-- Top Action Bar (No Print) -->
    <div class="w-full max-w-xl mx-auto flex items-center justify-between mb-6 z-10 no-print">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Return to Event Site</span>
        </a>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" 
                    type="button" 
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-xs font-semibold text-white transition-colors shadow-md">
                <i data-lucide="printer" class="w-4 h-4 text-cyan-400"></i>
                <span>Print / Save PDF</span>
            </button>
        </div>
    </div>

    <div role="status" class="w-full max-w-xl mx-auto mb-6 p-5 rounded-2xl bg-white/5 border border-white/10 z-10">
        <h2 class="font-display text-xl font-bold text-white">
            {{ $registration->confirmed_at ? 'Registration confirmed' : 'Awaiting email confirmation' }}
        </h2>
        <p class="mt-2 text-sm text-gray-300">
            @if ($registration->confirmed_at)
                Confirmed at {{ $registration->confirmed_at->toIso8601String() }}. Keep your ticket ID safe.
            @else
                Open the email sent during registration and click "Confirm my Registration" to confirm your reservation.
            @endif
        </p>
    </div>

    <!-- Main Boarding Pass Container -->
    <div class="ticket-card relative w-full max-w-xl rounded-3xl glass-panel border border-white/20 shadow-[0_25px_90px_rgba(0,0,0,0.9)] overflow-hidden z-10">
        
        <!-- Holographic Top Foil -->
        <div class="h-3 w-full hologram-strip"></div>

        <!-- Ticket Header -->
        <div class="p-6 sm:p-8 bg-gradient-to-b from-[#0f0f18] to-[#08080f] border-b border-white/10 space-y-4">
            
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div class="space-y-1">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[10px] font-mono font-semibold tracking-wider bg-pink-500/10 text-pink-400 border border-pink-500/30">
                        {{ $registration->confirmed_at ? 'OFFICIAL ADMISSION TICKET' : 'REGISTRATION RECEIVED' }}
                    </span>
                    <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        NOVA HORIZON 2026
                    </h1>
                    <p class="text-xs text-gray-400 font-mono">
                        Ariel Noah x Synthesia Audio-Visual Orchestra
                    </p>
                </div>

                <div class="text-left sm:text-right space-y-1">
                    <span class="text-[10px] font-mono text-gray-400 uppercase">TIER</span>
                    <div class="text-sm font-bold font-display text-cyan-400">VIP ANONYMOUS</div>
                    <div class="text-[10px] font-mono text-cyan-400">{{ $registration->confirmed_at ? 'CONFIRMED' : 'PENDING CONFIRMATION' }}</div>
                </div>
            </div>

        </div>

        <!-- Perforated Notch Divider -->
        <div class="relative flex items-center justify-between px-2 bg-[#08080f]">
            <div class="w-6 h-6 rounded-full bg-[#030303] -ml-5 border-r border-white/20"></div>
            <div class="flex-1 border-b border-dashed border-white/20 mx-2"></div>
            <div class="w-6 h-6 rounded-full bg-[#030303] -mr-5 border-l border-white/20"></div>
        </div>

        <!-- Ticket Body Details -->
        <div class="p-6 sm:p-8 space-y-6 bg-[#08080f]">
            
            <!-- Anonymous Ticket ID Spotlight -->
            <div class="p-4 rounded-2xl bg-black/70 border border-purple-500/30 text-center space-y-1 shadow-inner">
                <span class="text-[10px] font-mono uppercase tracking-widest text-gray-400">Encrypted Anonymous Pass ID</span>
                <div class="font-mono text-2xl sm:text-3xl font-extrabold tracking-widest text-cyan-300">
                    {{ $registration->anonymous_ticket_id }}
                </div>
                <div class="text-[10px] text-gray-500 font-mono">Strictly Zero PII Linked · Universal Admission Key</div>
            </div>

            <!-- Key Logistics Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs font-mono">
                <div>
                    <span class="text-gray-500 block uppercase">DATE</span>
                    <span class="font-bold text-white text-sm">Nov 14, 2026</span>
                </div>
                <div>
                    <span class="text-gray-500 block uppercase">TIME</span>
                    <span class="font-bold text-white text-sm">20:00 WIB</span>
                    <span class="text-[10px] text-gray-400 block">Doors 18:00</span>
                </div>
                <div>
                    <span class="text-gray-500 block uppercase">GATE / ZONE</span>
                    <span class="font-bold text-pink-400 text-sm">ALPHA-09</span>
                    <span class="text-[10px] text-gray-400 block">Floor Standing</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="text-gray-500 block uppercase">VENUE</span>
                    <span class="font-bold text-white text-sm">CyberDome Arena & Hologram Grounds</span>
                    <span class="text-[10px] text-gray-400 block">Neo Jakarta, Sector 7</span>
                </div>
                <div>
                    <span class="text-gray-500 block uppercase">GUEST ALIAS</span>
                    <span class="font-bold text-cyan-300 text-sm">
                        {{ $registration->nickname ?: 'Anonymous Guest' }}
                    </span>
                </div>
            </div>

            <!-- Preferences / Survey Info (Non-PII) -->
            <div class="p-3.5 rounded-xl bg-white/5 border border-white/5 text-xs text-gray-300 flex items-center justify-between">
                <div>
                    <span class="text-gray-500 text-[10px] font-mono uppercase block">Favorite Genres</span>
                    <span class="font-medium">
                        {{ implode(', ', $registration->favorite_genres ?? []) }}
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-gray-500 text-[10px] font-mono uppercase block">Origin Territory</span>
                    <span class="font-medium">{{ $registration->country }}</span>
                </div>
            </div>

            <!-- QR Code Section for Gate Scanning -->
            <div class="pt-4 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-6">
                
                <div class="space-y-2 text-center sm:text-left">
                    <div class="inline-flex items-center gap-1.5 text-xs font-mono text-emerald-400">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        <span>Zero-Knowledge Scannable Code</span>
                    </div>
                    <p class="text-xs text-gray-400 max-w-xs leading-relaxed">
                        @if ($registration->confirmed_at)
                            Present this pass directly on your mobile device or printed sheet at Turnstile Alpha-09. No photo ID is needed.
                        @else
                            Confirm your registration using the link in your email before presenting this pass for entry.
                        @endif
                    </p>
                    <div class="text-[10px] text-gray-500 font-mono">
                        Issued: {{ $registration->formatted_timestamp }}
                    </div>
                </div>

                <!-- Client-Side Generated QR Canvas -->
                <div class="flex-shrink-0 p-3 bg-white rounded-2xl shadow-xl flex flex-col items-center">
                    <canvas id="ticket-qr" class="w-36 h-36"></canvas>
                    <span class="text-[9px] font-mono text-black font-semibold mt-1">NOVA-AUTH-QR</span>
                </div>

            </div>

        </div>

        <!-- Ticket Footer Barcode Simulation -->
        <div class="p-4 bg-[#050508] border-t border-white/10 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between text-[10px] font-mono text-gray-500">
            <span class="min-w-0 break-all">SECURE HASH: {{ hash('sha256', $registration->anonymous_ticket_id . 'NOVA_2026') }}</span>
            <span class="shrink-0 text-cyan-400">{{ $registration->confirmed_at ? 'CONFIRMED' : 'PENDING' }}</span>
        </div>

    </div>

    <!-- Script to render QR Code on canvas -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('ticket-qr');
            if (canvas && window.QRCode) {
                const qrContent = "TICKET:{{ $registration->anonymous_ticket_id }}|EVENT:NOVA_HORIZON_2026|VENUE:CyberDome|STATUS:{{ $registration->confirmed_at ? 'CONFIRMED' : 'PENDING' }}";
                window.QRCode.toCanvas(canvas, qrContent, {
                    width: 144,
                    margin: 1,
                    color: {
                        dark: '#030303',
                        light: '#FFFFFF'
                    }
                }, function (error) {
                    if (error) console.error(error);
                });
            }
        });
    </script>

</body>
</html>
