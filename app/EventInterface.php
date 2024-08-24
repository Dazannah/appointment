<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;

interface EventInterface {
    public function getWeeklyEvents($start, $end): Collection;
    public function AddGreenBackgroundToOwnEvent($events, $userId): void;
    public function getAvailableWorkTypes($startDate): Collection;
    public function CreateEvent($validated, $userId): void;
}
