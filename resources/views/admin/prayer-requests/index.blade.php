<x-layouts.admin title="Prayer requests" subtitle="Private submissions from the congregation">

    <div class="flex flex-wrap gap-2 mb-6">
        @foreach (['' => 'All', 'new' => 'New', 'prayed_for' => 'Prayed for', 'followed_up' => 'Followed up'] as $val => $label)
            <a href="{{ route('admin.prayer-requests.index', $val ? ['status' => $val] : []) }}"
               class="inline-flex items-center gap-1.5 text-xs font-medium rounded-full px-3 py-1.5 border transition-colors
                      {{ request('status', '') === $val ? 'bg-navy-900 text-white border-navy-900' : 'text-stone-600 border-stone-800/15 hover:border-stone-800/30' }}">
                {{ $label }}
                @if ($val && isset($counts[$val]))
                    <span class="opacity-70">{{ $counts[$val] }}</span>
                @endif
            </a>
        @endforeach
    </div>

    <div class="space-y-4 max-w-2xl">
        @forelse ($requests as $request)
            <div class="bg-white border border-stone-800/10 rounded-lg shadow-soft p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-stone-900">
                            {{ $request->is_anonymous ? 'Anonymous' : ($request->name ?: 'No name given') }}
                        </p>
                        <p class="text-xs text-stone-500 mt-0.5">
                            {{ $request->created_at->format('M j, Y g:i A') }}
                            @if ($request->rebroadcast)
                                <span class="text-stone-400">&middot;</span> {{ $request->rebroadcast->title }}
                            @endif
                            @if ($request->contact)
                                <span class="text-stone-400">&middot;</span> {{ $request->contact }}
                            @endif
                        </p>
                    </div>
                    <form method="POST" action="{{ route('admin.prayer-requests.update-status', $request) }}">
                        @csrf @method('PATCH')
                        <select name="status" onchange="this.form.submit()"
                            class="text-xs rounded-md border-stone-800/15 focus:border-gold-500 focus:ring-gold-500/30">
                            @foreach (['new' => 'New', 'prayed_for' => 'Prayed for', 'followed_up' => 'Followed up'] as $val => $label)
                                <option value="{{ $val }}" @selected($request->status === $val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <p class="mt-3.5 text-sm text-stone-700 leading-relaxed">{{ $request->request_text }}</p>
            </div>
        @empty
            <div class="text-center py-16 text-stone-500 text-sm">
                <x-icon name="inbox" class="w-8 h-8 mx-auto mb-3 text-stone-400" />
                No prayer requests here yet.
            </div>
        @endforelse
    </div>

    <div class="mt-6 max-w-2xl">{{ $requests->links() }}</div>
</x-layouts.admin>
