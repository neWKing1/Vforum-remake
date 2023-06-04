@extends('layouts.app')
@section('content')
@if(session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<form action="{{ route('posts.update', ['post' => $post->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('posts.partials.form')
</form>
@endsection