<?php

namespace App;

use DateInterval;

interface DateInterface {
    public function GetMinutsFromDateDiff(DateInterval $dateDiff): int;
    public function IsMoreThanADay(int $availableMins): bool;
    public function IsStartInTheFuture($startDate): bool;
    public function GetDateDiffFromString($startDate, $eventStartDate): DateInterval;
    public function FormateDateForSave($dateTime): string;
}
