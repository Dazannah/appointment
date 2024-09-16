<?php

namespace App\Services;

use App\Enums\StartEnd;
use App\Interfaces\IDate;
use App\Models\ClosedDay;
use App\Interfaces\IClosedDay;
use App\Interfaces\IEvent;
use App\Interfaces\ISiteConfig;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ClosedDayService implements IClosedDay {

  private ISiteConfig $siteConfigService;
  private array $siteConfig;

  private IDate $dateService;
  private IEvent $eventService;

  public function __construct(ISiteConfig $siteConfigService, IDate $dateService, IEvent $eventService) {
    $this->siteConfigService = $siteConfigService;
    $this->siteConfig =  $this->siteConfigService->getConfig();

    $this->dateService = $dateService;
    $this->eventService = $eventService;
  }

  public function handleHolidays($holidays, $year): void {
    foreach ($holidays as $holiday) {
      if ($holiday['type'] == 1) {
        $isClosedDay = $this->isClosedDay($holiday['date']);

        if (!$isClosedDay) {
          ClosedDay::create([
            'title' => $holiday['name'],
            'start' => $holiday['date'],
            'end' => $holiday['date']
          ]);
        }
      }
    }
  }

  public function validateIfCanSave($validated): array {
    $startIsWorkDay = $this->dateService->isItWorkDay($validated['startDate']);
    if (!$startIsWorkDay) return ['canSave' => false, 'message' => "Start on weekend. Can't save it."];

    $endIsWorkDay = $this->dateService->isItWorkDay($validated['endDate']);
    if (!$endIsWorkDay) return ['canSave' => false, 'message' => "End on weekend. Can't save it."];

    $start = $this->getClosedDayByInput(StartEnd::Start, $validated['startDate']);
    $end = $this->getClosedDayByInput(StartEnd::End, $validated['endDate']);

    if (count($start) > 0 || count($end) > 0) return ['canSave' => false, 'message' => "Can't save on this date.<br>There is already closed day on this date."];

    $eventsOnTheStartDate = $this->eventService->getAllEventOnTheDay($validated['startDate']);
    $eventsOnTheEndDate = $this->eventService->getAllEventOnTheDay($validated['endDate']);

    if (count($eventsOnTheStartDate) > 0 || count($eventsOnTheEndDate) > 0) return ['canSave' => false, 'message' => "Can't save on this date.<br>There is reserved events on the dates."];

    return ['canSave' => true];
  }

  public function getClosedDayByInput(StartEnd $field, $date): Collection {
    return ClosedDay::where($field->value, '=', $date)->get();
  }

  public function getFilterClosedDays($validated): LengthAwarePaginator {
    $closedDays = ClosedDay::when(
      isset($validated['closedDayId']),
      function ($querry) use ($validated) {
        return $querry->where('id', 'REGEXP', $validated['closedDayId']);
      }
    )->when(
      isset($validated['startDate']),
      function ($querry) use ($validated) {
        return $querry->where('start', 'REGEXP', $validated['startDate']);
      }
    )->when(
      isset($validated['endDate']),
      function ($querry) use ($validated) {
        return $querry->where('end', 'REGEXP', $validated['endDate']);
      }
    )->when(
      isset($validated['holidays']),
      function ($querry) {
        return $querry->where('title', '!=', null);
      },
      function ($querry) use ($validated) {
        return $querry->where('title', '=', null);
      }
    )->when(
      isset($validated['currentYear']),
      function ($querry) {
        $year = date('Y');
        $yearStart = date('Y-m-d H:i', strtotime($year . '-01-01 00:00'));
        $yearEnd = date('Y-m-d H:i', strtotime($year . '-12-31 23:59'));

        return $querry->where([['start', '>=', $yearStart], ['start', '<=',  $yearEnd]]);
      }
    )->paginate(10);

    return $closedDays;
  }

  public function getWeeklyClosedDays($start, $end): Collection {
    $closedDays = ClosedDay::where([['start', '>=', $start], ['end', '<=', $end]])->get();

    $closedDays->map(
      function ($closedDay) {
        $closedDay['start'] = $closedDay['start'] . 'T' . $this->siteConfig['calendarTimes']['slotMinTime'];
        $closedDay['end'] = $closedDay['end'] . 'T' . $this->siteConfig['calendarTimes']['slotMaxTime'];
        if ($closedDay['title'] === null) $closedDay['title'] = $this->siteConfig['closedDays']['title'];
      }
    );

    return $closedDays;
  }

  public function AddClosedDayToEvents($events, $closedDays): Collection {
    return $events->merge($closedDays);
  }

  public function isClosedDay($day): bool {
    $splitedDay = explode('T', $day);

    return count(ClosedDay::where([['start', '<=', $splitedDay[0]], ['end', '>=', $splitedDay[0]]])->get()) > 0;
  }
}
