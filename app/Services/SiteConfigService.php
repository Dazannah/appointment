<?php

namespace App\Services;

use App\Interfaces\ISiteConfig;

class SiteConfigService implements ISiteConfig {
  private $configs;

  public function __construct() {
    $this->configs = require(base_path() . '/config/adminConfigs.php');
  }

  public function getConfig() {
    return $this->configs;
  }
}
