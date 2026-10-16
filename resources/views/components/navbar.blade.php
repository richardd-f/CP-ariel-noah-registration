<nav x-data="navBar"
     :class="isScrolled ? 'bg-[#050508]/80 backdrop-blur-xl border-b border-white/10 shadow-2xl py-3.5' : 'bg-transparent py-6'"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            
            <!-- Logo & Brand -->
            <a href="#hero" class="flex items-center gap-3 group focus:outline-none">
                <div class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-tr from-purple-600 via-pink-600 to-cyan-400 p-[1px] shadow-lg shadow-purple-900/40 group-hover:shadow-cyan-500/40 transition-all duration-300">
                    <div class="w-full h-full bg-[#07070b] rounded-[11px] flex items-center justify-center">
                        <i data-lucide="radio" class="w-5 h-5 text-cyan-400 group-hover:scale-110 transition-transform"></i>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="font-display font-bold text-lg sm:text-xl tracking-tight text-white flex items-center gap-2">
                        NOVA HORIZON
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            LIVE
                        </span>
                    </span>
                    <span class="text-[10px] uppercase tracking-widest text-gray-400 -mt-1 font-mono">
                        Anonymous Experience
                    </span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#hero" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
                    Home
                </a>
                <a href="#features" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
                    Features
                </a>
                <a href="#concert-details" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
                    Concert
                </a>
                <a href="#registration-section" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
                    Register
                </a>

                <!-- Mini Equalizer Visualizer preview -->
                <div class="flex items-end gap-0.5 h-4 px-2 py-1 rounded bg-white/5 border border-white/10" title="Audio Wave Status">
                    <span class="w-0.5 bg-cyan-400 eq-bar-1 rounded-full"></span>
                    <span class="w-0.5 bg-purple-400 eq-bar-2 rounded-full"></span>
                    <span class="w-0.5 bg-pink-400 eq-bar-3 rounded-full"></span>
                    <span class="w-0.5 bg-cyan-400 eq-bar-4 rounded-full"></span>
                    <span class="w-0.5 bg-purple-400 eq-bar-5 rounded-full"></span>
                </div>
            </div>

            <!-- CTA Button & Mobile Toggle -->
            <div class="flex items-center gap-3">
                <a href="#registration-section" 
                   class="relative inline-flex items-center justify-center px-5 py-2 text-xs sm:text-sm font-semibold rounded-xl text-white overflow-hidden shadow-lg shadow-purple-600/30 group">
                    <!-- Gradient border layer -->
                    <span class="absolute inset-0 bg-gradient-to-r from-purple-600 via-pink-600 to-cyan-500 group-hover:scale-105 transition-transform duration-300"></span>
                    <span class="absolute inset-[1px] bg-[#07070b]/90 rounded-[11px] group-hover:bg-[#07070b]/60 transition-colors"></span>
                    <span class="relative flex items-center gap-2">
                        <i data-lucide="ticket" class="w-4 h-4 text-pink-400"></i>
                        <span>Reserve Seat</span>
                    </span>
                </a>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="md:hidden p-2 rounded-xl bg-white/5 border border-white/10 text-gray-300 hover:text-white focus:outline-none"
                        aria-label="Toggle Navigation">
                    <i :data-lucide="mobileMenuOpen ? 'x' : 'menu'" class="w-5 h-5"></i>
                </button>
            </div>

        </div>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden mt-4 p-5 rounded-2xl glass-panel space-y-4 border border-white/10">
            <a @click="mobileMenuOpen = false" href="#hero" class="block text-sm font-medium text-gray-200 hover:text-cyan-400">
                Home
            </a>
            <a @click="mobileMenuOpen = false" href="#features" class="block text-sm font-medium text-gray-200 hover:text-cyan-400">
                Features
            </a>
            <a @click="mobileMenuOpen = false" href="#concert-details" class="block text-sm font-medium text-gray-200 hover:text-cyan-400">
                Concert Info
            </a>
            <a @click="mobileMenuOpen = false" href="#registration-section" class="block text-sm font-medium text-gray-200 hover:text-pink-400">
                Anonymous Registration
            </a>
        </div>
    </div>
</nav>
