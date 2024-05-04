<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', ['posts' => Post::all()]);
    }

    public function store(Request $request)
    {

        $user_id = Auth::user()->id;
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = $user_id;
        $post->save();
        return redirect('/posts');
    }

    public function show($id)
    {
        // the firstOrFail() method will throw an exception if the post is not found
        $post = Post::with('user')->where('id', $id)->firstorFail();
        return view('posts.show', ['post' => $post]);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Check if the authenticated user is the owner of the post
        if (Auth::user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'You are not authorized to edit this post.');
        }

        return view('posts.edit', ['post' => $post]);
    }


    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Check if the authenticated user is the owner of the post
        if (Auth::user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'You are not authorized to update this post.');
        }

        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return redirect('/posts')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Check if the authenticated user is the owner of the post
        if (Auth::user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'You are not authorized to delete this post.');
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post deleted successfully.');
    }

}
