<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller {

    public function isPrice(Price $price) {
        return $price;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('create-price', ['pageTitle' => 'Create price']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $valideted = $request->validate([
            'price' => 'required|numeric',
            'from' => '',
            'worktypeName' => '',
            'duration' => ''
        ]);

        if (Price::where('price', '=', $valideted['price'])->count() > 0) {
            if ($request->wantsJson())
                return response()->json(['error' => 'Price already exist.']);

            return back()->with('error', 'Price already exist.');
        }

        Price::create(['price' => $valideted['price']]);

        if (isset($valideted['from'])) {
            $redirectTo = url()->query($valideted['from'], ['worktypeName' => $valideted['worktypeName'] ?? '', 'duration' => $valideted['duration'] ?? '']);

            return redirect($redirectTo)->with('success', 'Price successfully created.');
        }

        if ($request->wantsJson())
            return response()->json(['success' => 'Price successfully created.']);

        return back()->with('success', 'Price successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Price $price) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Price $price) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Price $price) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Price $price) {
        //
    }
}
