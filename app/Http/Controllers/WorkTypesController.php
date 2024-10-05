<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\WorkTypes;
use Illuminate\Http\Request;
use App\Interfaces\IPriceService;
use App\Interfaces\IWorktypeService;
use GuzzleHttp\Psr7\Response;

class WorkTypesController extends Controller {

    private IWorktypeService $worktypeService;
    private IPriceService $priceService;

    public function __construct(IWorktypeService $worktypeService, IPriceService $priceService) {
        $this->worktypeService = $worktypeService;
        $this->priceService = $priceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $validated = $request->validate([
            'name' => '',
            'duration' => '',
            'price' => '',
        ]);

        $validated['priceId'] = $this->priceService->getPriceIdByPrice($validated['price'] ?? '');

        $worktypes = $this->worktypeService->getFilterWorktypes($validated);

        $responseArray = ['pageTitle' => 'Prices', 'worktypes' => $worktypes];

        if ($request->wantsJson())
            return response()->json($responseArray);
        else
            return view('prices', $responseArray);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('create-worktype', ['pageTitle' => 'Create worktype', 'prices' => Price::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'worktypeName' => 'required',
            'duration' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        if (Price::where('id', '=', $validated['price'])->count() < 1) {
            if ($request->wantsJson())
                return response()->json(['error' => "Price don't exist. First add the price."]);

            return back()->withInput()->with('error', "Price don't exist. First add the price.");
        }

        WorkTypes::create(['name' => $validated['worktypeName'], 'duration' => $validated['duration'], 'price_id' => $validated['price']]);

        if ($request->wantsJson())
            return response()->json(['success' => "Successfully created worktype."]);

        return redirect('/admin/menu/worktypes')->with('success', "Successfully created worktype.");
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkTypes $worktype) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkTypes $worktype, Request $request) {
        $responseArray = ['pageTitle' => 'Edit worktype', 'worktype' => $worktype, 'prices' => Price::all()->sortBy('price')];

        if ($request->wantsJson())
            return response()->json($responseArray);

        return view('edit-worktype', $responseArray);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkTypes $worktype) {
        $validated = $request->validate([
            'worktypeName' => 'required',
            'duration' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        if (Price::where('id', '=', $validated['price'])->count() == 0) {
            if ($request->wantsJson())
                return response()->json(['error' => "The provided price don't exist."]);

            return back()->with('error', "The provided price don't exist.");
        }

        $worktype->name = $validated['worktypeName'];
        $worktype->duration = $validated['duration'];
        $worktype->price_id = $validated['price'];
        $worktype->save();

        if ($request->wantsJson())
            return response()->json(['success' => 'Worktype successfully updated.']);

        return back()->with('success', 'Worktype successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkTypes $worktype, Request $request) {
        $worktype->destroy($worktype->id);

        if ($request->wantsJson())
            return response()->json(['success' => 'Worktype successfully deleted.']);

        return redirect('/admin/menu/worktypes')->with('success', 'Worktype successfully deleted.');
    }
}
