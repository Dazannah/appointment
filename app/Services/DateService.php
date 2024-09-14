<?php

namespace App\Services;

use App\Interfaces\IClosedDay;
use DateTime;
use DateInterval;
use DateTimeZone;
use App\Interfaces\IDate;
use App\Interfaces\ISiteConfig;
use App\Models\ClosedDay;

class DateService implements IDate {

  private ISiteConfig $siteConfigService;
  private IClosedDay $closedDayService;
  private $calendarTimes;

  public function __construct(ISiteConfig $siteConfigService, IClosedDay $closedDayService) {
    $this->siteConfigService = $siteConfigService;
    $this->calendarTimes = $this->siteConfigService->getConfig()['calendarTimes'];

    $this->closedDayService = $closedDayService;
  }
  public function isFitTwoDateTimeDuration($firstDateTime, $nextDateTime, $duration): bool {
    $dateDiff = $this->GetDateDiffFromString($firstDateTime, $nextDateTime);
    $minutesDiff = $this->GetMinutsFromDateDiff($dateDiff);

    return $minutesDiff >= $duration;
  }

  public function isFitEndOfDay($startDateTime, $duration): bool {
    $startDate = explode('T', $startDateTime)[0];
    $dateDiff = $this->GetDateDiffFromString($startDateTime, $startDate . 'T' . $this->calendarTimes['slotMaxTime']);
    $minutesDiff = $this->GetMinutsFromDateDiff($dateDiff);

    return $minutesDiff >= $duration;
  }

  public function isFitStartOfDay($eventStartDateTime, $duration): bool {
    $startDate = explode('T', $eventStartDateTime)[0];
    $dateDiff = $this->GetDateDiffFromString($startDate . 'T' . $this->calendarTimes['slotMinTime'], $eventStartDateTime);
    $minutesDiff = $this->GetMinutsFromDateDiff($dateDiff);

    return $minutesDiff >= $duration;
  }

  public function getNextWorkdayTimesDate($date): array {
    $day = date('Y-m-d', strtotime($date . " +1 day"));
    $dayOfWeek = date('w', strtotime($day));
    $isClosedDay = $this->closedDayService->isClosedDay($day);

    if (
      $dayOfWeek == 6
      /** szombat */
      || $dayOfWeek == 0
      /** vasárnap */
      || $isClosedDay
    ) {
      return $this->getNextWorkdayTimesDate($day);
    } else {
      return [
        'day' => $day,
        'start' => $day . 'T' . $this->calendarTimes['slotMinTime'],
        'end' => $day . 'T' . $this->calendarTimes['slotMaxTime']
      ];
    }
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

    if ($this->closedDayService->isClosedDay($start)) {
      $status['isDateWrong'] = true;
      $status['errorMessage'] = "Can't make appointment start on closed day.";

      return $status;
    }

    if ($this->closedDayService->isClosedDay($end)) {
      $status['isDateWrong'] = true;
      $status['errorMessage'] = "Can't make appointment end on closed day.";

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
