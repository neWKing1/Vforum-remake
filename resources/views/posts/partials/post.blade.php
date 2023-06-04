<article class="mb-3 justify-content-between post post--active">
    <div>
        <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="text-decoration-none">
            <h5 class="text-primary text-uppercase">{{ $post->title }}</h5>
        </a>
        @updated(['date' => $post->created_at, 'name' => $post->user->name ])@endupdated
        <div class="summary">
            @if($post->comments_count > 0)
            <ul style="list-style-type: none;" class="list-group">
                <li>
                    {{$post->comments_count }} comments
                </li>
            </ul>
            @endif
        </div>
    </div>
    <section class="d-flex">
        <div class="dropdown">
            <button class="border-0 bg-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-ellipsis fs-4 text-secondary"></i>
            </button>
            <ul class="dropdown-menu">
                @can('update', $post)
                <li>
                    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-light w-100">Edit</a>
                </li>
                @endcan
                @can('delete', $post)
                <li>
                    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this block?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-light w-100">Delete</button>
                    </form>
                </li>
                @endcan
                <li>
                    <button class="btn btn-light w-100 post__btn--{{ $post->id }}" data-id="{{ $post->id }}">Hide Post</button>
                </li>
            </ul>
        </div>
    </section>
</article>