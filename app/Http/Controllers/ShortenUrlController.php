<?php

namespace App\Http\Controllers;

use App\Models\ShortenUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShortenUrlController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);
        try {
            $shortenUrl= new ShortenUrl();
            $shortenUrl->url = $request->url;
            $shortenUrl->shorten_code = $this->generateShortenUrlCode();
            if (auth()->check()) {
                $shortenUrl->user_id = auth()->id();
            }
            $shortenUrl->save();
            $successMessage='Your shorten URL is: ' . route('shorten-url-redirect',$shortenUrl->shorten_code);
            return response()->json(['success_message' => $successMessage], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error_message' => 'Something went wrong. Please try again.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    protected function generateShortenUrlCode()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
