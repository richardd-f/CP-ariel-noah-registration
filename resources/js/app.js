import Alpine from 'alpinejs';
import confetti from 'canvas-confetti';
import { createIcons, icons } from 'lucide';
import QRCode from 'qrcode';

window.Alpine = Alpine;
window.confetti = confetti;
window.QRCode = QRCode;

// Initialize Lucide icons helper
function renderIcons() {
    createIcons({
        icons,
        attrs: {
            'stroke-width': 1.8,
            class: 'lucide-icon inline-block',
        },
    });
}

// Interactive Mouse Spotlight
function initSpotlight() {
    window.addEventListener('mousemove', (e) => {
        const x = e.clientX;
        const y = e.clientY;
        document.documentElement.style.setProperty('--spotlight-x', `${x}px`);
        document.documentElement.style.setProperty('--spotlight-y', `${y}px`);
    });
}

// 3D Tilt Card effect
function initTiltCards() {
    document.querySelectorAll('[data-tilt]').forEach((card) => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = ((y - centerY) / centerY) * -6;
            const rotateY = ((x - centerX) / centerX) * 6;

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
        });
    });
}

// Registration Form Store & State for Alpine
Alpine.data('registrationApp', (initialData = {}) => ({
    // Form fields
    email: initialData.oldEmail || '',
    nickname: initialData.oldNickname || '',
    ageRange: initialData.oldAgeRange || '',
    country: initialData.oldCountry || '',
    favoriteGenres: initialData.oldGenres || [],
    referralSource: initialData.oldReferral || '',
    message: initialData.oldMessage || '',
    agreeAnonymous: false,

    // UI States
    isSubmitting: false,
    submitProgress: 0,
    errors: initialData.errors || {},
    showSuccessModal: !!initialData.successTicket,
    successMessage: initialData.successMessage || '',
    ticket: initialData.successTicket || null,
    qrDataUrl: '',
    isPlayingMusic: false,
    audioElement: null,

    init() {
        this.$nextTick(() => {
            renderIcons();
            initTiltCards();
            if (this.ticket && this.ticket.ticket_id) {
                this.generateTicketQR(this.ticket.ticket_id);
                this.fireConfetti();
            }
        });
    },

    toggleGenre(genre) {
        if (this.favoriteGenres.includes(genre)) {
            this.favoriteGenres = this.favoriteGenres.filter(g => g !== genre);
        } else {
            this.favoriteGenres.push(genre);
        }
        if (this.errors.favorite_genres && this.favoriteGenres.length > 0) {
            delete this.errors.favorite_genres;
        }
    },

    validate() {
        this.errors = {};

        if (!this.email.trim()) {
            this.errors.email = 'Please enter your email address for the confirmation.';
        }
        if (!this.ageRange) {
            this.errors.age_range = 'Please select your age category.';
        }
        if (!this.country) {
            this.errors.country = 'Please choose your country.';
        }
        if (!this.favoriteGenres || this.favoriteGenres.length === 0) {
            this.errors.favorite_genres = 'Pick at least one music genre.';
        }
        if (!this.agreeAnonymous) {
            this.errors.agree_anonymous = 'Please acknowledge how your email is used and that your ticket ID is required for entry.';
        }

        return Object.keys(this.errors).length === 0;
    },

    async submitForm() {
        if (this.isSubmitting) return;

        if (!this.validate()) {
            // Scroll smoothly to form error
            const formCard = document.getElementById('registration-section');
            if (formCard) {
                formCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        this.isSubmitting = true;
        this.submitProgress = 10;

        // Progress simulation animation
        const progressInterval = setInterval(() => {
            if (this.submitProgress < 85) {
                this.submitProgress += Math.floor(Math.random() * 15) + 8;
            }
        }, 180);

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    email: this.email,
                    nickname: this.nickname,
                    age_range: this.ageRange,
                    country: this.country,
                    favorite_genres: this.favoriteGenres,
                    referral_source: this.referralSource,
                    message: this.message,
                    agree_anonymous: this.agreeAnonymous,
                }),
            });

            clearInterval(progressInterval);
            this.submitProgress = 100;

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422 && data.errors) {
                    this.errors = Object.keys(data.errors).reduce((acc, key) => {
                        acc[key] = data.errors[key][0];
                        return acc;
                    }, {});
                } else {
                    alert('An error occurred during submission. Please try again.');
                }
                this.isSubmitting = false;
                this.submitProgress = 0;
                return;
            }

            // Success state
            setTimeout(async () => {
                this.ticket = data.ticket;
                this.successMessage = data.message;
                this.isSubmitting = false;
                this.showSuccessModal = true;
                await this.generateTicketQR(this.ticket.ticket_id);
                this.fireConfetti();
                this.$nextTick(() => renderIcons());
            }, 300);

        } catch (err) {
            clearInterval(progressInterval);
            this.isSubmitting = false;
            this.submitProgress = 0;
            console.error(err);
            alert('Network error. Please verify your connection.');
        }
    },

    async generateTicketQR(ticketId) {
        try {
            const qrText = `TICKET:${ticketId}|EVENT:NOVA_HORIZON_2026|GATE:ALPHA-09`;
            this.qrDataUrl = await QRCode.toDataURL(qrText, {
                width: 320,
                margin: 2,
                color: {
                    dark: '#030303',
                    light: '#FFFFFF',
                },
            });
        } catch (err) {
            console.error('QR generation failed:', err);
        }
    },

    fireConfetti() {
        const count = 200;
        const defaults = {
            origin: { y: 0.6 },
            zIndex: 9999,
        };

        function fire(particleRatio, opts) {
            confetti({
                ...defaults,
                ...opts,
                particleCount: Math.floor(count * particleRatio),
            });
        }

        fire(0.25, {
            spread: 26,
            startVelocity: 55,
            colors: ['#7C3AED', '#06B6D4', '#EC4899'],
        });
        fire(0.2, {
            spread: 60,
            colors: ['#06B6D4', '#3B82F6', '#FFFFFF'],
        });
        fire(0.35, {
            spread: 100,
            decay: 0.91,
            scalar: 0.8,
            colors: ['#EC4899', '#7C3AED', '#A855F7'],
        });
        fire(0.1, {
            spread: 120,
            startVelocity: 25,
            decay: 0.92,
            colors: ['#38BDF8', '#C084FC', '#F472B6'],
        });
        fire(0.1, {
            spread: 120,
            startVelocity: 45,
            colors: ['#FFFFFF', '#06B6D4'],
        });
    },

    resetRegistration() {
        this.email = '';
        this.nickname = '';
        this.ageRange = '';
        this.country = '';
        this.favoriteGenres = [];
        this.referralSource = '';
        this.message = '';
        this.agreeAnonymous = false;
        this.showSuccessModal = false;
        this.successMessage = '';
        this.ticket = null;
        this.errors = {};
        this.submitProgress = 0;

        const formCard = document.getElementById('registration-section');
        if (formCard) {
            formCard.scrollIntoView({ behavior: 'smooth' });
        }
    },

    downloadTicketPass() {
        if (!this.ticket) return;
        window.open(this.ticket.view_url || `/ticket/${this.ticket.ticket_id}`, '_blank');
    },

    toggleMusicVisualizer() {
        this.isPlayingMusic = !this.isPlayingMusic;
    }
}));

// Countdown Timer Component
Alpine.data('countdownTimer', (targetIsoString) => ({
    targetDate: new Date(targetIsoString).getTime(),
    days: '00',
    hours: '00',
    minutes: '00',
    seconds: '00',
    timerInterval: null,

    init() {
        this.updateCountdown();
        this.timerInterval = setInterval(() => {
            this.updateCountdown();
        }, 1000);
    },

    updateCountdown() {
        const now = new Date().getTime();
        const difference = this.targetDate - now;

        if (difference <= 0) {
            this.days = '00';
            this.hours = '00';
            this.minutes = '00';
            this.seconds = '00';
            if (this.timerInterval) clearInterval(this.timerInterval);
            return;
        }

        const d = Math.floor(difference / (1000 * 60 * 60 * 24));
        const h = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const m = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const s = Math.floor((difference % (1000 * 60)) / 1000);

        this.days = d < 10 ? `0${d}` : `${d}`;
        this.hours = h < 10 ? `0${h}` : `${h}`;
        this.minutes = m < 10 ? `0${m}` : `${m}`;
        this.seconds = s < 10 ? `0${s}` : `${s}`;
    }
}));

// Navbar Scroll Spy Component
Alpine.data('navBar', () => ({
    isScrolled: false,
    mobileMenuOpen: false,

    init() {
        window.addEventListener('scroll', () => {
            this.isScrolled = window.scrollY > 40;
        }, { passive: true });
    }
}));

// Boot Alpine and icons
document.addEventListener('DOMContentLoaded', () => {
    initSpotlight();
    renderIcons();
    Alpine.start();
});
