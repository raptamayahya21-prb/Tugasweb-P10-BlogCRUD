<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Sample Posts untuk DevJournal
        $samplePosts = [
            [
                'title' => 'Memahami Arsitektur Model-View-Controller (MVC) Modern pada Laravel 12',
                'category' => 'Web Dev',
                'body' => "Pola arsitektur Model-View-Controller (MVC) adalah fondasi utama dalam pengembangan aplikasi web enterprise.\n\nDalam Laravel, 'Model' merepresentasikan entitas basis data melalui Eloquent ORM, 'View' menangani presentasi visual dengan Blade Templating Engine, dan 'Controller' menjadi dirigen pengatur alur data dan logika bisnis antar keduanya.\n\nDengan memisahkan ketiga tanggung jawab ini, kode menjadi jauh lebih terstruktur, mudah diuji (testable), dan siap dikembangkan dalam skala tim besar.",
            ],
            [
                'title' => 'Strategi Optimalisasi Query Database dengan Eager Loading Eloquent',
                'category' => 'Backend',
                'body' => "Masalah N+1 Query adalah momok paling umum yang memperlambat performa aplikasi berbasis ORM.\n\nSaat kita mengambil relasi di dalam loop tanpa 'with()', aplikasi akan mengeksekusi query terpisah untuk setiap baris data. Dengan menerapkan Eager Loading, Laravel hanya menjalankan satu query utama dan satu query relasi menggunakan klausa WHERE IN.\n\nLangkah sederhana ini sanggup memangkas waktu response hingga 80% pada endpoint yang memproses data masif.",
            ],
            [
                'title' => 'Eksplorasi Praktis RESTful API Design: Prinsip Idempotensi & Status Codes',
                'category' => 'Backend',
                'body' => "Membangun REST API bukan hanya tentang mengembalikan JSON, tetapi tentang kepatuhan pada standar protokol HTTP.\n\nMetode GET, PUT, dan DELETE idealnya bersifat idempoten — mengeksekusinya berulang kali tidak mengubah hasil akhir di server. Sebaliknya, metode POST bersifat non-idempoten.\n\nSelain itu, pemilihan status code yang presisi (seperti 201 Created vs 200 OK, atau 422 Unprocessable Content untuk kegagalan validasi) memberikan kejelasan bagi para developer client.",
            ],
            [
                'title' => 'Penerapan Blade Components untuk Membangun Design System yang Konsisten',
                'category' => 'Web Dev',
                'body' => "Blade Component di Laravel memungkinkan developer menciptakan elemen UI yang reusable layaknya framework frontend modern seperti Vue atau React.\n\nDengan memecah antarmuka menjadi komponen mandiri seperti <x-card>, <x-alert>, dan <x-button>, kita menghindari duplikasi kode CSS dan HTML. Jika suatu hari desain tombol atau kartu perlu diperbarui, kita cukup mengubah satu berkas komponen.",
            ],
            [
                'title' => 'Integrasi Model AI dan Large Language Models (LLM) pada Layanan Web',
                'category' => 'AI & Machine Learning',
                'body' => "Kecerdasan Buatan generatif kini menjadi kapabilitas krusial dalam perangkat lunak modern.\n\nDengan memanfaatkan arsitektur API terpadu, aplikasi backend dapat meneruskan prompt terstruktur ke model bahasa besar untuk fungsi seperti peringkasan konten otomatis, ekstraksi metadata, atau analisis sentimen ulasan pengguna secara real-time.",
            ],
            [
                'title' => 'Implementasi CI/CD Pipeline dengan GitHub Actions untuk Otomatisasi Deploy',
                'category' => 'DevOps',
                'body' => "Continuous Integration dan Continuous Deployment (CI/CD) menghapus proses deployment manual yang rawan kesalahan manusia (human error).\n\nSetiap kali ada commit atau Pull Request ke branch main, runner GitHub Actions secara otomatis menjalankan unit test, linter code, dan proses build aset frontend sebelum diteruskan ke server produksi.",
            ],
            [
                'title' => 'Panduan Keamanan Web: Mencegah Serangan CSRF, XSS, dan SQL Injection',
                'category' => 'Tutorial',
                'body' => "Keamanan web adalah prioritas nomor satu. Laravel secara default telah membekali developer dengan perlindungan tingkat tinggi:\n\n1. CSRF Protection: Setiap form POST/PUT/DELETE wajib menyertakan token @csrf.\n2. SQL Injection: PDO parameter binding diterapkan otomatis pada seluruh query Eloquent.\n3. XSS (Cross-Site Scripting): Sintaks Blade kurung kurawal ganda {{ }} otomatis melakukan escaping karakter berbahaya.",
            ],
            [
                'title' => 'Pengenalan Arsitektur Clean Code & SOLID Principles untuk Pemula',
                'category' => 'Tutorial',
                'body' => "Menulis kode yang bisa berjalan itu mudah, tetapi menulis kode yang mudah dirawat oleh orang lain memerlukan disiplin.\n\nPrinsip SOLID (Single Responsibility, Open-Closed, Liskov Substitution, Interface Segregation, Dependency Inversion) mengajarkan kita bagaimana merancang class yang modular, fleksibel terhadap perubahan, dan memiliki ketergantungan yang longgar (loose coupling).",
            ],
        ];

        foreach ($samplePosts as $post) {
            Post::firstOrCreate(
                ['title' => $post['title']],
                $post
            );
        }
    }
}
