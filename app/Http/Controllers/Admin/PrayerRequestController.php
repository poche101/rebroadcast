<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrayerRequestController extends Controller
{
    public function index(Request $request): View
    {
        $requests = PrayerRequest::with('rebroadcast')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'new' => PrayerRequest::where('status', 'new')->count(),
            'prayed_for' => PrayerRequest::where('status', 'prayed_for')->count(),
            'followed_up' => PrayerRequest::where('status', 'followed_up')->count(),
        ];

        return view('admin.prayer-requests.index', compact('requests', 'counts'));
    }

    public function updateStatus(Request $request, PrayerRequest $prayerRequest): RedirectResponse
    {
        $request->validate(['status' => ['required', 'in:new,prayed_for,followed_up']]);

        $prayerRequest->update(['status' => $request->string('status')]);

        return back()->with('status', 'Prayer request updated.');
    }
}
