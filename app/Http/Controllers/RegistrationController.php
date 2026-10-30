<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnonymousRegistrationRequest;
use App\Mail\RegistrationConfirmation;
use App\Models\AnonymousRegistration;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class RegistrationController extends Controller
{
    public function __construct(
        protected TicketService $ticketService
    ) {}

    /**
     * Display the concert landing page with the registration form.
     */
    public function index(): View
    {
        $concert = $this->ticketService->getConcertDetails();
        $genres = $this->ticketService->getAvailableGenres();
        $referralSources = $this->ticketService->getReferralSources();
        $ageRanges = $this->ticketService->getAgeRanges();
        $countries = $this->ticketService->getCountries();

        $totalRegistrations = AnonymousRegistration::count();

        return view('concert.index', compact(
            'concert',
            'genres',
            'referralSources',
            'ageRanges',
            'countries',
            'totalRegistrations'
        ));
    }

    /**
     * Store a new anonymous concert registration.
     */
    public function store(StoreAnonymousRegistrationRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();
        $ticketId = $this->ticketService->generateUniqueTicketId();

        $registration = AnonymousRegistration::create([
            'anonymous_ticket_id' => $ticketId,
            'nickname' => $validated['nickname'] ?? null,
            'age_range' => $validated['age_range'],
            'country' => $validated['country'],
            'favorite_genres' => $validated['favorite_genres'],
            'referral_source' => $validated['referral_source'] ?? null,
            'message' => $validated['message'] ?? null,
            'agreed_anonymous' => true,
        ]);

        $concert = $this->ticketService->getConcertDetails();

        $ticketPayload = [
            'ticket_id' => $registration->anonymous_ticket_id,
            'nickname' => $registration->nickname ?: 'Anonymous Guest',
            'age_range' => $registration->age_range,
            'country' => $registration->country,
            'favorite_genres' => $registration->favorite_genres,
            'registered_at' => $registration->formatted_timestamp,
            'concert' => $concert,
            'view_url' => route('ticket.show', $registration->anonymous_ticket_id),
            'download_url' => route('ticket.download', $registration->anonymous_ticket_id),
        ];

        $emailSent = false;

        try {
            Mail::to($validated['email'])->send(new RegistrationConfirmation(
                $ticketPayload,
                $validated + ['registered_at' => $registration->created_at->toIso8601String()],
            ));
            $emailSent = true;
        } catch (Throwable $exception) {
            report($exception);
        }

        $message = $emailSent
            ? 'Your registration has been received and is awaiting confirmation. Please check your inbox or spam folder and click "Confirm my Registration" in the email.'
            : 'Your registration has been saved, but we could not send the confirmation email. It remains unconfirmed. Please save your ticket ID and contact the organizer.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'email_sent' => $emailSent,
                'ticket' => $ticketPayload,
            ], 201);
        }

        return redirect()->route('home', ['#success'])
            ->with('success_ticket', $ticketPayload)
            ->with('success_message', $message);
    }

    public function confirm(Request $request, string $ticketId): RedirectResponse
    {
        $registration = AnonymousRegistration::where('anonymous_ticket_id', $ticketId)->firstOrFail();

        if ($request->isMethod('GET')) {
            AnonymousRegistration::whereKey($registration->id)
                ->whereNull('confirmed_at')
                ->update(['confirmed_at' => now()]);
        }

        return redirect()->route('ticket.show', $ticketId);
    }

    /**
     * Display the digital concert ticket pass.
     */
    public function show(string $ticketId): View
    {
        $registration = AnonymousRegistration::where('anonymous_ticket_id', $ticketId)->firstOrFail();
        $concert = $this->ticketService->getConcertDetails();

        return view('concert.ticket', [
            'registration' => $registration,
            'concert' => $concert,
        ]);
    }

    /**
     * Render print-ready / downloadable ticket pass.
     */
    public function download(string $ticketId): View
    {
        $registration = AnonymousRegistration::where('anonymous_ticket_id', $ticketId)->firstOrFail();
        $concert = $this->ticketService->getConcertDetails();

        return view('concert.ticket-pass', [
            'registration' => $registration,
            'concert' => $concert,
        ]);
    }
}
