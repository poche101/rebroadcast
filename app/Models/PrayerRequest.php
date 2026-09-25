<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrayerRequest extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'rebroadcast_id',
        'name',
        'contact',
        'is_anonymous',
        'request_text',
        'status',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

    public function rebroadcast(): BelongsTo
    {
        return $this->belongsTo(Rebroadcast::class);
    }
}
