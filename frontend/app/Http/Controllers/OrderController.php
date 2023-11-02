<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::withToken(session('api_token'))->get(env('API_URL').'orders-user/'.session('user')['id']);
        if($response->failed()) {
            return back()->withErrors("Couldn't load orders");
        }
        $json = $response->object();

        $title = "Order List";
        $orders = collect($json->data->orders);

        $perPage = 14;
        $currentPage = request('page', 1);
        $startIndex = ($currentPage - 1) * $perPage;
        $slicedData = $orders->slice($startIndex, $perPage);

        $data = new LengthAwarePaginator($slicedData, $orders->count(), $perPage, $currentPage, [
            'path' => route('client.orders'),
        ]);

        return view("client.orders.index", compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = Http::withToken(session('api_token'))->get(env('API_URL').'orders/'.$id);
        if($response->failed()) {
            return back()->withErrors("Couldn't load orders");
        }
        $json = $response->object();

        $title = "Order Detail";
        $data = collect($json->data);

        // dd($order);
        
        return view("client.orders.detail", compact('title', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show a page to select package
     */
    public function makeOrderSelectPackage()
    {
        $packages_response = Http::get(env('API_URL').'packages');

        if($packages_response->failed()) {
            return back()->withErrors("Couldn't load packages");
        }

        $title = "Select Package";
        $data = $packages_response["data"]["packages"];

        return view('user.order.index', compact('title', 'data'));
    }

    /**
     * Show a page to select theme.
     */
    public function makeOrderSelectTheme($package_id)
    {
        $response = Http::get(env('API_URL').'themes');

        if($response->failed()) {
            return back()->withErrors("Couldn't load themes");
        }

        $json = $response->json();
        $data = collect($json["data"]["themes"])->where('package_id', decode_id($package_id));

        $title = "Select Theme";
        

        return view('user.order.theme', compact('title', 'data'));
    }

    /**
     * Show a page that have the order summary
     */
    public function makeOrderSummary($theme_id)
    {
        $theme_response = Http::get(env('API_URL').'themes/'.decode_id($theme_id));
        if ($theme_response->failed()) {
            return back()->withErrors("Couldn't load theme");
        }

        $theme_json = $theme_response->json();
        $theme = collect($theme_json['data']['theme']);

        $package_response = Http::get(env('API_URL').'packages/'.$theme["package_id"]);
        if ($theme_response->failed()) {
            return back()->withErrors("Couldn't load theme");
        }

        $package_json = $package_response->json();
        $package = collect($package_json['data']['package']);

        $title = 'Order Summary';

        return view('user.order.summary', compact('title', 'theme', 'package'));
    }

    /**
     * Create the order.
     */
    public function makeOrder($theme_id)
    {
        $theme_response = Http::get(env('API_URL').'themes/'.decode_id($theme_id));
        if ($theme_response->failed()) {
            return back()->withErrors("Couldn't load theme");
        }

        $theme_json = $theme_response->json();
        $theme = collect($theme_json['data']['theme']);

        $package_response = Http::get(env('API_URL').'packages/'.$theme["package_id"]);
        if ($theme_response->failed()) {
            return back()->withErrors("Couldn't load theme");
        }

        $package_json = $package_response->json();
        $package = collect($package_json['data']['package']);

        
        $order_response = Http::post(env('API_URL').'orders', [
            'user_id' => session('user.id'),
            'theme_id'  => $theme['id'],
        ]);
        if($order_response->failed()) {
            return back();
        }
        $order_json = $order_response->json();
        $order = collect($order_json['data']);

        $data = [
            'theme' => $theme,
            'package' => $package,
            'order' => $order
        ];

        $title = 'Checkout';
        return view('user.order.checkout', compact('title', 'data'));
    }
}
