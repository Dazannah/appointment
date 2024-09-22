<?php

namespace App\Services;

use App\Interfaces\ISiteConfig;
use App\Interfaces\IDataSerialisation;
use Illuminate\Database\Eloquent\Collection;

class DataSerialisationService implements IDataSerialisation {
  protected array $siteConfig;

  public function __construct(ISiteConfig $siteConfigService) {
    $siteConfigService = $siteConfigService;
    $this->siteConfig =  $siteConfigService->getConfig();
  }

  public function serialiseInputForCreateClosedDay($validated): array {
    return  [
      'start' => $validated['startDate'],
      'end' => $validated['endDate']
    ];
  }

  public function serialiseInputForEditEvent($validated, $event): void {
    $event->note = $validated['userNote'];
    $event->admin_note = $validated['adminNote'];
    $event->status_id = $validated['status'];
  }

  public function serialiseInputForEditUser($validated, $user): void {
    $user->name = $validated['fullName'];
    $user->created_at = $validated['createdAt'];
    $user->updated_at = $validated['updatedAt'];
    $user->email = $validated['emailAddress'];
    $user->user_status_id = $validated['status'];
    $user->updated_by = $this->getUserId();

    if (isset($validated['isAdmin']) && ($validated['isAdmin'] === 'on')) {
      $user->is_admin = 1;
    } else {
      $user->is_admin = 0;
    }
  }

  public function getUserId(): int {
    return auth()->user()->id;
  }

  public function serialseClosedDaysForCalendar($closedDays): Collection {
    return $closedDays->map(
      function ($closedDay) {
        $closedDay['start'] = $closedDay['start'] . 'T' . $this->siteConfig['calendarTimes']['slotMinTime'];
        $closedDay['end'] = $closedDay['end'] . 'T' . $this->siteConfig['calendarTimes']['slotMaxTime'];
        if ($closedDay['title'] === null) $closedDay['title'] = $this->siteConfig['closedDays']['title'];

        return $closedDay;
      }
    );
  }
}
