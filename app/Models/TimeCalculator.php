<?php

namespace App\Models;

use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeCalculator extends Model {
    use HasFactory;

    public static function GetMinutsFromDateDiff(DateInterval $dateDiff): int {
        $availableMins = 0;
        $availableMins += $dateDiff->y * 24 * 60 * 30 * 365;
        $availableMins += $dateDiff->m * 24 * 60 * 30;
        $availableMins += $dateDiff->d * 24 * 60;
        $availableMins += $dateDiff->h * 60;
        $availableMins += $dateDiff->i;

        return $availableMins;
    }

    public static function IsMoreThanADay(int $availableMins): bool {
        return $availableMins > 1440;
    }

    public static function IsStartInTheFuture(DateTime $now, DateTime $startDate): bool {

        return $startDate > $now;
    }
}
