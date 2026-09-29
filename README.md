# 📖 DevJournal — Blog CRUD Laravel (Tugas Rutin 10)

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tests](https://img.shields.io/badge/Tests-10%2F10%20Passed-6BD957?style=for-the-badge&logo=checkmarx&logoColor=white)](tests/Feature/PostCrudTest.php)
[![Theme](https://img.shields.io/badge/Theme-Fresh%20Green%20%236BD957-6BD957?style=for-the-badge)](claude-ui-spec.md)

Aplikasi web **Blog Tech & Engineering (DevJournal)** yang dibangun dengan arsitektur **Model-View-Controller (MVC)** pada framework **Laravel 12**. Proyek ini dibuat untuk memenuhi seluruh kriteria dan fitur bonus pada **Tugas Rutin Pertemuan 10 — Pemrograman Web**.

---

## 🎯 Gambaran Proyek

**DevJournal** adalah platform blog artikel teknologi dan catatan rekayasa perangkat lunak (*software engineering*) yang mengusung gaya estetika *Warm Editorial Intellectual* dengan warna aksen hijau segar (`#6BD957`).

Pengguna dapat mengelola seluruh siklus hidup artikel melalui operasi **CRUD (Create, Read, Update, Delete)** dengan standar RESTful Resource routing, validasi data berlapis, proteksi keamanan token CSRF, retensi input form, serta sistem unggah media sampul.

---

## 📋 Matriks Pemenuhan Kriteria Tugas

### ✅ Kriteria Wajib (8/8 Selesai)
1. **`Route::resource('posts')` + Named Routes:**  
   Rute resource tunggal yang otomatis memetakan 7 metode HTTP standar (`posts.index`, `posts.create`, `posts.store`, `posts.show`, `posts.edit`, `posts.update`, `posts.destroy`).
2. **`PostController` Resource (7 Methods):**  
   Implementasi logika controller terstruktur dan bersih pada ke-7 method resource standar.
3. **Blade Master Layout (`@extends` & `@yield`):**  
   Kerangka antarmuka utama di `resources/views/layouts/app.blade.php` dengan direktif `@yield('title')` dan `@yield('content')`.
4. **Minimal 2 Komponen Blade Kustom:**  
   - `<x-alert>`: Komponen pesan notifikasi dinamis untuk status aksi.
   - `<x-card>`: Komponen kartu artikel dengan cover, label kategori, ringkasan, dan tombol aksi.
5. **Validasi Request & Error Penanganan:**  
   Pesan kesalahan per field menggunakan `@error(...)` dan nilai lama input dipertahankan dengan fungsi `old()`.
6. **Flash Session Message:**  
   Pesan notifikasi sukses/gagal tersimpan dalam session (`session('success')`) setelah setiap operasi CRUD.
7. **Keamanan Formulir (`@csrf` & Method Spoofing):**  
   Proteksi token Cross-Site Request Forgery di semua formulir, `@method('PUT')` untuk update data, dan `@method('DELETE')` untuk penghapusan.
8. **Route Model Binding & Pagination:**  
   Penyuntikan model otomatis `Post $post` di Controller serta penomoran halaman data (`paginate(6)`) dengan `{{ $posts->links() }}`.

### ⭐ Fitur Bonus (3/3 Selesai)
1. **🔍 Pencarian Real-Time (Search):**  
   Pencarian artikel berdasarkan judul, kategori, atau isi konten dengan persistensi query string (`?search=...`).
2. **🗑️ Soft Delete:**  
   Penggunaan trait `SoftDeletes` dan kolom `deleted_at`, sehingga artikel yang dihapus tetap aman di basis data dan tidak lenyap secara permanen.
3. **🖼️ Upload Gambar Sampul:**  
   Mendukung pengunggahan berkas gambar (JPEG, PNG, JPG, WEBP, GIF max 2MB) ke penyimpanan publik (`storage/app/public/posts`) lengkap dengan fitur pratinjau (*live preview*).

---

## 🛠️ Struktur Berkas Utama

```text
Blok-CRUD/
├── app/
│   ├── Http/Controllers/
│   │   └── PostController.php          # 7 Resource methods + validasi + upload
│   └── Models/
│       └── Post.php                    # Model dengan SoftDeletes & Accessor
├── database/
│   ├── migrations/
│   │   └── ..._create_posts_table.php  # Skema tabel posts + softDeletes
│   └── seeders/
│       └── DatabaseSeeder.php          # Seeder 8 artikel tech realistis
├── resources/
│   └── views/
│       ├── components/
│       │   ├── alert.blade.php         # <x-alert> flash notification
│       │   └── card.blade.php          # <x-card> post article card
│       ├── layouts/
│       │   └── app.blade.php           # Master layout + Fresh Green CSS Tokens
│       └── posts/
│           ├── index.blade.php         # Katalog artikel, search bar & pagination
│           ├── create.blade.php        # Form tambah artikel & live image preview
│           ├── edit.blade.php          # Form edit artikel & @method('PUT')
│           └── show.blade.php          # Halaman baca detail & related posts
├── routes/
│   └── web.php                         # Route::resource('posts')
└── tests/Feature/
    └── PostCrudTest.php                # 10 Test cases lengkap untuk validasi fitur
```

---

## 🚀 Panduan Menjalankan Proyek Secara Lokal

### Prasyarat
- PHP >= 8.2
- Composer
- Laragon / XAMPP

### Langkah Instalasi
1. **Clone repositori:**
   ```bash
   git clone https://github.com/raptamayahya21-prb/TugasWeb-P10-BlogCRUD.git
   cd TugasWeb-P10-BlogCRUD
   ```

2. **Instal dependensi Composer:**
   ```bash
   composer install
   ```

3. **Salin konfigurasi environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Hubungkan storage publik:**
   ```bash
   php artisan storage:link
   ```

5. **Jalankan migrasi database & seeding artikel awal:**
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan server aplikasi:**
   ```bash
   php artisan serve
   ```
   Buka browser di: **`http://127.0.0.1:8000/posts`**

---

## 🧪 Pengujian Otomatis (*Automated Testing*)

Proyek ini telah dilengkapi dengan unit dan feature testing komprehensif menggunakan PHPUnit:

```bash
php artisan test
```

### Hasil Test:
```text
PASS  Tests\Unit\ExampleTest
✓ that true is true

PASS  Tests\Feature\ExampleTest
✓ the application returns a successful response

PASS  Tests\Feature\PostCrudTest
✓ can view posts index and search
✓ can view create post page
✓ post creation requires validation
✓ can store new post with image
✓ can show post details
✓ can view edit post page
✓ can update post
✓ can soft delete post

Tests:    10 passed (35 assertions)
Duration: 0.90s
```

---

## 📌 Daftar Rute Aplikasi (`Route List`)

| HTTP Method | URI | Route Name | Action Controller |
| :--- | :--- | :--- | :--- |
| `GET` | `/` | - | Redirect ke `/posts` |
| `GET` | `/posts` | `posts.index` | `PostController@index` |
| `GET` | `/posts/create` | `posts.create` | `PostController@create` |
| `POST` | `/posts` | `posts.store` | `PostController@store` |
| `GET` | `/posts/{post}` | `posts.show` | `PostController@show` |
| `GET` | `/posts/{post}/edit` | `posts.edit` | `PostController@edit` |
| `PUT` | `/posts/{post}` | `posts.update` | `PostController@update` |
| `DELETE` | `/posts/{post}` | `posts.destroy` | `PostController@destroy` |

---

## 👨‍💻 Identitas Pembuat & Repositori
- **Nama Repositori:** `TugasWeb-P10-BlogCRUD`
- **Mata Kuliah:** Pemrograman Web (Pertemuan 10 — Blog CRUD Laravel)
- **Lisensi:** [MIT License](LICENSE)
