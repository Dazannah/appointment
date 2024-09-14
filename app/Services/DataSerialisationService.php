<?php

namespace App\Services;

use App\Interfaces\IDataSerialisation;

class DataSerialisationService implements IDataSerialisation {
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
    $user->updated_by = auth()->user()->id;

    if (isset($validated['isAdmin']) && ($validated['isAdmin'] === 'on')) {
      $user->is_admin = 1;
    } else {
      $user->is_admin = 0;
    }
  }
}
