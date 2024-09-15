<?php

namespace App\Http\Controllers;

use App\Interfaces\ISiteConfig;
use Illuminate\Http\Request;

class SiteConfigController extends Controller {

    private ISiteConfig $siteConfigs;

    public function __construct(ISiteConfig $siteConfigs) {
        $this->siteConfigs = $siteConfigs;
    }

    public function fillHolidays(Request $req) {
        $validated = $req->validate([
            'year' => 'required|date_format:Y'
        ]);

        //make request

        //go through all date and check if it is already saved if not save it, ignore the work days(type: 2)

        echo $validated['year'];
        exit;
    }

    public function index() {
        $configs = $this->siteConfigs->getConfig();

        return view('site-settings', ['pageTitle' => 'Site settings', 'configs' => $configs]);
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

        return back()->with('success', 'Sucessfuly updated the site settings');
    }
}
