<?php

namespace App\Http\Controllers;

use App\Interfaces\IClosedDay;
use App\Interfaces\IRequest;
use App\Interfaces\ISiteConfig;
use Illuminate\Http\Request;

class SiteConfigController extends Controller {

    private ISiteConfig $siteConfigs;
    private IClosedDay $closedDayService;

    public function __construct(ISiteConfig $siteConfigs, IClosedDay $closedDayService) {
        $this->siteConfigs = $siteConfigs;
        $this->closedDayService = $closedDayService;
    }

    public function fillHolidays(Request $request) {
        $validated = $request->validate([
            'year' => 'required|date_format:Y'
        ]);

        //make request
        $requestService = app(IRequest::class);
        $holidays = $requestService->getHolidays($validated['year']);

        if ($holidays['response'] === 'Error') {
            if ($request->wantsJson())
                return response()->json(['error' => $holidays['message']]);

            return back()->withInput()->with('error', $holidays['message']);
        } else {
            $this->closedDayService->handleHolidays($holidays['days'], $validated['year']);
            //go through all date and check if it is already saved if not save it, ignore the work days(type: 2)

            if ($request->wantsJson())
                return response()->json(['success' => 'Holidays successfully updated']);

            return back()->with('success', 'Holidays successfully updated');
        }
    }

    public function index(Request $request) {
        $configs = $this->siteConfigs->getConfig();

        $responseArray = ['pageTitle' => 'Site settings', 'configs' => $configs];

        if ($request->wantsJson())
            return response()->json($responseArray);

        return view('site-settings', $responseArray);
    }

    public function saveSettings(Request $request) {
        $validatedInputs = $request->validate([
            'workdayStart' => 'required|date_format:H:i',
            'workdayEnd' => 'required|date_format:H:i|after:workdayStart',
            'closedDaysTitle' => 'required'
        ]);

        $newValues = $this->siteConfigs->serialiseInputs($validatedInputs);
        $this->siteConfigs->setConfig($newValues);
        $this->siteConfigs->save();

        if ($request->wantsJson())
            return response()->json(['success' => 'Sucessfuly updated the site settings']);

        return back()->with('success', 'Sucessfuly updated the site settings');
    }
}
