<?php

namespace App\Interfaces;

use DateInterval;

interface IDate {
    public function GetMinutsFromDateDiff(DateInterval $dateDiff): int;
    public function IsMoreThanADay(int $availableMins): bool;
    public function IsStartInTheFuture($startDate): bool;
    public function GetDateDiffFromString(string $startDate, string $eventStartDate): DateInterval;
    public function FormateDateForSave($dateTime): string;
    public function workIterval($which);
    public function totalWorkMinutes(): int;
    public function replaceTInStartEnd($appointments): void;
    public function getNextEventDate($event = null, $startDate): string;
    public function ValidateDateForEvent($start, $end, $duration): array;
    public function IsStartBeforeOpen($start): bool;
    public function IsEndAfterClose($start): bool;
}
