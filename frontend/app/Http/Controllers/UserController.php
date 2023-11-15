<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\FileTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
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
        $id = decode_id($id);
        $response = Http::withToken(session('api_token'))->get(env('API_URL').'users/'.$id);

        $title = "Profile";
        $user = $response->object()->data->user;
        
        // dd($user);

        return view("client.profile.index", compact('title', 'user'));
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
        $id = decode_id($id);

        $input = $request->except('_token');
        if(isset($input['avatar'])){
            $input['avatar'] = FileTrait::store_file(null, $input['avatar'], 'avatar');
        } else {
            $input['avatar'] = 'img/default-avatar.jpg';
        }

        try {
            DB::beginTransaction();

            // Update data user
            $response = Http::withToken(session('api_token'))->put(env('API_URL').'users/'.$id, $input);

            DB::commit();

            return redirect()->back()->with("success", "Edit success");
        } catch (Exception $e) {
            DB::rollback();
            // dd($e);
            return redirect()->back()->with("error", "Edit failed");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
