<?php

namespace App\Interfaces;

use App\Models\User;
use App\Models\Event;
use App\Models\WorkTypes;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IEvent {
    public function getWeeklyEvents($start, $end): Collection;
    public function AddGreenBackgroundToOwnEvent($events, $userId): void;
    public function getAvailableWorkTypes($startDate): Collection;
    public function CreateEvent($validated, $userId): void;
    public function setStatusDeleted(Event $event): RedirectResponse;
    public function updateEvent(Event $event, $validatedData): void;
    public function getOwnEvents(int $userId): LengthAwarePaginator;
    public function getWeeklyData($which): object;
    public function getLatest10Appointments(): Collection;
    public function getLatest10AppointmentsForUser($userId): Collection;
    public function getAdminMenuFilterEvents($validated): LengthAwarePaginator;
    public function getAllEventsOfUser(User $user): LengthAwarePaginator;
    public function getAllOpenEndedEvents(): Collection;
    public function closeGivenEvents($events): void;
    public function getNextAvailableEventTime(WorkTypes $event, string $day): array;
}
