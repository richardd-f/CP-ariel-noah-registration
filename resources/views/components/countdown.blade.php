@props(['targetIso' => '2026-11-14T20:00:00+07:00', 'dateFormatted' => 'Saturday, November 14, 2026'])

<section class="py-16 px-4 sm:px-6 lg:px-8 relative">
    <div class="max-w-5xl mx-auto">
        
        <!-- Glass Container with Neon Border -->
        <div x-data="countdownTimer('{{ $targetIso }}')" 
             class="relative rounded-3xl p-8 sm:p-12 glass-panel border border-purple-500/30 overflow-hidden text-center shadow-[0_0_50px_-10px_rgba(124,58,237,0.3)]">
            
            <!-- Background Radial Glow -->
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600/10 via-pink-600/10 to-cyan-500/10 pointer-events-none"></div>

            <div class="relative z-10 space-y-8">
                
                <!-- Tagline -->
                <div class="space-y-2">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-mono font-medium tracking-widest text-pink-400 bg-pink-500/10 border border-pink-500/20 uppercase">
                        <span class="w-1.5 h-1.5 rounded-full bg-pink-400 animate-ping"></span>
                        Countdown to Showtime
                    </span>
                    <h3 class="font-display text-2xl sm:text-3xl font-bold text-white">
                        The Portal Opens In
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-mono">
                        {{ $dateFormatted }} · Doors open at 18:00 WIB
                    </p>
                </div>

                <!-- 4 Glowing Digits Blocks -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 max-w-3xl mx-auto">
                    
                    <!-- Days -->
                    <div class="flex flex-col items-center justify-center p-4 sm:p-6 rounded-2xl bg-[#090910]/80 border border-white/10 shadow-inner group hover:border-purple-500/50 transition-colors">
                        <div class="font-display text-4xl sm:text-6xl font-extrabold text-white tracking-tight drop-shadow-[0_0_15px_rgba(168,85,247,0.5)]" 
                             x-text="days">
                            00
                        </div>
                        <span class="text-[11px] sm:text-xs uppercase font-mono tracking-widest text-purple-400 mt-2">
                            Days
                        </span>
                    </div>

                    <!-- Hours -->
                    <div class="flex flex-col items-center justify-center p-4 sm:p-6 rounded-2xl bg-[#090910]/80 border border-white/10 shadow-inner group hover:border-pink-500/50 transition-colors">
                        <div class="font-display text-4xl sm:text-6xl font-extrabold text-white tracking-tight drop-shadow-[0_0_15px_rgba(236,72,153,0.5)]" 
                             x-text="hours">
                            00
                        </div>
                        <span class="text-[11px] sm:text-xs uppercase font-mono tracking-widest text-pink-400 mt-2">
                            Hours
                        </span>
                    </div>

                    <!-- Minutes -->
                    <div class="flex flex-col items-center justify-center p-4 sm:p-6 rounded-2xl bg-[#090910]/80 border border-white/10 shadow-inner group hover:border-cyan-500/50 transition-colors">
                        <div class="font-display text-4xl sm:text-6xl font-extrabold text-white tracking-tight drop-shadow-[0_0_15px_rgba(6,182,212,0.5)]" 
                             x-text="minutes">
                            00
                        </div>
                        <span class="text-[11px] sm:text-xs uppercase font-mono tracking-widest text-cyan-400 mt-2">
                            Minutes
                        </span>
                    </div>

                    <!-- Seconds -->
                    <div class="flex flex-col items-center justify-center p-4 sm:p-6 rounded-2xl bg-[#090910]/80 border border-white/10 shadow-inner group hover:border-purple-400/50 transition-colors">
                        <div class="font-display text-4xl sm:text-6xl font-extrabold text-cyan-300 tracking-tight drop-shadow-[0_0_20px_rgba(6,182,212,0.8)]" 
                             x-text="seconds">
                            00
                        </div>
                        <span class="text-[11px] sm:text-xs uppercase font-mono tracking-widest text-cyan-300 mt-2">
                            Seconds
                        </span>
                    </div>

                </div>

                <!-- Live Sync Status -->
                <div class="inline-flex items-center gap-2 text-xs text-gray-500 font-mono">
                    <i data-lucide="satellite" class="w-3.5 h-3.5 text-emerald-400"></i>
                    <span>Synchronized with Universal Time Coordination (UTC+7)</span>
                </div>

            </div>

        </div>

    </div>
</section>
