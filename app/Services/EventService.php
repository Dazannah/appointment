<?php

namespace App\Services;

use DateTimeZone;
use App\Models\Event;
use App\EventInterface;
use App\Models\WorkTypes;
use App\Models\PenaltyFee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;

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

  public function setStatusDeleted(Event $event): RedirectResponse {
    if ($event->status->id === 2) {
      return back()->with('error', "Can't delete event in progress.");
    }

    $dateDiff = $this->dateService->GetDateDiffFromString(date_create('now', new DateTimeZone('CEST'))->format('Y-m-d H:i'), $event['start']);
    $availableMins = $this->dateService->GetMinutsFromDateDiff($dateDiff);
    $isMoreThanADay = $this->dateService->IsMoreThanADay($availableMins);
    $isStartInTheFuture = $this->dateService->IsStartInTheFuture($event['start']);

    if (!$isMoreThanADay && $isStartInTheFuture) {
      PenaltyFee::create(['user_id' => auth()->user()->id, 'event_id' => $event->id/*, 'penalty_fee_status_id' => 1, 'penalty_fee_price_id' => 1*/]);
    }

    $event->status_id = 3;
    $event->save();

    return redirect('/dashboard')->with('success', 'Successfully deleted');
  }

  public function updateEvent(Event $event, $validatedData): void {
    if ($validatedData['note'] != $event->note) {
      $event->note = $validatedData['note'];
      $event->save();
    };
  }

  public function getOwnEvents(int $userId): Paginator {
    $reservations = Event::where([['user_id', '=', $userId]])->orderBy('start', 'desc')->simplePaginate(10);

    $reservations->transform(function ($reservation) {
      $reservation->start = str_replace("T", " ", $reservation->start);
      $reservation->end = str_replace("T", " ", $reservation->end);

      return $reservation;
    });

    return $reservations;
  }
}
