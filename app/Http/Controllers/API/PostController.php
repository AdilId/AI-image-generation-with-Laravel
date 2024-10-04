<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->get();

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image_url = $request->image_url;

        $response = Http::get($image_url);

        if (!$response->ok()) {
            return response()->json('Failed to fetch image from the provided URL.', 404);
        }

        $imageDirectory = public_path('images');

        if (!file_exists($imageDirectory)) {
            mkdir($imageDirectory, 0755, true);
        }

        $imageContent = $response->body();

        $slug = Str::slug($request->prompt, '-');
        $newImageName = uniqid() . '-' . $slug . '.jpg';

        file_put_contents($imageDirectory . '/' . $newImageName, $imageContent);

        $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');

        $post = new Post();

        $post->date = $currentDateTime;
        $post->prompt = $request->prompt;
        $post->image_url = $newImageName;
        $post->user_id = Auth::user()->id;

        $post->save();

        return response()->json(["message" => "Created Successfully."]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $post = Post::with('user')->find($id);

        return response()->json(['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $post = Post::find($id);
        $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');

        if (!$request->image_url) {
            $post->update([
                'date' => $currentDateTime,
                'prompt' => $request->prompt,
            ]);
        } else {
            $image_url = $request->image_url;

            $response = Http::get($image_url);

            if (!$response->ok()) {
                return response()->json('Failed to fetch image from the provided URL.', 404);
            }

            $imageDirectory = public_path('images');

            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0755, true);
            }

            $imageContent = $response->body();

            $slug = Str::slug($request->prompt, '-');
            $newImageName = uniqid() . '-' . $slug . '.jpg';

            file_put_contents($imageDirectory . '/' . $newImageName, $imageContent);

            $post->update([
                'date' => $currentDateTime,
                'prompt' => $request->prompt,
                'image_url' => $newImageName
            ]);
        }

        return response()->json(["message" => "Updated Successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (Auth::user()->id !== $post->user_id) {
            return response()->json("You should own this to delete it", 403);
        }

        $post->delete();

        return response()->json('Deleted');
    }
}
