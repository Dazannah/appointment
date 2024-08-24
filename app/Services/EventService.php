<?php

namespace App\Services;

use App\Models\Event;
use App\EventInterface;
use App\Models\WorkTypes;
use Illuminate\Database\Eloquent\Collection;

class EventService implements EventInterface {

  protected $dateService;

  public function __construct(DateService $dateService) {
    $this->dateService = $dateService;
  }

  public function getWeeklyEvents($start, $end): Collection {
    return Event::where([['start', '>=', $start], ['end', '<=', $end], ['status_id', '!=', '3']])->get();
  }

  public function AddGreenBackgroundToOwnEvent($events, $userId): void {
    foreach ($events as $event) {
      if ($event->user_id === $userId) {
        $event->backgroundColor = "green";
        $event->url = "/event/$event->id";
      } else {
        $event->title = "";
      }
    }
  }

  public function getAvailableWorkTypes($startDate): Collection {
    $event = Event::where([['start', '>=', $startDate], ['status_id', '!=', '3']])->orderBy('start', 'asc')->first();

    if ($event) {
      $dateDiff = $this->dateService->GetDateDiffFromString($startDate, $event['start']);
      $availableMins = $this->dateService->GetMinutsFromDateDiff($dateDiff);

      $result =  WorkTypes::where([['duration', '<=', $availableMins]])->with("price")->get();
    } else {
      $result = WorkTypes::with("price")->get();
    }

    return $result;
  }

  public function CreateEvent($validated, $userId): void {
    $work = WorkTypes::where('id', '=', $validated['workId'])->first();

    $event = [
      'user_id' => $userId,
      'title' => $work['name'],
      'start' => $validated['start'],
      'end' => $validated['end'],
      'work_type_id' => $work['id'],
      'note' => $validated['note'],
    ];

    Event::create($event);
  }
}
