<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function home()
    {
        $packages_response = Http::get(env('API_URL').'packages');
        $themes_response = Http::get(env('API_URL').'themes');

        if($packages_response->failed() || $themes_response->failed()) {
            return back()->withErrors("Couldn't load packages or themes");
        }

        $title = "Home";
        $data = [
            'packages' => $packages_response["data"]["packages"],
            'themes' => $themes_response["data"]["themes"]
        ];

        // dd($data);

        return view('user.home.index', compact("title", "data"));
    }
}
