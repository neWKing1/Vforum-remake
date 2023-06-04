<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tags = Tag::orderBy('id', 'desc')->paginate(10);
        $this->authorize('tags.viewAny', $tags);
        return view('tags.index', ['tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->authorize('tags.create');
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $tag = Tag::create($validated);
        $this->authorize('tags.create', $tag);
        return redirect()->back()->with('status', 'Tag Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $tag = Tag::findOrFail($id);
        $this->authorize('tags.update', $tag);
        return view('tags.edit', ['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $tag = Tag::findOrFail($id);
        // dd($tag, $validated);
        $tag->fill($validated);
        $tag->save();
        $this->authorize('tags.update', $tag);
        return redirect()->back()->with('status', 'Tag Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $tag = Tag::findOrFail($id);
        $tag->delete();
        $this->authorize('tags.delete', $tag);
        return redirect()->back();
    }
}
