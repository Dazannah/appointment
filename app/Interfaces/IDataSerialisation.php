<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IDataSerialisation {
  public function serialiseInputForEditEvent($validated, $event): void;
  public function serialiseInputForEditUser($validated, $user): void;
  public function serialiseInputForCreateClosedDay($validated): array;
  public function serialseClosedDaysForCalendar($closedDays): Collection;
  public function getUserId(): int;
}
