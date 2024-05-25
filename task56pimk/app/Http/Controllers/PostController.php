<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * 
     *
     * @return 
     */
    public function index()
    {
        $posts = Post::latest()->paginate(5);

        return view('post.index', compact('posts'));
    }

    /**
     * 
     *
     * @param 
     * @return 
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $post = Post::create([
                'title' => $request->title,
                'content' => $request->content,
            ]);

            return response()->json($post); // kembali ke laman post lewat JSON
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }
}
