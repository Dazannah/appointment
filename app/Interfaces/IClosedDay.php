<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IClosedDay {
    public function getWeeklyClosedDays($start, $end): Collection;
    public function AddClosedDayToEvents($events, $closedDays): Collection;
    public function isClosedDay($day): bool;
}
