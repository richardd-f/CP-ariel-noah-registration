<section id="hero" class="relative min-h-[92vh] flex items-center justify-center pt-28 pb-16 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        
        <!-- Left Column: Copy & Actions -->
        <div class="lg:col-span-7 flex flex-col items-center lg:items-start text-center lg:text-left space-y-6 sm:space-y-8 z-10">
            
            <!-- Privacy Pill Tag -->
            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white/5 border border-purple-500/30 backdrop-blur-md shadow-lg shadow-purple-900/20 animate-pulse-glow">
                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                <span class="text-xs font-medium text-cyan-300 font-mono tracking-wide">
                    NO ACCOUNT · EMAIL CONFIRMATION
                </span>
            </div>

            <!-- Main Headline -->
            <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.08] text-white">
                Experience The Night <br class="hidden sm:inline">
                <span class="text-neon-gradient">Beyond Music</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-base sm:text-xl text-gray-300 max-w-2xl font-light leading-relaxed">
                Reserve your concert entry without a login, account, real name, or phone number. Receive your confirmation and ticket links by email.
            </p>

            <!-- Prominent Anonymous Guarantee Notice -->
            <div class="p-3.5 sm:p-4 rounded-xl bg-purple-950/30 border border-purple-500/20 backdrop-blur-md flex items-center gap-3 text-xs sm:text-sm text-purple-200/90 max-w-xl">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-300">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                </div>
                <span>
                    <strong>No account or real name required.</strong> Your email is used to send your confirmation and is not saved with your registration.
                </span>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto pt-2">
                <!-- Primary Button -->
                <a href="#registration-section" 
                   class="w-full sm:w-auto relative group inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white rounded-2xl overflow-hidden shadow-2xl shadow-purple-600/40 hover:shadow-cyan-500/40 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                    <span class="absolute inset-0 bg-gradient-to-r from-purple-600 via-pink-600 to-cyan-500 group-hover:scale-105 transition-transform duration-300"></span>
                    <span class="absolute inset-0 opacity-0 group-hover:opacity-30 bg-white transition-opacity duration-300"></span>
                    <span class="relative flex items-center justify-center gap-2 font-display">
                        <span>Reserve Seat</span>
                        <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </a>

                <!-- Secondary Button -->
                <a href="#features" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-7 py-4 text-base font-medium text-gray-300 hover:text-white rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 backdrop-blur-lg transition-all duration-300">
                    <i data-lucide="sparkles" class="w-5 h-5 mr-2 text-cyan-400"></i>
                    <span>Learn More</span>
                </a>
            </div>

            <!-- Quick Metrics / Social Proof -->
            <div class="flex items-center gap-6 sm:gap-10 pt-4 border-t border-white/10 text-xs sm:text-sm text-gray-400">
                <div class="flex flex-col">
                    <span class="font-display font-bold text-lg sm:text-xl text-white">
                        {{ number_format($totalRegistrations + 1420) }}+
                    </span>
                    <span class="text-xs text-gray-400">Anonymous Passes Claimed</span>
                </div>
                <div class="h-8 w-px bg-white/10"></div>
                <div class="flex flex-col">
                    <span class="font-display font-bold text-lg sm:text-xl text-cyan-400">0.00%</span>
                    <span class="text-xs text-gray-400">Personal Data Stored</span>
                </div>
                <div class="h-8 w-px bg-white/10"></div>
                <div class="flex flex-col">
                    <span class="font-display font-bold text-lg sm:text-xl text-pink-400">Email</span>
                    <span class="text-xs text-gray-400">Ticket Confirmation</span>
                </div>
            </div>

        </div>

        <!-- Right Column: Interactive Vinyl Record & 3D Hologram Art -->
        <div class="lg:col-span-5 flex justify-center items-center relative">
            
            <!-- Neon Ambient Aura Behind Vinyl -->
            <div class="absolute w-72 h-72 sm:w-96 sm:h-96 rounded-full bg-gradient-to-tr from-purple-600/30 via-pink-600/25 to-cyan-500/30 blur-3xl -z-10 animate-pulse-glow"></div>

            <!-- 3D Card Stage with Tilt -->
            <div data-tilt class="relative w-full max-w-sm sm:max-w-md p-6 sm:p-8 rounded-3xl glass-card border border-white/15 flex flex-col items-center">
                
                <!-- Concert Tour Tag -->
                <div class="w-full flex items-center justify-between pb-4 border-b border-white/10 text-xs font-mono text-gray-400">
                    <span class="flex items-center gap-1.5 text-cyan-300">
                        <i data-lucide="disc" class="w-4 h-4 text-cyan-400"></i>
                        WORLD TOUR 2026
                    </span>
                    <span class="px-2 py-0.5 rounded bg-pink-500/20 text-pink-300 border border-pink-500/30 font-semibold">
                        VIP ANONYMOUS
                    </span>
                </div>

                <!-- Animated Vinyl Disc Centerpiece -->
                <div class="relative my-6 w-48 h-48 sm:w-56 sm:h-56 flex items-center justify-center">
                    <!-- Spinning Outer Grooves -->
                    <div class="absolute inset-0 rounded-full border-4 border-dashed border-purple-500/30 animate-spin" style="animation-duration: 25s;"></div>
                    <div class="absolute inset-2 rounded-full border border-white/10"></div>
                    <div class="absolute inset-4 rounded-full border border-white/5"></div>
                    
                    <!-- Vinyl Body -->
                    <div class="w-44 h-44 sm:w-52 sm:h-52 rounded-full bg-gradient-to-b from-neutral-900 via-neutral-950 to-black shadow-2xl flex items-center justify-center relative overflow-hidden animate-vinyl border border-white/10">
                        <!-- Holographic Vinyl Sheen -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-purple-500/10 to-cyan-400/15 pointer-events-none"></div>
                        
                        <!-- Concentric Vinyl Grooves -->
                        <div class="w-36 h-36 rounded-full border border-white/10 flex items-center justify-center">
                            <div class="w-28 h-28 rounded-full border border-white/10 flex items-center justify-center">
                                <!-- Vinyl Center Label -->
                                <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-pink-600 to-purple-700 flex flex-col items-center justify-center text-white text-[9px] font-bold tracking-widest shadow-inner border border-white/20">
                                    <span>NOVA</span>
                                    <div class="w-3 h-3 rounded-full bg-black/60 my-0.5 border border-white/40"></div>
                                    <span>2026</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Glowing Center Indicator -->
                    <div class="absolute w-3 h-3 rounded-full bg-cyan-400 shadow-[0_0_15px_#06B6D4]"></div>
                </div>

                <!-- Live Equalizer Visualizer Card -->
                <div class="w-full bg-black/40 rounded-2xl p-4 border border-white/10 space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <i data-lucide="music-2" class="w-4 h-4 text-purple-400"></i>
                            <span class="font-medium text-white">Ariel Noah x Synthesia</span>
                        </div>
                        <span class="font-mono text-cyan-400 text-[11px]">432 Hz Master</span>
                    </div>

                    <!-- Equalizer frequency bars -->
                    <div class="flex items-end justify-between h-8 px-2 gap-1.5 bg-neutral-950/80 rounded-lg p-1.5 border border-white/5">
                        <span class="w-2 rounded bg-gradient-to-t from-purple-600 to-pink-500 eq-bar-1"></span>
                        <span class="w-2 rounded bg-gradient-to-t from-purple-600 to-pink-500 eq-bar-2"></span>
                        <span class="w-2 rounded bg-gradient-to-t from-pink-500 to-cyan-400 eq-bar-3"></span>
                        <span class="w-2 rounded bg-gradient-to-t from-pink-500 to-cyan-400 eq-bar-4"></span>
                        <span class="w-2 rounded bg-gradient-to-t from-cyan-400 to-purple-500 eq-bar-5"></span>
                        <span class="w-2 rounded bg-gradient-to-t from-cyan-400 to-purple-500 eq-bar-2"></span>
                        <span class="w-2 rounded bg-gradient-to-t from-purple-600 to-pink-500 eq-bar-3"></span>
                        <span class="w-2 rounded bg-gradient-to-t from-purple-600 to-cyan-400 eq-bar-1"></span>
                    </div>

                    <div class="flex items-center justify-between text-[11px] text-gray-400 pt-1">
                        <span>Venue: CyberDome Arena</span>
                        <span class="text-pink-400 font-mono">Saturday, Nov 14</span>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
