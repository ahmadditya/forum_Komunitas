<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;

class Post_Controller extends Controller
{
    public function index()
    {
        return view(
            'index',
            [
                "title" => "Home",
                "posts" =>  Post::with(['user', 'category', 'comments'])
                    ->filter(request(['search']))->orderBy('id', 'desc')->paginate(10)
            ]
        );
    }

    public function show(Post $post)
    {
        return view(
            'post',
            [
                "title" => $post->judul,
                "post" => $post->load(['user', 'category']),
                "comments" => Comment::where('post_id', $post->id)->with('user', 'post')->orderBy('id', 'desc')->get()
            ]
        );
    }

    public function comment(Request $request, $postId)
    {
        // Validasi data komentar
        $request->validate([
            'body' => 'required|string|max:255', // Sesuaikan dengan kebutuhan
        ]);

        // Cari posting berdasarkan ID
        $post = Post::findOrFail($postId);

        // Buat komentar baru
        $comment = new Comment();
        $comment->user_id = auth()->id(); // ID pengguna yang membuat komentar
        $comment->post_id = $post->id; // ID posting tempat komentar akan disimpan
        $comment->body = $request->input('body');

        // Simpan komentar
        $comment->save();

        // Redirect kembali ke posting dengan pesan sukses
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function create()
    {
        return view(
            'post_create',
            [
                "title" => "Buat Tulisan",
                "categories" => Category::all()
            ]
        );
    }

    public function send(Request $request)
    {
        POST::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'judul' => $request->judul,
            'body' => $request->body
        ]);

        return redirect('/profile/' . auth()->user()->username);
    }
}
