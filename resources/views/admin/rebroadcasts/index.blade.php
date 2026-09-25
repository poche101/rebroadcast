<x-layouts.admin title="Rebroadcasts" subtitle="Manage what's playing on the public platform">

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-stone-800/10 rounded-lg p-4">
            <p class="text-xs uppercase tracking-wide text-stone-500">Live now</p>
            <p class="mt-1.5 font-serif text-2xl text-olive-600">{{ $stats['live'] }}</p>
        </div>
        <div class="bg-white border border-stone-800/10 rounded-lg p-4">
            <p class="text-xs uppercase tracking-wide text-stone-500">Upcoming</p>
            <p class="mt-1.5 font-serif text-2xl text-slateblue-600">{{ $stats['scheduled'] }}</p>
        </div>
        <div class="bg-white border border-stone-800/10 rounded-lg p-4">
            <p class="text-xs uppercase tracking-wide text-stone-500">Archived</p>
            <p class="mt-1.5 font-serif text-2xl text-stone-700">{{ $stats['archived'] }}</p>
        </div>
        <a href="{{ route('admin.prayer-requests.index', ['status' => 'new']) }}" class="bg-white border border-stone-800/10 rounded-lg p-4 hover:border-gold-500/40 transition-colors">
            <p class="text-xs uppercase tracking-wide text-stone-500">New prayer requests</p>
            <p class="mt-1.5 font-serif text-2xl text-gold-600">{{ $stats['new_prayer_requests'] }}</p>
        </a>
    </div>

    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.rebroadcasts.create') }}"
           class="inline-flex items-center gap-2 bg-navy-900 hover:bg-navy-800 text-white text-sm font-medium rounded-md px-4 py-2.5 transition-colors">
            <x-icon name="plus" class="w-4 h-4" />
            New service
        </a>
    </div>

    <div class="bg-white border border-stone-800/10 rounded-lg shadow-soft overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs uppercase tracking-wide text-stone-500 border-b border-stone-800/10">
                    <th class="px-5 py-3.5 font-medium">Service</th>
                    <th class="px-5 py-3.5 font-medium">Status</th>
                    <th class="px-5 py-3.5 font-medium">Scheduled</th>
                    <th class="px-5 py-3.5 font-medium">Prayer requests</th>
                    <th class="px-5 py-3.5 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-800/10">
                @forelse ($rebroadcasts as $item)
                    <tr class="hover:bg-linen-50/60">
                        <td class="px-5 py-4">
                            <p class="font-medium text-stone-900">{{ $item->title }}</p>
                            <p class="text-xs text-stone-500">{{ $item->speaker }}</p>
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $badge = [
                                    'active' => 'bg-olive-500/10 text-olive-700',
                                    'scheduled' => 'bg-slateblue-500/10 text-slateblue-600',
                                    'archived' => 'bg-stone-800/10 text-stone-600',
                                ][$item->status];
                            @endphp
                            <span class="inline-flex text-xs font-medium rounded-full px-2.5 py-1 {{ $badge }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-stone-600">
                            {{ optional($item->scheduled_at)->format('M j, Y g:i A') ?? '—' }}
                        </td>
                        <td class="px-5 py-4 text-stone-600">{{ $item->prayer_requests_count }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.rebroadcasts.edit', $item) }}" class="text-stone-500 hover:text-stone-900" title="Edit">
                                    <x-icon name="pencil" class="w-4 h-4" />
                                </a>
                                <form method="POST" action="{{ route('admin.rebroadcasts.destroy', $item) }}" onsubmit="return confirm('Remove this service?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-stone-500 hover:text-red-600" title="Delete">
                                        <x-icon name="trash" class="w-4 h-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-stone-500">
                            No services yet. <a href="{{ route('admin.rebroadcasts.create') }}" class="text-gold-600 hover:underline">Add your first one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $rebroadcasts->links() }}</div>
</x-layouts.admin>
