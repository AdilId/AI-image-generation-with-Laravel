@extends('layout')
@section('title', 'Generate')
@section('content')
    <div class="auth-form">
        <form action="{{ route('generate') }}" method="post">
            @csrf
            <label>Prompt: </label>
            @if (!empty($prompt))
                <input type="text" name="prompt" value="{{ $prompt }}">
            @else
                <input type="text" name="prompt">
            @endif
            @if (!empty($img))
                <img src="{{ $img }}" alt="">
            @endif
            <input type="submit" value="generate">
        </form>
        <form action="{{ route('posts.create') }}">
            @csrf
            @if (!empty($prompt) && !empty($img))
                <input type="hidden" name="prompt" value="{{ $prompt }}">
                <input type="hidden" name="image_url" value="{{ $img }}">
                <button>Create</button>
            @endif
        </form>
    </div>
@endsection
