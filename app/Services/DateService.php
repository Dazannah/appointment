<?php

namespace App\Services;

use DateTime;
use DateInterval;
use DateTimeZone;
use App\Interfaces\IDate;

class DateService implements IDate {

  public function GetMinutsFromDateDiff(DateInterval $dateDiff): int {
    $availableMins = 0;
    $availableMins += $dateDiff->y * 24 * 60 * 30 * 365;
    $availableMins += $dateDiff->m * 24 * 60 * 30;
    $availableMins += $dateDiff->d * 24 * 60;
    $availableMins += $dateDiff->h * 60;
    $availableMins += $dateDiff->i;

    return $availableMins;
  }

  public function IsMoreThanADay(int $availableMins): bool {
    return $availableMins > 1440;
  }

  public function IsStartInTheFuture($startDate): bool {
    $startDate = date_create($startDate);

    $now = date_create('now', new DateTimeZone('CEST'));

    return $startDate > $now;
  }

  public function GetDateDiffFromString(string $startDate, string $eventStartDate): DateInterval {
    $startDate = date_create($startDate);
    $nextEventStart = date_create($eventStartDate);

    return date_diff($startDate, $nextEventStart);
  }

  public function FormateDateForSave($dateTime): string {
    $validated['start'] = explode('T', $dateTime)[0] . ' ' . explode('T', $dateTime)[1];
    $result = str_replace(" ", "T", $validated['start']);

    return $result;
  }

  public function workIterval($which) {
    $monday = strtotime("$which monday");
    $friday = strtotime(date("Y-m-d", $monday) . " +4 days");

    $weekStart = date("Y-m-d", $monday);
    $weekEnd = date("Y-m-d", $friday);

    return ['start' => $weekStart, 'end' => $weekEnd];
  }

  public function totalWorkMinutes(): int {
    return 5 * 8 * 60;
  }

  public function replaceTInStartEnd($appointments): void {
    $appointments->transform(function ($appointment) {
      $appointment->start = str_replace("T", " ", $appointment->start);
      $appointment->end = str_replace("T", " ", $appointment->end);

      return $appointment;
    });
  }
}
