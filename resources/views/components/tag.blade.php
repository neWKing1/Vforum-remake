<p>
    @foreach($tags as $tag)
    <a href="" class="badge rounded-pill text-bg-success me-2 text-decoration-none">{{ $tag->name }}</a>
    @endforeach
</p>