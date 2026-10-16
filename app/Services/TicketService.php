<?php

namespace App\Services;

use App\Models\AnonymousRegistration;
use Illuminate\Support\Str;

class TicketService
{
    /**
     * Generate a unique anonymous ticket code.
     * Example: ANON-4F82D9A or ANON-9A3F8B1
     */
    public function generateUniqueTicketId(): string
    {
        do {
            // 7 characters of high-entropy uppercase alphanumeric
            $randomCode = strtoupper(Str::random(7));
            $ticketId = 'ANON-' . $randomCode;
        } while (AnonymousRegistration::where('anonymous_ticket_id', $ticketId)->exists());

        return $ticketId;
    }

    /**
     * Get official concert metadata.
     */
    public function getConcertDetails(): array
    {
        return [
            'title' => 'NOVA HORIZON',
            'subtitle' => 'The Night Beyond Music',
            'edition' => 'World Tour 2026',
            'headliner' => 'Ariel Noah x Horizon Audio-Visual Orchestra',
            'date_formatted' => 'Saturday, November 14, 2026',
            'date_iso' => '2026-11-14T20:00:00+07:00',
            'doors_open' => '18:00 WIB',
            'show_time' => '20:00 — 02:00 WIB',
            'venue' => 'CyberDome Arena & Hologram Grounds',
            'city' => 'Neo Jakarta / Global Stream Tier 1',
            'genre' => 'Alternative Rock / Electronic Ambient / Synthwave',
            'dress_code' => 'Cyberpunk Glow / All-Black Neon Accents',
            'age_restriction' => '18+ (Strictly Anonymous Gate Entry)',
            'tier' => 'Tier 1 Anonymous Entry Pass',
            'gate_code' => 'GATE-ALPHA-09',
        ];
    }

    /**
     * Available music genres for registration selection.
     */
    public function getAvailableGenres(): array
    {
        return [
            'Rock',
            'Pop',
            'EDM',
            'Hip-Hop',
            'Jazz',
            'Classical',
            'Metal',
            'R&B',
            'K-Pop',
            'J-Pop',
            'Other',
        ];
    }

    /**
     * Available referral channels.
     */
    public function getReferralSources(): array
    {
        return [
            'Friend',
            'Instagram',
            'TikTok',
            'Facebook',
            'YouTube',
            'Discord',
            'Website',
            'Other',
        ];
    }

    /**
     * Age range options.
     */
    public function getAgeRanges(): array
    {
        return [
            'Under 18' => 'Under 18',
            '18-24' => '18–24',
            '25-34' => '25–34',
            '35-44' => '35–44',
            '45+' => '45+',
        ];
    }

    /**
     * Curated list of popular and international countries.
     */
    public function getCountries(): array
    {
        return [
            'Indonesia',
            'Malaysia',
            'Singapore',
            'Japan',
            'South Korea',
            'United States',
            'United Kingdom',
            'Australia',
            'Germany',
            'France',
            'Canada',
            'Netherlands',
            'Thailand',
            'Philippines',
            'Vietnam',
            'Taiwan',
            'Brazil',
            'India',
            'United Arab Emirates',
            'Other Country',
        ];
    }
}
