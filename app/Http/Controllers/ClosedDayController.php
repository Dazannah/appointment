<?php

namespace App\Http\Controllers;

use App\Interfaces\IClosedDay;
use App\Interfaces\IDataSerialisation;
use App\Models\ClosedDay;
use Exception;
use Illuminate\Http\Request;

class ClosedDayController extends Controller {

    private IClosedDay $closedDayService;
    private IDataSerialisation $dataSerialisationService;

    public function __construct(IClosedDay $closedDayService, IDataSerialisation $dataSerialisationService) {
        $this->closedDayService = $closedDayService;
        $this->dataSerialisationService = $dataSerialisationService;
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

        $validationResult = $this->closedDayService->validateIfCanSave($validated);

        if (!$validationResult['canSave']) {
            if ($request->wantsJson())
                return response()->json(['error' => $validationResult['message']]);

            return back()->withInput()->with('error', $validationResult['message']);
        }

        $serialised = $this->dataSerialisationService->serialiseInputForCreateClosedDay($validated);

        ClosedDay::create($serialised);

        if ($request->wantsJson())
            return response()->json(['success' => 'Closed day successfully saved']);

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
    public function destroy(ClosedDay $closedDay, Request $request) {

        $closedDay->delete();

        if ($request->wantsJson())
            return response()->json(['success' => "Successfully deleted closed day"]);

        return back()->with('success', "Successfully deleted closed day");
    }
}
