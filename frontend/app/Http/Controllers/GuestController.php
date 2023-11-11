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
            'path' => route('client.invitation.guest.index', $id),
        ]);

        $invitationId = decode_id($id);

        return view("client.guests.index", compact('title', 'data', 'invitationId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $response = Http::withToken(session('api_token'))->get(env('API_URL').'guests-invitation/'.decode_id($id));
        if($response->failed()) {
            return back()->withErrors("Couldn't load guests");
        }
        $json = $response->object();

        $title = "Add Guest";
        $guests = collect($json->data->guests);

        return view('client.guests.add', compact('title', 'guests'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {   
        $input = $request->except('_token');
        $input['invitation_id'] = decode_id($input['invitation_id']);

        $response = Http::withToken(session('api_token'))->post(env('API_URL').'guests', $input);
        if($response->failed()){
            $errors = $response->json()["errors"];
            return back()->withErrors($errors ?? null)->withInput();
        }

        return back();
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
        $response = Http::withToken(session('api_token'))->get(env('API_URL').'guests/'.decode_id($id));
        if($response->failed()) {
            return back()->withErrors("Couldn't load guest");
        }
        $json = $response->object();

        $title = "Edit Guest";
        $guest = $json->data->guest;

        return view('client.guests.edit', compact('title', 'guest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->except('_token');

        $response = Http::withToken(session('api_token'))->put(env('API_URL').'guests/'.decode_id($id), $input);
        if($response->failed()){
            $errors = $response->json()["errors"];
            return back()->withErrors($errors ?? null)->withInput();
        }

        $guest = $response->object()->data->guest;
        return redirect()->route('client.invitation.guest.index', encode_id($guest->invitation_id))->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $ids = $request->selectedIDs;
        if (!$ids) $ids = [];

        try {
            foreach ($ids as $guest_id) {
                $guest = Http::withToken(session('api_token'))->delete(env('API_URL').'guests/'.$guest_id);
            }
            $status = 200;
        } catch (\Throwable $th) {
            $status = 400;
        }

        if (count($ids) == 0) $status = 400;

        return response()->json(['ids' => $request->selectedIDs], $status);
    }
}
