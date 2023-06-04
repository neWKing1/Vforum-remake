@extends('layouts.app')
@section('content')
<a href="{{ route('tags.create') }}" class="btn btn-success">Add</a>
<table class="table text-center">
    <thead>
        <tr>
            <th scope="col" class="text-start">#</th>
            <th scope="col">Name</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($tags as $key => $tag)
        <tr>
            <th scope="row" class="text-start">{{ ++$key }}</th>
            <td>{{ $tag->name }}</td>
            @can('update', $tag)
            <td class="text-end"> <a href="{{ route('tags.edit', ['tag' => $tag->id]) }}" class="btn btn-primary">Edit</a></td>
            @endcan
            @can('delete', $tag)
            <td class="text-start">
                <form action="{{ route('tags.destroy', ['tag' => $tag->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tag?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
            @endcan
        </tr>
        @empty
        <p>No Records Found</p>
        @endforelse
        <div>
        </div>
    </tbody>
</table>
{{ $tags->links() }}
@endsection