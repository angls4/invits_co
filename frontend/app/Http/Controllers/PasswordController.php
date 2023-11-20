<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
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
        $id = decode_id($id);

        $response = Http::withToken(session('api_token'))->get(env('API_URL').'users/'.$id);
        if($response->failed()){
            $errors = $response->json()['errors'];
            return back()->withErrors($errors ?? null);
        }

        $title = "Edit Password";
        $data = [
            'user' => $response->object()->data->user
        ];

        return view("client.profile.editPassword", compact('title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = Http::withToken(session('api_token'))->put(env('API_URL').'users/'.decode_id($id).'/change-password', $request->except('_token'));
        if($response->failed()){
            dd($response->json());
            $errors = $response->json()['errors'];
            return back()->withErrors($errors ?? null);
        }

        return redirect()->route('client.profile.index', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
