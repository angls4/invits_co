<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RsvpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
