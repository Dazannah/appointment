<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IUserService {
  public function getAdminMenuFilterUsers($validated): LengthAwarePaginator;
  public function getLatest10UsersRegistration(): Collection;
  public static function getAllIdRegexpFromName($userName): string;
}
