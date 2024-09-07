<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\WorkTypes;
use Illuminate\Http\Request;
use App\Interfaces\IPriceService;
use App\Interfaces\IWorktypeService;

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

        return view('prices', ['pageTitle' => 'Prices', 'worktypes' => $worktypes]);
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

        if (Price::where('id', '=', $validated['price'])->count() < 1)
            return back()->withInput()->with('error', "Price don't exist. First add the price.");

        WorkTypes::create(['name' => $validated['worktypeName'], 'duration' => $validated['duration'], 'price_id' => $validated['price']]);

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
    public function edit(WorkTypes $worktype) {
        return view('edit-worktype', ['pageTitle' => 'Edit worktype', 'worktype' => $worktype, 'prices' => Price::all()->sortBy('price')]);
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
            return back()->with('error', "The provided price don't exist.");
        }

        $worktype->name = $validated['worktypeName'];
        $worktype->duration = $validated['duration'];
        $worktype->price_id = $validated['price'];
        $worktype->save();

        return back()->with('success', 'Worktype successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkTypes $worktype) {
        $worktype->destroy($worktype->id);

        return redirect('/admin/menu/worktypes')->with('success', 'Worktype successfully deleted.');
    }
}
