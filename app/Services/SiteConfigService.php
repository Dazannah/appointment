<?php

namespace App\Services;

use App\Interfaces\ISiteConfig;

class SiteConfigService implements ISiteConfig {
  private $configs;

  public function __construct() {
    $jsonString = file_get_contents(base_path() . '/config/adminConfigs.json');
    $this->configs = json_decode($jsonString, true);
  }

  public function getConfig(): array {
    return $this->configs;
  }

  public function setConfig(array $newConfigs): void {
    $this->updateConfigs($newConfigs, $this->configs);
  }

  public function save(): void {
    $jsonString = json_encode($this->configs);
    file_put_contents(base_path() . '/config/adminConfigs.json', $jsonString);
  }

  public function updateConfigs(&$newConfigs, &$oldConfigs): void {
    $allKeys = array_keys($newConfigs);

    foreach ($allKeys as $key) {
      if (gettype($oldConfigs["$key"]) == 'array') {
        $this->updateConfigs($newConfigs["$key"], $oldConfigs["$key"]);
      } else {
        $oldConfigs["$key"] = $newConfigs["$key"];
      }
    }
  }

  public function serialiseInputs($validatedInputs): array {
    $result = array();

    if ($this->configs['calendarTimes']['slotMinTime'] !== $validatedInputs['workdayStart']) $result['calendarTimes']['slotMinTime'] = $validatedInputs['workdayStart'];
    if ($this->configs['calendarTimes']['slotMaxTime'] !== $validatedInputs['workdayEnd']) $result['calendarTimes']['slotMaxTime'] = $validatedInputs['workdayEnd'];
    if ($this->configs['closedDays']['title'] !== $validatedInputs['closedDaysTitle']) $result['closedDays']['title'] = $validatedInputs['closedDaysTitle'];

    return $result;
  }
}
