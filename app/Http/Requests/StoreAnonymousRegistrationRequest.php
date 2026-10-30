<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnonymousRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:254'],
            'nickname' => ['nullable', 'string', 'max:50'],
            'age_range' => ['required', 'string', 'in:Under 18,18-24,25-34,35-44,45+'],
            'country' => ['required', 'string', 'max:100'],
            'favorite_genres' => ['required', 'array', 'min:1'],
            'favorite_genres.*' => ['string', 'in:Rock,Pop,EDM,Hip-Hop,Jazz,Classical,Metal,R&B,K-Pop,J-Pop,Other'],
            'referral_source' => ['nullable', 'string', 'max:60'],
            'message' => ['nullable', 'string', 'max:1000'],
            'agree_anonymous' => ['accepted'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Please enter your email address for the confirmation.',
            'email.email' => 'Please enter a valid email address.',
            'age_range.required' => 'Please select your age range.',
            'age_range.in' => 'Please select a valid age range option.',
            'country.required' => 'Please choose your country of residence.',
            'favorite_genres.required' => 'Select at least one favorite music genre.',
            'favorite_genres.min' => 'Please pick at least one music genre.',
            'favorite_genres.*.in' => 'One of the selected music genres is invalid.',
            'agree_anonymous.accepted' => 'Please acknowledge how your email is used and that your ticket ID is required for entry.',
            'message.max' => 'Your message cannot exceed 1,000 characters.',
            'nickname.max' => 'Nickname cannot exceed 50 characters.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Support JSON string format if submitted via direct AJAX without deserializing
        if (is_string($this->favorite_genres)) {
            $decoded = json_decode($this->favorite_genres, true);
            if (is_array($decoded)) {
                $this->merge(['favorite_genres' => $decoded]);
            }
        }
    }
}
