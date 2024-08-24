<?php

namespace App;

use App\Models\Event;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Collection;

interface EventInterface {
    public function getWeeklyEvents($start, $end): Collection;
    public function AddGreenBackgroundToOwnEvent($events, $userId): void;
    public function getAvailableWorkTypes($startDate): Collection;
    public function CreateEvent($validated, $userId): void;
    public function setStatusDeleted(Event $event): RedirectResponse;
    public function updateEvent(Event $event, $validatedData): void;
    public function getOwnEvents(int $userId): Paginator;
}
