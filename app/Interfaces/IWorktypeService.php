<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface IWorktypeService {
    public function getFilterWorktypes($validated): LengthAwarePaginator;
}
