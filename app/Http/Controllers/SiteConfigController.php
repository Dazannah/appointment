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
}
