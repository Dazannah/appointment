<?php

namespace App\Services;

use App\Interfaces\IDate;
use DateTimeZone;
use App\Models\Event;
use App\Models\WorkTypes;
use App\Interfaces\IEvent;
use App\Models\PenaltyFee;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Collection;

class EventService implements IEvent {

  protected $dateService;

  public function __construct(IDate $dateService) {
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

    $this->dateService->replaceTInStartEnd($reservations);

    return $reservations;
  }

  public function getWeeklyData($which): object {
    $totalWorkMinutes = $this->dateService->totalWorkMinutes();
    $weekInterval = $this->dateService->workIterval($which);

    $weekEvents = Event::where([['start', '>=', $weekInterval['start']], ['end', '<=', $weekInterval['end']], ['status_id', '!=', '3']])->get();

    $weekWorkMinutes = 0;
    foreach ($weekEvents as $weekEvent) {
      $weekWorkMinutes += $weekEvent->workType->duration;
    }

    $nextWeekPercent = ($weekWorkMinutes / $totalWorkMinutes) * 100;

    return (object)array('pcs' => count($weekEvents), 'percent' => $nextWeekPercent);
  }

  public function getLatest10Appointments(): Collection {
    return Event::all()->sortByDesc('created_at')->take(10);
  }

  public function getLatest10AppointmentsForUser($userId): Collection {
    return Event::where([['user_id', '=', $userId]])->orderBy('created_at', 'desc')->take(10)->get();
  }
}
