<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class RsvpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $response = Http::withToken(session('api_token'))->get(env('API_URL').'rsvps-invitation/'.decode_id($id));
        if($response->failed()) {
            return back()->withErrors("Couldn't load orders");
        }
        $json = $response->object();

        $title = "Rsvp List";
        $rsvps = collect($json->data->rsvps);

        $perPage = 14;
        $currentPage = request('page', 1);
        $startIndex = ($currentPage - 1) * $perPage;
        $slicedData = $rsvps->slice($startIndex, $perPage);

        $sliced_rsvps = new LengthAwarePaginator($slicedData, $rsvps->count(), $perPage, $currentPage, [
            'path' => route('client.rsvp', $id),
        ]);

        $data = [
            'invitation' => $json->data->invitation,
            'rsvps' => $sliced_rsvps,
            'package' => $json->data->package
        ];

        // dd($data);

        return view("client.rsvp", compact('title', 'data'));
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
        // dd($request->except("_token"));
        $response = Http::post(env('API_URL').'rsvps', [
            'invitation_id' => decode_id($request->invitation_id),
            'name'  => $request->name,
            'amount_guest' => (int)$request->amount_guest,
            'is_attend' => $request->is_attend,
        ]);

        if($response->failed()){
            $errors = $response->object()->errors;
            return back()->withErrors($errors ?? null)->withInput();
        }

        return back()->with('success', 'Konfirmasi Berhasil!');
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
