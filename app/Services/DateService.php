<?php

namespace App\Services;

use DateTime;
use DateInterval;
use DateTimeZone;
use App\DateInterface;

class DateService implements DateInterface {
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
}
