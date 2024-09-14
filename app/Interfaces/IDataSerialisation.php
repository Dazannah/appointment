<?php

namespace App\Interfaces;

interface IDataSerialisation {
  public function serialiseInputForEditEvent($validated, $event): void;
  public function serialiseInputForEditUser($validated, $user): void;
  public function serialiseInputForCreateClosedDay($validated): array;
}
