<?php

namespace App\Http\Controllers;

use App\Models\ShortenUrl;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('home');
    }

    public function shortenUrl(Request $request)
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
            $successMessage='Your shorten URL is: ' . route('shorten-url-redirect',$shortenUrl->shorten_code) .
                '. If you want to see the statistics, please register or login.';
            return redirect()->route('home',['url_id'=>$shortenUrl->id])->with('success_message', $successMessage);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('home')->with('error_message', 'Something went wrong. Please try again.');
        }
    }

    public function shortenUrlRedirect($shorten_code)
    {
        $shortenUrl = ShortenUrl::where('shorten_code', $shorten_code)->first();
        if ($shortenUrl) {
            $shortenUrl->clicks++;
            $shortenUrl->save();
            return redirect($shortenUrl->url);
        }
        return redirect()->route('home')->with('error_message', 'The URL does not exist.');
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
