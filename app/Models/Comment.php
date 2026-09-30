<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'rebroadcast_id',
        'user_id',
        'parent_id',
        'body',
        'is_admin_comment',
    ];

    protected $casts = [
        'is_admin_comment' => 'boolean',
    ];

    public function rebroadcast(): BelongsTo
    {
        return $this->belongsTo(Rebroadcast::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->oldest();
    }
}
