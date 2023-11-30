<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages_response = Http::get(env('API_URL').'packages');

        if($packages_response->failed()) {
            return back()->with(["error" => "Couldn't load data"]);
        }

        $title = "All Packages";
        $packages = collect($packages_response->object()->data->packages);

        $perPage = 14;
        $currentPage = request('page', 1);
        $startIndex = ($currentPage - 1) * $perPage;
        $slicedData = $packages->slice($startIndex, $perPage);

        $data = new LengthAwarePaginator($slicedData, $packages->count(), $perPage, $currentPage, [
            'path' => route('admin.packages.index'),
        ]);

        return view('admin.packages.index', compact("title", "data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Add New Package";
        return view('admin.packages.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['price'] = 'Rp. ' . number_format($request['price'], 0, ',', '.');
        $data['features'] = collect($data['features'])->map(function ($item) {
            return "<li>" . $item . "</li>";
        })->implode('');

        $response = Http::withToken(session('api_token'))->post(env('API_URL').'packages', $data);
        if($response->failed()){
            $errors = $response->json()["errors"];
            return back()->withErrors($errors ?? null)->withInput();
        }

        return redirect()->route('admin.packages.index')->with('success', 'Data berhasil ditambahkan');
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
        $response = Http::get(env('API_URL').'packages/'.decode_id($id));
        if($response->failed()) {
            return back()->with("failed", "Couldn't load package");
        }

        $title = "Edit Package";
        $package = $response->object()->data->package;

        $package->price = str_replace(['Rp. ', '.'], '', $package->price);
        $package->features = explode('</li><li>', $package->features);
        $package->features = array_map('strip_tags', $package->features);

        return view('admin.packages.edit', compact('title', 'package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token');

        $data['price'] = 'Rp. ' . number_format($request['price'], 0, ',', '.');
        $data['features'] = collect($data['features'])->map(function ($item) {
            return "<li>" . $item . "</li>";
        })->implode('');

        $response = Http::withToken(session('api_token'))->put(env('API_URL').'packages/'.decode_id($id), $data);
        if($response->failed()){
            $errors = $response->json()["errors"];
            return back()->withErrors($errors ?? null)->withInput();
        }

        return redirect()->route('admin.packages.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ids = $request->selectedIDs;
        if (!$ids) $ids = [];

        try {
            foreach ($ids as $package_id) {
                $package = Http::withToken(session('api_token'))->delete(env('API_URL').'packages/'.$package_id);
            }
            $status = 200;
        } catch (\Throwable $th) {
            $status = 400;
        }

        if (count($ids) == 0) $status = 400;

        return response()->json(['ids' => $request->selectedIDs], $status);
    }
}
