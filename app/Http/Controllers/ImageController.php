<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Orhanerday\OpenAi\OpenAi;
use App\Models\Post;

class ImageController extends Controller
{

    public function generateForm() {
        if (auth()->check()) {
            return view('generate');
        } else {
            return redirect()->route('login');
        }
    }

    public function generate(Request $request) {
    $request->validate([
        'prompt' => 'required|string|max:1000'
    ]);

    $open_ai_key = getenv("OPENAI_API_KEY");
    $open_ai = new OpenAi($open_ai_key);

    $complete = $open_ai->image([
        'prompt' => $request->prompt,
        'n' => 1,
        'size' => '512x512',
        'response_format' => 'url'
    ]);

    $var = json_decode($complete, TRUE);

    if ($var === null) {
        abort(404, "decoding failed");
    } else {
        if (isset($var['data']) && is_array($var['data']) && count($var['data']) > 0) {
            $img = $var['data'][0]['url'];
        } else {
            $img = "https://picsum.photos/seed/picsum/200/300";
        }
    }

    $prompt = $request->prompt;

    $post = Post::where('id', $request->id)->first();

    if ($request->to_update) {
        return view('posts.edit', compact('img', 'prompt', 'post'));
    }

    return view('generate', compact('img', 'prompt'));

    }
}
