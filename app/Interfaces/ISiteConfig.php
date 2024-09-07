<?php

namespace App\Interfaces;

interface ISiteConfig {
    public function getConfig();
    public function setConfig(array $newConfigs): void;
    public function save(): void;
    public function updateConfigs(&$newConfigs, &$oldConfigs): void;
    public function serialiseInputs($validatedInputs): array;
}
