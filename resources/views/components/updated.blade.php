<p>
    {{ empty(trim($slot)) ? 'Added' : $slot}} {{ $date->diffForHumans() }},
    @if(isset($name))
    by <span class="text-primary text-decoration-underline">{{ $name }}</span>
    @endif
</p>