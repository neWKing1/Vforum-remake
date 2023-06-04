@extends('layouts.app')
@section('content')
@if(session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<form action="{{ route('tags.store') }}" method="POST">
    @csrf
    @include('tags.partials.form')
</form>
@endsection