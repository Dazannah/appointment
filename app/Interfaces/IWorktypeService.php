<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface IWorktypeService {
    public function getAdminMenuFilterWorktypes($validated): LengthAwarePaginator;
}
