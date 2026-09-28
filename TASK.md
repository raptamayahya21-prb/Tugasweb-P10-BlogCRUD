# 📋 TASK ROADMAP: Blog CRUD Laravel (Tugas Pertemuan 10)

Dokumen ini memuat panduan langkah demi langkah (*step-by-step*) pengerjaan proyek **Tugas Rutin 10 — Blog CRUD Laravel**, mulai dari inisialisasi basis data hingga fitur bonus, lengkap dengan checklist status.

---

## 🎯 Penjelasan & Tujuan Proyek (Bahasa Sederhana)

### Apa itu Proyek Ini?
Proyek ini adalah pembuatan aplikasi web **Blog sederhana** menggunakan framework **Laravel**. Di aplikasi ini, pengguna dapat mengelola artikel blog melalui 4 fungsi dasar data yang biasa disebut **CRUD**:
- **C (Create):** Membuat dan mempublikasikan postingan blog baru.
- **R (Read):** Membaca daftar postingan serta melihat isi detail artikel.
- **U (Update):** Mengubah atau memperbaiki isi postingan yang sudah ada.
- **D (Delete):** Menghapus artikel dari blog.

### Mengapa Tugas Ini Dibuat & Apa Tujuannya?
1. **Memahami Konsep Resource Controller & RESTful Routing:**
   Membiasakan penggunaan satu perintah rute (`Route::resource`) yang otomatis memetakan 7 fungsi kerja standar (index, create, store, show, edit, update, destroy) sehingga struktur URL aplikasi rapi dan standar industri.
2. **Mengenal Sistem Template Blade & Komponen Reusable:**
   Belajar membuat satu kerangka utama (*master layout*) dengan `@extends` dan `@yield`, serta memecah bagian tampilan yang sering dipakai berulang kali ke dalam komponen khusus (seperti kartu postingan `<x-card>` dan notifikasi pesan `<x-alert>`).
3. **Keamanan & Validasi Data Web:**
   Memastikan formulir tidak bisa dimanipulasi dengan proteksi token `@csrf`, verifikasi metode HTTP palsu (`@method('PUT')` / `@method('DELETE')`), serta menolak input kosong/tidak valid dengan pesan error per kolom dan menjaga teks yang sudah diketik pengguna tidak hilang (`old()`).
4. **Memberikan Pengalaman Pengguna (UX) yang Ramah:**
   Menyediakan pesan notifikasi sukses/gagal (*flash message*), navigasi halaman yang rapi jika data artikel banyak (*pagination*), serta fitur tambahan seperti pencarian (*search*), penghapusan aman (*soft delete*), dan lampiran foto (*upload gambar*).

---

## 📌 Matriks Checklist Kebutuhan

### ✅ Kriteria Wajib (8/8)
- [ ] **Req 1:** `Route::resource('posts')` + Named Routes standar
- [ ] **Req 2:** `PostController` Resource lengkap dengan 7 method (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`)
- [ ] **Req 3:** Blade Master Layout (`app.blade.php`) menggunakan direktif `@extends` & `@yield`
- [ ] **Req 4:** Minimal 2 Blade Component buatan sendiri/kustom (Komponen `Alert` & `Card`)
- [ ] **Req 5:** Validasi request + pesan error per field (`@error`) + pertahankan input lama (`old()`)
- [ ] **Req 6:** Flash session message untuk status sukses/gagal aksi CRUD
- [ ] **Req 7:** Proteksi `@csrf` di seluruh form + `@method('PUT')` untuk update & `@method('DELETE')` untuk hapus
- [ ] **Req 8:** Route Model Binding (`Post $post`) + Pagination data (`paginate()`)

### ⭐ Kriteria Bonus (3/3)
- [ ] **Bonus 1:** Fitur Pencarian Postingan (Search by title / content)
- [ ] **Bonus 2:** Fitur Soft Delete (Data tidak langsung lenyap dari DB menggunakan trait `SoftDeletes`)
- [ ] **Bonus 3:** Fitur Upload Gambar (Mendukung upload media gambar sampul/lampiran artikel)

---

## 🚀 Panduan Pengerjaan Step-by-Step

### Tahap 1: Konfigurasi Lingkungan & Database
- [ ] Pastikan file `.env` sudah terhubung ke database lokal (misal: MySQL di Laragon / SQLite).
- [ ] Buat file migration dan model untuk tabel `posts`:
  ```bash
  php artisan make:model Post -m
  ```
- [ ] Definisikan skema kolom di berkas migration `create_posts_table.php`:
  - `id` (bigIncrements atau uuid)
  - `title` (string)
  - `body` / `content` (text)
  - `image` (string, nullable - untuk bonus upload)
  - `timestamps` (`created_at`, `updated_at`)
  - `softDeletes` (untuk bonus soft delete)
- [ ] Konfigurasi Model `app/Models/Post.php`:
  - Tambahkan properti `$fillable = ['title', 'body', 'image'];`
  - Tambahkan trait `use Illuminate\Database\Eloquent\SoftDeletes;`
- [ ] Jalankan migration database:
  ```bash
  php artisan migrate
  ```

---

### Tahap 2: Routing & Controller (Resource 7 Methods)
- [ ] Di `routes/web.php`, definisikan redirect halaman awal dan route resource:
  ```php
  use App\Http\Controllers\PostController;

  Route::redirect('/', '/posts');
  Route::resource('posts', PostController::class);
  ```
- [ ] Buat Resource Controller:
  ```bash
  php artisan make:controller PostController --resource --model=Post
  ```
- [ ] Implementasikan logika di ke-7 method `PostController.php`:
  1. `index()`: Mengambil list post dengan pagination (misal: `Post::latest()->paginate(5)`), mendukung query pencarian jika ada.
  2. `create()`: Menampilkan view formulir tambah post (`posts.create`).
  3. `store(Request $request)`: Validasi data, proses upload file (jika ada), simpan data ke database, set flash message sukses, redirect ke `posts.index`.
  4. `show(Post $post)`: Menampilkan view detail artikel (`posts.show`).
  5. `edit(Post $post)`: Menampilkan view formulir ubah data (`posts.edit`) dengan data `$post`.
  6. `update(Request $request, Post $post)`: Validasi data baru, update data di database, set flash message sukses, redirect ke `posts.index`.
  7. `destroy(Post $post)`: Menghapus data (`$post->delete()`), set flash message sukses, redirect ke `posts.index`.

---

### Tahap 3: Desain Master Layout & Blade Components
- [ ] Buat folder layout: `resources/views/layouts/` dan buat file `app.blade.php`.
- [ ] Isi `app.blade.php` dengan:
  - Struktur HTML5 lengkap, meta viewport, judul dinamis (`@yield('title', 'Blog App')`).
  - Styling (Bootstrap / Tailwind CSS).
  - Navbar navigasi (Link ke Home / Buat Post / Form Pencarian).
  - Slot komponen Alert penampung flash message:
    ```blade
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="danger" :message="session('error')" />
    @endif
    ```
  - Area konten dinamis: `@yield('content')`.
- [ ] Buat Komponen Blade:
  - Komponen Alert:
    ```bash
    php artisan make:component Alert
    ```
    (Edit file `resources/views/components/alert.blade.php` untuk menampilkan pesan notifikasi bergaya).
  - Komponen Card:
    ```bash
    php artisan make:component Card
    ```
    (Edit file `resources/views/components/card.blade.php` untuk membungkus postingan blog dengan rapi).

---

### Tahap 4: Halaman Tampilan View (Blade Views)
- [ ] Buat direktori `resources/views/posts/`:
  - [ ] `index.blade.php`:
    - Menggunakan `@extends('layouts.app')` dan `@section('content')`.
    - Menampilkan form search (bonus).
    - Menampilkan tombol "+ Tambah Postingan Baru".
    - Melakukan looping `@forelse($posts as $post)` menggunakan komponen `<x-card>`.
    - Menampilkan pagination links: `{{ $posts->links() }}`.
  - [ ] `create.blade.php`:
    - Form penambahan postingan dengan `action="{{ route('posts.store') }}"` dan `method="POST"`.
    - Wajib menyertakan `@csrf`.
    - Jika mendukung upload gambar, sertakan `enctype="multipart/form-data"`.
    - Input `title` dengan value `old('title')` dan penanda error `@error('title') ... @enderror`.
    - Textarea `body` dengan isi `old('body')` dan penanda error `@error('body') ... @enderror`.
    - Input `image` (opsional untuk gambar).
  - [ ] `show.blade.php`:
    - Menampilkan detail judul, tanggal rilis, gambar, dan isi lengkap artikel.
    - Tombol navigasi kembali, tombol Edit, dan tombol Hapus.
  - [ ] `edit.blade.php`:
    - Form edit dengan `action="{{ route('posts.update', $post) }}"` dan `method="POST"`.
    - Wajib `@csrf` dan direktif `@method('PUT')`.
    - Value input diisi `old('title', $post->title)` dan `old('body', $post->body)`.
    - Penanganan error per field (`@error`).

---

### Tahap 5: Fitur Bonus (Pencarian, Soft Delete, Upload Gambar)
- [ ] **Bonus 1: Pencarian (Search)**
  - Tambahkan input search pada navbar atau `posts/index.blade.php` dengan query string `?search=...`.
  - Di `PostController::index()`, tambahkan filter:
    ```php
    $query = Post::query();
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('body', 'like', '%' . $request->search . '%');
    }
    $posts = $query->latest()->paginate(5)->withQueryString();
    ```
- [ ] **Bonus 2: Soft Delete**
  - Pastikan trait `SoftDeletes` aktif di model `Post`.
  - Saat data dihapus via tombol hapus (DELETE), data diberi timestamp `deleted_at` tanpa hilang fisik dari database.
- [ ] **Bonus 3: Upload Gambar**
  - Jalankan `php artisan storage:link` agar file di `storage/app/public` dapat diakses dari browser (`public/storage`).
  - Tambahkan validasi file gambar di controller: `'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'`.
  - Simpan berkas menggunakan `$request->file('image')->store('posts', 'public')`.
  - Tampilkan gambar di view menggunakan `<img src="{{ asset('storage/' . $post->image) }}">`.

---

### Tahap 6: Pengujian & Verifikasi Akhir
- [ ] Jalankan server: `php artisan serve`.
- [ ] Uji coba seluruh alur:
  - Buat postingan dengan input kosong -> pesan error validasi muncul & input lama tidak hilang.
  - Buat postingan sukses -> pesan flash notifikasi muncul & diarahkan ke daftar postingan.
  - Buka detail postingan (Show).
  - Edit postingan -> periksa apakah metode PUT bekerja.
  - Hapus postingan -> periksa apakah konfirmasi hapus & metode DELETE bekerja.
  - Uji coba pagination dengan membuat lebih dari 5 artikel.
  - Uji coba pencarian kata kunci.
  - Uji coba upload file gambar.
- [ ] Cek named routes di terminal:
  ```bash
  php artisan route:list --name=posts
  ```
- [ ] Commit dan push progres ke repositori Git:
  ```bash
  git add .
  git commit -m "feat: complete blog CRUD implementation with blade components"
  git push origin main
  ```
