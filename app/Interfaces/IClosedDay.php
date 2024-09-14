<?php

namespace App\Interfaces;

use App\Enums\StartEnd;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IClosedDay {
    public function getWeeklyClosedDays($start, $end): Collection;
    public function AddClosedDayToEvents($events, $closedDays): Collection;
    public function isClosedDay($day): bool;
    public function getFilterClosedDays($validated): LengthAwarePaginator;
    public function validateIfCanSave($validated): array;
    public function getClosedDayByInput(StartEnd $field, $date): Collection;
}
