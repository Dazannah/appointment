<?php

namespace App\Interfaces;

interface IRequest {
    public function getHolidays($year): array | false;
}
