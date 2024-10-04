@extends('layout')
@section('title', 'Image Generator')
@section('content')
    <section>
        <p id="typewriter-text">
            An image generator website is a digital platform that utilizes artificial intelligence and advanced algorithms
            to create, manipulate, or enhance images based on user inputs or predefined parameters.
            These websites typically offer a user-friendly interface where users can upload images, select from a variety of
            filters, effects, or styles, and generate customized visual content. Some image generator websites specialize in
            specific tasks, such as converting images into stylized artwork, enhancing photo quality, or creating
            visualizations from textual descriptions.
        </p>
        <img src="{{ url('images/ai.jpg') }}" alt="">
    </section>
@endsection
