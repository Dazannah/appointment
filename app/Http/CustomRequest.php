<?php

namespace App\Http;

use Illuminate\Http\Request;

class CustomRequest extends Request {
  public function isApi(): bool {
    return explode('/', $this->route()->uri)[0] === 'api';
  }
}
