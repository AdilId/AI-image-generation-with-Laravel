@extends('layout')
@section('title', 'Create')
@section('content')
    <div class="auth-form">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Date: </label>
            <input type="datetime" name="date" value="{{ date('Y-m-d H:i:s') }}" readonly>
            <label>Prompt: </label>
            <p>{{ $prompt }}</p>
            <input type="hidden" name="prompt" value="{{ $prompt }}">
            <label>Image: </label>
            <img src="{{ $image_url }}" alt="">
            <input type="hidden" name="image_url" value="{{ $image_url }}">
            <button type="submit">Create</button>
        </form>
    </div>
@endsection
