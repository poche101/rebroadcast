<?php

namespace App\Http\Controllers;

use App\Models\PrayerRequest;
use App\Models\Rebroadcast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RebroadcastPublicController extends Controller
{
    /**
     * The main worship experience: shows the active broadcast, or the
     * next scheduled one, or a gentle "nothing live right now" state.
     */
    public function show(): View
    {
        $rebroadcast = Rebroadcast::active()->latest('scheduled_at')->first()
            ?? Rebroadcast::where('status', 'scheduled')
                ->orderBy('scheduled_at')
                ->first();

        $recentArchive = Rebroadcast::where('status', 'archived')
            ->latest('scheduled_at')
            ->limit(6)
            ->get();

        $comments = $rebroadcast?->comments()->with('user')->limit(50)->get() ?? collect();
        $participants = $rebroadcast?->activeParticipants() ?? collect();

        return view('rebroadcast.show', compact('rebroadcast', 'recentArchive', 'comments', 'participants'));
    }

    public function submitPrayer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:120'],
            'contact' => ['nullable', 'string', 'max:160'],
            'is_anonymous' => ['nullable', 'boolean'],
            'request_text' => ['required', 'string', 'max:2000'],
            'rebroadcast_id' => ['nullable', 'uuid', 'exists:rebroadcasts,id'],
        ]);

        PrayerRequest::create([
            'rebroadcast_id' => $validated['rebroadcast_id'] ?? null,
            'name' => $validated['is_anonymous'] ?? false ? null : ($validated['name'] ?? null),
            'contact' => $validated['contact'] ?? null,
            'is_anonymous' => $validated['is_anonymous'] ?? false,
            'request_text' => $validated['request_text'],
        ]);

        return back()->with('prayer_submitted', true);
    }
}
