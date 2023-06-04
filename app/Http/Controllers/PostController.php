<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // dd(now()->subMonth(1));
        $posts = Post::with('user')
            ->withCount('comments')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        // dd($posts);
        $mostCommentedPosts = Post::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();
        // dd($mostCommentedPosts);
        $mostActiveUsers = User::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();
        // dd($mostActiveUsers);
        // dd(php_info());
        $mostActiveUsersLastMonth = User::withCount(['posts' => function ($query) {
            $query->whereBetween('created_at', [now()->subMonth(1), now()]);
        }])
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();
        // dd($mostActiveUsersLastMonth);
        return view('posts.index', [
            'posts' => $posts,
            'mostCommentedPosts' => $mostCommentedPosts,
            'mostActiveUsers' => $mostActiveUsers,
            'mostActiveUsersLastMonth' => $mostActiveUsersLastMonth,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $tags = Tag::all();
        return view('posts.create', ['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request['tags']);
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpg,jpeg,png,gif,svg'
        ]);
        $validated['author'] = $request->user()->id;
        // dd($validated);
        $post = Post::create($validated);
        if ($request->hasFile('thumbnail')) {
            // dd($request->file('thumbnail'));
            $path = $request->file('thumbnail')->store('thumbnails');
            $post->image()->save(
                Image::create(['path' => $path])
            );
        }
        if ($request['tags']) {
            // dd(true);
            $post->tags()->attach($request['tags']);
        }
        // die;
        return redirect()->back()->with('status', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $post = Post::with('tags')
            ->with('comments')
            ->with('user')
            ->with('image')
            ->findOrFail($id);
        // dd($post);
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $post = Post::with('tags')
            ->findOrFail($id);
        // ->with('image')
        // ->get();
        // dd($post);
        $tags = Tag::all();
        // dd($tags);
        $this->authorize('posts.update', $post);
        return view('posts.edit', [
            'post' => $post,
            'tags' => $tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $post = Post::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpg,jpeg,png,gif,svg'
        ]);
        $post->fill($validated);
        if ($request->hasFile('thumbnail')) {
            // dd($request->file('thumbnail'));
            $path = $request->file('thumbnail')->store('thumbnails');
            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }
            $post->image()->save(
                Image::create(['path' => $path])
            );
        }
        $post->save();
        if ($request['tags']) {
            // dd($request['tags']);
            $post->tags()->sync($request['tags']);
        }
        return redirect()->back()->with('status', 'Post Updated Successfully');
        // if (Gate::denies('update-post', $post)) {
        //     abort(403, 'You can\'t edit post!');
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $post = Post::findOrFail($id);
        if ($post->image) {
            Storage::delete($post->image->path);
        }
        $post->delete();

        return redirect()->back();
    }
}
