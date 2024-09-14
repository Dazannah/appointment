<?php

namespace App\Services;

use App\Interfaces\IClosedDay;
use App\Interfaces\ISiteConfig;
use App\Models\ClosedDay;
use Illuminate\Database\Eloquent\Collection;

class ClosedDayService implements IClosedDay {

  private ISiteConfig $siteConfigService;
  private array $siteConfig;

  public function __construct(ISiteConfig $siteConfigService) {
    $this->siteConfigService = $siteConfigService;
    $this->siteConfig =  $this->siteConfigService->getConfig();
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
    return count(ClosedDay::where('start', '<=', $day)->get()) > 0;
  }
}
