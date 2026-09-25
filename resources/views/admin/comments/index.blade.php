<x-layouts.admin title="Comments" subtitle="See every comment across services, and post as the media team">

    <div class="grid lg:grid-cols-3 gap-8" x-data="{ open: false, pendingForm: null }">

        <div class="lg:col-span-2">
            <div class="flex flex-wrap gap-2 mb-5">
                <a href="{{ route('admin.comments.index') }}"
                   class="text-xs font-medium rounded-full px-3 py-1.5 border {{ ! request('rebroadcast_id') ? 'bg-navy-900 text-white border-navy-900' : 'text-stone-600 border-stone-800/15' }}">
                    All services
                </a>
                @foreach ($rebroadcasts as $r)
                    <a href="{{ route('admin.comments.index', ['rebroadcast_id' => $r->id]) }}"
                       class="text-xs font-medium rounded-full px-3 py-1.5 border {{ request('rebroadcast_id') === $r->id ? 'bg-navy-900 text-white border-navy-900' : 'text-stone-600 border-stone-800/15' }}">
                        {{ $r->title }}
                    </a>
                @endforeach
            </div>

            <div class="space-y-3">
                @forelse ($comments as $comment)
                    <div class="bg-white border border-stone-800/10 rounded-lg p-4 flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm">
                                <span class="font-medium text-stone-900">{{ $comment->user->name }}</span>
                                @if ($comment->is_admin_comment)
                                    <span class="ml-1.5 inline-flex text-[10px] font-medium uppercase tracking-wide rounded-full px-2 py-0.5 bg-gold-500/15 text-gold-600">Media team</span>
                                @endif
                                <span class="text-stone-400 text-xs ml-2">on {{ $comment->rebroadcast->title }}</span>
                            </p>
                            <p class="mt-1 text-sm text-stone-700">{{ $comment->body }}</p>
                            <p class="mt-1 text-xs text-stone-400">{{ $comment->created_at->format('M j, Y g:i A') }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" x-ref="deleteForm{{ $loop->index }}">
                            @csrf @method('DELETE')
                            <button type="button" @click="pendingForm = $refs['deleteForm{{ $loop->index }}']; open = true" class="text-stone-400 hover:text-red-600">
                                <x-icon name="trash" class="w-4 h-4" />
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-16 text-stone-500 text-sm">No comments yet.</div>
                @endforelse
            </div>

            <div class="mt-6">{{ $comments->links() }}</div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white border border-stone-800/10 rounded-lg shadow-soft p-5 sticky top-8">
                <h2 class="font-serif text-lg text-stone-900 mb-4">Post as the media team</h2>
                <form method="POST" action="{{ route('admin.comments.store') }}" class="space-y-3.5">
                    @csrf
                    <div>
                        <label class="block text-xs uppercase tracking-wide text-stone-500 mb-1.5">Service</label>
                        <select name="rebroadcast_id" required class="w-full text-sm rounded-md border border-stone-600 py-3 px-3.5 focus:border-gold-500 focus:ring-gold-500/30">
                            @foreach ($rebroadcasts as $r)
                                <option value="{{ $r->id }}" @selected(request('rebroadcast_id') === $r->id)>{{ $r->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <textarea name="body" rows="4" required placeholder="Share an announcement or reply..."
                        class="w-full text-sm rounded-md border border-stone-600 py-3 px-3.5 focus:border-gold-500 focus:ring-gold-500/30"></textarea>
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-navy-900 hover:bg-navy-800 text-white text-sm font-medium rounded-md px-4 py-2.5 transition-colors">
                        Post comment
                    </button>
                </form>
            </div>
        </div>

        {{-- Delete confirmation modal --}}
        <div x-show="open" x-cloak @keydown.escape.window="open = false" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-stone-900/40" @click="open = false"></div>
            <div class="relative bg-white rounded-lg shadow-soft max-w-sm w-full p-6">
                <h3 class="font-serif text-lg text-stone-900 mb-2">Remove this comment?</h3>
                <p class="text-sm text-stone-600 mb-6">This can't be undone.</p>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="open = false" class="text-sm text-stone-500 hover:text-stone-800 px-3 py-2">Cancel</button>
                    <button type="button" @click="pendingForm.submit(); open = false" class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md px-4 py-2 transition-colors">Delete</button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
