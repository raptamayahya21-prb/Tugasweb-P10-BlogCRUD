@extends('layouts.app')

@section('title', 'Tulis Artikel Baru — DevJournal')

@section('content')
<div style="max-width: 760px; margin: 0 auto;">
    <!-- Breadcrumb & Back -->
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('posts.index') }}" class="btn btn-outline" style="border: none; padding-left: 0; font-size: 0.88rem; color: var(--text-secondary);">
            &larr; Kembali ke Daftar Artikel
        </a>
    </div>

    <!-- Form Container -->
    <div style="background: var(--bg-surface); border: 1px solid var(--border-default); border-radius: var(--radius-lg); padding: 2.2rem; box-shadow: var(--shadow-sm);">
        <div style="border-bottom: 1px solid var(--border-subtle); padding-bottom: 1.25rem; margin-bottom: 2rem;">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--accent-primary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
                Editor Artikel
            </div>
            <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; margin-bottom: 0.35rem;">
                Publikasikan Artikel Baru
            </h1>
            <p style="color: var(--text-secondary); font-size: 0.92rem;">
                Lengkapi formulir di bawah ini untuk membuat dan mempublikasikan postingan baru ke blog.
            </p>
        </div>

        <!-- Requirement 7: @csrf & Bonus 3: enctype multipart -->
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Judul Artikel (Requirement 5: error per field & old input) -->
            <div class="form-group">
                <label for="title" class="form-label">
                    Judul Artikel <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}" 
                    class="form-control @error('title') is-invalid @enderror"
                    placeholder="Contoh: Memahami Arsitektur Clean Code pada Framework Laravel"
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
                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih kategori artikel...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Bonus 3: Upload Sampul / Gambar -->
            <div class="form-group">
                <label for="image" class="form-label">
                    Foto Sampul / Gambar Artikel <span style="font-weight: 400; color: var(--text-tertiary);">(Opsional, Maks 2MB)</span>
                </label>
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

                <!-- Image Preview -->
                <div id="image-preview-container" style="display: none; margin-top: 1rem;">
                    <img id="image-preview" src="#" alt="Pratinjau Gambar" style="max-height: 220px; border-radius: var(--radius-md); border: 1px solid var(--border-default); object-fit: cover;">
                </div>
            </div>

            <!-- Konten Artikel (Requirement 5) -->
            <div class="form-group">
                <label for="body" class="form-label">
                    Konten Lengkap Artikel <span class="required">*</span>
                </label>
                <textarea 
                    id="body" 
                    name="body" 
                    rows="10" 
                    class="form-control @error('body') is-invalid @enderror"
                    placeholder="Tuliskan isi pembahasan, tutorial, atau dokumentasi artikel di sini..."
                    required
                >{{ old('body') }}</textarea>
                @error('body')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.85rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <a href="{{ route('posts.index') }}" class="btn btn-outline">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary" style="padding: 0.7rem 1.6rem;">
                    Simpan &amp; Publikasikan
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
