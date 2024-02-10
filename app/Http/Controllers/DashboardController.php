<?php

namespace App\Http\Controllers;

use App\Models\ShortenUrl;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $urls=ShortenUrl::where('user_id',auth()->id())->get();
        return view('dashboard',compact('urls'));
    }
}
