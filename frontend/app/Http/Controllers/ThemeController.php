<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\FileTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $themes_response = Http::get(env('API_URL').'themes');

        if($themes_response->failed()) {
            return back()->with(["error" => "Couldn't load data"]);
        }

        $title = "All Themes";
        $themes = collect($themes_response->object()->data->themes);

        $perPage = 14;
        $currentPage = request('page', 1);
        $startIndex = ($currentPage - 1) * $perPage;
        $slicedData = $themes->slice($startIndex, $perPage);

        $data = new LengthAwarePaginator($slicedData, $themes->count(), $perPage, $currentPage, [
            'path' => route('admin.themes.index'),
        ]);

        return view('admin.themes.index', compact("title", "data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $packages_response = Http::get(env('API_URL').'packages');

        if($packages_response->failed()) {
            return back()->with(["error" => "Couldn't load data"]);
        }

        $title = "Add New Theme";
        $packages = collect($packages_response->object()->data->packages);
        return view('admin.themes.add', compact('title', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $lowercase = strtolower($request->name);
        $data['slug'] = str_replace(' ', '-', $lowercase);
        $data['img_preview'] = FileTrait::store_file(null, $data['img_preview'], 'theme_images');

        $response = Http::withToken(session('api_token'))->post(env('API_URL').'themes', $data);
        if($response->failed()){
            $errors = $response->json()["errors"];
            return back()->withErrors($errors ?? null)->withInput();
        }

        return redirect()->route('admin.themes.index')->with('success', 'Data berhasil ditambahkan');
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
        $theme_response = Http::get(env('API_URL').'themes/'.decode_id($id));
        $packages_response = Http::get(env('API_URL').'packages');

        if($theme_response->failed() || $packages_response->failed()) {
            return back()->with("failed", "Couldn't load data");
        }

        $title = "Edit Theme";
        $theme = $theme_response->object()->data->theme;
        $packages = collect($packages_response->object()->data->packages);

        return view('admin.themes.edit', compact('title', 'theme', 'packages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token');
        $old_data = Http::withToken(session('api_token'))->get(env('API_URL').'themes/'.decode_id($id))->object()->data->theme;
        $lowercase = strtolower($request->name);
        $data['slug'] = str_replace(' ', '-', $lowercase);
        
        if(isset($data['img_preview'])){
            $data['img_preview'] = FileTrait::store_file(null, $data['img_preview'], 'theme_images');
        }else {
            $data['img_preview'] = $old_data->img_preview;
        }       

        $response = Http::withToken(session('api_token'))->post(env('API_URL').'themes/'.decode_id($id), $data);
        if($response->failed()){
            $errors = $response->json()["errors"];
            return back()->withErrors($errors ?? null)->withInput();
        }
        return redirect()->route('admin.themes.index')->with('success', 'Data berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ids = $request->selectedIDs;
        if (!$ids) $ids = [];

        try {
            foreach ($ids as $theme_id) {
                $theme = Http::withToken(session('api_token'))->delete(env('API_URL').'themes/'.$theme_id);
            }
            $status = 200;
        } catch (\Throwable $th) {
            $status = 400;
        }

        if (count($ids) == 0) $status = 400;

        return response()->json(['ids' => $request->selectedIDs], $status);
    }
}
