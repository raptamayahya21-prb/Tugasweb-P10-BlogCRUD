@extends('layouts.app')

@section('title', $post->title . ' — DevJournal')

@section('content')
<article style="max-width: 820px; margin: 0 auto;">
    <!-- Navigation Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <a href="{{ route('posts.index') }}" class="btn btn-outline" style="border: none; padding-left: 0; font-size: 0.9rem; color: var(--text-secondary);">
            &larr; Kembali ke Semua Artikel
        </a>

        <!-- Action Buttons (Edit & Delete) -->
        <div style="display: flex; align-items: center; gap: 0.65rem;">
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline" style="font-size: 0.85rem; padding: 0.45rem 0.95rem;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Edit
            </a>

            <!-- Requirement 7: Form Delete dengan @csrf & @method('DELETE') -->
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini? Data akan disimpan di tempat sampah (soft delete).')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline" style="color: #EF4444; border-color: rgba(239, 68, 68, 0.3); font-size: 0.85rem; padding: 0.45rem 0.95rem;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Article Header -->
    <header style="margin-bottom: 2.2rem;">
        <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1rem;">
            <span style="display: inline-block; padding: 0.25rem 0.75rem; background: var(--accent-subtle); color: var(--accent-primary); border-radius: var(--radius-full); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;">
                {{ $post->category }}
            </span>
            <span style="color: var(--text-tertiary); font-size: 0.85rem;">•</span>
            <span style="color: var(--text-secondary); font-size: 0.88rem;">
                {{ $post->created_at->format('d F Y') }}
            </span>
            <span style="color: var(--text-tertiary); font-size: 0.85rem;">•</span>
            <span style="color: var(--text-secondary); font-size: 0.88rem;">
                ⏱️ {{ $post->read_time }}
            </span>
        </div>

        <h1 style="font-family: var(--font-serif); font-size: 2.5rem; font-weight: 700; line-height: 1.25; margin-bottom: 1.2rem; color: var(--text-primary); letter-spacing: -0.02em;">
            {{ $post->title }}
        </h1>

        <!-- Author Meta Box -->
        <div style="display: flex; align-items: center; gap: 0.85rem; padding-top: 1rem; border-top: 1px solid var(--border-subtle);">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #D97757, #8F3A22); color: white; display: grid; place-items: center; font-weight: 700; font-family: var(--font-mono);">
                DJ
            </div>
            <div>
                <div style="font-weight: 600; font-size: 0.95rem;">DevJournal Editorial</div>
                <div style="font-size: 0.8rem; color: var(--text-tertiary);">Diperbarui: {{ $post->updated_at->diffForHumans() }}</div>
            </div>
        </div>
    </header>

    <!-- Featured Image (Bonus 3) -->
    @if($post->image)
        <div style="margin-bottom: 2.5rem; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--border-default); box-shadow: var(--shadow-sm);">
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="width: 100%; max-height: 480px; object-fit: cover; display: block;">
        </div>
    @endif

    <!-- Article Content -->
    <div class="article-body" style="background: var(--bg-surface); border: 1px solid var(--border-default); border-radius: var(--radius-lg); padding: 2.5rem; margin-bottom: 3.5rem; box-shadow: var(--shadow-sm); font-size: 1.05rem; line-height: 1.8; color: var(--text-primary); white-space: pre-line;">
        {{ $post->body }}
    </div>

    <!-- Related Articles -->
    @if(isset($relatedPosts) && $relatedPosts->count() > 0)
        <section style="margin-top: 3.5rem; border-top: 1px solid var(--border-default); padding-top: 2.5rem;">
            <h2 style="font-family: var(--font-serif); font-size: 1.5rem; margin-bottom: 1.5rem;">
                Artikel Terkait dalam Kategori {{ $post->category }}
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.2rem;">
                @foreach($relatedPosts as $related)
                    <div style="background: var(--bg-surface); border: 1px solid var(--border-default); border-radius: var(--radius-md); padding: 1.2rem; transition: var(--transition);">
                        <span style="font-size: 0.75rem; color: var(--accent-primary); font-weight: 600; text-transform: uppercase;">{{ $related->category }}</span>
                        <h4 style="font-family: var(--font-serif); font-size: 1.05rem; margin: 0.4rem 0 0.8rem;">
                            <a href="{{ route('posts.show', $related) }}">{{ $related->title }}</a>
                        </h4>
                        <a href="{{ route('posts.show', $related) }}" style="font-size: 0.82rem; color: var(--accent-primary); font-weight: 600;">
                            Baca Artikel &rarr;
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</article>
@endsection
