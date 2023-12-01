<?php

namespace App\Http\Controllers;

use index;
use Illuminate\Http\Request;
use App\Http\Traits\FileTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users_response = Http::withToken(session('api_token'))->get(env('API_URL').'users');

        if($users_response->failed()) {
            return back()->with(["error" => "Couldn't load data"]);
        }

        $title = "All Users";
        $users = collect($users_response->object()->data->users)->where('role', 'user');

        $perPage = 14;
        $currentPage = request('page', 1);
        $startIndex = ($currentPage - 1) * $perPage;
        $slicedData = $users->slice($startIndex, $perPage);

        $data = new LengthAwarePaginator($slicedData, $users->count(), $perPage, $currentPage, [
            'path' => route('admin.users.index'),
        ]);

        return view('admin.users', compact("title", "data"));
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

        if($response->failed()){
            $errors = $response->json()['errors'];
            return back()->withErrors($errors ?? null);
        }

        $title = "Profile";
        $user = $response->object()->data->user;

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
            if($response->failed()){
                $errors = $response->json()['errors'];
                return back()->withErrors($errors ?? null);
            }

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
