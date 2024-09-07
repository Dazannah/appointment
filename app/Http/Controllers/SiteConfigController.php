<?php

namespace App\Http\Controllers;

use App\Interfaces\ISiteConfig;
use Illuminate\Http\Request;

class SiteConfigController extends Controller {

    private ISiteConfig $siteConfigs;

    public function __construct(ISiteConfig $siteConfigs) {
        $this->siteConfigs = $siteConfigs;
    }

    public function index() {
        $configs = $this->siteConfigs->getConfig();

        return view('site-settings', ['pageTitle' => 'Site settings', 'configs' => $configs]);
    }

    public function saveSettings(Request $request) {
        $validatedInputs = $request->validate([
            'workdayStart' => 'required|date_format:H:i',
            'workdayEnd' => 'required|date_format:H:i|after:workdayStart'
        ]);

        $newValues = $this->siteConfigs->serialiseInputs($validatedInputs);
        $this->siteConfigs->setConfig($newValues);
        $this->siteConfigs->save();

        return back()->with('success', 'Sucessfuly updated the site settings');
    }
}
