<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title text-capitalize">{{ $title }}</h5>
        <p class="card-text">{{ $subtitle }}</p>
    </div>
    <ul class="list-group list-group-flush">
        @foreach($items as $key => $item)
        <li class="list-group-item">{{ $item }}</li>
        @endforeach
    </ul>
</div>