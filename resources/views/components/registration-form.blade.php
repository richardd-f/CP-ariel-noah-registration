@props([
    'ageRanges' => [],
    'countries' => [],
    'genres' => [],
    'referralSources' => [],
])

<section id="registration-section" class="py-24 px-4 sm:px-6 lg:px-8 relative">
    <div class="max-w-4xl mx-auto">
        
        <!-- Registration Card Container -->
        <div class="relative rounded-3xl p-6 sm:p-10 lg:p-12 glass-panel border border-white/15 shadow-[0_25px_80px_rgba(0,0,0,0.8)] overflow-hidden">
            
            <!-- Neon Edge Glows -->
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Form Header & Prominent Anonymous Notice -->
            <div class="text-center space-y-4 mb-10 relative z-10">
                
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-mono font-semibold tracking-wider bg-purple-500/10 text-purple-300 border border-purple-500/30">
                    <i data-lucide="shield-check" class="w-4 h-4 text-cyan-400"></i>
                    <span>ZERO-KNOWLEDGE REGISTRATION PROTOCOL</span>
                </div>

                <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Claim Your <span class="text-neon-gradient">Anonymous Seat</span>
                </h2>

                <p class="text-gray-300 text-sm sm:text-base max-w-xl mx-auto font-light">
                    No account. No email. No phone number. Fill in the anonymous survey to obtain your encrypted admission token.
                </p>

                <!-- High-Impact Privacy Notice Banner -->
                <div class="p-4 rounded-2xl bg-gradient-to-r from-purple-950/40 via-cyan-950/30 to-purple-950/40 border border-cyan-500/30 text-xs sm:text-sm text-cyan-200 flex items-center justify-center gap-3 shadow-lg shadow-cyan-950/30">
                    <i data-lucide="lock" class="w-5 h-5 text-cyan-400 flex-shrink-0"></i>
                    <span class="font-medium">
                        <strong>"Your identity is completely anonymous."</strong> No personally identifiable data is requested or stored.
                    </span>
                </div>

            </div>

            <!-- Alpine.js / Classic SSR Form hybrid -->
            <form @submit.prevent="submitForm" 
                  action="{{ route('register.store') }}" 
                  method="POST" 
                  class="space-y-8 relative z-10">
                @csrf

                <!-- 1. Nickname Field (Optional) -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="nickname" class="block text-sm font-semibold text-gray-200">
                            Alias / Nickname
                        </label>
                        <span class="text-xs font-mono text-gray-400">Optional · For Ticket Display Only</span>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="sparkles" class="w-4 h-4 text-purple-400"></i>
                        </div>
                        <input type="text" 
                               id="nickname" 
                               name="nickname"
                               x-model="nickname" 
                               placeholder="e.g. StarGazer, CyberPunk99, or leave blank"
                               maxlength="50"
                               class="glass-input w-full pl-11 pr-4 py-3.5 rounded-2xl text-sm placeholder-gray-500 font-sans"
                               :class="errors.nickname ? 'border-red-500 ring-1 ring-red-500' : ''">
                    </div>
                    <template x-if="errors.nickname">
                        <p class="text-xs text-red-400 flex items-center gap-1.5 mt-1 font-mono" x-text="errors.nickname"></p>
                    </template>
                </div>

                <!-- 2. Age Range Field (Required) -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-semibold text-gray-200">
                            Age Range <span class="text-pink-400">*</span>
                        </label>
                        <span class="text-xs font-mono text-cyan-400">Required</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                        @foreach ($ageRanges as $val => $label)
                            <label class="relative flex flex-col items-center justify-center p-3.5 rounded-2xl border cursor-pointer transition-all duration-200 text-center select-none"
                                   :class="ageRange === '{{ $val }}' 
                                        ? 'bg-purple-600/25 border-cyan-400 text-white shadow-[0_0_20px_rgba(6,182,212,0.3)] ring-1 ring-cyan-400' 
                                        : 'bg-white/5 border-white/10 text-gray-400 hover:border-white/20 hover:text-gray-200'">
                                <input type="radio" 
                                       name="age_range" 
                                       value="{{ $val }}" 
                                       x-model="ageRange"
                                       class="sr-only">
                                <span class="font-display font-semibold text-sm sm:text-base">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    <template x-if="errors.age_range">
                        <p class="text-xs text-red-400 flex items-center gap-1.5 mt-1 font-mono" x-text="errors.age_range"></p>
                    </template>
                </div>

                <!-- 3. Country Field (Required) -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="country" class="block text-sm font-semibold text-gray-200">
                            Country of Residence <span class="text-pink-400">*</span>
                        </label>
                        <span class="text-xs font-mono text-cyan-400">Required</span>
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="globe" class="w-4 h-4 text-cyan-400"></i>
                        </div>
                        <select id="country" 
                                name="country" 
                                x-model="country"
                                class="glass-input w-full pl-11 pr-10 py-3.5 rounded-2xl text-sm appearance-none bg-[#090912] cursor-pointer"
                                :class="errors.country ? 'border-red-500 ring-1 ring-red-500' : ''">
                            <option value="" disabled class="bg-[#090912] text-gray-500">Select your country...</option>
                            @foreach ($countries as $c)
                                <option value="{{ $c }}" class="bg-[#0e0e1a] text-white">{{ $c }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <template x-if="errors.country">
                        <p class="text-xs text-red-400 flex items-center gap-1.5 mt-1 font-mono" x-text="errors.country"></p>
                    </template>
                </div>

                <!-- 4. Favorite Music Genres (Required Multi-select Chips) -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-semibold text-gray-200">
                            Favorite Music Genres <span class="text-pink-400">*</span>
                        </label>
                        <span class="text-xs font-mono text-gray-400">Multi-select (Pick 1 or more)</span>
                    </div>

                    <div class="flex flex-wrap gap-2.5">
                        @foreach ($genres as $g)
                            <button type="button" 
                                    @click="toggleGenre('{{ $g }}')"
                                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-medium transition-all duration-200 flex items-center gap-2 select-none border"
                                    :class="favoriteGenres.includes('{{ $g }}') 
                                        ? 'bg-gradient-to-r from-pink-600 to-purple-600 border-pink-400 text-white shadow-[0_0_15px_rgba(236,72,153,0.4)] scale-[1.02]' 
                                        : 'bg-white/5 border-white/10 text-gray-300 hover:border-white/20 hover:bg-white/10'">
                                <span x-text="favoriteGenres.includes('{{ $g }}') ? '✓' : '+'" class="font-bold"></span>
                                <span>{{ $g }}</span>
                            </button>
                        @endforeach
                    </div>

                    <template x-if="errors.favorite_genres">
                        <p class="text-xs text-red-400 flex items-center gap-1.5 mt-1 font-mono" x-text="errors.favorite_genres"></p>
                    </template>
                </div>

                <!-- 5. Referral Source (Optional) -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-200">
                        How did you hear about this event?
                    </label>

                    <div class="flex flex-wrap gap-2">
                        @foreach ($referralSources as $ref)
                            <label class="px-3.5 py-1.5 rounded-xl border text-xs font-medium cursor-pointer transition-all duration-200 flex items-center gap-1.5 select-none"
                                   :class="referralSource === '{{ $ref }}' 
                                        ? 'bg-cyan-500/20 border-cyan-400 text-cyan-300 shadow-sm' 
                                        : 'bg-white/5 border-white/10 text-gray-400 hover:text-gray-200 hover:border-white/20'">
                                <input type="radio" 
                                       name="referral_source" 
                                       value="{{ $ref }}" 
                                       x-model="referralSource"
                                       class="sr-only">
                                <span>{{ $ref }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 6. Optional Message (Textarea) -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="message" class="block text-sm font-semibold text-gray-200">
                            Anonymous Message / Song Request
                        </label>
                        <span class="text-xs font-mono text-gray-400">Optional · Max 1,000 chars</span>
                    </div>

                    <textarea id="message" 
                              name="message" 
                              x-model="message"
                              rows="3" 
                              maxlength="1000"
                              placeholder="Share your favorite song or an anonymous vibe for the concert night..."
                              class="glass-input w-full p-4 rounded-2xl text-sm placeholder-gray-500 font-sans"></textarea>
                </div>

                <!-- 7. Mandatory Anonymous Agreement Checkbox -->
                <div class="pt-2">
                    <label class="flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 border border-white/10 hover:border-purple-500/40 cursor-pointer transition-all duration-200 group"
                           :class="errors.agree_anonymous ? 'border-red-500 ring-1 ring-red-500 bg-red-950/10' : ''">
                        <div class="relative flex items-center mt-0.5">
                            <input type="checkbox" 
                                   id="agree_anonymous" 
                                   name="agree_anonymous" 
                                   value="1"
                                   x-model="agreeAnonymous"
                                   class="w-5 h-5 rounded-lg bg-black/60 border-white/20 text-purple-600 focus:ring-purple-500 focus:ring-offset-black cursor-pointer">
                        </div>
                        <div class="flex-1 text-xs sm:text-sm text-gray-300 group-hover:text-white transition-colors">
                            <span class="font-medium text-white">I understand this registration is anonymous.</span>
                            <p class="text-xs text-gray-400 mt-0.5">
                                I acknowledge that no credentials or personal identity are tied to this reservation, and my ticket ID is the sole key for entry.
                            </p>
                        </div>
                    </label>

                    <template x-if="errors.agree_anonymous">
                        <p class="text-xs text-red-400 flex items-center gap-1.5 mt-2 font-mono" x-text="errors.agree_anonymous"></p>
                    </template>
                </div>

                <!-- Submitting Progress Bar -->
                <div x-show="isSubmitting" 
                     x-transition 
                     class="space-y-2 py-2">
                    <div class="flex items-center justify-between text-xs font-mono text-cyan-300">
                        <span class="flex items-center gap-2">
                            <i data-lucide="cpu" class="w-4 h-4 animate-spin text-cyan-400"></i>
                            <span>Generating Cryptographic Anonymous Token...</span>
                        </span>
                        <span x-text="submitProgress + '%'"></span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-black/60 overflow-hidden border border-white/10">
                        <div class="h-full bg-gradient-to-r from-purple-600 via-pink-600 to-cyan-400 transition-all duration-200 rounded-full"
                             :style="`width: ${submitProgress}%`"></div>
                    </div>
                </div>

                <!-- 8. Submit Button -->
                <div class="pt-4">
                    <button type="submit" 
                            :disabled="isSubmitting"
                            class="w-full relative group inline-flex items-center justify-center p-0.5 text-base sm:text-lg font-bold rounded-2xl overflow-hidden shadow-[0_0_35px_-5px_rgba(124,58,237,0.6)] hover:shadow-[0_0_45px_-5px_rgba(6,182,212,0.8)] transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        
                        <!-- Shimmering gradient border -->
                        <span class="absolute inset-0 bg-gradient-to-r from-purple-600 via-pink-600 via-cyan-400 to-purple-600 btn-shimmer"></span>
                        
                        <!-- Button inner container -->
                        <span class="relative w-full py-4 px-8 bg-[#090912] group-hover:bg-[#090912]/80 rounded-[14px] flex items-center justify-center gap-3 text-white transition-colors duration-200">
                            
                            <template x-if="!isSubmitting">
                                <span class="flex items-center gap-3">
                                    <i data-lucide="ticket" class="w-5 h-5 text-pink-400 group-hover:scale-110 transition-transform"></i>
                                    <span class="font-display tracking-wide">Reserve My Seat</span>
                                    <i data-lucide="arrow-right" class="w-5 h-5 text-cyan-400 group-hover:translate-x-1.5 transition-transform"></i>
                                </span>
                            </template>

                            <template x-if="isSubmitting">
                                <span class="flex items-center gap-3 text-cyan-300">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-cyan-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="font-display">Issuing Anonymous Pass...</span>
                                </span>
                            </template>

                        </span>
                    </button>
                </div>

                <!-- Footer Assurance -->
                <div class="text-center text-xs text-gray-400 pt-2 flex items-center justify-center gap-2">
                    <i data-lucide="shield" class="w-4 h-4 text-emerald-400"></i>
                    <span>No personal logs · Instant cryptographic verification · Free reservation</span>
                </div>

            </form>

        </div>

    </div>
</section>
