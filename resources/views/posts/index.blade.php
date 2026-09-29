@extends('layouts.app')

@section('title', 'Katalog Artikel & Catatan Engineering — DevJournal')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="margin-bottom: 2.5rem; text-align: center; padding: 2rem 1rem;">
    <div style="display: inline-block; padding: 0.3rem 0.85rem; background: var(--accent-subtle); color: var(--accent-primary); border-radius: var(--radius-full); font-size: 0.82rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">
        ⚡ Tech &amp; Engineering Journal
    </div>
    <h1 style="font-family: var(--font-serif); font-size: 2.6rem; font-weight: 700; line-height: 1.2; margin-bottom: 0.75rem; letter-spacing: -0.02em;">
        Wawasan &amp; Tutorial Pengembangan Web
    </h1>
    <p style="color: var(--text-secondary); max-width: 640px; margin: 0 auto 1.8rem; font-size: 1.05rem;">
        Kumpulan catatan arsitektur sistem, praktik terbaik clean code, dan eksplorasi teknologi terkini.
    </p>

    <!-- Bonus 1: Search Form & Category Filters -->
    <form action="{{ route('posts.index') }}" method="GET" class="search-box" style="max-width: 620px; margin: 0 auto; display: flex; gap: 0.5rem; background: var(--bg-surface); padding: 0.4rem; border-radius: var(--radius-lg); border: 1px solid var(--border-default); box-shadow: var(--shadow-sm);">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Cari berdasarkan judul, kategori, atau isi artikel..." 
            class="form-control" 
            style="border: none; box-shadow: none; padding: 0.6rem 0.9rem;"
            aria-label="Cari artikel"
        >
        @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        <button type="submit" class="btn btn-primary" style="padding: 0.6rem 1.4rem;">
            Cari
        </button>
        @if(request('search') || request('category'))
            <a href="{{ route('posts.index') }}" class="btn btn-outline" style="border: 1px solid var(--border-default);" title="Reset Filter">
                Reset
            </a>
        @endif
    </form>

    <!-- Category Filter Pills -->
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem; margin-top: 1.25rem;">
        <a href="{{ route('posts.index', array_merge(request()->except('category', 'page'), ['category' => 'all'])) }}" 
           class="filter-pill {{ !request('category') || request('category') == 'all' ? 'filter-pill--active' : '' }}">
            Semua ({{ \App\Models\Post::count() }})
        </a>
        @foreach($categories as $cat)
            @php
                $catCount = \App\Models\Post::where('category', $cat)->count();
            @endphp
            <a href="{{ route('posts.index', array_merge(request()->except('category', 'page'), ['category' => $cat])) }}" 
               class="filter-pill {{ request('category') == $cat ? 'filter-pill--active' : '' }}">
                {{ $cat }} ({{ $catCount }})
            </a>
        @endforeach
    </div>
</section>

<!-- Section Header -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-subtle); padding-bottom: 0.75rem;">
    <div>
        <h2 style="font-family: var(--font-serif); font-size: 1.4rem; font-weight: 600;">
            @if(request('search'))
                Hasil Pencarian: &ldquo;{{ request('search') }}&rdquo;
            @elseif(request('category') && request('category') !== 'all')
                Kategori: {{ request('category') }}
            @else
                Daftar Artikel Terbaru
            @endif
        </h2>
        <span style="font-size: 0.85rem; color: var(--text-tertiary);">
            Menampilkan {{ $posts->total() }} artikel total
        </span>
    </div>

    <a href="{{ route('posts.create') }}" class="btn btn-primary" style="font-size: 0.85rem;">
        + Buat Postingan Baru
    </a>
</div>

<!-- Posts Grid (Requirement 4: Card Component) -->
@if($posts->count() > 0)
    <div class="posts-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.6rem; margin-bottom: 2.5rem;">
        @foreach($posts as $post)
            <x-card :post="$post" />
        @endforeach
    </div>

    <!-- Requirement 8: Pagination Links -->
    <div class="pagination-wrapper" style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $posts->links() }}
    </div>
@else
    <!-- Empty State -->
    <div style="text-align: center; padding: 4rem 1.5rem; background: var(--bg-surface); border-radius: var(--radius-lg); border: 1px dashed var(--border-default); margin-bottom: 2rem;">
        <div style="font-size: 3rem; margin-bottom: 0.75rem;">📝</div>
        <h3 style="font-family: var(--font-serif); font-size: 1.3rem; margin-bottom: 0.5rem;">Belum ada artikel ditemukan</h3>
        <p style="color: var(--text-secondary); max-width: 420px; margin: 0 auto 1.5rem; font-size: 0.95rem;">
            @if(request('search'))
                Tidak ada artikel yang cocok dengan kata kunci &ldquo;{{ request('search') }}&rdquo;. Coba gunakan kata kunci lain atau reset filter.
            @else
                Mulai bagikan pengetahuan dan catatan teknismu sekarang dengan mempublikasikan artikel perdana.
            @endif
        </p>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            Tulis Artikel Pertama
        </a>
    </div>
@endif

@endsection

@push('styles')
<style>
    .filter-pill {
        display: inline-block;
        padding: 0.35rem 0.85rem;
        border-radius: var(--radius-full);
        background: var(--bg-surface);
        border: 1px solid var(--border-default);
        color: var(--text-secondary);
        font-size: 0.82rem;
        font-weight: 500;
        transition: var(--transition);
    }
    .filter-pill:hover {
        border-color: var(--accent-primary);
        color: var(--accent-primary);
    }
    .filter-pill--active {
        background: var(--accent-primary);
        color: white !important;
        border-color: var(--accent-primary);
    }

    /* Laravel Pagination Style Fix */
    .pagination-wrapper nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .pagination-wrapper svg {
        width: 18px;
        height: 18px;
    }
    .pagination-wrapper .flex.justify-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }
</style>
@endpush
