@extends('layouts.app')

@section('title', 'Edit Artikel: ' . $post->title . ' — DevJournal')

@section('content')
<div style="max-width: 760px; margin: 0 auto;">
    <!-- Breadcrumb & Back -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('posts.show', $post) }}" class="btn btn-outline" style="border: none; padding-left: 0; font-size: 0.88rem; color: var(--text-secondary);">
            &larr; Batal &amp; Kembali ke Artikel
        </a>
        <span style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--text-tertiary);">
            ID Post: #{{ $post->id }}
        </span>
    </div>

    <!-- Form Container -->
    <div style="background: var(--bg-surface); border: 1px solid var(--border-default); border-radius: var(--radius-lg); padding: 2.2rem; box-shadow: var(--shadow-sm);">
        <div style="border-bottom: 1px solid var(--border-subtle); padding-bottom: 1.25rem; margin-bottom: 2rem;">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--accent-primary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
                Edit Mode
            </div>
            <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; margin-bottom: 0.35rem;">
                Perbarui Artikel Blog
            </h1>
            <p style="color: var(--text-secondary); font-size: 0.92rem;">
                Sesuaikan isi materi atau perbaiki rincian artikel di bawah ini.
            </p>
        </div>

        <!-- Requirement 7: @csrf & @method('PUT') -->
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Judul Artikel (Requirement 5: old() dengan fallback data saat ini) -->
            <div class="form-group">
                <label for="title" class="form-label">
                    Judul Artikel <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $post->title) }}" 
                    class="form-control @error('title') is-invalid @enderror"
                    required
                >
                @error('title')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Kategori -->
            <div class="form-group">
                <label for="category" class="form-label">
                    Kategori <span class="required">*</span>
                </label>
                <select id="category" name="category" class="form-control @error('category') is-invalid @enderror" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $post->category) === $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Bonus 3: Upload Sampul / Gambar Baru -->
            <div class="form-group">
                <label for="image" class="form-label">
                    Gambar Sampul <span style="font-weight: 400; color: var(--text-tertiary);">(Opsional, Biarkan kosong jika tidak ingin mengubah)</span>
                </label>

                @if($post->image)
                    <div style="margin-bottom: 0.85rem; display: flex; align-items: center; gap: 1rem; background: var(--bg-subtle); padding: 0.65rem 0.9rem; border-radius: var(--radius-md);">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Sampul Saat Ini" style="width: 70px; height: 50px; object-fit: cover; border-radius: var(--radius-sm);">
                        <div>
                            <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); display: block;">Gambar Saat Ini</span>
                            <span style="font-size: 0.75rem; color: var(--text-tertiary);">Upload file baru di bawah ini jika ingin mengganti</span>
                        </div>
                    </div>
                @endif

                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    accept="image/*"
                    class="form-control @error('image') is-invalid @enderror"
                    onchange="previewImage(this)"
                >
                @error('image')
                    <span class="form-error">{{ $message }}</span>
                @enderror

                <!-- New Image Preview -->
                <div id="image-preview-container" style="display: none; margin-top: 1rem;">
                    <span style="font-size: 0.75rem; font-weight: 600; color: var(--accent-primary); display: block; margin-bottom: 0.35rem;">Pratinjau Gambar Baru:</span>
                    <img id="image-preview" src="#" alt="Pratinjau Gambar Baru" style="max-height: 220px; border-radius: var(--radius-md); border: 1px solid var(--border-default); object-fit: cover;">
                </div>
            </div>

            <!-- Konten Artikel -->
            <div class="form-group">
                <label for="body" class="form-label">
                    Konten Lengkap Artikel <span class="required">*</span>
                </label>
                <textarea 
                    id="body" 
                    name="body" 
                    rows="10" 
                    class="form-control @error('body') is-invalid @enderror"
                    required
                >{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.85rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <a href="{{ route('posts.show', $post) }}" class="btn btn-outline">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary" style="padding: 0.7rem 1.6rem;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const previewContainer = document.getElementById('image-preview-container');
        const previewImg = document.getElementById('image-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.style.display = 'none';
        }
    }
</script>
@endpush
