<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostCrudTest extends TestCase
{
    /**
     * Test menampilkan katalog artikel (index) dan pagination.
     */
    public function test_can_view_posts_index_and_search(): void
    {
        $post = Post::first();
        $this->assertNotNull($post, 'Post seeder must exist');

        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);
        $response->assertSee('DevJournal');
        $response->assertSee($post->title);

        // Test search query
        $searchResponse = $this->get(route('posts.index', ['search' => $post->title]));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee($post->title);
    }

    /**
     * Test halaman form tambah artikel.
     */
    public function test_can_view_create_post_page(): void
    {
        $response = $this->get(route('posts.create'));
        $response->assertStatus(200);
        $response->assertSee('Publikasikan Artikel Baru');
    }

    /**
     * Test validasi gagal saat input kosong.
     */
    public function test_post_creation_requires_validation(): void
    {
        $response = $this->post(route('posts.store'), []);
        $response->assertSessionHasErrors(['title', 'category', 'body']);
    }

    /**
     * Test simpan postingan baru beserta upload gambar sampul.
     */
    public function test_can_store_new_post_with_image(): void
    {
        Storage::fake('public');

        // Bersihkan data lama jika ada
        Post::where('title', 'Pengujian Otomatis CRUD Blog Berhasil')->forceDelete();

        // 1x1 valid minimal JPEG
        $validJpeg = base64_decode('/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA=');
        $image = UploadedFile::fake()->createWithContent('test_cover.jpg', $validJpeg);

        $payload = [
            'title'    => 'Pengujian Otomatis CRUD Blog Berhasil',
            'category' => 'Tutorial',
            'body'     => 'Ini adalah isi artikel pengujian otomatis untuk memastikan seluruh fungsi CRUD berjalan normal tanpa kendala.',
            'image'    => $image,
        ];

        $response = $this->post(route('posts.store'), $payload);

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('posts', [
            'title'    => 'Pengujian Otomatis CRUD Blog Berhasil',
            'category' => 'Tutorial',
        ]);

        $createdPost = Post::where('title', 'Pengujian Otomatis CRUD Blog Berhasil')->first();
        $this->assertNotNull($createdPost->image);
        Storage::disk('public')->assertExists($createdPost->image);
    }

    /**
     * Test melihat detail artikel (show).
     */
    public function test_can_show_post_details(): void
    {
        $post = Post::first();

        $response = $this->get(route('posts.show', $post));
        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    /**
     * Test membuka form edit artikel.
     */
    public function test_can_view_edit_post_page(): void
    {
        $post = Post::first();

        $response = $this->get(route('posts.edit', $post));
        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    /**
     * Test memperbarui artikel (update).
     */
    public function test_can_update_post(): void
    {
        $post = Post::first();

        $payload = [
            'title'    => $post->title . ' (Updated Version)',
            'category' => 'Backend',
            'body'     => 'Konten ini telah diperbarui melalui pengujian otomatis update artikel blog.',
        ];

        $response = $this->put(route('posts.update', $post), $payload);
        $response->assertRedirect(route('posts.show', $post));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('posts', [
            'id'    => $post->id,
            'title' => $post->title . ' (Updated Version)',
        ]);
    }

    /**
     * Test penghapusan artikel dengan soft delete.
     */
    public function test_can_soft_delete_post(): void
    {
        $post = Post::create([
            'title'    => 'Post Sementara untuk Diuji Hapus',
            'category' => 'Web Dev',
            'body'     => 'Artikel ini dibuat khusus untuk memverifikasi fungsionalitas Soft Deletes di basis data.',
        ]);

        $response = $this->delete(route('posts.destroy', $post));
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success');

        // Pastikan tidak ada di query biasa (karena soft deleted)
        $this->assertNull(Post::find($post->id));

        // Tapi masih tersimpan dengan timestamp deleted_at di database
        $this->assertSoftDeleted('posts', [
            'id' => $post->id,
        ]);
    }
}
