@props([
    'post' => null
])

<article class="c-card">
    @if($post && $post->image)
        <div class="c-card__cover">
            <a href="{{ route('posts.show', $post) }}">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" loading="lazy">
            </a>
        </div>
    @elseif($post)
        <div class="c-card__cover c-card__cover--placeholder">
            <div class="c-card__placeholder-pattern">
                <span class="c-card__tag-icon">⚡</span>
                <span class="c-card__tag-text">{{ $post->category ?? 'Tech Article' }}</span>
            </div>
        </div>
    @endif

    <div class="c-card__body">
        @if($post)
            <div class="c-card__meta">
                <span class="c-card__category">{{ $post->category }}</span>
                <span class="c-card__separator">•</span>
                <span class="c-card__date">{{ $post->created_at->format('d M Y') }}</span>
                <span class="c-card__separator">•</span>
                <span class="c-card__readtime">{{ $post->read_time }}</span>
            </div>

            <h3 class="c-card__title">
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
            </h3>

            <p class="c-card__excerpt">
                {{ Str::limit(strip_tags($post->body), 120, '...') }}
            </p>

            <div class="c-card__footer">
                <a href="{{ route('posts.show', $post) }}" class="c-card__link">
                    Baca Selengkapnya
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
                
                <div class="c-card__actions">
                    <a href="{{ route('posts.edit', $post) }}" class="btn-icon btn-icon--edit" title="Edit Artikel">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </a>

                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon btn-icon--delete" title="Hapus Artikel">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @else
            {{ $slot }}
        @endif
    </div>
</article>
