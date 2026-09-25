@php $editing = $rebroadcast->exists; @endphp

<x-layouts.admin :title="$editing ? 'Edit service' : 'New service'" subtitle="Paste a link and fill in the details — it publishes immediately.">

    <form method="POST" action="{{ $editing ? route('admin.rebroadcasts.update', $rebroadcast) : route('admin.rebroadcasts.store') }}" class="max-w-2xl space-y-6">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="bg-white border border-stone-800/10 rounded-lg shadow-soft p-6 space-y-5">
            <div>
                <label class="block text-sm font-medium text-stone-800 mb-1.5">Video link</label>
                <input type="text" name="video_url" required value="{{ old('video_url', $rebroadcast->video_url) }}"
                    placeholder="https://youtube.com/watch?v=... or https://vimeo.com/..."
                    class="w-full text-sm rounded-md border border-stone-600 py-3 px-3.5 focus:border-gold-500 focus:ring-gold-500/30">
                <p class="mt-1 text-xs text-stone-500">YouTube, Vimeo, or a direct MP4/HLS link. We'll detect the format automatically.</p>
                @error('video_url') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-800 mb-1.5">Sermon title</label>
                <input type="text" name="title" required value="{{ old('title', $rebroadcast->title) }}"
                    class="w-full text-sm rounded-md border border-stone-600 py-3 px-3.5 focus:border-gold-500 focus:ring-gold-500/30">
                @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-stone-800 mb-1.5">Preacher / speaker</label>
                    <input type="text" name="speaker" value="{{ old('speaker', $rebroadcast->speaker) }}"
                        class="w-full text-sm rounded-md border border-stone-600 py-3 px-3.5 focus:border-gold-500 focus:ring-gold-500/30">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-800 mb-1.5">Series</label>
                    <input type="text" name="series" value="{{ old('series', $rebroadcast->series) }}"
                        class="w-full text-sm rounded-md border border-stone-600 py-3 px-3.5 focus:border-gold-500 focus:ring-gold-500/30">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-800 mb-1.5">Scripture reference</label>
                <input type="text" name="scripture_reference" value="{{ old('scripture_reference', $rebroadcast->scripture_reference) }}"
                    placeholder="e.g. Romans 8:28–31"
                    class="w-full text-sm rounded-md border border-stone-600 py-3 px-3.5 focus:border-gold-500 focus:ring-gold-500/30">
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-800 mb-1.5">Bulletin / announcements</label>
                <textarea name="bulletin" rows="3" placeholder="Shown as a banner under the title on the public page"
                    class="w-full text-sm rounded-md border border-stone-600 py-3 px-3.5 focus:border-gold-500 focus:ring-gold-500/30">{{ old('bulletin', $rebroadcast->bulletin) }}</textarea>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-stone-800 mb-1.5">Status</label>
                    <select name="status" class="w-full text-sm rounded-md border border-stone-600 py-3 px-3.5 focus:border-gold-500 focus:ring-gold-500/30">
                        @foreach (['scheduled' => 'Upcoming', 'active' => 'Live rebroadcast', 'archived' => 'Archived'] as $val => $label)
                            <option value="{{ $val }}" @selected(old('status', $rebroadcast->status) === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-800 mb-1.5">Scheduled date &amp; time</label>
                    <input type="datetime-local" name="scheduled_at"
                        value="{{ old('scheduled_at', optional($rebroadcast->scheduled_at)->format('Y-m-d\TH:i')) }}"
                        class="w-full text-sm rounded-md border border-stone-600 py-3 px-3.5 focus:border-gold-500 focus:ring-gold-500/30">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="inline-flex items-center gap-2 bg-navy-900 hover:bg-navy-800 text-white text-sm font-medium rounded-md px-5 py-2.5 transition-colors">
                <x-icon name="check" class="w-4 h-4" />
                {{ $editing ? 'Save changes' : 'Publish service' }}
            </button>
            <a href="{{ route('admin.rebroadcasts.index') }}" class="inline-flex items-center gap-2 border border-stone-300 hover:bg-stone-50 text-stone-700 text-sm font-medium rounded-md px-5 py-2.5 transition-colors">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
