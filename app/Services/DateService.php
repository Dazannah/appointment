<?php

namespace App\Services;

use DateTime;
use DateInterval;
use DateTimeZone;
use App\Interfaces\IDate;
use App\Interfaces\ISiteConfig;

class DateService implements IDate {

  private ISiteConfig $siteConfigService;
  private $calendarTimes;

  public function __construct(ISiteConfig $siteConfigService) {
    $this->siteConfigService = $siteConfigService;
    $this->calendarTimes = $this->siteConfigService->getConfig()['calendarTimes'];
  }

  public function ValidateDateForEvent($start, $end, $duration): array {
    $status = [
      'isDateWrong' => false,
      'errorMessage' => ''
    ];

    if (!$this->IsStartInTheFuture($start)) {
      $status['isDateWrong'] = true;
      $status['errorMessage'] = "Can't make appointment for the past.";

      return $status;
    }

    if ($this->IsStartBeforeOpen($start)) {
      $status['isDateWrong'] = true;
      $status['errorMessage'] = "Can't make appointment before open time.";

      return $status;
    }

    if ($this->IsEndAfterClose($end)) {
      $status['isDateWrong'] = true;
      $status['errorMessage'] = "Can't make appointment that end after close.";

      return $status;
    }

    if (!$this->IsStartAndEndDifferenceEqualWithEventDuration($start, $end, $duration)) {
      $status['isDateWrong'] = true;
      $status['errorMessage'] = "Can't make appointment with miss match dates.";

      return $status;
    }


    return $status;
  }

  public function IsEndAfterClose($end): bool {
    return $this->calendarTimes['slotMaxTime'] < explode('T', $end)[1];
  }

  public function IsStartBeforeOpen($start): bool {
    return $this->calendarTimes['slotMinTime'] > explode('T', $start)[1];
  }

  public function IsStartAndEndDifferenceEqualWithEventDuration($start, $end, $duration): bool {
    $dateDiff = $this->GetDateDiffFromString($start, $end);
    $startEndTimeDifferenceInMinutes = $this->GetMinutsFromDateDiff($dateDiff);

    return $startEndTimeDifferenceInMinutes == $duration;
  }




  public function GetMinutsFromDateDiff(DateInterval $dateDiff): int {
    $availableMins = 0;
    $availableMins += $dateDiff->y * 24 * 60 * 30 * 365;
    $availableMins += $dateDiff->m * 24 * 60 * 30;
    $availableMins += $dateDiff->d * 24 * 60;
    $availableMins += $dateDiff->h * 60;
    $availableMins += $dateDiff->i;

    return $availableMins;
  }

  public function getNextEventDate($event = null, $startDate): string {
    $startDateExploded = explode('T', $startDate);

    if ($event) {
      $nextEventStartDateExploded = explode('T', $event['start']);

      if ($startDateExploded[0] < $nextEventStartDateExploded[0]) {
        return $startDateExploded[0] . 'T' . $this->calendarTimes['slotMaxTime'];
      }

      return $event['start'];
    } else {
      return $startDateExploded[0] . 'T' . $this->calendarTimes['slotMaxTime'];
    }
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
