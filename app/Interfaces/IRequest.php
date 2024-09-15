<?php

namespace App\Interfaces;

interface IRequest {
    public function __construct(string $uri);
}
