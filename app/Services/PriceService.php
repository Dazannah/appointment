<?php

namespace App\Services;

use App\Models\Price;
use App\Interfaces\IPriceService;

class PriceService implements IPriceService {
  public function getPriceIdByPrice($price = null): int|null|string {
    $priceId = null;

    if ($price != null) {
      $price = Price::where('price', '=', $price)->first();

      $priceId = isset($price) ? $price->id : '';
    }

    return $priceId;
  }
}
