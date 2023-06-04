@push('styles')
<style>
    .comment__content,
    .comment__edit-form {
        display: none;
    }

    .comment__content.comment__content--active {
        display: flex;
    }

    .comment__edit-form.comment__edit-form--active {
        display: block;
    }
</style>
@endpush
@extends('layouts.app')
@section('content')
<article class="mb-3">
    @if($post->image)
    <div style="background-image: url('{{ $post->image->url() }}'); min-height: 400px; background-size: cover;" class="d-flex align-items-center justify-content-center">
        <h3 class="text-white text-uppercase h-full" style="text-shadow: 1px 2px #000;">{{ $post->title }}</h3>
        @if($post->created_at->diffInMinutes() < 20) @badge New! @endbadge @endif </div>
            <p>{{ $post->content }}</p>
            @else
            <h3 class="text-primary text-uppercase">{{ $post->title }}</h3>
            @if($post->created_at->diffInMinutes() < 20) @badge New! @endbadge @endif <p>{{ $post->content }}</p>
                @endif
                @updated(['date' => $post->created_at, 'name' => $post->user->name ]) @endupdated
                @tag(['tags' => $post->tags])@endtag
</article>
<section>
    <h4 class="fw-bold">Comments</h4>
    @include('comments.create')
    <div id="cmt" class="comments__container">
        @forelse($post->comments as $key => $comment)
        @include('comments.comment')
        @empty
        <p id="no-cmt">No Comments Found</p>
        @endforelse
    </div>
</section>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        console.log();
        $('.comment__content').click(function(e) {
            // console.log(e.target.dataset.id);
            comment = $(`.comment__content--${e.target.dataset.id}`);
            // console.log(comment);
            comment.removeClass('comment__content--active')
            // comment.parents().eq(4).removeClass('comment--active');
        })
    })
</script>
@endpush