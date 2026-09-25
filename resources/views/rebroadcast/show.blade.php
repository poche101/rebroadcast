<x-layouts.app :title="($rebroadcast->title ?? 'Worship With Us') . ' — ' . config('app.name')">

    <section id="watch" class="max-w-5xl mx-auto px-6 pt-10 pb-6">

        @if ($rebroadcast)
            <div class="flex items-center gap-2 mb-4">
                @if ($rebroadcast->status === 'active')
                    <span
                        class="inline-flex items-center gap-1.5 text-xs font-medium tracking-wide text-white bg-navy-900 rounded-full px-3 py-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-olive-500 animate-pulse"></span>
                        Rebroadcasting now
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 text-xs font-medium tracking-wide text-stone-700 bg-linen-200 rounded-full px-3 py-1">
                        <x-icon name="clock" class="w-3.5 h-3.5" />
                        Upcoming service
                    </span>
                @endif
                @if ($rebroadcast->series)
                    <span class="text-xs text-stone-500">{{ $rebroadcast->series }}</span>
                @endif

                @if ($rebroadcast->status === 'active')
                    <div
                        class="ml-auto flex items-center gap-2 bg-white/70 border border-stone-200 rounded-full pl-2.5 pr-3 py-1">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-slateblue-500 opacity-60"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-slateblue-500"></span>
                        </span>
                        <span class="text-xs text-stone-600">
                            <span class="font-semibold text-stone-900" x-text="$store.presence.names.length"></span>
                            watching now
                        </span>
                    </div>
                @endif
            </div>

            <h1 class="font-serif text-3xl sm:text-4xl text-stone-900 leading-tight max-w-prose">
                {{ $rebroadcast->title }}
            </h1>
            <p class="mt-2 text-stone-600">
                @if ($rebroadcast->speaker)
                    {{ $rebroadcast->speaker }}
                @endif
                @if ($rebroadcast->scripture_reference)
                    <span class="text-stone-400">&middot;</span> {{ $rebroadcast->scripture_reference }}
                @endif
            </p>

            @if ($rebroadcast->bulletin)
                <div
                    class="mt-4 flex items-start gap-2.5 bg-linen-200/60 border border-stone-200 rounded-md px-4 py-3 max-w-prose">
                    <x-icon name="inbox" class="w-4 h-4 mt-0.5 text-slateblue-500 shrink-0" />
                    <p class="text-sm text-stone-700 whitespace-pre-line">{{ $rebroadcast->bulletin }}</p>
                </div>
            @endif
        @else
            <h1 class="font-serif text-3xl sm:text-4xl text-stone-900">Welcome, friend.</h1>
            <p class="mt-2 text-stone-600 max-w-prose">There's no service rebroadcasting at the moment. Please check
                back soon.</p>
        @endif

        <div class="mt-8 grid md:grid-cols-12 gap-6">

            {{-- Player — the main event --}}
            <div class="md:col-span-8">
                <div class="relative w-full aspect-video rounded-lg overflow-hidden bg-navy-900 shadow-soft">
                    @if ($rebroadcast && $rebroadcast->status === 'active')
                        <iframe src="{{ $rebroadcast->embed_url }}" class="absolute inset-0 w-full h-full"
                            title="{{ $rebroadcast->title }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    @elseif ($rebroadcast && $rebroadcast->status === 'scheduled')
                        <div x-data="countdown('{{ optional($rebroadcast->scheduled_at)->toIso8601String() }}')" x-init="tick();
                        setInterval(tick, 1000)"
                            class="absolute inset-0 flex flex-col items-center justify-center text-linen-100 text-center px-6">
                            <x-icon name="play" class="w-8 h-8 text-gold-400 mb-4" />
                            <p class="text-sm uppercase tracking-wide text-stone-400 mb-2">Begins in</p>
                            <p class="font-serif text-3xl sm:text-4xl" x-text="display"></p>
                            <p class="mt-3 text-sm text-stone-400" x-show="isPast" x-cloak>Refresh this page — the
                                service should be starting.</p>
                        </div>
                    @else
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center text-stone-400 text-center px-6">
                            <x-icon name="video-camera" class="w-8 h-8 mb-3" />
                            <p class="text-sm">Nothing is broadcasting right now.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar: tabs first, participants underneath --}}
            <div class="md:col-span-4 flex flex-col gap-4">

                {{-- Prayer / Comments / Give --}}
                <div x-data="{ tab: 'prayer' }"
                    class="bg-white/60 border border-stone-200 rounded-lg shadow-soft flex flex-col">

                    <div class="flex border-b border-stone-200 px-2">
                        <button @click="tab = 'prayer'" :class="tab === 'prayer' && 'is-active'"
                            class="tab-btn">Prayer</button>
                        <button @click="tab = 'comments'" :class="tab === 'comments' && 'is-active'"
                            class="tab-btn">Comments</button>
                        <button @click="tab = 'give'" :class="tab === 'give' && 'is-active'"
                            class="tab-btn">Give</button>
                    </div>

                    <div class="p-4 flex-1 overflow-y-auto max-h-[440px]">

                        {{-- Prayer request --}}
                        <div x-show="tab === 'prayer'" x-data="{ anonymous: false }">
                            @if (session('prayer_submitted'))
                                <div
                                    class="mb-4 flex items-start gap-2.5 rounded-md bg-olive-500/10 border border-olive-500/20 px-3.5 py-3">
                                    <x-icon name="check" class="w-4 h-4 mt-0.5 text-olive-600 shrink-0" />
                                    <p class="text-sm text-olive-700">Thank you. Your request has been received, and our
                                        pastoral team will be praying with you.</p>
                                </div>
                            @endif

                            <p class="text-sm text-stone-600 mb-4">Send your prayer request</p>

                            <form method="POST" action="{{ route('prayer-requests.store') }}" class="space-y-3.5">
                                @csrf
                                @if ($rebroadcast)
                                    <input type="hidden" name="rebroadcast_id" value="{{ $rebroadcast->id }}">
                                @endif

                                <textarea name="request_text" rows="4" required placeholder=""
                                    class="w-full text-sm rounded-md border border-stone-200 focus:border-gold-500 focus:ring-gold-500/30 bg-linen-50">{{ old('request_text') }}</textarea>

                                <label class="flex items-center gap-2 text-sm text-stone-600">
                                    <input type="checkbox" name="is_anonymous" value="1" x-model="anonymous"
                                        class="rounded border-stone-200 text-gold-600 focus:ring-gold-500/40">
                                    Submit anonymously
                                </label>

                                <div x-show="!anonymous" class="space-y-3">
                                    <input type="text" name="name" placeholder="Your name (optional)"
                                        value="{{ old('name') }}"
                                        class="w-full text-sm rounded-md border border-stone-200 focus:border-gold-500 focus:ring-gold-500/30 bg-linen-50 px-3.5 py-3">
                                    <input type="text" name="contact" placeholder="Email or phone (optional)"
                                        value="{{ old('contact') }}"
                                        class="w-full text-sm rounded-md border border-stone-200 focus:border-gold-500 focus:ring-gold-500/30 bg-linen-50 px-3.5 py-3">
                                </div>

                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 bg-navy-900 hover:bg-navy-800 text-linen-50 text-sm font-medium rounded-md px-4 py-2.5 transition-colors">
                                    <x-icon name="heart" class="w-4 h-4" />
                                    Send prayer request
                                </button>
                            </form>
                        </div>

                        {{-- Comments: list above, composer below — posts via fetch, no page reload --}}
                        <div x-show="tab === 'comments'" x-cloak x-data="commentsPanel(@js(
                                $comments->map(
                                    fn($c) => [
                                        'name' => $c->user->name ?? 'A member',
                                        'is_admin' => (bool) $c->is_admin_comment,
                                        'time' => $c->created_at->diffForHumans(),
                                        'body' => $c->body,
                                    ],
                                ),
                            ), @js($rebroadcast->id))">
                            <div class="space-y-3.5 mb-5">
                                <template x-if="comments.length === 0">
                                    <p class="text-sm text-stone-500">No comments yet — be the first to say hello.</p>
                                </template>
                                <template x-for="(comment, i) in comments" :key="i">
                                    <div>
                                        <p class="text-sm">
                                            <span class="font-medium text-stone-900" x-text="comment.name"></span>
                                            <span x-show="comment.is_admin"
                                                class="ml-1 inline-flex text-[10px] font-medium uppercase tracking-wide rounded-full px-1.5 py-0.5 bg-gold-500/15 text-gold-600">Media
                                                team</span>
                                            <span class="text-stone-400 text-xs ml-1.5" x-text="comment.time"></span>
                                        </p>
                                        <p class="text-sm text-stone-700" x-text="comment.body"></p>
                                    </div>
                                </template>
                            </div>

                            @if ($rebroadcast)
                                <div class="pt-4 border-t border-stone-200">
                                    <p x-show="error" x-cloak x-text="error" class="text-xs text-red-600 mb-2"></p>
                                    <textarea x-model="draft" @keydown.enter.meta.prevent="send()" rows="2"
                                        placeholder="Say something to the church family..."
                                        class="w-full text-sm rounded-md border border-stone-200 focus:border-gold-500 focus:ring-gold-500/30 bg-linen-50"></textarea>
                                    <button type="button" @click="send()" :disabled="sending || !draft.trim()"
                                        class="mt-2 inline-flex items-center gap-2 bg-navy-900 hover:bg-navy-800 disabled:opacity-50 disabled:cursor-not-allowed text-linen-50 text-xs font-medium rounded-md px-3.5 py-2 transition-colors">
                                        <span x-show="!sending">Post comment</span>
                                        <span x-show="sending" x-cloak>Posting…</span>
                                    </button>
                                </div>
                            @endif
                        </div>

                        {{-- Give: account details, no button --}}
                        <div x-show="tab === 'give'" x-cloak class="py-1">
                            <div class="flex items-center gap-3 mb-5">
                                <span
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-gold-500/10 text-gold-600 shrink-0">
                                    <x-icon name="gift" class="w-5 h-5" />
                                </span>
                                <p class="text-sm text-stone-600">Give your offering</p>
                            </div>

                            <div class="space-y-3">
                                <div class="rounded-md border border-stone-200 bg-linen-50 px-4 py-3">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-gold-600 mb-2">
                                        Espees</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-stone-500">Wallet ID</span>
                                        <span
                                            class="text-sm font-medium text-stone-900">{{ config('services.giving.espees_id', 'Not set') }}</span>
                                    </div>
                                </div>

                                <div class="rounded-md border border-stone-200 bg-linen-50 px-4 py-3 space-y-2">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-gold-600 mb-1">Naira
                                        &middot; Bank transfer</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-stone-500">Bank</span>
                                        <span
                                            class="text-sm font-medium text-stone-900">{{ config('services.giving.bank_name', 'Not set') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-stone-500">Account name</span>
                                        <span
                                            class="text-sm font-medium text-stone-900">{{ config('services.giving.account_name', 'Not set') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-stone-500">Account number</span>
                                        <span
                                            class="text-sm font-medium text-stone-900 tracking-wide">{{ config('services.giving.account_number', 'Not set') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Participants — sits below the tab card --}}
                @if ($rebroadcast)
                    <div x-data x-init="$store.presence.ping('{{ $rebroadcast->id }}');
                    setInterval(() => $store.presence.ping('{{ $rebroadcast->id }}'), 15000)"
                        class="bg-white/60 border border-stone-200 rounded-lg shadow-soft px-4 py-3 flex flex-wrap items-center gap-1.5">
                        <span class="text-xs text-stone-500 mr-1">Here now:</span>
                        <template x-for="name in $store.presence.names" :key="name">
                            <span
                                class="inline-flex items-center gap-1 text-xs text-stone-700 bg-linen-200 rounded-full pl-1 pr-2.5 py-1">
                                <span
                                    class="w-4 h-4 rounded-full bg-slateblue-500 text-white flex items-center justify-center text-[9px] font-medium"
                                    x-text="$store.presence.initials(name)"></span>
                                <span x-text="name"></span>
                            </span>
                        </template>
                        <span x-show="$store.presence.names.length === 0" x-cloak
                            class="text-xs text-stone-400">You're the first one here.</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if ($recentArchive->isNotEmpty())
        <section class="max-w-5xl mx-auto px-6 py-16 mt-4 border-t border-stone-200">
            <div class="flex items-end justify-between mb-8">
                <h2 class="font-serif text-2xl text-stone-900">Recently rebroadcast</h2>
                <span class="text-xs uppercase tracking-wide text-stone-400">Archive</span>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($recentArchive as $item)
                    <article
                        class="group bg-white border border-stone-200 rounded-xl p-5 shadow-sm hover:shadow-soft hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-center justify-between mb-3">
                            <span
                                class="inline-flex items-center gap-1.5 text-[11px] font-medium uppercase tracking-wide text-slateblue-600 bg-slateblue-500/10 rounded-full px-2.5 py-1">
                                <x-icon name="video-camera" class="w-3 h-3" />
                                {{ optional($item->scheduled_at)->format('M j, Y') }}
                            </span>
                            <x-icon name="arrow-right"
                                class="w-4 h-4 text-stone-300 group-hover:text-gold-500 group-hover:translate-x-0.5 transition-all" />
                        </div>
                        <p class="font-serif text-lg text-stone-900 leading-snug">{{ $item->title }}</p>
                        @if ($item->speaker)
                            <p class="text-xs text-stone-500 mt-1.5">{{ $item->speaker }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('presence', {
                names: [],
                initials(name) {
                    return name.split(' ').map(p => p[0]).join('').slice(0, 2).toUpperCase();
                },
                async ping(rebroadcastId) {
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').content;
                        const res = await fetch('{{ route('presence.ping') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                rebroadcast_id: rebroadcastId
                            }),
                        });
                        const data = await res.json();
                        this.names = data.participants.map(p => p.name);
                    } catch (e) {
                        /* quietly ignore — presence is a nice-to-have */ }
                }
            });
        });

        function countdown(iso) {
            return {
                display: '',
                isPast: false,
                tick() {
                    if (!iso) {
                        this.display = 'Soon';
                        return;
                    }
                    const diff = new Date(iso).getTime() - Date.now();
                    if (diff <= 0) {
                        this.isPast = true;
                        this.display = "Any moment now";
                        return;
                    }
                    const d = Math.floor(diff / 86400000);
                    const h = Math.floor((diff % 86400000) / 3600000);
                    const m = Math.floor((diff % 3600000) / 60000);
                    const s = Math.floor((diff % 60000) / 1000);
                    this.display = d > 0 ? `${d}d ${h}h ${m}m` :
                        `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
                }
            }
        }

        function commentsPanel(initialComments, rebroadcastId) {
            return {
                comments: initialComments || [],
                draft: '',
                sending: false,
                error: null,
                async send() {
                    if (!this.draft.trim() || this.sending) return;
                    this.sending = true;
                    this.error = null;
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').content;
                        const res = await fetch('{{ route('comments.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                rebroadcast_id: rebroadcastId,
                                body: this.draft,
                            }),
                        });
                        if (!res.ok) throw new Error('Failed to post comment');
                        const data = await res.json();
                        this.comments.unshift({
                            name: (data.comment && data.comment.user && data.comment.user.name) || 'You',
                            is_admin: (data.comment && data.comment.is_admin_comment) || false,
                            time: 'just now',
                            body: this.draft,
                        });
                        this.draft = '';
                    } catch (e) {
                        this.error = 'Something went wrong — please try again.';
                    } finally {
                        this.sending = false;
                    }
                }
            }
        }
    </script>
</x-layouts.app>
