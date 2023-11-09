<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $response = Http::withToken(session('api_token'))->get(env('API_URL').'guests-invitation/'.decode_id($id));
        if($response->failed()) {
            return back()->withErrors("Couldn't load guests");
        }
        $json = $response->object();

        $title = "Guest List";
        $guests = collect($json->data->guests);

        $perPage = 14;
        $currentPage = request('page', 1);
        $startIndex = ($currentPage - 1) * $perPage;
        $slicedData = $guests->slice($startIndex, $perPage);

        $data = new LengthAwarePaginator($slicedData, $guests->count(), $perPage, $currentPage, [
            'path' => route('client.guest.index', $id),
        ]);

        return view("client.guests.index", compact('title', 'data'));
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
        //
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
}
