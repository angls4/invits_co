<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\FileTrait;
use Illuminate\Support\Facades\Http;

class InvitationController extends Controller
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
    public function store(Request $request, string $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = Http::withToken(session('api_token'))->get(env('API_URL').'weddings-invitation/'.$id);
        if($response->failed()) {
            return back()->withErrors("Couldn't load invitation");
        }
        $json = $response->object();

        $title = "Invitation Detail";
        $data = collect($json->data);
        $data['quran'] = Http::get("http://api.alquran.cloud/v1/ayah/30:21/en.asad")->object()->data;

        // dd($data);

        return view('client.invitation', compact('title', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $response = Http::withToken(session('api_token'))->get(env('API_URL').'weddings-order/'.$id);
        if($response->failed()) {
            return back()->withErrors("Couldn't load invitation");
        }
        $json = $response->object();

        $title = "Invitation Detail";
        $data = collect($json->data);

        // dd($data);

        return view("client.editInvitation", compact('title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token');
        $old_data = Http::withToken(session('api_token'))->get(env('API_URL').'weddings-order/'.$id)->object()->data;

        foreach ($data['love_stories'] as $index => $love_story) {
            $data['love_stories'][$index]['id'] = (int)$love_story['id'];
            if(isset($love_story['image'])){
                $data['love_stories'][$index]['image'] = FileTrait::store_file(null, $love_story['image'], 'love_stories');
            }else {
                $data['love_stories'][$index]['image'] = $old_data->order->invitation->wedding->love_story[$index]->image;
            }
        }
        
        foreach ($data['galleries'] as $index => $gallery) {
            $data['galleries'][$index]['id'] = (int)$gallery['id'];
            if(isset($gallery['file'])){
                $data['galleries'][$index]['file'] = FileTrait::store_file(null, $gallery['file'], 'galleries');
            }else {
                $data['galleries'][$index]['file'] = $old_data->order->invitation->wedding->gallery[$index]->file;
            }
        }

        if(isset($data['groom_image'])){
            $data['groom_image'] = FileTrait::store_file(null, $data['groom_image'], 'groom_images');
        }else {
            $data['groom_image'] = $old_data->order->invitation->wedding->groom->image;
        }

        if(isset($data['bride_image'])){
            $data['bride_image'] = FileTrait::store_file(null, $data['bride_image'], 'bride_images');
        }else {
            $data['bride_image'] = $old_data->order->invitation->wedding->bride->image;
        }

        $response = Http::withToken(session('api_token'))->post(env('API_URL').'weddings-order/'.$id, $data);

        if($response->failed()){
            $errors = $response->json()["errors"];
            return back()->withErrors($errors ?? null)->withInput();
        }

        return back()->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
