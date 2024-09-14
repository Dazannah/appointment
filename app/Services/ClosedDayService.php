<?php

namespace App\Services;

use App\Interfaces\IClosedDay;
use App\Interfaces\ISiteConfig;
use App\Models\ClosedDay;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ClosedDayService implements IClosedDay {

  private ISiteConfig $siteConfigService;
  private array $siteConfig;

  public function __construct(ISiteConfig $siteConfigService) {
    $this->siteConfigService = $siteConfigService;
    $this->siteConfig =  $this->siteConfigService->getConfig();
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
