<?php

namespace App\Interfaces;

interface IPriceService {
    public function getPriceIdByPrice($price = null): int|null|string;
}
