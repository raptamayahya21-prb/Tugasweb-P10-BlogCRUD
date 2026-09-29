# 📋 TASK ROADMAP: Blog CRUD Laravel (Tugas Pertemuan 10)

Dokumen ini memuat panduan langkah demi langkah (*step-by-step*) pengerjaan proyek **Tugas Rutin 10 — Blog CRUD Laravel**, mulai dari inisialisasi basis data hingga fitur bonus, lengkap dengan checklist status.

---

## 🎯 Penjelasan & Tujuan Proyek (Bahasa Sederhana)

### Apa itu Proyek Ini?
Proyek ini adalah pembuatan aplikasi web **Blog Tech & Engineering (DevJournal)** menggunakan framework **Laravel**. Di aplikasi ini, pengguna dapat mengelola artikel blog melalui 4 fungsi dasar data yang biasa disebut **CRUD**:
- **C (Create):** Membuat dan mempublikasikan postingan blog baru dengan validasi dan upload gambar sampul.
- **R (Read):** Membaca katalog artikel dengan pagination, filtering kategori, fitur pencarian (*search*), dan membaca detail artikel.
- **U (Update):** Mengubah atau memperbaiki isi postingan dengan formulir update dan preview file gambar.
- **D (Delete):** Menghapus artikel menggunakan penghapusan aman (*Soft Deletes*).

### Mengapa Tugas Ini Dibuat & Apa Tujuannya?
1. **Memahami Konsep Resource Controller & RESTful Routing:**
   Penggunaan perintah rute tunggal (`Route::resource`) yang otomatis memetakan 7 fungsi kerja standar (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`) sehingga struktur URL aplikasi rapi dan standar industri.
2. **Mengenal Sistem Template Blade & Komponen Reusable:**
   Menggunakan master layout (`app.blade.php`) dengan `@extends` dan `@yield`, serta memecah bagian tampilan yang sering dipakai ke dalam komponen mandiri: kartu postingan `<x-card>` dan notifikasi pesan `<x-alert>`.
3. **Keamanan & Validasi Data Web:**
   Proteksi token `@csrf`, verifikasi metode HTTP palsu (`@method('PUT')` / `@method('DELETE')`), serta validasi input kolom dengan pesan error spesifik (`@error`) dan retensi input lama (`old()`).
4. **Memberikan Pengalaman Pengguna (UX) yang Ramah:**
   Pesan notifikasi sukses/gagal (*flash message*), navigasi halaman (*pagination*), pencarian kata kunci (*search*), penghapusan aman (*soft delete*), dan lampiran media (*upload gambar*).

---

## 📌 Matriks Checklist Kebutuhan

### ✅ Kriteria Wajib (8/8) — SELESAI
- [x] **Req 1:** `Route::resource('posts')` + Named Routes standar (7 rute resource aktif)
- [x] **Req 2:** `PostController` Resource lengkap dengan 7 method (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`)
- [x] **Req 3:** Blade Master Layout (`app.blade.php`) menggunakan direktif `@extends` & `@yield`
- [x] **Req 4:** Minimal 2 Blade Component buatan sendiri/kustom (Komponen `<x-alert>` & `<x-card>`)
- [x] **Req 5:** Validasi request + pesan error per field (`@error`) + pertahankan input lama (`old()`)
- [x] **Req 6:** Flash session message untuk status sukses/gagal aksi CRUD
- [x] **Req 7:** Proteksi `@csrf` di seluruh form + `@method('PUT')` untuk update & `@method('DELETE')` untuk hapus
- [x] **Req 8:** Route Model Binding (`Post $post`) + Pagination data (`paginate(6)`)

### ⭐ Kriteria Bonus (3/3) — SELESAI
- [x] **Bonus 1:** Fitur Pencarian Postingan (Search by title, body, & category)
- [x] **Bonus 2:** Fitur Soft Delete (Menggunakan trait `SoftDeletes` pada Model & migration `softDeletes()`)
- [x] **Bonus 3:** Fitur Upload Gambar (Mendukung upload media gambar sampul dengan `storage:link` dan validasi berkas)

---

## 🚀 Rangkuman File yang Telah Dibuat
1. **Migration:** `database/migrations/2026_09_29_165822_create_posts_table.php` (dengan kolom `title`, `category`, `body`, `image`, `softDeletes`).
2. **Model:** `app/Models/Post.php` (dengan trait `SoftDeletes`, `$fillable`, dan accessor `read_time`).
3. **Controller:** `app/Http/Controllers/PostController.php` (7 methods lengkap dengan validasi, pagination, search, flash message, dan storage upload).
4. **Routes:** `routes/web.php` (`Route::resource('posts', PostController::class)` dan redirect root).
5. **Blade Components:**
   - `resources/views/components/alert.blade.php` (`<x-alert>`)
   - `resources/views/components/card.blade.php` (`<x-card>`)
6. **Master Layout:** `resources/views/layouts/app.blade.php` (Warm intellectual design system sesuai `claude-ui-spec.md`).
7. **Views:**
   - `resources/views/posts/index.blade.php`
   - `resources/views/posts/create.blade.php`
   - `resources/views/posts/edit.blade.php`
   - `resources/views/posts/show.blade.php`
8. **Seeder:** `database/seeders/DatabaseSeeder.php` (8 artikel sampel realistis).
