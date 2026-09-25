<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rebroadcast extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'video_url',
        'embed_url',
        'video_provider',
        'title',
        'speaker',
        'series',
        'scripture_reference',
        'notes',
        'bulletin',
        'status',
        'scheduled_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function prayerRequests(): HasMany
    {
        return $this->hasMany(PrayerRequest::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function participants(): HasMany
    {
        return $this->hasMany(RebroadcastParticipant::class);
    }

    /** Users considered actively present right now, most recently seen first. */
    public function activeParticipants()
    {
        return $this->participants()
            ->with('user')
            ->where('last_seen_at', '>=', RebroadcastParticipant::activeWindow())
            ->latest('last_seen_at')
            ->get()
            ->pluck('user')
            ->filter();
    }

    /**
     * Detect the provider and build a safe, autoplay-friendly embed URL
     * from a pasted YouTube, Vimeo, or direct video link.
     */
    public static function buildEmbed(string $url): array
    {
        // YouTube: watch?v=, youtu.be/, /live/, /shorts/
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|live/|shorts/|embed/))([A-Za-z0-9_-]{6,})~', $url, $m)) {
            return [
                'provider' => 'youtube',
                'embed' => "https://www.youtube.com/embed/{$m[1]}?rel=0&modestbranding=1",
            ];
        }

        // Vimeo: vimeo.com/123456789
        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
            return [
                'provider' => 'vimeo',
                'embed' => "https://player.vimeo.com/video/{$m[1]}?title=0&byline=0&portrait=0",
            ];
        }

        // Direct MP4 / HLS stream
        return [
            'provider' => 'direct',
            'embed' => $url,
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
