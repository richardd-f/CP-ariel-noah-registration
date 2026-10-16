<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnonymousRegistration extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'anonymous_registrations';

    /**
     * The attributes that are mass assignable.
     * Strictly anonymous - NO personally identifiable information is stored.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'anonymous_ticket_id',
        'nickname',
        'age_range',
        'country',
        'favorite_genres',
        'referral_source',
        'message',
        'agreed_anonymous',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'favorite_genres' => 'array',
        'agreed_anonymous' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the formatted display date for the ticket pass.
     */
    public function getFormattedTimestampAttribute(): string
    {
        return $this->created_at->format('M d, Y · H:i:s \U\T\C');
    }
}
