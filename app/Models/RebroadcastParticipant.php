<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RebroadcastParticipant extends Model
{
    protected $fillable = [
        'rebroadcast_id',
        'user_id',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rebroadcast(): BelongsTo
    {
        return $this->belongsTo(Rebroadcast::class);
    }

    /** Participants counted as "present" if seen in the last 2 minutes. */
    public static function activeWindow(): \Carbon\Carbon
    {
        return now()->subMinutes(2);
    }
}
