@extends('layout')
@section('title', 'Posts')
@section('content')
    <main>
        @if (count($posts))
            @foreach ($posts as $post)
                <div class="card">
                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                        <img src='{{ url("images/$post->image_url") }}' alt="">
                        @can('update', $post)
                            <span class="star"></span>
                        @endcan
                        <a class="download" href='{{ asset("images/$post->image_url") }}' download>
                            <span class="material-symbols-outlined">download</span>
                        </a>
                        <p>
                            <span>{{ $post->user->name[0] }}</span>
                            @if (strlen($post->prompt) > 15)
                                {{ Str::substr($post->prompt, 0, 22) }}...
                            @else
                                {{ $post->prompt }}
                            @endif
                        </p>
                    </a>
                </div>
            @endforeach
        @else
            There is no posts to show.
        @endif
    </main>
@endsection
