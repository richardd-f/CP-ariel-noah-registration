<!-- Success Modal Component -->
<div x-show="showSuccessModal" 
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-6"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     role="dialog"
     aria-modal="true"
     aria-labelledby="success-modal-title">

    <!-- Backdrop with strong blur -->
    <div class="fixed inset-0 bg-black/85 backdrop-blur-2xl transition-opacity"></div>

    <!-- Modal Box with elastic zoom -->
    <div x-show="showSuccessModal"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-90 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-90 translate-y-4"
         @click.away="showSuccessModal = false"
         class="relative w-full max-w-xl p-6 sm:p-8 rounded-3xl glass-panel border border-cyan-500/30 shadow-[0_0_80px_-10px_rgba(6,182,212,0.4)] text-center space-y-6 overflow-hidden">
        
        <!-- Hologram accent strip on top -->
        <div class="absolute top-0 left-0 right-0 h-1.5 hologram-strip"></div>

        <!-- Large Animated Checkmark Icon -->
        <div class="flex justify-center pt-2">
            <div class="relative w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-tr from-emerald-500/20 via-cyan-500/20 to-purple-500/20 border-2 border-emerald-400 flex items-center justify-center shadow-[0_0_30px_rgba(16,185,129,0.5)]">
                <i data-lucide="check" class="w-10 h-10 sm:w-12 sm:h-12 text-emerald-400 stroke-[3]"></i>
                <div class="absolute inset-0 rounded-full border border-emerald-400/50 animate-ping pointer-events-none"></div>
            </div>
        </div>

        <!-- Headline & Subtitle -->
        <div class="space-y-2">
            <h3 id="success-modal-title" class="font-display text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                Check your email.
            </h3>
            <p class="text-sm sm:text-base text-gray-300" role="status" x-text="successMessage || 'Your reservation has been received.'">
                Your reservation has been received.
            </p>
        </div>

        <!-- Generated Anonymous Ticket ID Card -->
        <div class="p-5 rounded-2xl bg-black/60 border border-white/10 text-left space-y-4 shadow-inner">
            
            <div class="flex items-center justify-between pb-3 border-b border-white/10">
                <span class="text-xs font-mono text-gray-400">ANONYMOUS PASS ID</span>
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-mono text-cyan-300 bg-cyan-500/10 border border-cyan-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    PENDING
                </span>
            </div>

            <!-- Big Ticket Code with Quick Copy -->
            <div class="flex items-center justify-between bg-[#0e0e18] px-4 py-3 rounded-xl border border-white/10">
                <span class="font-mono text-xl sm:text-2xl font-bold tracking-widest text-cyan-300 select-all" 
                      x-text="ticket ? ticket.ticket_id : 'ANON-XXXXXXX'">
                </span>
                
                <button type="button" 
                        @click="navigator.clipboard.writeText(ticket.ticket_id); alert('Ticket ID copied to clipboard!')"
                        class="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-xs text-gray-300 hover:text-white flex items-center gap-1.5 transition-colors"
                        title="Copy Ticket ID">
                    <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                    <span>Copy</span>
                </button>
            </div>

            <!-- QR Code and Ticket Snapshot -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center pt-2">
                
                <!-- QR Code Box -->
                <div class="flex flex-col items-center justify-center p-3 bg-white rounded-xl shadow-md">
                    <template x-if="qrDataUrl">
                        <img :src="qrDataUrl" alt="Anonymous Ticket QR Code" class="w-36 h-36 object-contain">
                    </template>
                    <span class="text-[10px] font-mono text-gray-800 mt-1">Awaiting email confirmation</span>
                </div>

                <!-- Event Details Snapshot -->
                <div class="space-y-1.5 text-xs text-gray-300 font-mono">
                    <div>
                        <span class="text-gray-500">EVENT:</span>
                        <div class="font-bold text-white font-sans text-sm">NOVA HORIZON 2026</div>
                    </div>
                    <div>
                        <span class="text-gray-500">DATE:</span>
                        <div class="text-gray-200">Nov 14, 2026 · 20:00 WIB</div>
                    </div>
                    <div>
                        <span class="text-gray-500">VENUE:</span>
                        <div class="text-gray-200">CyberDome Arena</div>
                    </div>
                    <div>
                        <span class="text-gray-500">GUEST ALIAS:</span>
                        <div class="text-pink-400 font-semibold" x-text="ticket ? ticket.nickname : 'Anonymous Guest'"></div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
            
            <!-- Download Ticket Pass -->
            <button type="button" 
                    @click="downloadTicketPass"
                    class="relative inline-flex items-center justify-center px-6 py-3.5 text-sm font-bold text-white rounded-xl overflow-hidden shadow-lg shadow-purple-600/40 group">
                <span class="absolute inset-0 bg-gradient-to-r from-purple-600 to-cyan-500 group-hover:scale-105 transition-transform"></span>
                <span class="relative flex items-center justify-center gap-2">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>View Registration</span>
                </span>
            </button>

            <!-- Register Another -->
            <button type="button" 
                    @click="resetRegistration"
                    class="inline-flex items-center justify-center px-6 py-3.5 text-sm font-semibold text-gray-300 hover:text-white rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 transition-colors">
                <i data-lucide="user-plus" class="w-4 h-4 mr-2 text-pink-400"></i>
                <span>Register Another</span>
            </button>

        </div>

        <!-- Privacy Reminder Footer -->
        <p class="text-[11px] text-gray-500 font-mono pt-1">
            Keep your ticket ID safe. Your email address is not saved with your registration.
        </p>

    </div>
</div>
