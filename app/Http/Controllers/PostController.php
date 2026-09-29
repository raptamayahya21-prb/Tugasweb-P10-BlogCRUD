<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mendukung Bonus 1: Search query & Pagination.
     */
    public function index(Request $request)
    {
        $query = Post::query();

        // Bonus: Pencarian berdasarkan judul atau konten
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter kategori opsional jika ada
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Pagination data (6 per halaman)
        $posts = $query->latest()->paginate(6)->withQueryString();

        // Daftar kategori untuk filter bar
        $categories = ['Web Dev', 'Backend', 'AI & Machine Learning', 'DevOps', 'Mobile', 'Tutorial'];

        return view('posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['Web Dev', 'Backend', 'AI & Machine Learning', 'DevOps', 'Mobile', 'Tutorial'];
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * Validasi data + Bonus 3: Upload gambar.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|min:4|max:255',
            'category' => 'required|string|max:50',
            'body'     => 'required|string|min:15',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ], [
            'title.required'    => 'Judul artikel wajib diisi.',
            'title.min'         => 'Judul artikel minimal terdiri dari 4 karakter.',
            'category.required' => 'Kategori wajib dipilih.',
            'body.required'     => 'Konten artikel tidak boleh kosong.',
            'body.min'          => 'Konten artikel minimal 15 karakter agar informatif.',
            'image.image'       => 'Berkas yang diunggah harus berupa file gambar.',
            'image.mimes'       => 'Format gambar yang diperbolehkan: JPEG, PNG, JPG, WEBP, GIF.',
            'image.max'         => 'Ukuran gambar maksimal adalah 2 MB.',
        ]);

        // Proses unggah gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($validated);

        return redirect()->route('posts.index')
            ->with('success', '🎉 Artikel baru berhasil dipublikasikan!');
    }

    /**
     * Display the specified resource.
     * Route Model Binding: Post $post.
     */
    public function show(Post $post)
    {
        // Rekomendasi bacaan artikel lainnya
        $relatedPosts = Post::where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest()
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = ['Web Dev', 'Backend', 'AI & Machine Learning', 'DevOps', 'Mobile', 'Tutorial'];
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * Validasi + pergantian gambar baru (jika ada).
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'    => 'required|string|min:4|max:255',
            'category' => 'required|string|max:50',
            'body'     => 'required|string|min:15',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ], [
            'title.required'    => 'Judul artikel wajib diisi.',
            'title.min'         => 'Judul artikel minimal 4 karakter.',
            'category.required' => 'Kategori wajib dipilih.',
            'body.required'     => 'Konten artikel tidak boleh kosong.',
            'body.min'          => 'Konten artikel minimal 15 karakter.',
            'image.image'       => 'Berkas harus berupa gambar.',
            'image.max'         => 'Ukuran gambar maksimal 2 MB.',
        ]);

        // Jika user mengunggah gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', '✨ Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menggunakan Soft Delete (Bonus 2).
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', '🗑️ Artikel berhasil dipindahkan ke tempat sampah (Soft Deleted).');
    }
}
