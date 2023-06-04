@push('styles')
<style>
    .post {
        display: none;
    }

    .post.post--active {
        display: flex;
    }
</style>
@endpush
@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-9 col-md-8 col-12 mb-md-3">
        @forelse($posts as $key => $post)
        @include('posts.partials.post')
        @empty
        <p>No Records Found</p>
        @endforelse
        {{ $posts->links() }}
    </div>
    <div class="col-lg-3 col-md-4 d-none d-md-block">
        <div class="card  mb-3">
            <div class="card-body">
                <h5 class="card-title text-capitalize">Most Commented</h5>
                <p class="card-text">what people are currently talking about</p>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($mostCommentedPosts as $key => $post)
                <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="text-decoration-none">
                    <li class="list-group-item text-primary">{{ $post->title }}</li>
                </a>
                @endforeach
            </ul>
        </div>
        @card(['title' => 'Most Active'])
        @slot('subtitle', 'User with most posts written')
        @slot('items', collect($mostActiveUsers)->pluck('name'))
        @endcard
        @card(['title' => 'Most Active last month'])
        @slot('subtitle', 'User with most posts written in the month')
        @slot('items', collect($mostActiveUsersLastMonth)->pluck('name'))
        @endcard
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.post').click(function(e) {
            console.log(e.target);
            post = $(`.post__btn--${e.target.dataset.id}`);
            // post.removeClass('post__btn--active')
            post.parents().eq(4).removeClass('post--active');
        })
    })
</script>
@endpush