<?php

namespace App\Services;

use App\Interfaces\IWorktypeService;
use App\Models\WorkTypes;
use Illuminate\Pagination\LengthAwarePaginator;

class WorktypeService implements IWorktypeService {

  public function GetDurationById($worktypeId): int {
    $worktype = WorkTypes::where('id', '=', $worktypeId)->first();

    return $worktype['duration'];
  }

  public function getFilterWorktypes($validated): LengthAwarePaginator {
    $worktypes = WorkTypes::when(
      isset($validated['worktypeId']),
      function ($querry) use ($validated) {
        return $querry->where('id', 'REGEXP', $validated['worktypeId']);
      }
    )->when(
      isset($validated['name']),
      function ($querry) use ($validated) {
        return $querry->where('name', 'REGEXP', $validated['name']);
      }
    )->when(
      isset($validated['duration']),
      function ($querry) use ($validated) {
        return $querry->where('duration', 'REGEXP', $validated['duration']);
      }
    )->when(
      isset($validated['priceId']) && ($validated['priceId'] != 0),
      function ($querry) use ($validated) {
        return $querry->where('price_id', '=', $validated['priceId']);
      }
    )->with('price')->paginate(10);

    return $worktypes;
  }
}
