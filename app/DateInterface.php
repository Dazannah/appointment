<?php

namespace App;

use DateInterval;

interface DateInterface {
    public function GetMinutsFromDateDiff(DateInterval $dateDiff): int;
    public function IsMoreThanADay(int $availableMins): bool;
    public function IsStartInTheFuture($startDate): bool;
    public function GetDateDiffFromString(string $startDate, string $eventStartDate): DateInterval;
    public function FormateDateForSave($dateTime): string;
    public function workIterval($which);
    public function totalWorkMinutes(): int;
    public function replaceTInStartEnd($appointments): void;
}
