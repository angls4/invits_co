<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
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

    /**
     * Show a page to select package
     */
    public function makeOrderSelectPackage()
    {
        return view('user.order.index', ['title' => 'Select Package']);
    }

    /**
     * Show a page to select theme.
     */
    public function makeOrderSelectTheme()
    {
        return view('user.order.theme', ['title' => 'Select Theme']);
    }

    /**
     * Show a page that have the order summary
     */
    public function makeOrderSummary()
    {
        return view('user.order.summary', ['title' => 'Order Summary']);
    }

    /**
     * Create the order.
     */
    public function makeOrder()
    {
        return view('user.order.checkout', ['title' => 'Checkout']);
    }
}
