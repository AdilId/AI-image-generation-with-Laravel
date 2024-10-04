<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::select('id', 'prompt', 'image_url', 'user_id')->simplePaginate(12);
        return view('posts.index', compact('posts'));
    }

    public function create(Request $request)
    {
        $prompt = $request->prompt;
        $image_url = $request->image_url;

        if (auth()->check()) {
            return view('posts.create', compact('prompt', 'image_url'));
        } else {
            return redirect()->route('login');
        }
    }

    public function store(Request $request)
    {
        $image_url = $request->image_url;

        $response = Http::get($image_url);

        if (!$response->ok()) {
            abort(404, 'Failed to fetch image from the provided URL.');
        }

        $imageDirectory = public_path('images');

        if (!file_exists($imageDirectory)) {
            mkdir($imageDirectory, 0755, true);
        }

        $imageContent = $response->body();

        $slug = Str::slug($request->prompt, '-');
        $newImageName = uniqid() . '-' . $slug . '.jpg';

        file_put_contents($imageDirectory . '/' . $newImageName, $imageContent);

        $post = new Post();

        $post->date = $request->date;
        $post->prompt = $request->prompt;
        $post->image_url = $newImageName;
        $post->user_id = Auth::user()->id;

        $post->save();

        return redirect()->route('posts.index');
    }

    public function edit(Post $post) {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {

        $image_url = $request->image_url;

        if ($startsWithHttp = Str::startsWith($request->image_url, "http")) {

             $response = Http::get($image_url);

            if (!$response->ok()) {
                abort(404, 'Failed to fetch image from the provided URL.');
            }

            $imageDirectory = public_path('images');

            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0755, true);
            }

            $imageContent = $response->body();

            $slug = Str::slug($request->prompt, '-');
            $newImageName = uniqid() . '-' . $slug . '.jpg';

            file_put_contents($imageDirectory . '/' . $newImageName, $imageContent);
        } else {

            if ($request->prompt === $post->prompt) {
                return redirect()->route('posts.show', compact('post'));
            } else {
                $post->update([
                    'date' => $request->date,
                    'prompt' => $request->prompt,
                ]);
                return redirect()->route('posts.show', compact('post'));
            }

            return redirect()->route('posts.show', compact('post'));
        }

        $post->update([
            'date' => $request->date,
            'prompt' => $request->prompt,
            'image_url' => $newImageName
        ]);

        return redirect()->route('posts.show', compact('post'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        $this->authorize('update', $post);
        $post->delete();

        return redirect()->route('posts.index');
    }
}
