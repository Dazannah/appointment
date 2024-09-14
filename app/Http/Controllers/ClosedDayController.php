<?php

namespace App\Http\Controllers;

use App\Interfaces\IClosedDay;
use Illuminate\Http\Request;

class ClosedDayController extends Controller {

    private IClosedDay $closedDayService;

    public function __construct(IClosedDay $closedDayService) {
        $this->closedDayService = $closedDayService;
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
        return view('create-closed-day', ['pageTitle' => 'Create closed day']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);

        $result = $this->closedDayService->validateIfCanSave($validated);

        if (!$result['canSave']) return back()->withInput()->with('error', $result['message']);
        //save

        return back()->with('success', 'Closed day successfully saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
