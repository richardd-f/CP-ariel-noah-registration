@props(['concert'])

<section id="concert-details" class="py-20 px-4 sm:px-6 lg:px-8 relative">
    <div class="max-w-7xl mx-auto space-y-12">
        
        <!-- Header -->
        <div class="text-center space-y-4 max-w-2xl mx-auto">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-medium tracking-widest uppercase bg-purple-500/10 text-purple-400 border border-purple-500/20">
                Official Event Dossier
            </span>
            <h2 class="font-display text-3xl sm:text-5xl font-bold tracking-tight text-white">
                Concert <span class="text-neon-gradient">Intelligence</span>
            </h2>
            <p class="text-gray-400 text-sm sm:text-base">
                Everything you need to know about the upcoming live sonic journey.
            </p>
        </div>

        <!-- 6 Concert Info Glass Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            
            <!-- Date Card -->
            <div data-tilt class="group p-6 sm:p-7 rounded-3xl glass-card relative overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400 group-hover:scale-110 group-hover:bg-cyan-500/20 transition-all duration-300">
                        <i data-lucide="calendar" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="text-xs font-mono uppercase text-gray-400 tracking-wider">Date</span>
                        <h4 class="font-display text-lg sm:text-xl font-bold text-white mt-1 group-hover:text-cyan-300 transition-colors">
                            {{ $concert['date_formatted'] }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-1">Single exclusive evening worldwide</p>
                    </div>
                </div>
                <div class="pt-4 mt-4 border-t border-white/5 flex items-center gap-2 text-xs font-mono text-cyan-400/80">
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    <span>CONFIRMED CALENDAR</span>
                </div>
            </div>

            <!-- Time Card -->
            <div data-tilt class="group p-6 sm:p-7 rounded-3xl glass-card relative overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 group-hover:bg-purple-500/20 transition-all duration-300">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="text-xs font-mono uppercase text-gray-400 tracking-wider">Time</span>
                        <h4 class="font-display text-lg sm:text-xl font-bold text-white mt-1 group-hover:text-purple-300 transition-colors">
                            {{ $concert['show_time'] }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-1">Gates open strictly at {{ $concert['doors_open'] }}</p>
                    </div>
                </div>
                <div class="pt-4 mt-4 border-t border-white/5 flex items-center gap-2 text-xs font-mono text-purple-400/80">
                    <i data-lucide="sparkle" class="w-3.5 h-3.5"></i>
                    <span>6-HOUR IMMERSIVE SET</span>
                </div>
            </div>

            <!-- Venue Card -->
            <div data-tilt class="group p-6 sm:p-7 rounded-3xl glass-card relative overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-pink-500/10 border border-pink-500/20 flex items-center justify-center text-pink-400 group-hover:scale-110 group-hover:bg-pink-500/20 transition-all duration-300">
                        <i data-lucide="map-pin" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="text-xs font-mono uppercase text-gray-400 tracking-wider">Venue</span>
                        <h4 class="font-display text-lg sm:text-xl font-bold text-white mt-1 group-hover:text-pink-300 transition-colors">
                            {{ $concert['venue'] }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-1">{{ $concert['city'] }}</p>
                    </div>
                </div>
                <div class="pt-4 mt-4 border-t border-white/5 flex items-center gap-2 text-xs font-mono text-pink-400/80">
                    <i data-lucide="navigation" class="w-3.5 h-3.5"></i>
                    <span>GATE: ALPHA-09 FASTLANE</span>
                </div>
            </div>

            <!-- Genre Card -->
            <div data-tilt class="group p-6 sm:p-7 rounded-3xl glass-card relative overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover:scale-110 group-hover:bg-emerald-500/20 transition-all duration-300">
                        <i data-lucide="radio-tower" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="text-xs font-mono uppercase text-gray-400 tracking-wider">Genre & Sonic Landscape</span>
                        <h4 class="font-display text-lg sm:text-xl font-bold text-white mt-1 group-hover:text-emerald-300 transition-colors">
                            {{ $concert['genre'] }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-1">Multi-dimensional surround audio spatialization</p>
                    </div>
                </div>
                <div class="pt-4 mt-4 border-t border-white/5 flex items-center gap-2 text-xs font-mono text-emerald-400/80">
                    <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                    <span>360° DOLBY ATMOS LIVE</span>
                </div>
            </div>

            <!-- Dress Code Card -->
            <div data-tilt class="group p-6 sm:p-7 rounded-3xl glass-card relative overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 group-hover:scale-110 group-hover:bg-amber-500/20 transition-all duration-300">
                        <i data-lucide="shirt" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="text-xs font-mono uppercase text-gray-400 tracking-wider">Dress Code</span>
                        <h4 class="font-display text-lg sm:text-xl font-bold text-white mt-1 group-hover:text-amber-300 transition-colors">
                            {{ $concert['dress_code'] }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-1">Glow bracelets and refractive light badges provided</p>
                    </div>
                </div>
                <div class="pt-4 mt-4 border-t border-white/5 flex items-center gap-2 text-xs font-mono text-amber-400/80">
                    <i data-lucide="eye-off" class="w-3.5 h-3.5"></i>
                    <span>MASKS & VISORS ENCOURAGED</span>
                </div>
            </div>

            <!-- Age Restriction Card -->
            <div data-tilt class="group p-6 sm:p-7 rounded-3xl glass-card relative overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 group-hover:scale-110 group-hover:bg-indigo-500/20 transition-all duration-300">
                        <i data-lucide="shield" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="text-xs font-mono uppercase text-gray-400 tracking-wider">Age Restriction</span>
                        <h4 class="font-display text-lg sm:text-xl font-bold text-white mt-1 group-hover:text-indigo-300 transition-colors">
                            {{ $concert['age_restriction'] }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-1">Anonymous optical age estimation or zero-knowledge check</p>
                    </div>
                </div>
                <div class="pt-4 mt-4 border-t border-white/5 flex items-center gap-2 text-xs font-mono text-indigo-400/80">
                    <i data-lucide="fingerprint" class="w-3.5 h-3.5"></i>
                    <span>ZERO-KNOWLEDGE VERIFIED</span>
                </div>
            </div>

        </div>

    </div>
</section>
