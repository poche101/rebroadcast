<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerRequest;
use App\Models\Rebroadcast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RebroadcastController extends Controller
{
    public function index(): View
    {
        $rebroadcasts = Rebroadcast::withCount('prayerRequests')
            ->orderByRaw("CASE status WHEN 'active' THEN 1 WHEN 'scheduled' THEN 2 WHEN 'archived' THEN 3 ELSE 4 END")
            ->latest('scheduled_at')
            ->paginate(12);

        $stats = [
            'live' => Rebroadcast::where('status', 'active')->count(),
            'scheduled' => Rebroadcast::where('status', 'scheduled')->count(),
            'archived' => Rebroadcast::where('status', 'archived')->count(),
            'new_prayer_requests' => PrayerRequest::where('status', 'new')->count(),
        ];

        return view('admin.rebroadcasts.index', compact('rebroadcasts', 'stats'));
    }

    public function create(): View
    {
        return view('admin.rebroadcasts.form', ['rebroadcast' => new Rebroadcast()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $embed = Rebroadcast::buildEmbed($data['video_url']);
        $data['video_provider'] = $embed['provider'];
        $data['embed_url'] = $embed['embed'];

        Rebroadcast::create($data);

        return redirect()->route('admin.rebroadcasts.index')->with('status', 'Service saved and published to the platform.');
    }

    public function edit(Rebroadcast $rebroadcast): View
    {
        return view('admin.rebroadcasts.form', compact('rebroadcast'));
    }

    public function update(Request $request, Rebroadcast $rebroadcast): RedirectResponse
    {
        $data = $this->validated($request);

        $embed = Rebroadcast::buildEmbed($data['video_url']);
        $data['video_provider'] = $embed['provider'];
        $data['embed_url'] = $embed['embed'];

        $rebroadcast->update($data);

        return redirect()->route('admin.rebroadcasts.index')->with('status', 'Service updated.');
    }

    public function destroy(Rebroadcast $rebroadcast): RedirectResponse
    {
        $rebroadcast->delete();

        return redirect()->route('admin.rebroadcasts.index')->with('status', 'Service removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'video_url' => ['required', 'string', 'max:500'],
            'title' => ['required', 'string', 'max:180'],
            'speaker' => ['nullable', 'string', 'max:120'],
            'series' => ['nullable', 'string', 'max:120'],
            'scripture_reference' => ['nullable', 'string', 'max:180'],
            'bulletin' => ['nullable', 'string'],
            'status' => ['required', 'in:active,scheduled,archived'],
            'scheduled_at' => ['nullable', 'date'],
        ]);
    }
}
