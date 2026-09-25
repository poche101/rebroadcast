<?php

namespace App\Http\Controllers;

use App\Models\Rebroadcast;
use App\Models\RebroadcastParticipant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    /** Called every ~15s from the viewing page to mark the user as present. */
    public function ping(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'rebroadcast_id' => ['required', 'uuid', 'exists:rebroadcasts,id'],
        ]);

        RebroadcastParticipant::updateOrCreate(
            [
                'rebroadcast_id' => $validated['rebroadcast_id'],
                'user_id' => $request->user()->id,
            ],
            ['last_seen_at' => now()]
        );

        return $this->list($request, $validated['rebroadcast_id']);
    }

    public function list(Request $request, string $rebroadcast): JsonResponse
    {
        $rebroadcast = Rebroadcast::findOrFail($rebroadcast);

        $participants = $rebroadcast->activeParticipants()->map(fn ($user) => [
            'name' => $user->name,
            'is_you' => $user->id === $request->user()->id,
        ])->values();

        return response()->json([
            'count' => $participants->count(),
            'participants' => $participants,
        ]);
    }
}
