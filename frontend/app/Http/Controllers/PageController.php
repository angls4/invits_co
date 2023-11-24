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
            return back()->with(["error" => "Couldn't load packages or themes"]);
        }

        $title = "Home";
        $data = [
            'packages' => $packages_response["data"]["packages"],
            'themes' => $themes_response["data"]["themes"]
        ];

        // dd($data);

        return view('user.home.index', compact("title", "data"));
    }

    public function dashboardIndex()
    {
        $packages_response = Http::get(env('API_URL').'packages');
        $themes_response = Http::get(env('API_URL').'themes');
        $users_response = Http::withToken(session('api_token'))->get(env('API_URL').'users');
        $orders_response = Http::withToken(session('api_token'))->get(env('API_URL').'orders');
        $payments_response = Http::withToken(session('api_token'))->get(env('API_URL').'payments/total/paid');

        if($packages_response->failed() || $themes_response->failed() || $users_response->failed() || $orders_response->failed() || $payments_response->failed()) {
            return back()->with(["error" => "Couldn't load data"]);
        }

        $title = "Dashboard Admin";
        $data = [
            "packages"=> collect($packages_response->object()->data->packages),
            "themes"=> collect($themes_response->object()->data->themes),
            "orders"=> collect($orders_response->object()->data->orders),
            "users"=> collect($users_response->object()->data->users),
            "payments"=> $payments_response->object()->data->total_payments_paid,
        ];

        return view('admin.index', compact("title", "data"));
    }
}
