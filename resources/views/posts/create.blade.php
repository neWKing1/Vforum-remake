@extends('layouts.app')
@section('content')
@if(session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('posts.partials.form')
</form>
@endsection