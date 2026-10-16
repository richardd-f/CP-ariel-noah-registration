<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'NOVA HORIZON · Anonymous Concert Experience' }}</title>
    <meta name="description" content="Experience The Night Beyond Music. Reserve your completely anonymous concert admission pass in seconds. Zero accounts, zero tracking.">

    <!-- Preload Google Fonts: Space Grotesk & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚡</text></svg>">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Cursor Spotlight dynamic background */
        .spotlight-follower {
            background: radial-gradient(
                700px circle at var(--spotlight-x, 50vw) var(--spotlight-y, 50vh),
                rgba(124, 58, 237, 0.12),
                transparent 70%
            );
        }
    </style>
</head>
<body class="bg-[#030303] text-gray-100 antialiased relative min-h-screen selection:bg-purple-600/40 selection:text-white">

    <!-- Interactive Cursor Spotlight -->
    <div class="spotlight-follower fixed inset-0 pointer-events-none z-10 transition-opacity duration-300"></div>

    <!-- GPU-Optimized Animated Aurora Background Blobs -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <!-- Purple Blob -->
        <div class="absolute -top-[20%] -left-[10%] w-[650px] h-[650px] rounded-full bg-purple-700/20 blur-[130px] animate-aurora-1 mix-blend-screen"></div>
        <!-- Cyan Blob -->
        <div class="absolute top-[35%] -right-[15%] w-[600px] h-[600px] rounded-full bg-cyan-500/18 blur-[140px] animate-aurora-2 mix-blend-screen"></div>
        <!-- Pink Blob -->
        <div class="absolute -bottom-[20%] left-[25%] w-[700px] h-[700px] rounded-full bg-pink-600/15 blur-[150px] animate-aurora-3 mix-blend-screen"></div>
        <!-- Subtle Grid overlay -->
        <div class="absolute inset-0 bg-cyber-grid opacity-35"></div>
    </div>

    <!-- Navigation Bar -->
    <x-navbar />

    <!-- Main Content Slot -->
    <main class="relative z-10">
        {{ $slot }}
    </main>

    <!-- Global Footer -->
    <x-footer />

</body>
</html>
