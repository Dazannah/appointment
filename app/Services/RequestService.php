<?php

namespace App\Services;

use App\Interfaces\IRequest;

class RequestService implements IRequest {

  protected string $uri;
  public function __construct(string $uri) {
    $this->uri = $uri;
  }
}
