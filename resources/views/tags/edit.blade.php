@extends('layouts.app')
@section('content')
@if(session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<form action="{{ route('tags.update', ['tag' => $tag->id]) }}" method="POST">
    @csrf
    @method('PUT')
    @include('tags.partials.form')
</form>
@endsection