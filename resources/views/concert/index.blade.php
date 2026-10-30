<x-app-layout>
    @php
        $initialData = [
            'oldEmail' => old('email', ''),
            'oldNickname' => old('nickname', ''),
            'oldAgeRange' => old('age_range', ''),
            'oldCountry' => old('country', ''),
            'oldGenres' => old('favorite_genres', []),
            'oldReferral' => old('referral_source', ''),
            'oldMessage' => old('message', ''),
            'errors' => $errors->toArray(),
            'successTicket' => session('success_ticket', null),
            'successMessage' => session('success_message', ''),
        ];
    @endphp

    <div x-data="registrationApp({{ Js::from($initialData) }})" class="relative">
        
        <!-- Hero Section -->
        <x-hero :totalRegistrations="$totalRegistrations" />

        <!-- Neon Section Divider -->
        <div class="relative py-4 flex items-center justify-center overflow-hidden">
            <div class="h-px w-3/4 max-w-4xl bg-gradient-to-r from-transparent via-cyan-500/40 to-transparent"></div>
        </div>

        <!-- Features Section -->
        <x-features />

        <!-- Neon Section Divider -->
        <div class="relative py-4 flex items-center justify-center overflow-hidden">
            <div class="h-px w-3/4 max-w-4xl bg-gradient-to-r from-transparent via-purple-500/40 to-transparent"></div>
        </div>

        <!-- Countdown Section -->
        <x-countdown :targetIso="$concert['date_iso']" :dateFormatted="$concert['date_formatted']" />

        <!-- Neon Section Divider -->
        <div class="relative py-4 flex items-center justify-center overflow-hidden">
            <div class="h-px w-3/4 max-w-4xl bg-gradient-to-r from-transparent via-pink-500/40 to-transparent"></div>
        </div>

        <!-- Concert Information Section -->
        <x-concert-info :concert="$concert" />

        <!-- Neon Section Divider -->
        <div class="relative py-4 flex items-center justify-center overflow-hidden">
            <div class="h-px w-3/4 max-w-4xl bg-gradient-to-r from-transparent via-cyan-500/40 to-transparent"></div>
        </div>

        <!-- Registration Form Section -->
        <x-registration-form 
            :ageRanges="$ageRanges"
            :countries="$countries"
            :genres="$genres"
            :referralSources="$referralSources"
        />

        <!-- Success Modal (shown after registration) -->
        <x-success-modal />

    </div>
</x-app-layout>
