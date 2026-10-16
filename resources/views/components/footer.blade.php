<footer class="relative z-10 border-t border-white/10 bg-[#020204]/80 backdrop-blur-xl pt-16 pb-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-12">
        
        <!-- Top Row: Brand & Manifesto -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <div class="md:col-span-6 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-purple-600 via-pink-600 to-cyan-400 p-[1px]">
                        <div class="w-full h-full bg-[#07070b] rounded-[7px] flex items-center justify-center">
                            <i data-lucide="radio" class="w-4 h-4 text-cyan-400"></i>
                        </div>
                    </div>
                    <span class="font-display font-bold text-lg text-white tracking-tight">
                        NOVA HORIZON 2026
                    </span>
                </div>
                <p class="text-sm text-gray-400 max-w-md leading-relaxed">
                    A revolutionary live musical sanctuary where privacy meets sonic grandeur. No cookies, no trackers, no surveillance. Pure live frequency.
                </p>
                <div class="flex items-center gap-3 text-xs font-mono text-cyan-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>ALL NODES ENCRYPTED & ANONYMIZED</span>
                </div>
            </div>

            <div class="md:col-span-3 space-y-3">
                <h4 class="text-xs font-mono uppercase text-gray-300 tracking-wider">Navigation</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#hero" class="hover:text-cyan-400 transition-colors">Home & Audio</a></li>
                    <li><a href="#features" class="hover:text-cyan-400 transition-colors">Privacy Architecture</a></li>
                    <li><a href="#concert-details" class="hover:text-cyan-400 transition-colors">Event Logistics</a></li>
                    <li><a href="#registration-section" class="hover:text-pink-400 transition-colors">Anonymous Registration</a></li>
                </ul>
            </div>

            <div class="md:col-span-3 space-y-3">
                <h4 class="text-xs font-mono uppercase text-gray-300 tracking-wider">Event Coordination</h4>
                <div class="space-y-1 text-sm text-gray-400">
                    <p class="text-white font-medium">CyberDome Arena</p>
                    <p class="text-xs text-gray-400">Neo Jakarta, Sector 7</p>
                    <p class="text-xs text-cyan-400 font-mono mt-2">Gate Code: ALPHA-09</p>
                </div>

                <div class="pt-2">
                    <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
                            type="button" 
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-xs text-gray-300 hover:text-white transition-colors">
                        <i data-lucide="arrow-up" class="w-3.5 h-3.5 text-cyan-400"></i>
                        <span>Back to Top</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- Neon Glow Divider Line -->
        <div class="h-px w-full bg-gradient-to-r from-transparent via-purple-500/30 to-transparent"></div>

        <!-- Bottom Copyright & Security Stamp -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500 font-mono">
            <div>
                &copy; 2026 NOVA HORIZON. Built with Laravel 12 & Modern Web Aesthetics.
            </div>
            <div class="flex items-center gap-4">
                <span class="hover:text-gray-300 transition-colors">Zero PII Policy</span>
                <span>·</span>
                <span class="hover:text-gray-300 transition-colors">Client-Side QR</span>
                <span>·</span>
                <span class="text-pink-400">Pure Concert Culture</span>
            </div>
        </div>

    </div>
</footer>
