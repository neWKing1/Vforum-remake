<div class="justify-content-between comment__content comment__content--{{ $comment->id }} comment__content--active">
    <div class="">
        <span>{{ $comment->content }}</span>
        <p class="text-secondary">Added {{ $post->created_at->diffForHumans() }}, by {{ $comment->user->name }}</p>
    </div>
    <section>
        <div class="dropdown">
            <button class="border-0 bg-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-ellipsis fs-4 text-secondary"></i>
            </button>
            <ul class="dropdown-menu">
                @can('update', $comment)
                <li>
                    <button class="btn btn-light w-100 comment__btn-edit" data-id="{{ $comment->id }}">Edit</button>
                </li>
                @endcan
                @can('delete', $comment)
                <li>
                    <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?')" class="comment__delete-form comment__delete-form--{{$comment->id}}" data-id="{{ $comment->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-light w-100">Delete</button>
                    </form>
                </li>
                @endcan
                <li>
                    <button class="btn btn-light w-100 " data-id="{{ $comment->id }}">Hide Comment</button>
                </li>
            </ul>
        </div>
    </section>
</div>