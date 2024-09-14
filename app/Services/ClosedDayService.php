<?php

namespace App\Services;

use App\Enums\StartEnd;
use App\Interfaces\IDate;
use App\Models\ClosedDay;
use App\Interfaces\IClosedDay;
use App\Interfaces\ISiteConfig;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ClosedDayService implements IClosedDay {

  private ISiteConfig $siteConfigService;
  private array $siteConfig;

  private IDate $dateService;

  public function __construct(ISiteConfig $siteConfigService, IDate $dateService) {
    $this->siteConfigService = $siteConfigService;
    $this->siteConfig =  $this->siteConfigService->getConfig();

    $this->dateService = $dateService;
  }

  public function validateIfCanSave($validated): array {
    $startIsWorkDay = $this->dateService->isItWorkDay($validated['startDate']);
    if (!$startIsWorkDay) return ['canSave' => false, 'message' => "Start on weekend. Can't save it."];

    $endIsWorkDay = $this->dateService->isItWorkDay($validated['endDate']);
    if (!$endIsWorkDay) return ['canSave' => false, 'message' => "End on weekend. Can't save it."];

    $start = $this->getClosedDayByInput(StartEnd::Start, $validated['startDate']);
    $end = $this->getClosedDayByInput(StartEnd::End, $validated['endDate']);

    if (count($start) > 0 || count($end) > 0) return ['canSave' => false, 'message' => "Can't save on this date.<br>There is already closed day on this date."];

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
    )->paginate(10);

    return $closedDays;
  }

  public function getWeeklyClosedDays($start, $end): Collection {
    $closedDays = ClosedDay::where([['start', '>=', $start], ['end', '<=', $end]])->get();

    $closedDays->map(
      function ($closedDay) {
        $closedDay['start'] = $closedDay['start'] . 'T' . $this->siteConfig['calendarTimes']['slotMinTime'];
        $closedDay['end'] = $closedDay['end'] . 'T' . $this->siteConfig['calendarTimes']['slotMaxTime'];
        $closedDay['title'] = $this->siteConfig['closedDays']['title'];
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
