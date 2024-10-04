@extends('layout')
@section('title', 'Edit')
@section('content')
    <div class="auth-form">
        <form action="{{ route('posts.update', ['post' => $post]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <label>Date: </label>
            <input type="datetime" name="date" value="{{ date('Y-m-d H:i:s') }}" readonly>
            <label>Prompt: </label>
            @if (empty($prompt))
                <input type="text" name="prompt" value="{{ $post->prompt }}">
            @else
                <input type="text" name="prompt" value="{{ $prompt }}">
            @endif
            <label>Image: </label>
            @if (empty($img))
                <img src='{{ url("images/$post->image_url") }}' alt="">
                <input type="hidden" name="image_url" value="{{ $post->image_url }}">
            @else
                <img src='{{ $img }}' alt="">
                <input type="hidden" name="image_url" value="{{ $img }}">
            @endif
            <button>Save</button>
        </form>
        <form action="{{ route('generate') }}" method="Post">
            @csrf
            <input type="hidden" name="id" value="{{ $post->id }}">
            <input id="hidden" type="hidden" name="prompt">
            <input type="hidden" name="to_update" value="to_update">
            <button>Regenerate</button>
        </form>
    </div>
    <script>
        let promptInput = document.querySelector('input[name="prompt"]');

        let hiddenInput = document.querySelector('#hidden');

        function updateHiddenInput() {
            hiddenInput.value = promptInput.value;
        }

        promptInput.addEventListener('input', updateHiddenInput);
        promptInput.addEventListener('change', updateHiddenInput);

        updateHiddenInput();
    </script>
@endsection
